<?php

add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');

	register_nav_menus([
		'navigation' => __('Menu principal'),
		'social' => __('Menu Réseaux sociaux'),
		'footer' => __('Pied de page'),
	]);
});

require_once 'classes/htr-scripts.php';
require_once 'classes/htr-walkers.php';
require_once 'classes/htr-templates.php';
require_once 'classes/htr-tools.php';
require_once 'inc/disable-comments.php';
