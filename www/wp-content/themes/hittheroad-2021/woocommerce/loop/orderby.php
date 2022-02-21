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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form class="products-ordering" method="get">
	<?php /*
	<select name="orderby" class="form-select orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	*/ ?>
	<div class="filters">
		<div class="filter-item">
			<label class="form-label" for="filter-country">Filter par localité</label>
			<select id="filter-country" name="filterbycountry" class="form-select filterbycountry" aria-label="Filtrer par pays">
				<option value="0">Tous</option>
				<?php
				$query = new WP_Query(['post_type' => 'location']);
				foreach ($query->posts as $location) : ?>
					<option value="<?= $location->post_name ?>"><?= $location->post_title ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<input type="hidden" name="paged" value="1">
	<?php wc_query_string_form_fields(null, ['orderby', 'submit', 'paged', 'product-page']); ?>
</form>
