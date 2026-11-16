# hittheroad

Theme wordpress/woocommerce pour le site marchand du collectif Hit the Road.

## Développement

Sources dans `markup/`, compilées vers `www/wp-content/themes/hittheroad-2021/assets/` (non versionné).

* `npm run dev` : compilation complète + watch
* `npm run build` : build de production (à lancer avant chaque déploiement des assets)

## Animations d'apparition

Gérées en CSS natif (`markup/styles/components/reveal.scss`), sans JavaScript.

```html
<div data-reveal="fade-in">…</div>
<div data-reveal="fade-up" style="--reveal-delay: 100ms; --reveal-duration: 300ms">…</div>
<article data-reveal="fade-in stagger">…</article>
```

* `fade-in` / `fade-up` : effet utilisé
* `stagger` : décale chaque élément selon sa position parmi ses frères (`sibling-index()`, plafonné au 8e)
* `--reveal-delay` / `--reveal-duration` : délai et durée de l'animation au chargement (défaut : `0s` / `.4s`)

Fonctionnement :

* Un élément visible au chargement de la page apparaît en fondu immédiatement.
* Un élément sous la ligne de flottaison apparaît au fil du scroll, en entrant dans l'écran.
* Navigateurs sans support des scroll-driven animations : seule l'animation au chargement est jouée, le reste s'affiche sans effet.
* `prefers-reduced-motion: reduce` : aucune animation.
