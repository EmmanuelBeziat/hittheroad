<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.2.0
 */

defined('ABSPATH') || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php
	do_action('woocommerce_before_add_to_cart_button');
	do_action('woocommerce_before_add_to_cart_quantity');

	woocommerce_quantity_input([
		'min_value'   => $product->get_min_purchase_quantity(),
		'max_value'   => $product->get_max_purchase_quantity(),
		'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
	]); ?>

	<div class="woocommerce-variation-custom-text-field">
	</div>

	<?php
	do_action('woocommerce_after_add_to_cart_quantity');
	?>

	<button type="submit" class="single_add_to_cart_button btn btn-primary"><?= esc_html($product->single_add_to_cart_text()); ?></button>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<input type="hidden" name="add-to-cart" value="<?= absint($product->get_id()); ?>">
	<input type="hidden" name="product_id" value="<?= absint($product->get_id()); ?>">
	<input type="hidden" name="variation_id" class="variation_id" value="0">
</div>
