<header class="site-header bg-dark">
	<div class="container-fluid">
		<div class="d-flex">
			<a href="<?= get_site_url() ?>" class="navbar-brand">
				<img src="<?= get_template_directory_uri() ?>/" alt="<?= get_bloginfo('name') ?>">
			</a>

			<?php // get_template_part('template-parts/header/navigation'); ?>
			<?php get_template_part('template-parts/header/user'); ?>
		</div>
	</div>
</header>
