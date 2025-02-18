<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */

$product_tabs = apply_filters('woocommerce_product_tabs', []);
if (!empty($product_tabs)) : ?>

	<div class="woocommerce-tabs mt-4">
		<?php /*
		<ul class="nav nav-tabs" role="tablist">
			<?php
			$index = 0;
			foreach ($product_tabs as $key => $product_tab) : $index++; ?>
				<li class="nav-item" id="tab-title-<?= esc_attr($key); ?>" role="tab" aria-controls="tab-<?= esc_attr($key); ?>">
					<a href="#tab-<?= esc_attr($key); ?>" class="nav-link<?= $index === 1 ? ' active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab-<?= esc_attr($key); ?>" type="button">
						<?= wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="tab-content mt-4">
			<?php
			$index = 0;
			foreach ($product_tabs as $key => $product_tab) : $index++; ?>
				<div class="tab-pane fade <?= $index === 1 ? 'active show' : ''; ?>" id="tab-<?= esc_attr($key); ?>" role="tabpanel" aria-labelledby="tab-title-<?= esc_attr($key); ?>">
					<?php
					if (isset($product_tab['callback'])) {
						call_user_func($product_tab['callback'], $key, $product_tab);
					}
					?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php do_action('woocommerce_product_after_tabs'); */ ?>
		<?php foreach ($product_tabs as $key => $product_tab) :
			if (isset($product_tab['callback'])) {
				call_user_func($product_tab['callback'], $key, $product_tab);
			}
		endforeach; ?>
		<?php do_action('woocommerce_product_after_tabs'); ?>
	</div>
<?php endif;
