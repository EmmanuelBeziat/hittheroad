<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined('ABSPATH') || exit;

$customer_id = get_current_user_id();

if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		[
			'billing'  => __('Billing address', 'woocommerce'),
			'shipping' => __('Shipping address', 'woocommerce'),
		],
		$customer_id
	);
}
else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		[
			'billing' => __('Billing address', 'woocommerce'),
		],
		$customer_id
	);
}

$oldcol = 1;
$col = 1;
?>

<p>
	<?= apply_filters('woocommerce_my_account_my_address_description', esc_html__('The following addresses will be used on the checkout page by default.', 'woocommerce')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>

<?php if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) : ?>
	<div class="woocommerce-Addresses addresses">
<?php endif; ?>

<?php foreach ($get_addresses as $name => $address_title) :
		$address = wc_get_account_formatted_address($name);
	?>

	<div class="woocommerce-Address mb-3">
		<header class="woocommerce-Address-title title">
			<h3><?= esc_html($address_title); ?></h3>
		</header>
		<address>
			<?= $address ? wp_kses_post($address) : esc_html_e('You have not set up this type of address yet.', 'woocommerce');

			/**
			 * Used to output content after core address fields.
			 *
			 * @param string $name Address type.
			 * @since 8.7.0
			 */
			do_action('woocommerce_my_account_after_my_address', $name);
			?>
		</address>
		<a href="<?= esc_url(wc_get_endpoint_url('edit-address', $name)); ?>" class="edit btn btn-primary">
			<?php printf(
				/* translators: %s: Address title */
				$address ? esc_html__('Edit %s', 'woocommerce') : esc_html__('Add %s', 'woocommerce'), esc_html( $address_title)
				); ?>
		</a>
	</div>

<?php endforeach; ?>

<?php if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) : ?>
	</div>
	<?php
endif;
