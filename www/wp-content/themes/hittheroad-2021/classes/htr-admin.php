<?php
/**
 * Admin functions.
 */
class HTR_Admin {
	/**
	 * Add Wordpress' actions and filters.
	 */
	function __construct() {
		add_action('admin_init', [$this, 'theme_additional_images']);
		add_action('admin_init', [$this, 'editor_styles']);
		add_action('admin_menu', [$this, 'remove_posts_menu']);
	}

	public function theme_additional_images() {
		global $_wp_additional_image_sizes;
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
	}

	/**
	 * Add editor styles
	 */
	public function editor_styles() {
		add_editor_style('assets/css/editor-style.css');
	}

	/**
	 * Remove posts menu.
	 */
	public function remove_posts_menu() {
    remove_menu_page('edit.php');
	}
}
new HTR_Admin();
