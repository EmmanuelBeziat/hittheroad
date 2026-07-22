<?php
/**
 * Woocommerce functions.
 */
class HTR_Woocommerce {
	private $acf_variation_index = 0;

	/**
	 * Add Wordpress' actions and filters.
	 */
	function __construct () {
		add_action('template_redirect', [$this, 'remove_shop_breadcrumbs']);
		// quantity
		add_action('woocommerce_product_after_variable_attributes', [$this, 'variation_max_qty_field'], 10, 3);
		add_action('woocommerce_save_product_variation', [$this, 'save_variation_max_qty_field'], 10, 2);
		add_action('woocommerce_available_variation', [$this, 'load_variation_max_qty_field']);

		// ACF on variations
		add_filter('woocommerce_available_variation', [$this, 'load_variation_settings_fields']);
		add_action('woocommerce_product_after_variable_attributes', [$this, 'render_acf_variation_fields'], 10, 3);
		add_action('woocommerce_save_product_variation', [$this, 'save_acf_variation_fields'], 10, 2);

		// Address fields
		add_filter('woocommerce_default_address_fields', [$this, 'remove_state_field']);

		add_action('woocommerce_cart_calculate_fees', [$this, 'woocommerce_custom_shipping_tax'], 10, 1);
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

	/**
	 * Render the max stock quantity input field in the variation admin.
	 *
	 * @param int $loop Current variation index.
	 * @param array $variation_data Variation data.
	 * @param WC_Product $variation Variation product object.
	 */
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

	/**
	 * Save the max stock quantity meta for a product variation.
	 *
	 * @param int $variation_id The variation post ID.
	 * @param int $loop The variation index.
	 */
	public function save_variation_max_qty_field ($variation_id, $loop) {
		if (!current_user_can('edit_product', $variation_id)) {
			return;
		}
		$max_stock_qty = isset($_POST['max_stock_qty'][$loop]) ? absint($_POST['max_stock_qty'][$loop]) : 0;
		update_post_meta($variation_id, 'max_stock_qty', $max_stock_qty);
	}

	/**
	 * Load the max stock quantity meta into variation data.
	 *
	 * @param array $variation Variation data array.
	 * @return array Modified variation data with max_stock_qty.
	 */
	public function load_variation_max_qty_field ($variation) {
		$variation['max_stock_qty'] = get_post_meta($variation['variation_id'], 'max_stock_qty', true);
		return $variation;
	}

	/**
	 * Load custom settings fields for product variations.
	 *
	 * @param array $variations Variation data array.
	 * @return array Modified variation data with custom fields.
	 */
	public function load_variation_settings_fields ($variations) {
		$variations['text_field'] = get_post_meta($variations['variation_id'], '_text_field', true);
		return $variations;
	}

	/**
	 * Render ACF fields in the product variation admin interface.
	 *
	 * This workaround ensures ACF fields are properly namespaced for each variation by temporarily hooking into acf/prepare_field to update field names.
	 *
	 * @param int $loop Current variation index.
	 * @param array $variation_data Variation data (unused).
	 * @param WC_Product $variation Variation product object.
	 */
	public function render_acf_variation_fields ($loop, $variation_data, $variation) {
		$this->acf_variation_index = $loop;
		add_filter('acf/prepare_field', [$this, 'acf_prepare_field_update_field_name']);

		$acf_field_groups = acf_get_field_groups();
		foreach ($acf_field_groups as $acf_field_group) {
			foreach ($acf_field_group['location'] as $group_locations) {
				foreach ($group_locations as $rule) {
					if ($rule['param'] == 'post_type' && $rule['operator'] == '==' && $rule['value'] == 'product_variation') {
						acf_render_fields($variation->ID, acf_get_fields($acf_field_group));
						break 2;
					}
				}
			}
		}

		remove_filter('acf/prepare_field', [$this, 'acf_prepare_field_update_field_name']);
	}

	/**
	 * Update ACF field names to include the variation index.
	 *
	 * Callback for acf/prepare_field filter. Modifies field names from acf[...] to acf[{index}][...] to properly namespace fields per variation.
	 *
	 * @param array $field ACF field configuration array.
	 * @return array Modified field configuration with updated name.
	 */
	public function acf_prepare_field_update_field_name ($field) {
		$field['name'] = preg_replace('/^acf\[/', "acf[{$this->acf_variation_index}][", $field['name']);
		return $field;
	}

	/**
	 * Save ACF field values for product variations.
	 *
	 * Handles saving all ACF fields submitted via $_POST['acf'][$i] for the given variation.
	 * Includes capability check and input sanitization.
	 *
	 * @param int $variation_id The variation post ID.
	 * @param int $i he variation index in the edit form.
	 */
	public function save_acf_variation_fields ($variation_id, $i = -1) {
		if (!current_user_can('edit_product', $variation_id)) {
			return;
		}
		if (!empty($_POST['acf']) && is_array($_POST['acf']) && array_key_exists($i, $_POST['acf']) && is_array(($fields = $_POST['acf'][$i]))) {
			foreach ($fields as $key => $val) {
				update_field(sanitize_key($key), sanitize_text_field($val), $variation_id);
			}
		}
	}

	/**
	 * Remove the state/province field from WooCommerce address forms.
	 *
	 * @param array $fields Default address fields.
	 * @return array Modified address fields without the state field.
	 */
	public function remove_state_field ($fields) {
		unset($fields['state']);
		return $fields;
	}

	/**
	 * Remove WooCommerce breadcrumbs on shop pages.
	 */
	public function remove_shop_breadcrumbs () {
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	}

	/**
	 * Get the label of the currently chosen shipping method.
	 *
	 * @return string|null Shipping method label, or null if none chosen.
	 */
	public function get_current_shipping_method () {
		$chosen_label = null;

		$packages = WC()->shipping->get_packages();
		foreach ($packages as $i => $package) {
			$chosen_method = WC()->session->chosen_shipping_methods[$i] ?? '';
			$chosen_label = isset($package['rates'][$chosen_method]) ? $package['rates'][$chosen_method]->label : null;
		}

		return $chosen_label;
	}

	/**
	 * Add a fuel surcharge fee to the cart based on the chosen shipping method.
	 *
	 * Reads ACF option 'shipping-taxes' to determine the tax percentage
	 * for standard or express shipping, then applies it as a cart fee.
	 */
	public function woocommerce_custom_shipping_tax () {
		global $woocommerce;

		if (is_admin() && !defined('DOING_AJAX')) {
			return;
		}

		$shipping_method = $this->get_current_shipping_method();
		$shipping_taxes = get_field('shipping-taxes', 'option');
		if (!is_array($shipping_taxes)) {
			return;
		}
		$tax = $shipping_method === 'Express' ? ($shipping_taxes['shipping-tax-express'] ?? 0) : ($shipping_taxes['shipping-tax-std'] ?? 0);
		$percentage = $tax / 100;
		$shipping_total = $woocommerce->cart->get_shipping_total() * $percentage ?: 0;
		$woocommerce->cart->add_fee('Supplément carburant', $shipping_total, true, '');
	}

	/**
	 * Filter the number of products per page on the shop.
	 *
	 * @param int $products Default products per page.
	 * @return int Products per page from ACF option, or 12 as fallback.
	 */
	public function products_per_page ($products) {
		return get_field('products-per-page', 'option') ?: 12;
	}

	/**
	 * Override the single product gallery image HTML to use a custom image size.
	 *
	 * Replaces the default WooCommerce gallery image with the 'product-preview' size
	 * and adds a portrait/landscape CSS class based on aspect ratio.
	 *
	 * @param string $args Original gallery image HTML.
	 */
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

	/**
	 * Get dimensions (length, width) for all variations of a product.
	 *
	 * @param WC_Product $product The parent product.
	 * @return array Array of [length, width] pairs keyed by variation order.
	 */
	public static function get_variation_size ($product) {
		$items = [];

		foreach ($product->get_children() as $item) {
			array_push($items, [
				get_post_meta($item, '_length', true),
				get_post_meta($item, '_width', true),
			]);
		}

		return $items;
	}

	/**
	 * Enrich the WooCommerce order webhook payload with custom data.
	 *
	 * Adds variation dimensions, stock info, Vimeo code retrieval, and the order email for Google Sheets integration.
	 *
	 * @param array $payload The webhook payload.
	 * @param string $resource The resource type (e.g. 'order').
	 * @param int $resource_id The resource ID.
	 * @param int $id The webhook ID.
	 * @return array Modified payload.
	 */
	public function add_custom_webhook_payload ($payload, $resource, $resource_id, $id) {
		if ($resource !== 'order') return $payload;

		foreach ($payload['line_items'] as $key => $item) {
			$code = '';
			$variation_id = $item['variation_id'];
			$parent_product_id = $item['product_id'];

			if ($parent_product_id) {
				$vimeoCode = get_field('vimeo-code', $parent_product_id);
				$videoId = intval(get_field('movie', $parent_product_id)) ?? NULL;
				if ($vimeoCode && $videoId && class_exists('HTRVimeoCode')) {
					$HTRVimeoCode = new HTRVimeoCode();
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
			$payload['line_items'][$key]['width'] = get_post_meta($variation_id, '_length', true);
			$payload['line_items'][$key]['height'] = get_post_meta($variation_id, '_width', true);
			$max_stock = get_post_meta($variation_id, 'max_stock_qty', true);
			$stock = get_post_meta($variation_id, '_stock', true);
			$payload['line_items'][$key]['number'] = (intval($max_stock) - intval($stock)) . '/' . $max_stock;
			$payload['line_items'][$key]['vimeo_code'] = $code;
		}

		$orderEmail = get_field('order_email_gsheet', 'option');
		$payload['order_email_gsheet'] = is_email($orderEmail) ? $orderEmail : '';

		return $payload;
	}

	/**
	 * Apply tiered discount pricing for product packs in the cart.
	 *
	 * Reads ACF 'pack' option to determine active packs, collects matching cart items, then delegates to apply_pack_discounts().
	 *
	 * @param WC_Cart $cart The WooCommerce cart object.
	 */
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
			return;
		}

		$cart_product_ids = array_map(fn($cart_item) => $cart_item['product_id'], $cart->get_cart());
		$pack_product_count = count(array_intersect($cart_product_ids, $packs_list->products_list));
		$pack_products = [];

		if ($pack_product_count < 2) {
			return;
		}

		// Collect all pack products in the cart
		foreach ($cart->get_cart() as $cart_item) {
			$product_id = $cart_item['product_id'];
			if (in_array($product_id, $packs_list->products_list)) {
				$pack_products[] = $cart_item;
			}
		}

		$this->apply_pack_discounts($pack_products, $packs_list->discounts);
	}

	/**
	 * Apply tiered discounts to pack products in the cart.
	 *
	 * For each discount tier, counts products and applies the percentage discount when the threshold is reached, then resets for the next tier.
	 *
	 * @param array $pack_products Cart items belonging to active packs.
	 * @param array $discounts Array of discount objects (product_number, discount).
	 */
	private function apply_pack_discounts($pack_products, $discounts) {
		foreach ($discounts as $discount) {
			$processed = 0;
			foreach ($pack_products as $cart_item) {
				$remaining = $cart_item['quantity'];
				while ($remaining > 0) {
					$processed++;
					$remaining--;
					if ($processed === $discount->product_number) {
						$original = $cart_item['data']->get_regular_price();
						$cart_item['data']->set_price($original * ((100 - $discount->discount) / 100));
						$processed = 0;
						break;
					}
				}
			}
		}
	}

	/**
	 * Apply a discount to the cart based on the number of products from a specific category.
	 */
	public function pack_apply_discount_to_cart () {
		static $running = false;
		if ($running) {
			return;
		}
		$running = true;

		$couponRules = $this->get_custom_coupon_rules();
		$cart = WC()->cart;

		if (empty($cart->get_cart())) {
			$running = false;
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
		$running = false;
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

	/**
	 * Proxy for pack_apply_discount_to_cart, hooked on woocommerce_cart_updated.
	 */
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
