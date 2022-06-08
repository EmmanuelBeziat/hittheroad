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
			if ($field['type'] === 'tab') continue;

			$type = $field['type'];
			$name = $field['name'];
			$label = $field['label'];
		?>
		<div class="filter-item">
			<h3 class="h4"><?= $label ?></h3>

			<?php if (!isset($field['choices'])) :
				global $wpdb;
				$years = $wpdb->get_results("SELECT DISTINCT(meta_value) FROM htrwp_postmeta WHERE meta_key = '$name' AND meta_value != '' ORDER BY meta_value DESC", ARRAY_A);
				$index = 0;
				foreach ($years as $year) : ?>
					<?php if ($index === 5) : ?>
						<a class="filter-toggle" data-bs-toggle="collapse" href="#filters-category-<?= $name ?>" role="button" aria-expanded="false" aria-controls="filters-category-<?= $name ?>">Voir d’avantage <i class="fa fa-chevron-down"></i></a>
						<div id="filters-category-<?= $name ?>" class="collapse">
					<?php endif; ?>

					<div class="filter-checkbox">
						<input class="form-check-input shop-filter" type="checkbox" name="<?= $name ?>" id="filter-<?= $name ?>-<?= $year['meta_value'] ?>" value="<?= $year['meta_value'] ?>">
						<label class="form-check-label" for="filter-<?= $name ?>-<?= $year['meta_value'] ?>"><?= $year['meta_value'] ?></label>
					</div>

					<?php if ($index >= 5 && $index === count($years) - 1) : ?>
					</div>
					<?php endif;
					$index++;
				endforeach;
			else :
				$index = 0;
				foreach ($field['choices'] as $key => $value) : ?>
					<?php if ($index === 5) : ?>
						<a class="filter-toggle" data-bs-toggle="collapse" href="#filters-category-<?= $name ?>" role="button" aria-expanded="false" aria-controls="filters-category-<?= $name ?>">Voir d’avantage <i class="fa fa-chevron-down"></i></a>
						<div id="filters-category-<?= $name ?>" class="collapse">
					<?php endif; ?>

						<div class="filter-checkbox">
							<input class="form-check-input shop-filter" type="checkbox" name="<?= $name ?>" id="filter-<?= $name ?>-<?= $key ?>" value="<?= $key ?>">
							<label class="form-check-label" for="filter-<?= $name ?>-<?= $key ?>"><?= $value ?></label>
						</div>

					<?php if ($index >= 5 && $index === count($field['choices']) - 1) : ?>
					</div>
					<?php endif;
					$index++;
				endforeach;
			endif; ?>
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
