<?php
/**
 * Script functions.
 */
class HTR_Scripts {
	/**
	 * Add WordPress' actions and filters.
	 */
	function __construct () {
		add_action('wp_enqueue_scripts', [$this, 'front_scripts']);
		add_action('login_enqueue_scripts', [$this, 'login_scripts']);
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function front_scripts () {
		$custom_css = '/assets/css/custom.css';
		$custom_js = '/assets/js/custom.js';

		// CSS
		wp_enqueue_style('htr-app', get_template_directory_uri().'/assets/css/app.css', [], THEME_VERSION);

		if (file_exists(get_template_directory().$custom_css)) {
			wp_enqueue_style('htr-custom', get_template_directory_uri().$custom_css, ['htr-app'], THEME_VERSION);
		}

		// External CSS

		// JS
		wp_enqueue_script('htr-vendors', get_template_directory_uri().'/assets/js/vendors.js', [], THEME_VERSION, true);
		wp_enqueue_script('htr-classes', get_template_directory_uri().'/assets/js/classes.js', [], THEME_VERSION, true);
		wp_enqueue_script('htr-app', get_template_directory_uri().'/assets/js/app.js', [], THEME_VERSION, true);

		if (file_exists(get_template_directory().$custom_js)) {
			wp_enqueue_script('htr-custom', get_template_directory_uri().$custom_js, ['htr-app'], THEME_VERSION, true);
		}

		// External JS

		// AJAX
	}

	public function login_scripts () {
    wp_enqueue_style('htr-login', get_stylesheet_directory_uri().'/assets/css/login-style.css');
	}
}
new HTR_Scripts();
