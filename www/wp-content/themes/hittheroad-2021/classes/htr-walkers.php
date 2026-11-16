<?php
defined('ABSPATH') || exit;

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory().'/classes/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');
