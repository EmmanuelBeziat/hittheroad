<div class="mobile-nav-content" id="mobile-menu">
	<?php if (has_nav_menu('navigation')) : ?>
		<?php wp_nav_menu([
			'theme_location' => 'navigation',
			'depth' => 1, // 1 = no dropdowns, 2 = with dropdowns.
			'container' => 'ul',
			'menu_class' => 'navbar-nav navbar-nav-mobile',
			'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
			'walker' => new WP_Bootstrap_Navwalker()
		]); ?>
	<?php endif ?>

	<div class="mobile-social">
		<div class="menu-social">
			<?php foreach(get_field('social-networks', 'option') as $social) : ?>
				<a href="<?= $social['url']; ?>" class="social-link btn btn-dark btn-outline" title="<?= $social['site']['label']; ?>">
					<i class="fab fa-<?= $social['site']['value']; ?>"></i>
				</a>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="text-center mt-3">
		Hit the Road © <?= date('Y') ?>
	</div>
</div>
