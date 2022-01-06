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
		'destinations' => get_field('block-map')['destinations'],
	],
	'bestProducts' => (object) [
		'isActive' => get_field('block-best-products')['is-active'],
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
		<h2 class="showcase-title"><?= $home->showcase->title ?></h2>
		<p class="lead"><?= $home->showcase->content ?></p>

		<?php if (isset($home->showcase->link->url) && $home->showcase->link->url !== '') : ?>
			<a class="btn btn-secondary btn-lg showcase-button" href="<?= $home->showcase->link->url ?>"><?= $home->showcase->link->label ?></a>
		<?php endif; ?>
	</div>
</section>

<section class="map" id="home-map">
	<div class="map-divider-top">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M1200 0L0 0 892.25 114.72 1200 0z" class="shape-fill"></path>
    </svg>
	</div>

	<div id="htr-destinations"></div>
	<script>
		const places = <?= json_encode($home->map->destinations) ?>;
		const htrMapToken = '<?= $home->map->token ?>'
		const htrMapStyle = '<?= $home->map->style ?>'
		const htrMapDestinations = []
		places.forEach(place => {
			htrMapDestinations.push({
				lat: parseFloat(place.ville.split(',')[0]),
				lng: parseFloat(place.ville.split(',')[1]),
			})
		})
	</script>
</section>

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
