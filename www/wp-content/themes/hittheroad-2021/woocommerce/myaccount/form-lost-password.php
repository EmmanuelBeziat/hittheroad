<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit; ?>

<div class="container">
<?php
do_action('woocommerce_before_lost_password_form');
?>

<div class="form-card">
	<form method="post" class="woocommerce-ResetPassword lost_reset_password">
		<p><?= apply_filters('woocommerce_lost_password_message', esc_html__('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce')); ?></p><?php // @codingStandardsIgnoreLine ?>

		<div class="form-floating mb-3">
			<input class="form-control" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="Login">
			<label for="user_login"><?php esc_html_e('Username or email', 'woocommerce'); ?></label>
		</div>

		<?php do_action('woocommerce_lostpassword_form'); ?>

		<div class="d-grid">
			<input type="hidden" name="wc_reset_password" value="true">
			<button type="submit" class="btn btn-primary" value="<?php esc_attr_e('Reset password', 'woocommerce'); ?>"><?php esc_html_e('Reset password', 'woocommerce'); ?></button>
		</div>

		<?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
	</form>
</div>
<?php do_action('woocommerce_after_lost_password_form'); ?>
</div>
