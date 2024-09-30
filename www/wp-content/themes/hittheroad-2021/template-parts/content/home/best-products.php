<?php if ($args['products']->isActive) : ?>
<section class="section best-products">
	<div class="container">
		<h2 class="h1 section-title">Notre sélection</h2>
		<div class="products-slider swiper">
			<div class="swiper-wrapper">
				<?php foreach ($args['products']->products as $index => $product_id) :
					get_template_part('template-parts/content/product/product', 'item', ['id' => $product_id]);
				endforeach; ?>
			</div>

			<?php get_template_part('template-parts/content/home/slider', 'controls'); ?>
		</div>
	</div>
</section>
<?php endif; ?>
