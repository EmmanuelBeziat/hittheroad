# Plugins & External Integrations

## Core WordPress Plugins
The project relies on a specific set of plugins for functionality, performance, and security.

### E-commerce & Payments
- **WooCommerce**: Core e-commerce functionality.
- **WooCommerce Stripe Gateway**: Payment processing via Stripe (customized form UI).
- **WooCommerce PDF Invoices & Packing Slips**: Generates PDF invoices (custom address formatting applied).
- **Additional Product Fields for WooCommerce**: Supplements custom variation fields.
- **F4 WooCommerce Shipping Phone and E-mail**: Adds contact info to shipping calculations.
- **YITH WooCommerce Zoom Magnifier**: Product image zoom functionality.
- **Woo Preview Emails**: For testing and styling transactional emails.

### Forms & Spam Protection
- **Contact Form 7**: Main form builder.
- **Contact Form 7 Honeypot**: Spam reduction.
- **WP Contact Form 7 Spam Blocker**: Additional spam filtering.
- **ALTCHA Spam Protection**: Advanced, privacy-friendly spam protection (replaces/augments CAPTCHA).
- **Flamingo**: Saves Contact Form 7 submissions to the database as a backup.

### Administration & Performance
- **WP-Optimize**: Database cleanup, caching, and image compression.
- **Filebird**: Folder management for the WordPress media library.
- **BackWPUp**: Automated website and database backups.
- **Better Search Replace**: Safe database search and replace operations (e.g., for URL migrations).
- **Regenerate Thumbnails Advanced**: Manages and regenerates WordPress image sizes.
- **Image Sizes Panel**: UI for managing registered image sizes.

### Security
- **Limit Login Attempts Reloaded**: Protects against brute-force login attacks.

## External Integrations

### Google Sheets API
The project features a deep integration with Google Sheets, managed via Google Apps Script (`markup/googlesheets/`).
- **Order Status Sync**: Automatically updates WooCommerce order statuses based on spreadsheet data.
- **Automated Content**: Scripts to push/pull content or mailing lists between WordPress and Google Sheets.
- **REST API**: The Google App Script communicates with the WooCommerce REST API to perform updates.

### Theme Assets (via Grunt)
- **Bootstrap 5**: Customized via `markup/styles/vendors/custom-bootstrap.scss`.
- **MapLibre GL**: For interactive maps (e.g., home page map section).
- **Swiper**: For carousels and sliders.
- **Tom Select**: For enhanced, accessible dropdown menus.

## Maintenance Best Practices
1. **WooCommerce Template Updates**: Regularly check `WooCommerce > Status` for outdated template files. Update the `/woocommerce` override folder and document the version bump in `CHANGELOG.md`.
2. **Plugin Updates**: Test updates in a staging environment first, especially for WooCommerce, Stripe, and ACF, as they directly impact revenue-critical flows.
3. **Google Sheets Scripts**: Changes to the Apps Script require redeployment as a new version or updating the trigger configurations in the Google Cloud console.
