<?php
/**
 * Single Product stock.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$quantity = $product->get_stock_quantity();
$maxNumber = $product->get_type() === 'variation' ? get_field('max_number', $product->get_parent_id()) : get_field('max_number', $product->get_id());
$percent = $maxNumber ? ($quantity / $maxNumber) : 0;
?>
<div class="stock <?php echo esc_attr($class); ?> mb-4">
	Limité à <?= $maxNumber ?> tirages
	<div class="stock-meter my-2">
		<span class="stock-meter-value" style="transform: scaleX(<?= $percent ?>)"></span>
	</div>
	<div class="stock-number"><?= $quantity > 0 ? 'Encore '.$quantity.' tirages disponibles' : 'Plus de tirages disponibles' ?></div>
	<?php //echo wp_kses_post( $availability ); ?>
</div>
