<?php
$theme = wp_get_theme()->get('Version');
define('THEME_VERSION', is_string($theme) ? $theme : false);

add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	add_theme_support('woocommerce');

	register_nav_menus([
		'navigation' => __('Menu principal'),
		'footer-center' => __('Pied de page'),
	]);
});

require_once 'classes/htr-acf.php';
require_once 'classes/htr-admin.php';
// require_once 'classes/htr-locations.php';
require_once 'classes/htr-custom-post-types.php';
require_once 'classes/htr-scripts.php';
require_once 'classes/htr-templates.php';
require_once 'classes/htr-tools.php';
require_once 'classes/htr-walkers.php';
require_once 'classes/htr-woocommerce.php';
require_once 'inc/disable-comments.php';
require_once 'inc/woocommerce-functions.php';

// Disable sitemaps
add_filter('wp_sitemaps_enabled', '__return_false');

if (!function_exists('wc_dropdown_variation_attribute_options')) {
function wc_dropdown_variation_attribute_options($args = []) {
	$args = wp_parse_args(
		apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args),
		[
			'options'          => false,
			'attribute'        => false,
			'product'          => false,
			'selected'         => false,
			'name'             => '',
			'id'               => '',
			'class'            => '',
			'show_option_none' => __('Choose an option', 'woocommerce'),
		]
	);

	// Get selected value.
	if (false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
		$selected_key = 'attribute_' . sanitize_title($args['attribute']);
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$args['selected'] = isset($_REQUEST[ $selected_key ]) ? wc_clean(wp_unslash($_REQUEST[ $selected_key ])) : $args['product']->get_variation_default_attribute($args['attribute']);
		// phpcs:enable WordPress.Security.NonceVerification.Recommended
	}

	$options               = $args['options'];
	$product               = $args['product'];
	$attribute             = $args['attribute'];
	$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title($attribute);
	$id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
	$class                 = $args['class'];
	$show_option_none      = (bool) $args['show_option_none'];
	$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce'); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

	if (empty($options) && ! empty($product) && ! empty($attribute)) {
		$attributes = $product->get_variation_attributes();
		$options    = $attributes[ $attribute ];
	}

	$html  = '<select id="' . esc_attr($id) . '" class="' . esc_attr($class) . '" name="' . esc_attr($name) . '" data-attribute_name="attribute_' . esc_attr(sanitize_title($attribute)) . '" data-show_option_none="' . ($show_option_none ? 'yes' : 'no') . '">';
	$html .= '<option value="">' . esc_html($show_option_none_text) . '</option>';

	if (! empty($options)) {
		if ($product && taxonomy_exists($attribute)) {
			// Get terms if this is a taxonomy - ordered. We need the names too.
			$terms = wc_get_product_terms(
				$product->get_id(),
				$attribute,
				[
					'fields' => 'all',
				]
			);

			foreach ($terms as $key => $term) {
				if (in_array($term->slug, $options, true)) {
					$size = HTR_Woocommerce::get_variation_size($product);
					$html .= '<option value="' . esc_attr($term->slug) . '" ' . selected(sanitize_title($args['selected']), $term->slug, false) . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $term->name, $term, $attribute, $product)) . ' ('. $size[$key][0] . '×' . $size[$key][1] .' cm)</option>';
				}
			}
		}
		else {
			foreach ($options as $option) {
				// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
				$selected = sanitize_title($args['selected']) === $args['selected'] ? selected($args['selected'], sanitize_title($option), false) : selected($args['selected'], $option, false);
				$html    .= '<option value="' . esc_attr($option) . '" ' . $selected . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $option, null, $attribute, $product)) . '</option>';
			}
		}
	}

	$html .= '</select>';

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo apply_filters('woocommerce_dropdown_variation_attribute_options_html', $html, $args);
}
}

add_filter('wpcf7_autop_or_not', '__return_false');
