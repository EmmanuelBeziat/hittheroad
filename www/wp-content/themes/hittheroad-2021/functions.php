<?php

add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');

	register_nav_menus([
		'navigation' => __('Menu principal'),
		'social' => __('Menu Réseaux sociaux'),
		'footer-left' => __('Pied de page — Gauche'),
		'footer-center' => __('Pied de page — Centre'),
		'footer-right' => __('Pied de page — Droite'),
	]);
});

require_once 'classes/htr-scripts.php';
require_once 'classes/htr-walkers.php';
require_once 'classes/htr-templates.php';
require_once 'classes/htr-tools.php';
require_once 'inc/disable-comments.php';

function debug ($message, $exit = false) {
	echo '<pre style="padding: 1rem; margin: 1rem 0; background: #e8e8e8; color: 2f2f2f;">';
	print_r($message);
	echo '</pre>';

	if ($exit) {
		exit();
	}
}

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
