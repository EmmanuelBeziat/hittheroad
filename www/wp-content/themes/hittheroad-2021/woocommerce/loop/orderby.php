<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

?>
<form class="products-ordering" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800" method="get">
	<?php /*
	<select name="orderby" class="form-select orderby" aria-label="<?php esc_attr_e('Shop order', 'woocommerce'); ?>">
		<?php foreach ($catalog_orderby_options as $id => $name) : ?>
			<option value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>><?php echo esc_html($name); ?></option>
		<?php endforeach; ?>
	</select>
	*/ ?>
	<div class="filters">
		<?php
		$fields = acf_get_fields(252);
		foreach ($fields as $field) :
			if ($field['type'] === 'tab' || !isset($field['choices'])) continue;
		?>
		<div class="filter-item">
			<label class="form-label" for="filter-<?= $field['name'] ?>"><?= $field['label'] ?></label>

			<select id="filter-<?= $field['name'] ?>" name="<?= $field['name'] ?>" class="form-select shop-filter" aria-label="Filtrer par <?= $field['label'] ?>">
				<option value="0">Tous</option>
				<?php
				foreach ($field['choices'] as $key => $value) : ?>
					<option value="<?= $key?>"><?= $value ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php endforeach; ?>
	</div>

	<div class="d-grid mt-3">
		<button type="button" id="filter-reset" class="btn btn-secondary btn-outline mb-2">Retirer les filtres</button>
		<button type="button" id="filter-submit" class="btn btn-primary">Appliquer les filtres</button>
	</div>

	<input type="hidden" name="paged" value="1">
	<?php wc_query_string_form_fields(null, ['orderby', 'submit', 'paged', 'product-page']); ?>
</form>
