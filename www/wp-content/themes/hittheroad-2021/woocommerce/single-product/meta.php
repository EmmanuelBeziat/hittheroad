<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $product;

/*?>
<div class="product-meta">

	<?php do_action('woocommerce_product_meta_start'); ?>

	<?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>

		<span class="sku_wrapper"><?php esc_html_e('SKU:', 'woocommerce'); ?> <span class="sku"><?php echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span></span>

	<?php endif; ?>

	<?php echo wc_get_product_category_list($product->get_id(), ', ', '<span class="posted_in">' . _n('Category:', 'Categories:', count($product->get_category_ids()), 'woocommerce') . ' ', '</span>'); ?>

	<?php echo wc_get_product_tag_list($product->get_id(), ', ', '<span class="tagged_as">' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'woocommerce') . ' ', '</span>'); ?>

	<?php do_action('woocommerce_product_meta_end'); ?>

</div>
*/ ?>
<?php
$tags = [
	'country' => (object) [
		'name' => get_field_object('country')['label'],
		'value' => get_field('country', $product->get_id())['value'],
		'label' => get_field('country', $product->get_id())['label'],
	],
	'orientation' => (object) [
		'name' => get_field_object('orientation')['label'],
		'value' => get_field('orientation', $product->get_id())['value'],
		'label' => get_field('orientation', $product->get_id())['label'],
	],
	'format' => (object) [
		'name' => get_field_object('format')['label'],
		'value' => get_field('format', $product->get_id())['value'],
		'label' => get_field('format', $product->get_id())['label'],
	],
	'character' => (object) [
		'name' => get_field_object('character')['label'],
		'value' => get_field('character', $product->get_id())['value'],
		'label' => get_field('character', $product->get_id())['label'],
	],
	'type' => (object) [
		'name' => get_field_object('type')['label'],
		'value' => get_field('type', $product->get_id())['value'],
		'label' => get_field('type', $product->get_id())['label'],
	],
	// 'year' => get_field('year', $product->get_id()),
	'colors' => (object) [
		'name' => get_field_object('colors')['label'],
		'value' => get_field('colors', $product->get_id())['value'],
		'label' => get_field('colors', $product->get_id())['label'],
	],
];
?>

<h2 class="h3 mt-4">Filtres</h2>
<div class="product-tags">
	<?php foreach ($tags as $tag) : ?>
	<span class="product-tag" data-value="<?= $tag->value ?>"><i class="fas fa-tag"></i> <strong><?= $tag->name ?> :</strong> <?= $tag->label ?></span>
	<?php endforeach; ?>
</div>
