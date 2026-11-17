# hittheroad

Theme wordpress/woocommerce pour le site marchand du collectif Hit the Road.

## Développement

Sources dans `markup/`, compilées vers `www/wp-content/themes/hittheroad-2021/assets/` (non versionné).

* `npm run dev` : compilation complète + watch
* `npm run build` : build de production (à lancer avant chaque déploiement des assets)

## Plugins requis

Le thème affiche un avis dans l'administration si l'un d'eux est absent ou inactif (`HTR_Admin::theme_plugins()`).

Indispensables :

* WooCommerce
* Advanced Custom Fields PRO (mu-plugin)

Utilisés par des fonctionnalités du thème :

* PDF Invoices & Packing Slips for WooCommerce : gabarit de facture `woocommerce/pdf/HTR/`
* Additional Product Fields for WooCommerce : options produit (finition)
* WooCommerce Stripe Gateway : paiement
* YITH WooCommerce Zoom Magnifier : galerie de la fiche produit
* Contact Form 7 : formulaire de contact
* Hit The Road — Codes Viméo (mu-plugin) : codes Viméo dans le webhook de commande
* F4 Shipping Phone and E-Mail for WooCommerce : e-mail de livraison (export Google Sheets)
* WooCommerce Order Paid Webhook : webhook « commande payée » (export Google Sheets)

