<?php
defined('ABSPATH') || exit;
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
		add_action('admin_notices', [$this, 'missing_plugins_notice']);
	}

	/**
	 * Plugins the theme relies on, with a presence check.
	 * "required": the theme breaks without them; "integrated": a theme feature depends on them.
	 *
	 * @return array<string, array<string, callable>>
	 */
	protected function theme_plugins () {
		return [
			'required' => [
				'WooCommerce' => fn () => class_exists('WooCommerce'),
				'Advanced Custom Fields PRO' => fn () => function_exists('acf_add_options_page'),
			],
			'integrated' => [
				'PDF Invoices & Packing Slips for WooCommerce (factures)' => fn () => defined('WPO_WCPDF_VERSION'),
				'Additional Product Fields for WooCommerce (options produit)' => fn () => function_exists('rednaowooextraproduct'),
				'WooCommerce Stripe Gateway (paiement)' => fn () => defined('WC_STRIPE_VERSION'),
				'YITH WooCommerce Zoom Magnifier (galerie produit)' => fn () => defined('YITH_YWZM_FREE') || defined('YITH_YWZM_PREMIUM'),
				'Contact Form 7 (formulaire de contact)' => fn () => defined('WPCF7_VERSION'),
				'Hit The Road — Codes Viméo (codes dans le webhook de commande)' => fn () => class_exists('HTRVimeoCode'),
				'F4 Shipping Phone and E-Mail (e-mail de livraison, Google Sheets)' => fn () => defined('F4_WCSPE_VERSION'),
				'WooCommerce Order Paid Webhook (Google Sheets)' => fn () => defined('WOPW_VERSION'),
			],
		];
	}

	/**
	 * Warn administrators when a plugin used by the theme is missing or inactive.
	 */
	public function missing_plugins_notice () {
		if (!current_user_can('activate_plugins')) {
			return;
		}

		$notices = [
			'required' => ['notice-error', 'Plugins indispensables au thème manquants ou inactifs :'],
			'integrated' => ['notice-warning is-dismissible', 'Plugins utilisés par des fonctionnalités du thème manquants ou inactifs :'],
		];

		foreach ($this->theme_plugins() as $level => $plugins) {
			$missing = array_keys(array_filter($plugins, fn ($is_active) => !$is_active()));
			if (!$missing) {
				continue;
			}

			[$class, $message] = $notices[$level];
			printf(
				'<div class="notice %s"><p><strong>Hit the Road</strong> — %s %s</p></div>',
				esc_attr($class),
				esc_html($message),
				esc_html(implode(', ', $missing))
			);
		}
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
