<?php

/**
 * Insert the opening anchor tag for products in the loop.
 */
function woocommerce_template_loop_product_link_open() {
	global $product;

	$link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product); ?>
	<a href="<?= esc_url($link) ?>" class="product-link">
	<?php
}
