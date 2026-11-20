#!/usr/bin/env bash
# Deploy the theme to production with rsync over SSH.
#
# Usage: npm run deploy -- [--no-build] [--delete] [--yes]
#        npm run deploy -- --rollback <snapshot.tar.gz>
#
# Configuration in .env (not versioned): SSH_HOST (~/.ssh/config host), SSH_PATH (remote theme directory).
#
# Each deploy: build, dry run, confirmation, remote snapshot (tar.gz of the whole theme)
# in ~/deploy-backups/, then rsync. Files replaced (or deleted with --delete) are also kept
# in ~/deploy-backups/<date>/. Nothing is deleted on the server without --delete;
# assets/css/custom.css and assets/js/custom.js (production quick fixes) are never touched.

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
SOURCE="$ROOT/www/wp-content/themes/hittheroad-2021/"
RSYNC=/opt/homebrew/bin/rsync
BACKUP_DIR=deploy-backups

build=1 delete=0 assume_yes=0 rollback=''
while [ $# -gt 0 ]; do
	case "$1" in
		--no-build) build=0 ;;
		--delete) delete=1 ;;
		--yes) assume_yes=1 ;;
		--rollback) rollback="${2:-}"; shift ;;
		*) echo "Option inconnue : $1" >&2; exit 1 ;;
	esac
	shift
done

[ -f "$ROOT/.env" ] || { echo ".env manquant (SSH_HOST, SSH_PATH)" >&2; exit 1; }
set -a; source "$ROOT/.env"; set +a
: "${SSH_HOST:?SSH_HOST manquant dans .env}" "${SSH_PATH:?SSH_PATH manquant dans .env}"
SSH_PATH="${SSH_PATH%/}"

confirm () {
	[ "$assume_yes" = 1 ] && return 0
	read -r -p "$1 [o/N] " answer
	[[ "$answer" =~ ^[oOyY]$ ]]
}

# One shared SSH connection for the whole run: the key passphrase is asked at most once.
SSH_CMD=(ssh -o ControlMaster=auto -o "ControlPath=$HOME/.ssh/cm-deploy-%C" -o ControlPersist=120)
remote () {
	"${SSH_CMD[@]}" "$SSH_HOST" "$@"
}
trap '"${SSH_CMD[@]}" -O exit "$SSH_HOST" 2>/dev/null || true' EXIT

remote true || { echo "Connexion SSH impossible à $SSH_HOST (clé, phrase de passe, ~/.ssh/config ?)" >&2; exit 1; }

remote_theme_dir="$(dirname "$SSH_PATH")"
remote_theme_name="$(basename "$SSH_PATH")"

# Rollback: restore a snapshot, the current theme is moved aside (never deleted).
if [ -n "$rollback" ]; then
	remote "test -f ~/$BACKUP_DIR/$(printf %q "$rollback")" || { echo "Sauvegarde introuvable : ~/$BACKUP_DIR/$rollback" >&2; remote "ls -1t ~/$BACKUP_DIR/*.tar.gz 2>/dev/null | head" || true; exit 1; }
	confirm "Restaurer $rollback sur $SSH_HOST ? Le thème actuel sera renommé en $remote_theme_name.avant-restauration-<date>." || exit 1
	remote "cd $(printf %q "$remote_theme_dir") && mv $(printf %q "$remote_theme_name") $(printf %q "$remote_theme_name").avant-restauration-\$(date +%Y%m%d-%H%M%S) && tar -xzf ~/$BACKUP_DIR/$(printf %q "$rollback")"
	echo "Thème restauré depuis $rollback."
	exit 0
fi

[ -x "$RSYNC" ] || { echo "rsync Homebrew introuvable : brew install rsync" >&2; exit 1; }

if [ -n "$(git -C "$ROOT" status --porcelain -- www/wp-content/themes markup)" ]; then
	echo "⚠️  Modifications non commitées dans le thème ou markup/ :"
	git -C "$ROOT" status --short -- www/wp-content/themes markup
	confirm "Déployer quand même ?" || exit 1
fi

if [ "$build" = 1 ]; then
	(cd "$ROOT" && npm run build)
fi
[ -f "${SOURCE}assets/css/app.css" ] || { echo "assets/css/app.css absent : lancer le build" >&2; exit 1; }

remote "command -v rsync >/dev/null" || { echo "rsync absent sur le serveur" >&2; exit 1; }

stamp="$(date +%Y%m%d-%H%M%S)"
version="$(sed -n 's/.*"version": "\(.*\)".*/\1/p' "$ROOT/package.json" | head -1)"
remote_home="$(remote 'printf %s "$HOME"')"

rsync_opts=(
	-e "${SSH_CMD[*]}"
	-rlptz --checksum --human-readable --itemize-changes
	--exclude=.DS_Store --exclude=.gitignore
	--filter='P /assets/css/custom.css' --filter='P /assets/js/custom.js'
	--backup --backup-dir="$remote_home/$BACKUP_DIR/$stamp"
)
[ "$delete" = 1 ] && rsync_opts+=(--delete)

echo "→ Simulation : $SOURCE → $SSH_HOST:$SSH_PATH/ (version $version)"
changes="$("$RSYNC" "${rsync_opts[@]}" --dry-run "$SOURCE" "$SSH_HOST:$SSH_PATH/" | grep -v '^\.' || true)"
if [ -z "$changes" ]; then
	echo "Aucun changement à déployer."
	exit 0
fi
echo "$changes"
echo "($(echo "$changes" | wc -l | tr -d ' ') fichier(s) ; « <f » envoyé (+++ = nouveau), « *deleting » supprimé)"

confirm "Déployer ces changements sur $SSH_HOST ?" || exit 1

snapshot="$remote_theme_name-$stamp-v$version.tar.gz"
echo "→ Sauvegarde du thème en production : ~/$BACKUP_DIR/$snapshot"
remote "mkdir -p ~/$BACKUP_DIR && tar -czf ~/$BACKUP_DIR/$snapshot -C $(printf %q "$remote_theme_dir") $(printf %q "$remote_theme_name") && gzip -t ~/$BACKUP_DIR/$snapshot"

echo "→ Envoi"
"$RSYNC" "${rsync_opts[@]}" "$SOURCE" "$SSH_HOST:$SSH_PATH/" | grep -v '^\.' || true

echo "✅ Déployé (version $version)."
echo "   Fichiers remplacés : ~/$BACKUP_DIR/$stamp/"
echo "   Retour arrière     : npm run deploy -- --rollback $snapshot"
