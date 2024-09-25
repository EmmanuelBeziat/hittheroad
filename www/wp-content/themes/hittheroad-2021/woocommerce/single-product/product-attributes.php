<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined('ABSPATH') || exit;

if (!$product_attributes) {
	return;
}

global $product;
$tags = [
	'country' => (object) [
		'name' => get_field_object('country')['label'],
		'value' => get_field('country', $product->get_id())['value'],
		'label' => get_field('country', $product->get_id())['label'],
	],
	'year' => get_field('origin-year', $product->get_id()),
];
?>
<table class="woocommerce-product-attributes shop_attributes" aria-label="<?php esc_attr_e('Product Details', 'woocommerce'); ?>">
	<?php foreach ($product_attributes as $product_attribute_key => $product_attribute) : ?>
		<?php if ($product_attribute_key === 'weight') { continue; } ?>
		<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?= esc_attr($product_attribute_key); ?>">
			<th class="woocommerce-product-attributes-item__label"><?= wp_kses_post($product_attribute['label']); ?></th>
			<td class="woocommerce-product-attributes-item__value"><?= wp_kses_post($product_attribute['value']); ?></td>
		</tr>
	<?php endforeach; ?>
	<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--place>">
		<th class="woocommerce-product-attributes-item__label">Pays</th>
		<td class="woocommerce-product-attributes-item__value"><?= $tags['country']->label ?></td>
	</tr>
	<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--place>">
		<th class="woocommerce-product-attributes-item__label">Année</th>
		<td class="woocommerce-product-attributes-item__value"><?= $tags['year'] ?></td>
	</tr>
</table>
