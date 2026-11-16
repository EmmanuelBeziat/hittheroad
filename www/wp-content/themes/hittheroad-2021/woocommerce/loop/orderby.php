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
 * @version     9.7.0
 */

if (!defined('ABSPATH')) {
	exit;
}

$id_suffix = wp_unique_id();
?>
<form class="products-ordering" data-reveal="fade-up" style="--reveal-duration: 300ms; --reveal-delay: 50ms" method="get">
	<div class="filters">
		<?php
		foreach (htr_get_shop_filter_fields() as $field) :
			$name = $field['name'];
		?>
		<div class="filter-item">
			<h2 class="h4"><?= esc_html($field['label']) ?></h2>

			<?php if (!isset($field['choices'])) :
				$years = htr_get_meta_values($name);
				$index = 0;
				foreach ($years as $year) : ?>
					<?php if ($index === 3) : ?>
						<details class="filter-more" id="filters-category-<?= esc_attr($name) ?>">
							<summary class="filter-toggle">Voir davantage <i class="fa fa-chevron-down" aria-hidden="true"></i></summary>
					<?php endif; ?>

					<div class="filter-checkbox">
						<input class="form-check-input shop-filter" type="checkbox" name="<?= esc_attr($name) ?>" id="filter-<?= esc_attr($name . '-' . $year) ?>" value="<?= esc_attr($year) ?>">
						<label class="form-check-label" for="filter-<?= esc_attr($name . '-' . $year) ?>"><?= esc_html($year) ?></label>
					</div>

					<?php if ($index >= 3 && $index === count($years) - 1) : ?>
					</details>
					<?php endif;
					$index++;
				endforeach;
			else :
				$index = 0;
				foreach ($field['choices'] as $key => $value) : ?>
					<?php if ($index === 5) : ?>
						<details class="filter-more" id="filters-category-<?= esc_attr($name) ?>">
							<summary class="filter-toggle">Voir davantage <i class="fa fa-chevron-down" aria-hidden="true"></i></summary>
					<?php endif; ?>

						<div class="filter-checkbox">
							<input class="form-check-input shop-filter" type="checkbox" name="<?= esc_attr($name) ?>" id="filter-<?= esc_attr($name . '-' . $key) ?>" value="<?= esc_attr($key) ?>">
							<label class="form-check-label" for="filter-<?= esc_attr($name . '-' . $key) ?>"><?= esc_html($value) ?></label>
						</div>

					<?php if ($index >= 5 && $index === count($field['choices']) - 1) : ?>
					</details>
					<?php endif;
					$index++;
				endforeach;
			endif; ?>
		</div>
		<?php endforeach; ?>
	</div>

	<div class="d-grid mt-3">
		<button type="button" id="filter-reset" class="btn-outline theme-secondary mb-2">Retirer les filtres</button>
		<button type="button" id="filter-submit" class="btn-solid theme-primary">Appliquer les filtres</button>
	</div>

	<input type="hidden" name="paged" value="1">
	<?php wc_query_string_form_fields(null, ['orderby', 'submit', 'paged', 'product-page']); ?>
</form>
