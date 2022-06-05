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
<form class="products-ordering" data-aos="fade-up" data-aos-delay="50" data-aos-duration="300" method="get">
	<div class="filters">
		<?php
		$fields = acf_get_fields(252);
		foreach ($fields as $field) :
			if ($field['type'] === 'tab' || !isset($field['choices'])) continue;

			$type = $field['type'];
			$name = $field['name'];
			$label = $field['label'];
			$choices = $field['choices'];
		?>
		<div class="filter-item">
			<h3 class="h4"><?= $label ?></h3>

			<?php if ($type === 'country') : ?>
			<select id="filter-<?= $name ?>" name="<?= $name ?>" multiple class="form-select shop-filter" aria-label="Filtrer par <?= $label ?>" placeholder="<?= $label ?>" aria-label="<?= $label ?>">
				<?php foreach ($choices as $key => $value) : ?>
					<option value="<?= $key ?>"><?= $value ?></option>
				<?php endforeach; ?>
			</select>

			<?php else: ?>
				<?php foreach ($choices as $key => $value) : ?>
					<div class="filter-checkbox">
						<input class="form-check-input shop-filter" type="checkbox" name="<?= $name ?>" id="filter-<?= $name ?>-<?= $key ?>" value="<?= $key ?>">
						<label class="form-check-label" for="filter-<?= $name ?>-<?= $key ?>"><?= $value ?></label>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
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
