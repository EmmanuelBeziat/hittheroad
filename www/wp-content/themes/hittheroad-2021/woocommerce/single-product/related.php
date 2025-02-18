<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $product;
$tags = [
	'year' => get_field('origin-year', $product->get_id()),
	'country' => get_field('country', $product->get_id())['value'],
	'colors' => get_field('colors', $product->get_id())['value'],
	// 'orientation' => get_field('orientation', $product->get_id())['value'],
	// 'character' => get_field('character', $product->get_id())['value'],
	// 'type' => get_field('type', $product->get_id())['value'],
];

$args = [
	'post_type' => 'product',
	'posts_per_page' => 4,
	'orderby' => 'date',
	'post_status' => 'publish',
	'post__not_in' => [$product->get_id()],
];

$metaQuery = [
	'relation' => 'AND',
];
foreach ($tags as $key => $value) :
	$metaQuery[] = [
		'taxonomy' => $key,
		'value' => $value,
		'compare' => 'IN',
	];
endforeach;
$args = array_merge($args, ['meta_query' => $metaQuery]);
$related = new WP_Query($args);
if ($related->have_posts()) : ?>
	<section class="related products">
		<?php $heading = apply_filters('woocommerce_product_related_products_heading', __('Related products', 'woocommerce'));
		if ($heading) : ?>
			<h2 class="h1">Tirages suggérés</h2>
		<?php endif;

		woocommerce_product_loop_start();
		$index = 0;
		while ($related->have_posts()) :
			$related->the_post();
			get_template_part('template-parts/content/product/product', 'item', ['id' => get_the_id()]);
			$index++;
		endwhile;
		woocommerce_product_loop_end(); ?>
	</section>
	<?php
endif;
wp_reset_query();

wp_reset_postdata();
