<section class="section best-products">
	<div class="container">
		<h1 class="section-title">Nos meilleures aventures</h1>
		<div class="products-grid" style="--products-count: <?= count($args['products']) ?>">
			<?php foreach ($args['products'] as $index => $product) :
			$product = $product['product'];
			?>
			<article data-aos="fade-up" data-aos-delay="<?= ($index + 2) * 50 ?>" data-aos-duration="500">
				<a href="<?= get_the_permalink($product->ID) ?>" class="product-link">
					<div class="product-picture">
						<img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id($product->ID), 'product-thumbnail')[0] ?>" alt>
					</div>
					<h3 class="woocommerce-loop-product__title"><?= $product->post_title ?></h3>
					<span class="price">
						<span class="woocommerce-Price-amount amount">
							<bdi><?= wc_get_product($product->ID)->get_price() ?> <span class="woocommerce-Price-currencySymbol">€</span></bdi>
						</span>
					</span>
				</a>
				<div class="d-grid">
					<a href="<?= get_the_permalink($product->ID) ?>" class="btn btn-primary" aria-label="Aller voir “<?= $product->post_title ?>”" rel="nofollow">Voir l’article</a>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
