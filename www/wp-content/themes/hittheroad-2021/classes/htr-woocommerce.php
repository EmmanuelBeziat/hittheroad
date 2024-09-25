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
		add_action('woocommerce_before_calculate_totals', [$this, 'apply_custom_pricing_rules'], 10, 1);
		add_action('woocommerce_before_cart_table', [$this, 'pack_apply_discount_to_cart'], 10, 1);
		add_action('woocommerce_cart_updated', [$this, 'pack_update_discount_to_cart'], 10, 1);
		add_filter('woocommerce_coupon_is_valid', [$this, 'pack_validate_coupon'], 10, 3);

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
			$parent_product_id = $item['product_id'];

			if ($parent_product_id) {
				$vimeoCode = get_field('vimeo-code', $parent_product_id);
				$videoId = intval(get_field('movie', $parent_product_id)) ?? NULL;
				if ($vimeoCode && $videoId) {
					$HTRVimeoCode = new HTRVimeoCode();
					if ($HTRVimeoCode instanceof HTRVimeoCode) {
						$vimeo = $HTRVimeoCode->applyCodeAtSale($videoId) ?? NULL;

						if (isset($vimeo) && $vimeo) {
							$code = $vimeo->code;
						}
						else {
							$orderNumber = $payload['id'];
							$email = get_option('admin_email');
							$subject = 'Code Viméo manquant pour la commande n°' . $orderNumber;
							$message = 'La commande n° ' . $orderNumber . ' a besoin d’un code Viméo qui n’a pas pu être ajouté automatiquement.';
							wp_mail($email, $subject, $message);
							error_log(print_r('Code Viméo manquant pour la commande n°' . $orderNumber, true));
						}
					}
				}
			}
			$payload['line_items'][$key]['width'] = $product['_length'][0];
			$payload['line_items'][$key]['height'] = $product['_width'][0];
			$payload['line_items'][$key]['number'] = (intval($product['max_stock_qty'][0]) - intval($product['_stock'][0])) . '/' . $product['max_stock_qty'][0];
			$payload['line_items'][$key]['vimeo_code'] = $code;
		}

		return $payload;
	}

	public function apply_custom_pricing_rules ($cart) {
		if (is_admin() && !defined('DOING_AJAX')) {
			return;
		}

		// Get the custom field values
		$packs = get_field('pack', 'option');
		$packs_list = (object) [
			'isActive' => false,
			'products_list' => [],
			'discounts' => []
		];

		if ($packs) {
			$active_packs = array_filter($packs, fn($pack) => $pack['active']);
			$packs_list->isActive = !empty($active_packs);

			$packs_list->products_list = array_merge(...array_map(fn($pack) => $pack['products_list'] ?? [], $active_packs));
			$packs_list->discounts = array_merge(...array_map(fn($pack) => array_map(fn($discount) => (object) [
				'product_number' => $discount['product_number'] ?? 0,
				'discount' => $discount['discount'] ?? 0
			], $pack['discounts'] ?? []), $active_packs));
		}

		if (!$packs_list->isActive) {
			error_log("No active packs found");
			return;
		}

		$cart_product_ids = array_map(fn($cart_item) => $cart_item['product_id'], $cart->get_cart());
		$pack_product_count = count(array_intersect($cart_product_ids, $packs_list->products_list));
		$pack_products = [];

		if ($pack_product_count < 2) {
			error_log("Not enough pack products in cart");
			return;
		}

		// Collect all pack products in the cart
		foreach ($cart->get_cart() as $cart_item) {
			$product_id = $cart_item['product_id'];
			if (in_array($product_id, $packs_list->products_list)) {
				$pack_products[] = $cart_item;
			}
		}

		// Apply discounts to the collected pack products
		foreach ($packs_list->discounts as $discount) {
			$processed_quantity = 0;

			foreach ($pack_products as $cart_item) {
				$quantity = $cart_item['quantity'];

				while ($quantity > 0 && $processed_quantity < $discount->product_number) {
					$processed_quantity++;
					$quantity--;

					error_log("Processed quantity: $processed_quantity, Discount product number: {$discount->product_number}");

					if ($processed_quantity == $discount->product_number) {
						$original_price = $cart_item['data']->get_regular_price();
						$discounted_price = $original_price * ((100 - $discount->discount) / 100);
						$cart_item['data']->set_price($discounted_price);
						// Log debug information
						error_log("Discount applied: Product ID: {$cart_item['product_id']}, Original Price: $original_price, Discounted Price: $discounted_price");
						$processed_quantity = 0; // Reset processed_quantity to apply next discount level correctly
						break; // Break to avoid applying the same discount multiple times
					}
				}
			}
		}
	}

	/**
	 * Apply a discount to the cart based on the number of products from a specific category.
	 */
	public function pack_apply_discount_to_cart () {
		$couponRules = $this->get_custom_coupon_rules();
		$cart = WC()->cart;

		if (empty($cart->get_cart())) {
			return;
		}

		$productsInCategories = [];
		$categoryIds = [];
    foreach ($couponRules as $rule) {
			$categoryIds[$rule['category']] = true;
    }

		// Count products in the category
		foreach ($cart->get_cart() as $cartItem) {
			$productId = $cartItem['product_id'];
			$productCategories = get_the_terms($productId, 'product_cat');

			if (is_array($productCategories)) {
				foreach ($productCategories as $category) {
					$categoryId = $category->term_id;
					$categoryName = $category->name;
					$categorySlug = $category->slug;

					// Check if this category is targeted by any coupon rule
					if (isset($categoryIds[$categoryName])) {
						if (!isset($productsInCategories[$categoryName])) {
							$productsInCategories[$categoryName] = 0; // Initialize count if not already set
						}
						$productsInCategories[$categoryName]++;
					}
				}
			}
		}

		// Determine which coupon to apply based on the number of products in 'movies' category
    $couponToApply = '';
    foreach ($couponRules as $couponCode => $rule) {
			$categoryTarget = $rule['category'];
			$itemCountCondition = $rule['itemCountCondition'];

			if (isset($productsInCategories[$categoryTarget]) && $productsInCategories[$categoryTarget] >= $itemCountCondition) {
				$couponToApply = $couponCode;
				break; // Exit loop as soon as a coupon is found to apply
			}
    }

		// Apply or remove coupons accordingly
    foreach ($couponRules as $couponCode => $rule) {
			$couponCodeSanitized = sanitize_text_field($couponCode);

			if ($couponCode === $couponToApply) {
				if (!$cart->has_discount($couponCodeSanitized)) {
					$cart->apply_coupon($couponCodeSanitized);
				}
			}
			else {
				if ($cart->has_discount($couponCodeSanitized)) {
					$cart->remove_coupon($couponCodeSanitized);
				}
			}
    }
	}

	/**
	 * Validate the coupon application based on custom conditions.
	 *
	 * @param bool $valid Indicates if the coupon is valid.
	 * @param WC_Coupon $coupon The coupon object.
	 * @param WC_Discounts $discounts The discounts object.
	 * @return bool
	 */
	public function pack_validate_coupon ($valid, $coupon, $discounts) {
		$couponRules = $this->get_custom_coupon_rules();

		$couponCode = $coupon->get_code();
		$couponCodeSanitized = sanitize_text_field($couponCode);

		// Check if the coupon has a defined rule
		if (isset($couponRules[$couponCodeSanitized])) {
			$categoryTarget = $couponRules[$couponCodeSanitized]['category'];
			$itemCountCondition = $couponRules[$couponCodeSanitized]['itemCountCondition'];
			$cart = WC()->cart;
			$productsInCategory = 0;

			// Iterate through cart items and count products in the target category
			foreach ($cart->get_cart() as $cartItem) {
				$productId = $cartItem['product_id'];
				$productCategories = get_the_terms($productId, 'product_cat');

				if (is_array($productCategories)) {
					// Check if the target category exists in the product's categories
					$categoryNames = wp_list_pluck($productCategories, 'name');
					if (in_array($categoryTarget, $categoryNames, true)) {
						$productsInCategory++;
					}
				}
			}

			// Validate based on the custom condition
			if ($productsInCategory >= $itemCountCondition) {
				$valid = true;
			}
			else {
				$valid = false;
				wc_add_notice(__('The coupon cannot be applied as the condition is not met.', 'woocommerce'), 'error');
			}
		}

		return $valid;
	}

	public function pack_update_discount_to_cart () {
		$this->pack_apply_discount_to_cart();
	}

	/**
	 * Get coupon rules from ACF fields.
	 * @return array Associative array of coupon rules.
	 */
	public function get_custom_coupon_rules () {
		$couponRules = [];

		// Get the custom field values using ACF functions
		$rulesList = get_field('pack', 'option');

		if (!is_array($rulesList)) {
			return $couponRules; // Return empty array if rulesList is not an array
		}

		foreach ($rulesList as $rule) {
			if (isset($rule['active']) && $rule['active']) {
				// HTR_Tools::dd($rule);
				$productCategory = $rule['product_category'] ?? 0; // Assuming product_category is a single category ID


				// Ensure $productCategory is not empty and is a valid category ID
				if ($productCategory && is_int($productCategory)) {
					// Loop through coupon rules for the current rule
					if (isset($rule['coupon_rules']) && is_array($rule['coupon_rules'])) {
						foreach ($rule['coupon_rules'] as $couponRule) {
							$couponID = $couponRule['coupon'] ?? 0;
							$productsCount = $couponRule['products_count'] ?? 0;

							// Fetch coupon code from coupon post object
							$couponCode = '';
							if ($couponID && ($couponPost = get_post($couponID)) && $couponPost->post_type === 'shop_coupon') {
								$couponCode = $couponPost->post_title; // Assuming post_title is the coupon code
							}

							// Add coupon rule to the output array
							if ($couponCode && $productsCount > 0) {
								$productCategoryName = get_term_by('term_id', $productCategory, 'product_cat')->name;
								$couponRules[$couponCode] = [
									'category' => $productCategoryName,
									'itemCountCondition' => $productsCount,
								];
							}
						}
					}
				}
			}
		}

		return $couponRules;
	}
}

new HTR_Woocommerce();
