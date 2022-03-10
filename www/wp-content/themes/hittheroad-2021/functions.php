<?php

add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	add_theme_support('woocommerce');

	register_nav_menus([
		'navigation' => __('Menu principal'),
		'footer-left' => __('Pied de page — Gauche'),
		'footer-center' => __('Pied de page — Centre'),
		'footer-right' => __('Pied de page — Droite'),
	]);
});

require_once 'classes/htr-acf.php';
require_once 'classes/htr-locations.php';
require_once 'classes/htr-scripts.php';
require_once 'classes/htr-templates.php';
require_once 'classes/htr-tools.php';
require_once 'classes/htr-walkers.php';
require_once 'inc/disable-comments.php';
require_once 'inc/woocommerce-functions.php';

function debug ($message, $exit = false) {
	echo '<pre style="padding: 1rem; margin: 1rem 0; background: #e8e8e8; color: #2f2f2f;">';
	var_dump($message);
	echo '</pre>';

	if ($exit) {
		exit();
	}
}

function gn_ajouter_styles_editeur() {
	add_editor_style('assets/css/editor-style.css');
}
add_action( 'init', 'gn_ajouter_styles_editeur' );
// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function custom_pagination ($args) {
	$page = $args['currentPage'];
	$maxPages = (int)$args['maxNumPages'];

	if ($maxPages > 1) :
	?>
	<nav class="products-pagination" aria-label="Navigation pages produits" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
		<ul class="pagination justify-content-center">
			<li class="page-item<?= $page - 1 === 0 ? ' disabled' : '' ?>">
				<a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Précédent"<?= $page - 1 === 0 ? ' tabindex="-1" aria-disabled="true"' : '' ?>>
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
			<?php for ($i = 0; $i < $args['maxNumPages']; $i++) : ?>
				<?php if ($i+1 === $args['currentPage']) : ?>
					<li class="page-item active"><a class="page-link" href="#"><?= $i+1 ?></a></li>
				<?php else : ?>
					<li class="page-item"><a class="page-link" href="?page=<?= $i+1 ?>"><?= $i+1 ?></a></li>
				<?php endif; ?>
			<?php endfor; ?>
			<li class="page-item<?= $maxPages === $page ? ' disabled' : '' ?>">
				<a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Suivant"<?= $maxPages === $page ? ' tabindex="-1" aria-disabled="true"' : '' ?>>
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</nav>
	<?php
	endif;
}
