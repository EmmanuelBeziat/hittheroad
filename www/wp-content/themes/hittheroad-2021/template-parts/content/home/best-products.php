<?php if ($args['products']->isActive) : ?>
<section class="section best-products">
	<div class="container">
		<h1 class="section-title">Nos meilleures aventures</h1>
		<div class="products-slider">
			<?php foreach ($args['products']->products as $index => $product_id) : ?>
				<?php $tags = [
					'country' => (object) [
						'name' => get_field_object('country')['label'],
						'value' => get_field('country', $product_id)['value'],
						'label' => get_field('country', $product_id)['label'],
					],
					'orientation' => (object) [
						'name' => get_field_object('orientation')['label'],
						'value' => get_field('orientation', $product_id)['value'],
						'label' => get_field('orientation', $product_id)['label'],
					],
					'format' => (object) [
						'name' => get_field_object('format')['label'],
						'value' => get_field('format', $product_id)['value'],
						'label' => get_field('format', $product_id)['label'],
					],
					'character' => (object) [
						'name' => get_field_object('character')['label'],
						'value' => get_field('character', $product_id)['value'],
						'label' => get_field('character', $product_id)['label'],
					],
					'type' => (object) [
						'name' => get_field_object('type')['label'],
						'value' => get_field('type', $product_id)['value'],
						'label' => get_field('type', $product_id)['label'],
					],
					// 'year' => get_field('year', $product_id),
					'colors' => (object) [
						'name' => get_field_object('colors')['label'],
						'value' => get_field('colors', $product_id)['value'],
						'label' => get_field('colors', $product_id)['label'],
					],
				];
				?>
				<article data-aos="fade-up" data-aos-delay="<?= ($index + 2) * 50 ?>" data-aos-duration="500" class="product">
					<a href="<?= get_the_permalink(get_the_ID($product_id)) ?>" class="product-link">
						<h2 class="screen-reader-text"><?= get_the_title($product_id); ?></h2>
						<div class="product-picture">
							<img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'product-thumbnail')[0] ?>" alt>
						</div>
						<div class="product-tags mt-2">
							<?php foreach ($tags as $tag) : ?>
							<span class="product-tag" data-value="<?= $tag->value ?>"><i class="fas fa-tag"></i><?= $tag->label ?></span>
							<?php endforeach; ?>
						</div>
					</a>
					<div class="d-grid">
						<a href="<?= get_the_permalink($product_id) ?>" class="btn btn-primary" aria-label="Aller voir “<?= get_the_title($product_id) ?>”" rel="nofollow">Voir l’article</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
