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
		'borders'	=> get_field('block-hero')['borders'],
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
		'isActive' => get_field('block-map')['is-active'],
		'token' => get_field('block-map')['token'],
		'style' => get_field('block-map')['style'],
		'borders'	=> get_field('block-map')['borders'],
	],
	'latestProducts' => (object) [
		'isActive' => get_field('block-latest-products')['is-active'],
		'number' => get_field('block-latest-products')['number'],
		'borders'	=> get_field('block-latest-products')['borders'],
	],
	'bestProducts' => (object) [
		'isActive' => get_field('block-best-products')['is-active'],
		'products' => get_field('block-best-products')['products'],
		'borders'	=> get_field('block-best-products')['borders'],
	],
];
?>

<?php get_header(); ?>

<section class="hero" style="--hero-background: url(<?= $home->hero->background ?>)">
	<div class="hero-content">
		<div class="hero-inner-content" data-aos="fade-in" data-aos-duration="1000">
			<video class="hero-video" width="480" height=480" autoplay muted loop playsinline>
				<source src="<?= get_stylesheet_directory_uri() ?>/assets/images/videos/htr-logo.mov" type="video/quicktime">
				<source src="<?= get_stylesheet_directory_uri() ?>/assets/images/videos/htr-logo.webm" type="video/webm">
			</video>
			<?php if ($home->hero->content && $home->hero->content !== '') :
				echo $home->hero->content;
			endif; ?>
		</div>

		<?php if ($home->hero->borders): ?>
		<div class="hero-divider-bottom">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
				<path d="M1200 0L0 0 598.97 114.72 2000 0z" class="shape-fill"></path>
			</svg>
		</div>
		<?php endif; ?>
	</div>
</section>

<section class="showcase">
	<div class="container text-center">
		<h2 class="showcase-title" data-aos="fade-up" data-aos-duration="400"><?= $home->showcase->title ?></h2>
		<?php if ($home->showcase->content && $home->showcase->content !== '') : ?>
		<p class="lead" data-aos="fade-up" data-aos-duration="400" data-aos-delay="100"><?= $home->showcase->content ?></p>
		<?php endif; ?>

		<?php if (isset($home->showcase->link->url) && $home->showcase->link->url !== '') : ?>
			<div>
				<a class="btn btn-secondary btn-lg showcase-button" data-aos="fade-up" data-aos-duration="400" data-aos-delay="200" href="<?= $home->showcase->link->url ?>"><?= $home->showcase->link->label ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_template_part('template-parts/content/home/map', '', ['map' => $home->map]); ?>
<?php get_template_part('template-parts/content/home/latest-products', '', ['products' => $home->latestProducts]); ?>
<?php get_template_part('template-parts/content/home/best-products', '', ['products' => $home->bestProducts]); ?>

<?php get_footer(); ?>
