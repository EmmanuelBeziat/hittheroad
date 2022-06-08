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
		// Finish
		/* add_action('woocommerce_product_after_variable_attributes', [$this, 'variation_finish'], 10, 3);
		add_action('woocommerce_save_product_variation', [$this, 'save_variation_finish'], 10, 2);
		add_action('woocommerce_available_variation', [$this, 'load_variation_finish']); */

		add_action('woocommerce_cart_calculate_fees', [$this, 'woocommerce_custom_shipping_tax'], 10, 1);
		add_action('wp_head', [$this, 'get_current_shipping_method']);
		add_filter('loop_shop_per_page', [$this, 'products_per_page'], 30);
		add_filter('woocommerce_product_get_weight', '__return_false');
		add_filter('woocommerce_single_product_image_html', [$this, 'custom_single_product_image_html']);

		// add_action('woocommerce_single_variation', [$this, 'custom_product_variation_options'], 10, 3);
		/* add_action('woocommerce_before_add_to_cart_quantity', [$this, 'get_current_variation_options']);

		add_action('wp_ajax_live_change_variation', [$this, 'live_change_variation']);
		add_action('wp_ajax_nopriv_live_change_variation', [$this, 'live_change_variation']); */
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

	// Finish
/* 	public function variation_finish ($loop, $variation_data, $variation) {
		woocommerce_wp_hidden_input([
			'id' => "finish{$loop}",
			'name' => "finish[{$loop}]",
			'value' => get_post_meta($variation->ID, 'finish', true),
			'label' => __('Finition', 'htr'),
			'desc_tip' => true,
			'description' => __('Enregistre la finition pour cette variation', 'htr'),
		]);
	}

	public function save_variation_finish ($variation_id, $loop) {
		$finish = isset($_POST['finish'][$loop]) ? $_POST['finish'][$loop] : '';
		update_post_meta($variation_id, 'finish', esc_attr($finish));
	}

	public function load_variation_finish ($variation) {
		$variation['finish'] = get_post_meta($variation['variation_id'], 'finish', true);
		return $variation;
	} */

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
		$attachment_ids = get_the_post_thumbnail_url($product->get_id(), 'product-preview');
		$imageSize = getimagesize($attachment_ids);
		$containerClass = $imageSize[0] > $imageSize[1] ? 'paysage' : 'portrait';
		$replacement = ['/class="woocommerce-product-gallery__image /', '/src="(.*?)"/', '/width="(.*?)"/', '/height="(.*?)"/'];
		$image = preg_replace($replacement, ['class="woocommerce-product-gallery__image '.$containerClass, 'src="'.$attachment_ids.'"', 'width="'.$imageSize[0].'"', 'height="'.$imageSize[1].'"'], $args);
		echo $image;
	}

	public function add_finish_price () {
		$cart_item_price     = is_numeric( $cart_item['data']->get_price() ) ? ( $cart_item['data']->get_price() / $currency_rate ) : 0;
		$total_options_price = $total_options_price / $currency_rate;
		$cart_item['data']->set_price( $cart_item_price + $total_options_price );
	}

	public function custom_product_variation_options () {
		global $product;
		$product_id = $product->get_id();
		$finish_options = get_field('finish-styles', 'option');

		// HTR_Tools::dd($variation->get_id());
		?>
		<div class="mb-4 finish-styles-variations">
		<?php foreach ($finish_options as $finish) :
			$price = $finish['fee'] === '0' ? 'Aucun surcoût' : '+ '.$finish['fee'].'€';
			$related = (object) [
				'name' => $finish['related'][0]->name,
				'slug' => $finish['related'][0]->slug,
				'id' => $finish['related'][0]->term_taxonomy_id,
			];
			$sanitized = sanitize_title($finish['label'].'-'.$related->slug);
			// HTR_Tools::dd($product);
		?>
			<div class="mb-2 <?= $sanitized ?>">
				<input class="form-check-input" type="radio" name="finish-option" id="<?= $sanitized ?>" value="<?= $finish['fee'] ?>">
				<label class="form-check-label" for="<?= $sanitized ?>"><?= $finish['label'] ?> <small>(<?= $price ?>)</small></label>
			</div>
		<?php endforeach; ?>
		</div>
		<?php
	}

	public function get_current_variation_options () {
		global $product;
		if ($product->is_type('variable')) {
			$variation_id = $product->get_id();
			$current_variation_size = wc_get_product($variation_id)->get_variation_attributes()['attribute_pa_size'];
			HTR_Tools::dd($current_variation_size);
			/* $finish = get_post_meta($variation_id, 'finish', true);
			$finish_options = get_field('finish-styles', 'option');
			foreach ($finish_options as $option) {
				if ($option['label'] === $finish) {
					return $option;
				}
			} //*/
		}
	}

	public function live_change_variation () {
		global $woocommerce, $product, $variation;
		$product = wc_get_product($product_id);
		HTR_Tools::dd($product_id);
		wp_die();
	}
}

new HTR_Woocommerce();
