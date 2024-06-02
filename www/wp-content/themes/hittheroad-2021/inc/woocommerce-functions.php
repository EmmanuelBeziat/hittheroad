<?php

/**
 * Insert the opening anchor tag for products in the loop.
 */
function woocommerce_template_loop_product_link_open () {
	global $product;

	$link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);
	?>
	<a href="<?= esc_url($link) ?>" class="product-link">
	<?php
}

function woocommerce_template_loop_product_title () {
	global $product;
}

add_filter('woocommerce_dropdown_variation_attribute_options_args', static function($args) {
	$args['class'] = 'form-select';
	return $args;
}, 2);

if (!function_exists('woocommerce_form_field')) {

	/**
	 * Outputs a checkout/address form field.
	 *
	 * @param string $key Key.
	 * @param mixed $args Arguments.
	 * @param string $value (default: null).
	 * @return string
	 */
	function woocommerce_form_field ($key, $args, $value = null) {
		$defaults = [
			'type' => 'text',
			'label' => '',
			'description' => '',
			'placeholder' => '',
			'maxlength' => false,
			'required' => false,
			'autocomplete' => false,
			'id' => $key,
			'class' => [],
			'label_class' => [],
			'input_class' => [],
			'return' => false,
			'options' => [],
			'custom_attributes' => [],
			'validate' => [],
			'default' => '',
			'autofocus' => '',
			'priority' => '',
		];

		$args = wp_parse_args($args, $defaults);
		$args = apply_filters('woocommerce_form_field_args', $args, $key, $value);

		if ($args['required']) {
			$args['class'][] = 'validate-required';
			$required = ' <span class="required" aria-label="' . esc_attr__('required', 'woocommerce') . '">*</span>';
		}
		else {
			$required = ' <span class="optional">(' . esc_html__('optional', 'woocommerce') . ')</span>';
		}

		if (is_string($args['label_class'])) {
			$args['label_class'] = [$args['label_class']];
		}

		if (is_null($value)) {
			$value = $args['default'];
		}

		// Custom attribute handling.
		$custom_attributes = [];
		$args['custom_attributes'] = array_filter((array) $args['custom_attributes'], 'strlen');

		if ($args['maxlength']) {
			$args['custom_attributes']['maxlength'] = absint($args['maxlength']);
		}

		if (!empty($args['autocomplete'])) {
			$args['custom_attributes']['autocomplete'] = $args['autocomplete'];
		}

		if (true === $args['autofocus']) {
			$args['custom_attributes']['autofocus'] = 'autofocus';
		}

		if ($args['description']) {
			$args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
		}

		if (!empty($args['custom_attributes']) && is_array($args['custom_attributes'])) {
			foreach ($args['custom_attributes'] as $attribute => $attribute_value) {
				$custom_attributes[] = esc_attr($attribute) . '="' . esc_attr($attribute_value) . '"';
			}
		}

		if (!empty($args['validate'])) {
			foreach ($args['validate'] as $validate) {
				$args['class'][] = 'validate-' . $validate;
			}
		}

		$field = '';
		$label_id = $args['id'];
		$sort = $args['priority'] ? $args['priority'] : '';
		$floating = 'select' === $args['type'] || 'country' === $args['type'] ? '' : 'form-floating ';
		$field_container = '<div class="form-floating mb-3 %1$s" id="%2$s" data-priority="' . esc_attr($sort) . '">%3$s</div>';

		switch ($args['type']) {
			case 'country':
				$countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

				if (1 === count($countries)) {
					$field .= '<strong>' . current(array_values($countries)) . '</strong>';
					$field .= '<input type="hidden" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" value="' . current(array_keys($countries)) . '" ' . implode(' ', $custom_attributes) . ' class="country_to_state" readonly="readonly" />';
				}
				else {
					$data_label = !empty($args['label']) ? 'data-label="' . esc_attr($args['label']) . '"' : '';
					$field = '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" class="form-select country_to_state country_select ' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . ' data-placeholder="' . esc_attr($args['placeholder'] ? $args['placeholder'] : esc_attr__('Select a country / region&hellip;', 'woocommerce')) . '" ' . $data_label . '><option value="">' . esc_html__('Select a country / region&hellip;', 'woocommerce') . '</option>';

					foreach ($countries as $ckey => $cvalue) {
						$field .= '<option value="' . esc_attr($ckey) . '" ' . selected($value, $ckey, false) . '>' . esc_html($cvalue) . '</option>';
					}

					$field .= '</select>';
					$field .= '<noscript><button type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__('Update country / region', 'woocommerce') . '">' . esc_html__('Update country / region', 'woocommerce') . '</button></noscript>';
				}

				break;
			case 'state':
				/* Get country this state field is representing */
				$for_country = isset($args['country']) ? $args['country'] : WC()->checkout->get_value('billing_state' === $key ? 'billing_country' : 'shipping_country');
				$states = WC()->countries->get_states($for_country);

				if (is_array($states) && empty($states)) {
					$field_container = '<div class="mb-3 %1$s" id="%2$s" style="display: none">%3$s</div>';
					$field .= '<input type="hidden" class="hidden" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" value="" ' . implode(' ', $custom_attributes) . ' placeholder="' . esc_attr($args['placeholder']) . '" readonly="readonly" data-input-classes="' . esc_attr(implode(' ', $args['input_class'])) . '"/>';
				}
				elseif (!is_null($for_country) && is_array($states)) {
					$data_label = !empty($args['label']) ? 'data-label="' . esc_attr($args['label']) . '"' : '';
					$field .= '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" class="form-select state_select ' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . ' data-placeholder="' . esc_attr($args['placeholder'] ? $args['placeholder'] : esc_html__('Select an option&hellip;', 'woocommerce')) . '" data-input-classes="' . esc_attr(implode(' ', $args['input_class'])) . '" ' . $data_label . '>
						<option value="">' . esc_html__('Select an option&hellip;', 'woocommerce') . '</option>';

					foreach ($states as $ckey => $cvalue) {
						$field .= '<option value="' . esc_attr($ckey) . '" ' . selected($value, $ckey, false) . '>' . esc_html($cvalue) . '</option>';
					}

					$field .= '</select>';
				}
				else {
					$field .= '<input type="text" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($args['placeholder']) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" ' . implode(' ', $custom_attributes) . ' data-input-classes="' . esc_attr(implode(' ', $args['input_class'])) . '"/>';

				}
				break;
			case 'textarea':
				$field .= '<textarea name="' . esc_attr($key) . '" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . (empty($args['custom_attributes']['rows']) ? ' rows="2"' : '') . (empty($args['custom_attributes']['cols']) ? ' cols="5"' : '') . implode(' ', $custom_attributes) . '>' . esc_textarea($value) . '</textarea>';

				break;
			case 'checkbox':
				$field = '<label class="checkbox ' . implode(' ', $args['label_class']) . '" ' . implode(' ', $custom_attributes) . '>
						<input type="' . esc_attr($args['type']) . '" class="form-checkbox ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" value="1" ' . checked($value, 1, false) . ' /> ' . $args['label'] . $required . '</label>';

				break;
			case 'text':
			case 'password':
			case 'datetime':
			case 'datetime-local':
			case 'date':
			case 'month':
			case 'time':
			case 'week':
			case 'number':
			case 'email':
			case 'url':
			case 'tel':
				$field .= '<input type="' . esc_attr($args['type']) . '" class="form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" value="' . esc_attr($value) . '" ' . implode(' ', $custom_attributes) . ' />';
				break;
			case 'hidden':
				$field .= '<input type="' . esc_attr($args['type']) . '" class="input-hidden ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" value="' . esc_attr($value) . '" ' . implode(' ', $custom_attributes) . ' />';
				break;
			case 'select':
				$field = '';
				$options = '';

				if (!empty($args['options'])) {
					foreach ($args['options'] as $option_key => $option_text) {
						if ('' === $option_key) {
							// If we have a blank option, select2 needs a placeholder.
							if (empty($args['placeholder'])) {
								$args['placeholder'] = $option_text ? $option_text : __('Choose an option', 'woocommerce');
							}
							$custom_attributes[] = 'data-allow_clear="true"';
						}
						$options .= '<option value="' . esc_attr($option_key) . '" ' . selected($value, $option_key, false) . '>' . esc_html($option_text) . '</option>';
					}

					$field .= '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '" class="form-select ' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . ' data-placeholder="' . esc_attr($args['placeholder']) . '">
							' . $options . '
						</select>';
				}
				break;
			case 'radio':
				$label_id .= '_' . current(array_keys($args['options']));

				if (!empty($args['options'])) {
					foreach ($args['options'] as $option_key => $option_text) {
						$field .= '<input type="radio" class="input-radio ' . esc_attr(implode(' ', $args['input_class'])) . '" value="' . esc_attr($option_key) . '" name="' . esc_attr($key) . '" ' . implode(' ', $custom_attributes) . ' id="' . esc_attr($args['id']) . '_' . esc_attr($option_key) . '"' . checked($value, $option_key, false) . ' />';
						$field .= '<label for="' . esc_attr($args['id']) . '_' . esc_attr($option_key) . '" class="radio ' . implode(' ', $args['label_class']) . '">' . esc_html($option_text) . '</label>';
					}
				}
				break;
		}

		if (!empty($field)) {
			$field_html = '';

			$field_html .= $field;
			if ($args['label'] && 'checkbox' !== $args['type']) {
				$field_html .= '<label for="' . esc_attr($label_id) . '" class="form-label">' . wp_kses_post($args['label']) . $required . '</label>';
			}

			if ($args['description']) {
				$field_html .= '<span class="description" id="' . esc_attr($args['id']) . '-description" aria-hidden="true">' . wp_kses_post($args['description']) . '</span>';
			}

			$container_class = esc_attr(implode(' ', $args['class']));
			$container_id = esc_attr($args['id']) . '_field';
			$field = sprintf($field_container, $container_class, $container_id, $field_html);
		}

		/**
		 * Filter by type.
		 */
		$field = apply_filters('woocommerce_form_field_' . $args['type'], $field, $key, $args, $value);

		/**
		 * General filter on form fields.
		 *
		 * @since 3.4.0
		 */
		$field = apply_filters('woocommerce_form_field', $field, $key, $args, $value);

		if ($args['return']) {
			return $field;
		}
		else {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $field;
		}
	}
}
