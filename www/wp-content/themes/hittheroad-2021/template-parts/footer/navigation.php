<nav class="footer-nav">
	<div class="footer-nav-item">
		<?php
		if (has_nav_menu('footer-left')) :
			wp_nav_menu([
				'theme_location' => 'footer-left',
				'container'=> 'ul',
			]);
		endif;
		?>
	</div>

	<div class="footer-nav-item">
		<?php
		if (has_nav_menu('footer-center')) :
			wp_nav_menu([
				'theme_location' => 'footer-center',
				'container'=> 'ul',
			]);
		endif;
		?>
	</div>

	<div class="footer-nav-item">
		<?php
		if (has_nav_menu('footer-right')) :
			wp_nav_menu([
				'theme_location' => 'footer-right',
				'container'=> 'ul',
			]);
		endif;
		?>
	</div>
</nav>
