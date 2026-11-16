<?php
defined('ABSPATH') || exit;
/**
 * Script functions.
 */
class HTR_Scripts {
	/**
	 * Add WordPress' actions and filters.
	 */
	function __construct () {
		add_action('wp_enqueue_scripts', [$this, 'front_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'dequeue_unused_plugin_assets'], 100);
		add_action('login_enqueue_scripts', [$this, 'login_scripts']);
	}

	/**
	 * Remove plugin assets from pages that do not use them.
	 */
	public function dequeue_unused_plugin_assets () {
		// Additional Product Fields: only for WooCommerce cart blocks (not used, cart/checkout are classic).
		// It pulls the whole WooCommerce Blocks/React stack on every page.
		wp_dequeue_script('rn-cart-block-edit');

		if ($this->has_contact_form()) {
			return;
		}

		// Contact Form 7 and its anti-spam add-ons
		foreach (['contact-form-7', 'swv', 'spam-protect-for-contact-form7', 'altcha-widget-custom-options'] as $handle) {
			wp_dequeue_script($handle);
		}
		foreach (['contact-form-7', 'cf7apps-honeypot-frontend', 'spam-protect-for-contact-form7'] as $handle) {
			wp_dequeue_style($handle);
		}
	}

	/**
	 * Whether the current page content contains a Contact Form 7 form (shortcode or block).
	 *
	 * @return bool
	 */
	private function has_contact_form () {
		$post = get_post();

		return is_singular() && $post && (has_shortcode($post->post_content, 'contact-form-7') || has_block('contact-form-7/contact-form-selector', $post));
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
		/* wp_localize_script('htr-app', 'query_products', [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('htr-queryproducts-nonce'),
		]); */
	}

	public function login_scripts () {
    wp_enqueue_style('htr-login', get_stylesheet_directory_uri().'/assets/css/login-style.css');
	}
}
new HTR_Scripts();
