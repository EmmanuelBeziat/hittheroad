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
		$custom_css = '/assets/css/custom.css';
		$custom_js = '/assets/js/custom.js';

		// CSS
		wp_enqueue_style('cc-app', get_template_directory_uri().'/assets/css/app.css', [], '1.0.0');
		if (file_exists(get_template_directory().$custom_css)) {
			wp_enqueue_style('cc-custom', get_template_directory_uri().$custom_css, ['cc-app'], '1.0.0');
		}

		// External CSS

		// JS
		wp_enqueue_script('cc-vendors', get_template_directory_uri().'/assets/js/vendors.js', [], '1.0.0', true);
		wp_enqueue_script('cc-app', get_template_directory_uri().'/assets/js/app.js', [], '1.0.0', true);
		if (file_exists(get_template_directory().$custom_js)) {
			wp_enqueue_script('cc-custom', get_template_directory_uri().$custom_js, ['cc-app'], '1.0.0', true);
		}

		// External JS

		// AJAX
	}
}
new HTR_Scripts();
