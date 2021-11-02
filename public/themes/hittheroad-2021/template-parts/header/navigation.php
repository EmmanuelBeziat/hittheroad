<button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#main-navigation" aria-controls="main-navigation" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
</button>

<?php if (has_nav_menu('navigation')) : ?>
<div class="collapse navbar-collapse" id="main-navigation">
	<?php wp_nav_menu([
		'theme_location' => 'navigation',
		'depth' => 1, // 1 = no dropdowns, 2 = with dropdowns.
    'container' => 'ul',
    'menu_class' => 'navbar-nav ms-auto',
    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
		'walker' => new WP_Bootstrap_Navwalker()
	]); ?>
</div>
<?php endif; ?>
