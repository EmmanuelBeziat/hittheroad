<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 *
 * @var bool   $readonly If the input should be set to readonly mode.
 * @var string $type     The input type attribute.
 */

defined('ABSPATH') || exit;

/* translators: %s: Quantity. */
$label = !empty($args['product_name']) ? sprintf(esc_html__('%s quantity', 'woocommerce'), wp_strip_all_tags($args['product_name'])) : esc_html__('Quantity', 'woocommerce');

?>
<div class="quantity">
	<?php
	/**
	 * Hook to output something before the quantity input field.
	 *
	 * @since 7.2.0
	 */
	do_action('woocommerce_before_quantity_input_field'); ?>
	<label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo esc_attr($label); ?></label>
	<input
		type="<?= esc_attr($type); ?>"
		<?= $readonly ? 'readonly="readonly"' : ''; ?>
		id="<?= esc_attr($input_id); ?>"
		class="<?= esc_attr(join(' ', (array) $classes)); ?> form-control"
		name="<?= esc_attr($input_name); ?>"
		value="<?= esc_attr($input_value); ?>"
		aria-label="<?php esc_attr_e('Product quantity', 'woocommerce'); ?>"
		size="4"
		min="<?= esc_attr($min_value); ?>"
		max="<?= esc_attr(0 < $max_value ? $max_value : ''); ?>"
		<?php if (!$readonly) : ?>
			step="<?= esc_attr($step); ?>"
			placeholder="<?= esc_attr($placeholder); ?>"
			inputmode="<?= esc_attr($inputmode); ?>"
			autocomplete="<?= esc_attr(isset($autocomplete) ? $autocomplete : 'on'); ?>">
		<?php endif; ?>
	<?php
	/**
	 * Hook to output something after quantity input field
	 *
	 * @since 3.6.0
	 */
	do_action('woocommerce_after_quantity_input_field');
	?>
</div>
