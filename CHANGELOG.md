# Suivi de mises à jour

## 22.07.2026

* Corrections de sécurité (audit thème)
  * Upload SVG restreint aux administrateurs (`classes/htr-tools.php`)
  * Sanitization des `$_POST` dans la sauvegarde des variations (`functions.php`, `classes/htr-woocommerce.php`)
  * Ajout des guards `current_user_can('edit_product')` sur les hooks de sauvegarde

## 21.07.2026

* Mise à jour du script Pacific Colours (failsafe, validation de données, mail variable)
* Ajout variable de mailing Options ACF
* Mise à jour templates woocommerce
  * `hittheroad-2021/woocommerce/order/order-details.php` 10.1.0 → 10.9.0
  * `hittheroad-2021/woocommerce/single-product/add-to-cart/variable.php` 9.6.0 → 10.9.0

## 12.06.2026

* Mises à jour templates woocommerce
  * `hittheroad-2021/woocommerce/cart/cart.php` 10.1.0 → 10.8.0
  * `hittheroad-2021/woocommerce/emails/email-order-details.php` 10.4.0 → 10.8.0
  * `hittheroad-2021/woocommerce/loop/result-count.php` 9.9.0 → 10.8.0
  * `hittheroad-2021/woocommerce/myaccount/form-edit-account.php` 9.7.0 → 10.5.0
  * `hittheroad-2021/woocommerce/myaccount/view-order.php` 10.1.0 → 10.6.0
  * `hittheroad-2021/woocommerce/single-product/add-to-cart/variation-add-to-cart-button.php` 10.2.0 → 10.5.2
  * `hittheroad-2021/woocommerce/single-product/product-image.php` 9.7.0 → 10.5.0
* Nettoyage du code : suppression de la logique et des templates liés aux mugs (fonctionnalité abandonnée).

## 06.01.2026

* Mise à jour templates woocommerce
	`hittheroad-2021/woocommerce/emails/customer-invoice.php` 9.8.0 → 104.0
	`hittheroad-2021/woocommerce/emails/email-order-details.hp` 10.1.0 → 10.4.0
	`hittheroad-2021/woocommerce/notices/notice.php` 10.2.0 → 10.4.
	`hittheroad-2021/woocommerce/single-product/related.php` 9.6.0 → 10.3.0

## 10.12.2025

* Debug des factures PDF (adresse)

F2025 ----------------------------------------------

## 18.10.2025

* Mises à jour templates woocommerce
	* `hittheroad-2021/woocommerce/cart/cart.php` 7.9.0 → 10.1.0
	* `hittheroad-2021/woocommerce/checkout/form-coupon.php` 7.0.1 → 9.8.0
	* `hittheroad-2021/woocommerce/checkout/payment.php` 8.1.0 → 9.8.0
	* `hittheroad-2021/woocommerce/emails/customer-invoice.php` 9.7.0 → 9.8.0
	* `hittheroad-2021/woocommerce/emails/email-order-details.php` 9.7.0 → 10.1.0
	* `hittheroad-2021/woocommerce/global/quantity-input.php` 9.4.0 → 10.1.0
	* `hittheroad-2021/woocommerce/loop/result-count.php` 9.4.0 → 9.9.0
	* `hittheroad-2021/woocommerce/myaccount/form-login.php` 9.7.0 → 9.9.0
	* `hittheroad-2021/woocommerce/myaccount/view-order.php` 3.0.0 → 10.1.0
	* `hittheroad-2021/woocommerce/notices/notice.php` 8.6.0 → 10.2.0
	* `hittheroad-2021/woocommerce/order/order-details.php` 9.6.0 → 10.1.0
	* `hittheroad-2021/woocommerce/single-product/add-to-cart/simple.php` 7.0.1 → 10.2.0
	* `hittheroad-2021/woocommerce/single-product/add-to-cart/variation-add-to-cart-button.php` 7.0.1 → 10.2.0
	* `hittheroad-2021/woocommerce/single-product/product-thumbnails.php` 9.5.0 → 9.8.0
	* `hittheroad-2021/woocommerce/single-product/tabs/tabs.php` 9.6.0 → 9.8.0

## 02.03.2025

* Mises à jour templates woocommerce
	* `hittheroad-2021/woocommerce/cart/shipping-calculator.php` 9.5.0 → 9.7.0
	* `hittheroad-2021/woocommerce/emails/customer-invoice.php` 9.6.0 → 9.7.0
	* `hittheroad-2021/woocommerce/emails/email-order-details.php` 3.7.0 → 9.7.0
	* `hittheroad-2021/woocommerce/loop/orderby.php` 3.6.0 → 9.7.0
	* `hittheroad-2021/woocommerce/myaccount/form-edit-account.php` 9.6.0 → 9.7.0
	* `hittheroad-2021/woocommerce/myaccount/form-login.php` 9.2.0 → 9.7.0
	* `hittheroad-2021/woocommerce/single-product/meta.php` 3.0.0 → 9.7.0
	* `hittheroad-2021/woocommerce/single-product/product-image.php` 9.0.0 → 9.7.0


## 18.02.2025

* Mises à jour templates woocommerce
	* `hittheroad-2021/woocommerce/cart/shipping-calculator.php` 7.0.1 → 9.5.0
	* `hittheroad-2021/woocommerce/emails/customer-invoice.php` 3.7.0 → 9.6.0
	* `hittheroad-2021/woocommerce/myaccount/form-edit-account.php` 8.7.0 → 9.6.0
	* `hittheroad-2021/woocommerce/myaccount/orders.php` 9.2.0 → 9.5.0
	* `hittheroad-2021/woocommerce/order/order-details.php` 9.0.0 → 9.6.0
	* `hittheroad-2021/woocommerce/single-product/add-to-cart/variable.php` 6.1.0 → 9.6.0
	* `hittheroad-2021/woocommerce/single-product/product-thumbnails.php` 3.5.1 → 9.5.0
	* `hittheroad-2021/woocommerce/single-product/related.php` 3.9.0 → 9.6.0
	* `hittheroad-2021/woocommerce/single-product/tabs/tabs.php` 3.8.0 → 9.6.0
	* `hittheroad-2021/woocommerce/single-product/up-sells.php` 3.0.0 → 9.6.0
* Mise à jour du script Pacific Colours


## 14.11.2024

* Mises à jour templates woocommerce
  * `hittheroad-2021/woocommerce/content-product.php` 3.6.0 → 9.4.0
  * `hittheroad-2021/woocommerce/global/quantity-input.php` 7.8.0 → 9.4.0
  * `hittheroad-2021/woocommerce/loop/result-count.php` 3.7.0 → 9.4.0

## 16.10.2024

* Mise à jour du script Pacific Colours

## 30.09.2024

* Mises à jour templates pour accessibilité

## 22.09.2024

* Mises à jour templates woocommerce
  * `hittheroad-2021/woocommerce/loop/add-to-cart.php` 9.0.0 → 9.2.0
  * `hittheroad-2021/woocommerce/loop/pagination.php` 3.3.1 → 9.3.0
  * `hittheroad-2021/woocommerce/myaccount/form-edit-address.php` 7.0.1 → 9.3.0
  * `hittheroad-2021/woocommerce/myaccount/my-address.php` 9.2.0 → 9.3.0
  * `hittheroad-2021/woocommerce/myaccount/navigation.php` 9.0.0 → 9.3.0
  * `hittheroad-2021/woocommerce/single-product/product-attributes.php` 3.6.0 → 9.3.0
* Mise à jour script Google sheet

## 29.08.2024

* Mises à jour templates woocommerce
  * `hittheroad-2021/woocommerce/global/form-login.php` 7.0.1 → 9.2.0
  * `hittheroad-2021/woocommerce/myaccount/form-login.php` 7.0.1 → 9.2.0
  * `hittheroad-2021/woocommerce/myaccount/form-lost-password.php` 9.0.0 → 9.2.0
  * `hittheroad-2021/woocommerce/myaccount/form-reset-password.php` 7.0.1 → 9.2.0
  * `hittheroad-2021/woocommerce/myaccount/my-address.php` 8.7.0 → 9.2.0
  * `hittheroad-2021/woocommerce/myaccount/orders.php` 9.1.0 → 9.2.0

## 26.07.2024

* Mise à jour ACF-Pro
* Mise à jour ACF-Country
* Mise à jour Stripe (nouveau form)
* Debugs css font
* Debugs php version

F2024 ----------------------------------------------

## 17.07.2024

* Mises à jour templates woocommerce
  * `hittheroad-2021/woocommerce/myaccount/orders.php` 8.5.0 → 9.1.0
  * `hittheroad-2021/woocommerce/single-product/product-image.php` 7.8.0 → 9.0.0
* Documentation Packs

## 11.07.2024

* Système de packs de produits
  * Système de promotions automatiques par packs de produits
  * Présentation du contenu des packs (front)

## 18.06.2024

* Mise à jour script order-status.js
* Mises à jour templates woocommerce
  * `hittheroad-2021/woocommerce/loop/add-to-cart.php` 3.3.0 → 9.0.0
  * `hittheroad-2021/woocommerce/myaccount/form-lost-password.php` 7.0.1 → 9.0.0
  * `hittheroad-2021/woocommerce/myaccount/navigation.php` 2.6.0 → 9.0.0
  * `hittheroad-2021/woocommerce/order/order-details.php` 8.5.0 → 9.0.0

## 15.06.2024

* Mises à jour templates woocommerce
  * `hittheroad-2021/woocommerce/archive-products.php` 3.4.0 → 8.6.0
  * `hittheroad-2021/woocommerce/cart/cart-shipping.php` 7.3.0 → 8.8.0
  * `hittheroad-2021/woocommerce/myaccount/form-edit-account.php` 7.0.1 → 8.7.0
  * `hittheroad-2021/woocommerce/myaccount/my-address.php` 2.6.0 → 8.7.0
  * `hittheroad-2021/woocommerce/myaccount/payment-method.php` 7.8.0 → 8.9.0
  * `hittheroad-2021/woocommerce/notices/error.php` 8.5.0 → 8.6.0
  * `hittheroad-2021/woocommerce/notices/notice.php` 8.5.0 → 8.6.0
  * `hittheroad-2021/woocommerce/notices/success.php` 8.5.0 → 8.6.0
* Plugin HtR Vimeo
  * Nouveau type de contenu "Films"
  * Modification page "Nos films"
  * Génération des codes Viméo pour les films
* Debug méthodes de livraison
* Système d’update du status depuis Google Sheets
  * Script order-status.js pour App Scripts
  * API REST woocommerce

## 30.01.2024

* Mise à jour de PHP (8.0 → 8.2)
* Mise à jour templates woocommerce
  * `hittheroad-2021/woocommerce/myaccount/orders.php` 7.8.0 → 8.5.0
  * `hittheroad-2021/woocommerce/notices/error.php` 3.9.0 → 8.5.0
  * `hittheroad-2021/woocommerce/notices/notice.php` 3.9.0 → 8.5.0
  * `hittheroad-2021/woocommerce/notices/success.php` 3.9.0 → 8.5.0
* Débug classes d’expédition
* Modifications produits (classe d’expédition manquantes)

## 01.01.2024

* Mises à jour de sécurité
* Évolution script du Google Sheet (contenu automatisé)

## 09.12.2023

* Modification script Google (Ajout mailing)

## 11.10.2023

* Mise à jour templates woocommerce
  * `hittheroad-2021/woocommerce/checkout/payment.php` 7.8.0 → 8.1.0
  * `hittheroad-2021/woocommerce/checkout/thankyou.php` 3.7.0 → 8.1.0

## 12.09.2023

* Mise à jour manuelle du doc Google Sheet (3 commandes manquantes après blocage en écriture)

## 09.08.2023

* Mise à jour Wordpress 6.3
* Mise à jour templates woocommerce
  * `hittheroad-2021/woocommerce/cart/cart.php` 7.8.0 → 7.9.0
