<?php
$theme = wp_get_theme();
define('THEME_VERSION', $theme->Version);

add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	add_theme_support('woocommerce');

	register_nav_menus([
		'navigation' => __('Menu principal'),
		// 'footer-left' => __('Pied de page — Gauche'),
		'footer-center' => __('Pied de page'),
		// 'footer-right' => __('Pied de page — Droite'),
	]);
});

require_once 'classes/htr-acf.php';
require_once 'classes/htr-admin.php';
// require_once 'classes/htr-locations.php';
require_once 'classes/htr-scripts.php';
require_once 'classes/htr-templates.php';
require_once 'classes/htr-tools.php';
require_once 'classes/htr-walkers.php';
require_once 'classes/htr-woocommerce.php';
require_once 'inc/disable-comments.php';
require_once 'inc/woocommerce-functions.php';

