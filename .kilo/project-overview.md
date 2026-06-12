# Hit The Road - Project Overview

## General Information
- **Project Name**: Hit The Road (HtR) Shop
- **Author**: Emmanuel Béziat
- **Version**: 1.1.18
- **License**: MPL-2.0
- **Repository**: https://github.com/emmanuelbeziat/hittheroad

## Tech Stack
- **Backend**: WordPress + WooCommerce (PHP 8.2+)
- **Frontend Build Tool**: Grunt.js + Node.js
- **Styling**: SCSS (Sass), Bootstrap 5 (customized), PostCSS (Autoprefixer, CSSComb)
- **Scripting**: Vanilla JavaScript, concatenated and uglified
- **UI Libraries**: 
  - MapLibre GL (maps)
  - AOS (Animate On Scroll)
  - Swiper (sliders)
  - Tom Select (dropdowns)
  - WP Bootstrap Navwalker (menus)

## Development Commands
Run these from the project root (`/Volumes/Sites/hittheroad`):

| Command | Description |
|---------|-------------|
| `npm run dev` | Full development mode: compiles SASS, concatenates JS, copies images/fonts, and starts watching for changes. |
| `npm run watch` | Quick development mode: only watches for changes and recompiles modified files. |
| `npm run build` | Production build: compiles minified SASS, uglifies JS, and copies assets. |
| `npm run build:styles` | Production build for styles only. |
| `npm run build:scripts` | Production build for scripts only. |

## Important Notes
- The project uses a custom `markup/` directory as the source of truth for all frontend assets. **Never edit files directly in `www/wp-content/themes/hittheroad-2021/assets/`**; always edit the source in `markup/` and run the build process.
- Custom styling can be added via `assets/css/custom.css` and `assets/js/custom.js` in the theme, which are enqueued if they exist (bypassing the build pipeline for quick fixes, though build pipeline is preferred).
- PHP version requirement: 8.2+ (updated from 8.0 in Jan 2024).
