<?php
/**
 * ACF functions.
 */
class HTR_Admin {
	/**
	 * Add Wordpress' actions and filters.
	 */
	function __construct() {
		add_action('admin_init', [$this, 'theme_additional_images']);
		add_action('admin_init', [$this, 'editor_styles']);
	}

	public function theme_additional_images() {
		global $_wp_additional_image_sizes;
    $get_intermediate_image_sizes = get_intermediate_image_sizes();

    // echo '<pre>' . print_r($_wp_additional_image_sizes) . '</pre>';
	}

	public function editor_styles() {
		add_editor_style('assets/css/editor-style.css');
	}
}
new HTR_Admin();
