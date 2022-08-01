<?php
$theme = wp_get_theme();
define('THEME_VERSION', $theme->Version);

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
require_once 'classes/htr-scripts.php';
require_once 'classes/htr-templates.php';
require_once 'classes/htr-tools.php';
require_once 'classes/htr-walkers.php';
require_once 'classes/htr-woocommerce.php';
require_once 'inc/disable-comments.php';
require_once 'inc/woocommerce-functions.php';

// Add New Variation Settings
add_filter('woocommerce_available_variation', 'load_variation_settings_fields');

/**
 * Add custom fields for variations
 *
*/
function load_variation_settings_fields($variations) {
	// duplicate the line for each field
	$variations['text_field'] = get_post_meta($variations[ 'variation_id' ], '_text_field', true);
	return $variations;
}

// Render fields at the bottom of variations - does not account for field group order or placement.
add_action('woocommerce_product_after_variable_attributes', function($loop, $variation_data, $variation) {
	global $abcdefgh_i; // Custom global variable to monitor index
	$abcdefgh_i = $loop;
	// Add filter to update field name
	add_filter('acf/prepare_field', 'acf_prepare_field_update_field_name');

	// Loop through all field groups
	$acf_field_groups = acf_get_field_groups();
	foreach($acf_field_groups as $acf_field_group) {
		foreach($acf_field_group['location'] as $group_locations) {
			foreach($group_locations as $rule) {
				// See if field Group has at least one post_type = Variations rule - does not validate other rules
				if($rule['param'] == 'post_type' && $rule['operator'] == '==' && $rule['value'] == 'product_variation') {
					// Render field Group
					acf_render_fields($variation->ID, acf_get_fields($acf_field_group));
					break 2;
				}
			}
		}
	}

	// Remove filter
	remove_filter('acf/prepare_field', 'acf_prepare_field_update_field_name');
}, 10, 3);

// Filter function to update field names
function acf_prepare_field_update_field_name($field) {
	global $abcdefgh_i;
	$field['name'] = preg_replace('/^acf\[/', "acf[$abcdefgh_i][", $field['name']);
	return $field;
}

// Save variation data
add_action('woocommerce_save_product_variation', function($variation_id, $i = -1) {
	// Update all fields for the current variation
	if (!empty($_POST['acf']) && is_array($_POST['acf']) && array_key_exists($i, $_POST['acf']) && is_array(($fields = $_POST['acf'][ $i ]))) {
		foreach ($fields as $key => $val) {
			update_field($key, $val, $variation_id);
		}
	}
}, 10, 2);

/* add_action('wp_ajax_query_products', 'ajax_query_products');
add_action('wp_ajax_nopriv_query_products', 'ajax_query_products');

function ajax_query_products () {
	$security = wp_verify_nonce($_POST['nonce'], 'htr-queryproducts-nonce');

	$json = [];
	ob_start();
	get_template_part('template-parts/products-list');
	$json['html'] = ob_get_contents();
	ob_end_clean();

	echo wp_json_encode($json);
	wp_die();
} */

// Disable sitemaps
add_filter('wp_sitemaps_enabled', '__return_false');

function noIndexPage ($id) {
	if (get_field('no-index', 'option') === null) return;
	foreach(get_field('no-index', 'option') as $page) :
		if ($id == $page) : ?>
			<meta name="robots" content="noindex,nofollow">
		<?php endif;
	endforeach;
}

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
			} else {
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
