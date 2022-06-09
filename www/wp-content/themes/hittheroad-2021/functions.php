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
function  acf_prepare_field_update_field_name($field) {
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
}
 */
