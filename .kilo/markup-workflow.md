# Markup Workflow & Asset Pipeline

The `/markup` directory is the source of truth for all frontend assets of the `hittheroad-2021` WordPress theme. Grunt is used to process, optimize, and copy these assets to the theme's `/assets` directory.

## Directory Structure (`/markup`)
```text
markup/
├── fonts/       # Custom fonts (e.g., Bebas Neue, Montserrat)
├── googlesheets/ # Scripts related to Google Sheets API/integration
├── images/      # Source images (optimized during build)
├── scripts/     # JavaScript source files
│   ├── app.js       # Main application logic
│   ├── classes/     # JS class modules (concatenated into classes.js)
│   └── vendors/     # Third-party vendor scripts (concatenated into vendors.js)
└── styles/      # SCSS source files
    ├── app.scss         # Main entry point
    ├── maintenance.scss # Maintenance mode styles
    ├── editor-style.scss # Gutenberg editor styles
    ├── login-style.scss  # wp-login.php styles
    ├── variables.scss    # Global SASS variables
    ├── components/       # UI components (buttons, forms, tabs, etc.)
    ├── fonts/            # Font-face declarations
    ├── layout/           # Global layout rules
    ├── pages/            # Page-specific styles (home, cart, my-account, etc.)
    ├── partials/         # Header, footer, mobile-nav
    └── vendors/          # Custom Bootstrap, MapLibre, AOS, Swiper, etc.
```

## Build Pipeline (Grunt)
Defined in `Gruntfile.js` and `grunt-settings.js`.

### Development (`npm run dev`)
1. **SASS**: Compiles `app.scss` to `app.css` with source maps.
2. **JS Concat**: Concatenates `vendors/*.js` → `vendors.js`, `classes/*.js` → `classes.js`, and `app.js` → `app.js`.
3. **Copy**: Copies images and fonts from `markup/` to `www/wp-content/themes/hittheroad-2021/assets/`.
4. **Watch**: Watches for changes in SCSS, JS, and images, triggering incremental builds.

### Production (`npm run build`)
1. **SASS**: Compiles all SCSS entry points (`app`, `maintenance`, `editor-style`, `login-style`) with `outputStyle: 'compressed'` and no source maps.
2. **JS Uglify**: Minifies `vendors.js`, `classes.js`, and `app.js`.
3. **Copy**: Copies images and fonts.

## Rules for Developers
- **NEVER** manually edit files inside `www/wp-content/themes/hittheroad-2021/assets/`. They will be overwritten by the next build.
- Always add new SCSS partials to `markup/styles/app.scss` to ensure they are included in the build.
- When adding new vendor JS, place it in `markup/scripts/vendors/` so it is properly concatenated and minified.
- Image optimization: The current setup copies images. For heavy optimization, `grunt-contrib-imagemin` or similar can be leveraged if configured.
