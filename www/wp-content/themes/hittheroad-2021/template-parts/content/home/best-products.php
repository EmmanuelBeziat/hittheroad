<?php if ($args['products']->isActive) : ?>
<section class="section best-products">
	<div class="container">
		<h1 class="section-title">Notre sélection</h1>
		<div class="products-slider swiper">
			<div class="swiper-wrapper">
				<?php foreach ($args['products']->products as $index => $product_id) : ?>
					<article data-aos="fade-up" data-aos-delay="<?= ($index + 2) * 50 ?>" data-aos-duration="500" class="product swiper-slide">
						<a href="<?= get_the_permalink(get_the_ID($product_id)) ?>" class="product-link">
							<h2 class="screen-reader-text"><?= get_the_title($product_id); ?></h2>
							<div class="product-picture">
								<img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'product-thumbnail')[0] ?>" alt>
							</div>
						</a>
						<div class="d-grid">
							<a href="<?= get_the_permalink($product_id) ?>" class="btn btn-primary" aria-label="Aller voir “<?= get_the_title($product_id) ?>”" rel="nofollow">Voir l’article</a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

			<div class="products-slider-controls mt-2 mb-2">
				<div class="nav-dots"></div>

				<button type="button" class="slider-arrow slider-prev" aria-label="Produits précédents"><i class="fas fa-chevron-left"></i></button>
				<button type="button" class="slider-arrow slider-next" aria-label="Produits suivants"><i class="fas fa-chevron-right"></i></button>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
