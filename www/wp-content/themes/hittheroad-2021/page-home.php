<?php
/**
* Template Name: Accueil
*
* @package WordPress
* @subpackage HitTheRoad
*/

$home = (object) [
	'hero' => (object) [
		// 'isActive' => get_field('block-hero')['is-active'],
		'content' => get_field('block-hero')['content'],
		'background' => isset(get_field('block-hero')['background']['url']) && get_field('block-hero')['background']['url'] !== '' ? get_field('block-hero')['background']['url'] : '#000',
	],
	'showcase' => (object) [
		// 'isActive' => get_field('block-showcase')['is-active'],
		'title' => get_field('block-showcase')['title'],
		'content' => get_field('block-showcase')['content'],
		'link' => (object) [
			'url' => get_field('block-showcase')['link']['url'],
			'label' => get_field('block-showcase')['link']['label'],
		],
	],
	'map' => (object) [
		// 'isActive' => get_field('block-map')['is-active'],
		'token' => get_field('block-map')['token'],
		'style' => get_field('block-map')['style'],
	],
	'bestProducts' => (object) [
		'isActive' => get_field('block-best-products')['is-active'],
		'latestProducts' => get_field('block-best-products')['products-select'],
		'products' => get_field('block-best-products')['products'],
	],
];
?>

<?php get_header(); ?>

<section class="hero" style="--hero-background: url(<?= $home->hero->background ?>)">
	<div class="hero-content">
		<div class="hero-inner-content" data-aos="fade-in" data-aos-duration="1000">
			<?php if ($home->hero->content) :
				echo $home->hero->content;
			endif; ?>
		</div>

		<div class="hero-divider-bottom">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
				<path d="M1200 0L0 0 598.97 114.72 1200 0z" class="shape-fill"></path>
			</svg>
		</div>
	</div>
</section>

<section class="showcase">
	<div class="container text-center">
		<h2 class="showcase-title" data-aos="fade-up" data-aos-duration="400"><?= $home->showcase->title ?></h2>
		<p class="lead" data-aos="fade-up" data-aos-duration="400" data-aos-delay="100"><?= $home->showcase->content ?></p>

		<?php if (isset($home->showcase->link->url) && $home->showcase->link->url !== '') : ?>
			<a class="btn btn-secondary btn-lg showcase-button" data-aos="fade-up" data-aos-duration="400" data-aos-delay="200" href="<?= $home->showcase->link->url ?>"><?= $home->showcase->link->label ?></a>
		<?php endif; ?>
	</div>
</section>

<?php get_template_part('template-parts/content/home/map', '', ['map' => $home->map]); ?>

<?php if ($home->bestProducts->isActive) :
	if ($home->bestProducts->latestProducts) :
		get_template_part('template-parts/content/home/last-products');
	else :
		get_template_part('template-parts/content/home/best-products', '', ['products' => $home->bestProducts->products]);
	endif;
endif; ?>

<?php get_footer(); ?>
