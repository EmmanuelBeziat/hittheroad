<?php

/**
 * Insert the opening anchor tag for products in the loop.
 */
function woocommerce_template_loop_product_link_open() {
	global $product;

	$link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);
	?>
	<a href="<?= esc_url($link) ?>" class="product-link">
	<?php
}

function woocommerce_template_loop_product_title () {
	global $product;
	$id = get_the_id($product);
	$city = get_the_title(get_field('place', $id));
	// $country = get_field('country', get_field('place', $id));
	?>
	<h2 class="<?= esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) ?>"><?= $city ?> : <?= get_the_title() ?></h2>
<?php
}

function remove_shop_breadcrumbs() {
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
}
add_action('template_redirect', 'remove_shop_breadcrumbs');
