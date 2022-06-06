<?php if ($args['products']->isActive) : ?>
<section class="section latest-products">
	<?php if ($args['products']->borders) : ?>
	<div class="latest-divider-top">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M1200 0L0 0 892.25 114.72 1200 0z" class="shape-fill"></path>
    </svg>
	</div>
	<?php endif; ?>

	<div class="container">
		<h1 class="section-title">Nos dernières aventures</h1>
		<div class="products-slider swiper">
			<div class="swiper-wrapper">
				<?php
				$options = [
					'post_type' => 'product',
					'posts_per_page' => $args['products']->number ?: 4,
					'orderby' => 'date',
					'order' => 'DESC',
					'post_status' => 'publish',
				];
				$loop = new WP_Query($options);
				$index = 0;
				if ($loop->have_posts()) :
					while ($loop->have_posts()) :
						$loop->the_post();
						setup_postdata($loop->post->ID);
						$product_id = get_the_ID();
						?>
						<article data-aos="fade-up" data-aos-delay="<?= ($index + 2) * 50 ?>" data-aos-duration="500" class="product swiper-slide">
							<a href="<?= get_the_permalink(get_the_ID()) ?>" class="product-link">
								<h2 class="screen-reader-text"><?= get_the_title(); ?></h2>
								<div class="product-picture">
									<img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'product-thumbnail')[0] ?>" alt>
								</div>
							</a>
							<div class="d-grid">
								<a href="<?= get_the_permalink(get_the_ID()) ?>" class="btn btn-primary" aria-label="Aller voir “<?= get_the_title() ?>”" rel="nofollow">Voir l’article</a>
							</div>
						</article>
						<?php $index++; ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>

			<div class="products-slider-controls mt-2 mb-2">
				<div class="nav-dots"></div>
				<button type="button" class="slider-arrow slider-prev" aria-label="Produits précédents"><i class="fas fa-chevron-left"></i></button>
				<button type="button" class="slider-arrow slider-next" aria-label="Produits suivants"><i class="fas fa-chevron-right"></i></button>
			</div>
		</div>
	</div>

	<?php /* if ($args['products']->borders) : ?>
	<div class="latest-divider-bottom">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
			<path d="M1200 0L0 0 892.25 114.72 1200 0z" class="shape-fill"></path>
    </svg>
	</div>
	<?php endif; */ ?>
</section>
<?php endif; ?>
