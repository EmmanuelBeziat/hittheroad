# Release & Update Workflow

When the user requests to execute an update or release, the following steps **must** be performed in order:

## 1. Update Changelog
- Add a new section with the current date (format: `DD.MM.YYYY`) at the top of the `CHANGELOG.md` file.
- List all relevant changes, bug fixes, WooCommerce template updates, or new features under this new section.

## 2. Increment Project Version
- Read the current version in `package.json`.
- Increment the version number appropriately (Patch `x.x.1` for minor fixes, Minor `x.1.0` for new features, Major `1.0.0` for breaking changes).
- Update the `"version"` field in `package.json`.

## 3. Increment Theme Version
- Read the current version in `www/wp-content/themes/hittheroad-2021/style.css`.
- Update the `Version:` header in the theme's comment block to match the newly incremented version.

## 4. Create Git Tag
- Create an annotated git tag for the new version (e.g., `git tag -a v1.1.18 -m "Release v1.1.18"`).
- Push the tag to the remote repository (`git push origin v1.1.18`).

## Example Execution
If the current version is `1.0.6` and a minor WooCommerce template update is performed:
1. `CHANGELOG.md`: Add `## 12.06.2026` with the list of updated templates.
2. `package.json`: Change `"version": "1.0.6"` to `"version": "1.0.7"`.
3. `style.css`: Change `Version: 1.0.6` to `Version: 1.0.7`.
