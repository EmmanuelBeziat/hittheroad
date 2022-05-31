<?php
global $woocommerce;
global $current_user;
wp_get_current_user();
$count = $woocommerce->cart->cart_contents_count;
?>
<nav class="user-menu ms-auto" id="user-menu">
	<a class="nav-item" href="<?= get_permalink(wc_get_page_id('myaccount')) ?>">
		<i class="fas fa-user"></i>
		<span class="nav-item-label"><?= is_user_logged_in() ? $current_user->display_name : 'Mon compte' ?></span>
	</a>
	<a class="nav-item position-relative" aria-label="Mon panier" href="<?= get_permalink(wc_get_page_id('cart')) ?>">
		<i class="fas fa-shopping-cart"></i>
		<span class="nav-item-label">Mon panier</span>
		(<?= $count; ?>)
	</a>
</nav>
