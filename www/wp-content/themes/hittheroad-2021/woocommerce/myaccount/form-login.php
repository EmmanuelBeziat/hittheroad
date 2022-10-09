<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$registerIsEnabled = 'yes' === get_option('woocommerce_enable_myaccount_registration');
$userRegistration = isset($_GET['action']) && $_GET['action'] === 'register';

do_action('woocommerce_before_customer_login_form'); ?>

<div class="container">
	<div class="form-card">
		<?php if ($registerIsEnabled && $userRegistration) : ?>
		<form method="post" class="woocommerce-form woocommerce-form-register" <?php do_action('woocommerce_register_form_tag'); ?> >
			<h2><?php esc_html_e('Register', 'woocommerce'); ?></h2>

			<?php do_action('woocommerce_register_form_start'); ?>

			<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
				<div class="form-floating mb-3">
					<input type="text" class="form-control" name="username" id="reg_username" autocomplete="username" placeholder="John Doe" value="<?= (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>">
					<label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?> <span class="required">*</span></label>
				</div>
			<?php endif; ?>

			<div class="form-floating mb-3">
				<input type="email" class="form-control" name="email" id="reg_email" autocomplete="email" placeholder="your@email.com" value="<?= (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>">
				<label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?> <span class="required">*</span></label>
			</div>

			<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
			<div class="form-floating mb-3">
				<input type="password" class="form-control" name="password" id="reg_password" autocomplete="new-password" placeholder="Your password">
				<label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
			</div>
			<?php else : ?>
				<p><?php esc_html_e('A password will be sent to your email address.', 'woocommerce'); ?></p>
			<?php endif; ?>

			<?php do_action('woocommerce_register_form'); ?>

			<div class="d-grid gap-2">
				<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
				<button type="submit" class="btn btn-primary woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
				<a class="btn btn-light" href="<?= get_permalink(wc_get_page_id('myaccount')) ?>">Déjà inscrit ? Se connecter</a>
			</div>
			<?php do_action('woocommerce_register_form_end'); ?>

		</form>
		<?php else : ?>
		<form class="woocommerce-form woocommerce-form-login" method="post">
			<h2><?php esc_html_e('Login', 'woocommerce'); ?></h2>

			<?php do_action('woocommerce_login_form_start'); ?>
			<div class="form-floating mb-3">
				<input type="text" class="form-control" name="username" id="username" autocomplete="username" placeholder="JohnDoe" value="<?= (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>">
				<label for="username" class="form-label"><?php esc_html_e('Username or email address', 'woocommerce'); ?> <span class="required">*</span></label>
			</div>
			<div class="form-floating mb-3">
				<input class="form-control" type="password" name="password" id="password" palceholder="Mot de passe" autocomplete="current-password">
				<label for="password" class="form-label"><?php esc_html_e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
			</div>
			<?php do_action('woocommerce_login_form'); ?>
			<div class="mb-3">
				<input class="form-check-input" name="rememberme" type="checkbox" id="rememberme" value="forever">
				<label class="form-check-label" for="rememberme"><?php esc_html_e('Remember me', 'woocommerce'); ?></label>
			</div>
			<div class="d-grid gap-2">
				<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
				<button type="submit" class="btn btn-primary" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>

				<a class="btn btn-light" href="<?= get_permalink(wc_get_page_id('myaccount')) ?>lost-password/"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
				<a class="btn btn-light" href="<?= get_permalink(wc_get_page_id('myaccount')) ?>?action=register">S’inscrire</a>
			</div>
			<?php do_action('woocommerce_login_form_end'); ?>
		</form>
		<?php endif; ?>
	</div>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>
