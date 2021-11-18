<?php
/**
* Template Name: Accueil
*
* @package WordPress
* @subpackage HitTheRoad
*/

$home = (object) [
	'hero' => (object) [
		'isActive' => get_field('block-hero')['is-active'],
		'content' => get_field('block-hero')['content'],
		'background' => isset(get_field('block-hero')['background']['url']) && get_field('block-hero')['background']['url'] !== '' ? get_field('block-hero')['background']['url'] : '#000',
	],
	'bestProducts' => (object) [
		'isActive' => get_field('block-best-products')['is-active'],
		'products' => get_field('block-best-products')['products'],
	],
];
?>

<?php get_header(); ?>

<?php if ($home->hero->isActive) : ?>
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
<?php endif; ?>

<?php if ($home->bestProducts->isActive) : ?>
<section class="best-products">
	<div class="container">
		<div class="products-list" style="--products-count: <?= count($home->bestProducts->products) ?>">
			<?php foreach ($home->bestProducts->products as $index => $product) :
			$product = $product['product'];
			?>
			<article data-aos="fade-up" data-aos-delay="<?= ($index + 10) * 50 ?>" data-aos-duration="500">
				<a href="<?= get_the_permalink($product->ID) ?>" class="product">
					<div class="product-image">
						<img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), 'medium')[0] ?>" alt>
					</div>
					<div class="product-content">
						<h3 class="product-title"><?= $product->post_title ?></h3>
						<p><?= wc_get_product($product->ID)->get_price() ?> €</p>
						<p><?= wc_get_product($product->ID)->get_width() ?>×<?= wc_get_product($product->ID)->get_height() ?> mm</p>
					</div>
				</a>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
