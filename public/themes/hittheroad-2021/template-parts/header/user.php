<nav class="user-menu ms-auto" id="user-menu">
	<?php if (is_user_logged_in()) : ?>
	<a class="nav-item position-relative" href="#">
		<i data-feather="shopping-bag"></i>
		<span class="nav-item-label">Mon panier</span>
		<span class="position-absolute start-100 translate-middle badge rounded-pill bg-danger">
			5 <span class="visually-hidden">Articles</span>
		</span>
	</a>
	<a class="nav-item" href="#">
		<i data-feather="user"></i>
		<span class="nav-item-label">Mon compte</span>
	</a>
	<a class="nav-item" href="#">
		<i data-feather="power"></i>
		<span class="nav-item-label">Déconnexion</span>
	</a>
	<?php else : ?>
	<a class="nav-item" href="#">
		<i data-feather="user"></i>
		<span class="nav-item-label">Connexion / Inscription</span>
	</a>
	<?php endif; ?>
</nav>
