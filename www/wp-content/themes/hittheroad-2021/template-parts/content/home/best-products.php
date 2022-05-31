<section class="section best-products">
	<div class="container">
		<h1 class="section-title">Nos meilleures aventures</h1>
		<div class="products-grid" style="--products-count: <?= count($args['products']) ?>">
			<?php foreach ($args['products'] as $index => $product) :
			$product = $product['product'];
			$tags = [
				'country' => (object) [
					'name' => get_field_object('country')['label'],
					'value' => get_field('country', $product->ID)['value'],
					'label' => get_field('country', $product->ID)['label'],
				],
				'orientation' => (object) [
					'name' => get_field_object('orientation')['label'],
					'value' => get_field('orientation', $product->ID)['value'],
					'label' => get_field('orientation', $product->ID)['label'],
				],
				'format' => (object) [
					'name' => get_field_object('format')['label'],
					'value' => get_field('format', $product->ID)['value'],
					'label' => get_field('format', $product->ID)['label'],
				],
				'character' => (object) [
					'name' => get_field_object('character')['label'],
					'value' => get_field('character', $product->ID)['value'],
					'label' => get_field('character', $product->ID)['label'],
				],
				'type' => (object) [
					'name' => get_field_object('type')['label'],
					'value' => get_field('type', $product->ID)['value'],
					'label' => get_field('type', $product->ID)['label'],
				],
				// 'year' => get_field('year', $product->ID),
				'colors' => (object) [
					'name' => get_field_object('colors')['label'],
					'value' => get_field('colors', $product->ID)['value'],
					'label' => get_field('colors', $product->ID)['label'],
				],
			];
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
					<div class="product-tags">
						<?php foreach ($tags as $tag) : ?>
						<span class="product-tag" data-value="<?= $tag->value ?>"><i class="fas fa-tag"></i> <strong><?= $tag->name ?> :</strong> <?= $tag->label ?></span>
						<?php endforeach; ?>
					</div>
				</a>
				<div class="d-grid">
					<a href="<?= get_the_permalink($product->ID) ?>" class="btn btn-primary" aria-label="Aller voir “<?= $product->post_title ?>”" rel="nofollow">Voir l’article</a>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
