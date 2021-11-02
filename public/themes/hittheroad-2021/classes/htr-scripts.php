<?php
/**
 * Script functions.
 */
class HTR_Scripts {
	/**
	 * Add WordPress' actions and filters.
	 */
	function __construct () {
		add_action('wp_enqueue_scripts', array($this, 'front_scripts'));
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function front_scripts () {
		$custom_css = '/assets/custom.css';
		$custom_js = '/assets/custom.js';

		// CSS
		if (file_exists(get_template_directory().$custom_css)) {
			wp_enqueue_style('cc-custom', get_template_directory_uri().$custom_css, [], '1.0.0');
		}

		// External CSS

		// JS
		if (file_exists(get_template_directory().$custom_js)) {
			wp_enqueue_script('cc-custom', get_template_directory_uri().$custom_js, [], '1.0.0', true);
		}

		// External JS

		// AJAX
	}
}
new HTR_Scripts();
