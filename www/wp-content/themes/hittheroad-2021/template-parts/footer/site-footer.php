<footer class="site-footer" role="contentinfo">
	<div class="site-footer-top">
		<?php if (get_field('footer-borders', 'option')) : ?>
		<div class="footer-divider-top">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
				<path d="M1200 0L0 0 598.97 114.72 1200 0z" class="shape-fill"></path>
			</svg>
		</div>
		<?php endif; ?>

		<div class="container">
			<?php get_template_part('template-parts/footer/navigation'); ?>
		</div>

		<?php if (get_field('footer-borders', 'option')) : ?>
		<div class="footer-divider-bottom">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
				<path d="M598.97 114.72L0 0 0 120 1200 120 1200 0 598.97 114.72z" class="shape-fill"></path>
			</svg>
		</div>
		<?php endif; ?>
	</div>

	<div class="site-footer-bottom">
		<div class="footer-copyright">
			Hit the Road © <?= date('Y') ?>
		</div>

		<a href="#top" class="btn btn-secondary btn-squared back-to-top" title="Retourner en haut">
			<i class="fas fa-chevron-up"></i>
		</a>
	</div>
</footer>
