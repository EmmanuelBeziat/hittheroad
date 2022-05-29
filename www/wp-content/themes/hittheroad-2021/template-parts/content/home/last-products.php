
<section class="section best-products">
	<div class="container">
		<h1 class="section-title">Nos dernières aventures</h1>
		<div class="products-grid">
			<?php
			$args = [
				'post_type' => 'product',
				'posts_per_page' => 4,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_status' => 'publish',
			];
			$loop = new WP_Query($args);
			$index = 0;
			if ($loop->have_posts()) :
				while ($loop->have_posts()) :
					$loop->the_post();
					setup_postdata($loop->post->ID);
					?>
					<article data-aos="fade-up" data-aos-delay="<?= ($index + 2) * 50 ?>" data-aos-duration="500">
						<a href="<?= get_the_permalink(get_the_ID()) ?>" class="product-link">
							<div class="product-picture">
								<img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'product-thumbnail')[0] ?>" alt>
							</div>
							<h3 class="woocommerce-loop-product__title"><?= get_the_title() ?></h3>
								<span class="woocommerce-Price-amount amount">
									<bdi>34,00 <span class="woocommerce-Price-currencySymbol">€</span></bdi>
								</span>
							</span>
						</a>
						<div class="d-grid">
							<a href="<?= get_the_permalink(get_the_ID()) ?>" class="btn btn-primary" aria-label="Aller voir “<?= get_the_title() ?>”" rel="nofollow">Voir l’article</a>
						</div>
					</article>
					<?php $index++; ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
