<?php
global $woocommerce;
$count = $woocommerce->cart->cart_contents_count;
?>
<nav class="user-menu ms-auto" id="user-menu">
	<a class="nav-item" href="<?= get_permalink(wc_get_page_id('myaccount')) ?>">
		<i class="fas fa-user"></i>
		<span class="nav-item-label">Mon compte</span>
	</a>
	<a class="nav-item position-relative" aria-label="Mon panier" href="<?= get_permalink(wc_get_page_id('cart')) ?>">
		<i class="fas fa-shopping-cart"></i>
		<span class="nav-item-label">Mon panier</span>
		(<?= $count; ?>)
	</a>
</nav>
