<nav class="user-menu ms-auto" id="user-menu">
	<?php if (is_user_logged_in()) :
		global $woocommerce;
		$count = $woocommerce->cart->cart_contents_count;
	?>
	<a class="nav-item position-relative" href="<?= get_permalink(wc_get_page_id('cart')) ?>">
		<i data-feather="shopping-bag"></i>
		<span class="nav-item-label">Mon panier</span>
		<?php if ($count > 0) : ?>
		<span class="position-absolute start-100 translate-middle badge rounded-pill bg-danger">
			<?= $count; ?> <span class="visually-hidden">Articles</span>
		</span>
		<?php endif; ?>
	</a>
	<a class="nav-item" href="<?= get_permalink(wc_get_page_id('myaccount')) ?>">
		<i data-feather="user"></i>
		<span class="nav-item-label">Mon compte</span>
	</a>
	<a class="nav-item" href="<?= wp_logout_url(home_url()) ?>">
		<i data-feather="power"></i>
		<span class="nav-item-label">Déconnexion</span>
	</a>
	<?php else : ?>
	<a class="nav-item" href="<?= get_permalink(wc_get_page_id('myaccount')) ?>">
		<i data-feather="user"></i>
		<span class="nav-item-label">Connexion / Inscription</span>
	</a>
	<?php endif; ?>
</nav>
