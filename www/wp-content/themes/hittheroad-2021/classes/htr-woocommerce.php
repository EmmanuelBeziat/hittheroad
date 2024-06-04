<?php
/**
 * Woocommerce functions.
 */
class HTR_Woocommerce {
	/**
	 * Add Wordpress' actions and filters.
	 */
	function __construct () {
		add_action('template_redirect', [$this, 'remove_shop_breadcrumbs']);
		// quantity
		add_action('woocommerce_product_after_variable_attributes', [$this, 'variation_max_qty_field'], 10, 3);
		add_action('woocommerce_save_product_variation', [$this, 'save_variation_max_qty_field'], 10, 2);
		add_action('woocommerce_available_variation', [$this, 'load_variation_max_qty_field']);

		add_action('woocommerce_cart_calculate_fees', [$this, 'woocommerce_custom_shipping_tax'], 10, 1);
		add_action('wp_head', [$this, 'get_current_shipping_method']);
		add_filter('loop_shop_per_page', [$this, 'products_per_page'], 30);
		add_filter('woocommerce_product_get_weight', '__return_false');
		add_filter('woocommerce_single_product_image_html', [$this, 'custom_single_product_image_html']);

		// Webhooks
		add_filter('woocommerce_webhook_payload', [$this, 'add_custom_webhook_payload'], 10, 4);
	}

	// Quantity
	public function variation_max_qty_field ($loop, $variation_data, $variation) {
		woocommerce_wp_text_input([
			'id' => "max_stock_qty{$loop}",
			'name' => "max_stock_qty[{$loop}]",
			'value' => get_post_meta($variation->ID, 'max_stock_qty', true),
			'label' => __('Stock maximal', 'htr'),
			'desc_tip' => true,
			'description' => __('Stock (nombre de tirages) maximal pour cette variation', 'htr'),
			'type' => 'number',
			'custom_attributes' => [
				'min' => 0,
				'step' => 1,
			],
			'wrapper_class' => 'form-row form-row-full',
		]);
	}

	public function save_variation_max_qty_field ($variation_id, $loop) {
		$max_stock_qty = isset($_POST['max_stock_qty'][$loop]) ? $_POST['max_stock_qty'][$loop] : '';
		update_post_meta($variation_id, 'max_stock_qty', esc_attr($max_stock_qty));
	}

	public function load_variation_max_qty_field ($variation) {
		$variation['max_stock_qty'] = get_post_meta($variation['variation_id'], 'max_stock_qty', true);
		return $variation;
	}

	public function remove_shop_breadcrumbs () {
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	}

	public function get_current_shipping_method () {
		$chosen_label = null;

		$packages = WC()->shipping->get_packages();
		foreach ($packages as $i => $package) {
			$chosen_method = isset(WC()->session->chosen_shipping_methods[$i]) ? WC()->session->chosen_shipping_methods[$i] : '';
			$chosen_label = $package['rates'][$chosen_method]->label;
		}

		return $chosen_label;
	}

	public function woocommerce_custom_shipping_tax () {
		global $woocommerce;

		if (is_admin() && !defined('DOING_AJAX')) {
			return;
		}

		$shipping_method = $this->get_current_shipping_method();
		$tax = $shipping_method === 'Express' ? get_field('shipping-taxes', 'option')['shipping-tax-express'] : get_field('shipping-taxes', 'option')['shipping-tax-std'];
		$percentage = $tax / 100;
		$shipping_total = $woocommerce->cart->get_shipping_total() * $percentage ?: 0;
		$woocommerce->cart->add_fee('Supplément carburant', $shipping_total, true, '');
	}

	public function products_per_page ($products) {
		return get_field('products-per-page', 'option') ?: 12;
	}

	public function custom_single_product_image_html ($args) {
		global $product;
		global $_wp_additional_image_sizes;
		$attachment_uri = get_the_post_thumbnail_url($product->get_id(), 'product-preview');
		$attachment_id = get_post_thumbnail_id($product->get_id());
		$imageSize = wp_get_attachment_image_src($attachment_id, 'product-preview');
		$containerClass = $imageSize[0] > $imageSize[1] ? 'paysage' : 'portrait';
		$replacement = ['/class="woocommerce-product-gallery__image /', '/src="(.*?)"/', '/width="(.*?)"/', '/height="(.*?)"/'];
		$image = preg_replace($replacement, ['class="woocommerce-product-gallery__image '.$containerClass, 'src="'.$attachment_uri.'"', 'width="'.$imageSize[0].'"', 'height="'.$imageSize[1].'"'], $args);
		echo $image;
	}

	public static function get_variation_size ($product) {
		$items = [];

		foreach ($product->get_children() as $key => $item) {
			array_push($items, [
				get_post_meta($item)['_length'][0],
				get_post_meta($item)['_width'][0]
			]);
		}

		return $items;
	}

	public function add_custom_webhook_payload ($payload, $resource, $resource_id, $id) {
		if ($resource !== 'order') return $payload;

		foreach ($payload['line_items'] as $key => $item) {
			$code = '';
			$product = get_post_meta($item['variation_id']);
			error_log('PRODUCT');
			var_dump($product);
			$parent_product_id = $product->get_parent_id();
			error_log($parent_product_id);
			var_dump($parent_product_id);

			/* if ($parent_product_id) {
				$vimeo_code = get_field('vimeo-code', $parent_product_id);
				if ($vimeo_code) {
					$HTRVimeoCode = get_option('htr_vimeo_code_instance');
					if ($HTRVimeoCode instanceof HTRVimeoCode) {
						$vimeo = $HTRVimeoCode->applyCodeAtSale();
						if ($vimeo) {
							$code = $vimeo;
						}
						else {
							$order_number = $payload['id'];
							$admin_email = get_option('admin_email');
							$subject = 'Code Viméo manquant pour la commande n°' . $order_number;
							$message = 'La commande n° ' . $order_number . ' a besoin d’un code Viméo qui n’a pas pu être ajouté automatiquement.';
							wp_mail($admin_email, $subject, $message);
						}
					}
				}
			} */
			$payload['line_items'][$key]['width'] = $product['_length'][0];
			$payload['line_items'][$key]['height'] = $product['_width'][0];
			$payload['line_items'][$key]['number'] = (intval($product['max_stock_qty'][0]) - intval($product['_stock'][0])) . '/' . $product['max_stock_qty'][0];
			$payload['line_items'][$key]['vimeo_code'] = $code;
		}

		return $payload;
	}
}

new HTR_Woocommerce();
