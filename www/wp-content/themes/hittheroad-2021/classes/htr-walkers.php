<?php
/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory().'/classes/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');

class HTR_WalkerNav extends Walker_Nav_Menu {
	function start_lvl (&$output, $depth = 2, $args = []) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"dropdown plr-15\">\n";
	}
}

class HTR_WalkerSocial extends Walker_Nav_Menu {
	function start_el (&$output, $item, $depth = 0, $args = [], $id = 0) {
		$output .= sprintf("\n<li><a class='s-icone' data-original-title='%s' href='%s' target='_blank'><i class='fa fa-%s'></i></a></li>\n", $item->title, $item->url, strtolower($item->title)
		);
	}
}
