<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;
// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}

$tags = [
	'country' => (object) [
		'name' => get_field_object('country')['label'],
		'value' => get_field('country', get_the_id($product))['value'],
		'label' => get_field('country', get_the_id($product))['label'],
	],
	'orientation' => (object) [
		'name' => get_field_object('orientation')['label'],
		'value' => get_field('orientation', get_the_id($product))['value'],
		'label' => get_field('orientation', get_the_id($product))['label'],
	],
	'format' => (object) [
		'name' => get_field_object('format')['label'],
		'value' => get_field('format', get_the_id($product))['value'],
		'label' => get_field('format', get_the_id($product))['label'],
	],
	'character' => (object) [
		'name' => get_field_object('character')['label'],
		'value' => get_field('character', get_the_id($product))['value'],
		'label' => get_field('character', get_the_id($product))['label'],
	],
	'type' => (object) [
		'name' => get_field_object('type')['label'],
		'value' => get_field('type', get_the_id($product))['value'],
		'label' => get_field('type', get_the_id($product))['label'],
	],
	'year' => get_field('year', get_the_id($product)),
	'colors' => (object) [
		'name' => get_field_object('colors')['label'],
		'value' => get_field('colors', get_the_id($product))['value'],
		'label' => get_field('colors', get_the_id($product))['label'],
	],
];
?>
<article <?php wc_product_class('', $product); ?> data-aos="fade-in" data-aos-delay="100" data-aos-duration="400">
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action('woocommerce_before_shop_loop_item'); ?>

	<h2 class="screen-reader-text"><?= get_the_title(); ?></h2>
	<div class="product-picture">
		<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action('woocommerce_before_shop_loop_item_title');
		?>
	</div>

	<?php
	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action('woocommerce_shop_loop_item_title');

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	// do_action('woocommerce_after_shop_loop_item_title');
	/*
	?>

	<div class="product-tags my-2">
		<?php foreach ($tags as $tag) : ?>
		<span class="product-tag" data-value="<?= $tag->value ?>"><i class="fas fa-tag"></i><?= $tag->label ?></span>
		<?php endforeach; ?>
	</div>

	<?php
	*/
	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action('woocommerce_after_shop_loop_item');
	?>
</article>
