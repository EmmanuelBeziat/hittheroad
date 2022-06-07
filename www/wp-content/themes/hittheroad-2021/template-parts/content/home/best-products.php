<?php if ($args['products']->isActive) : ?>
<section class="section best-products">
	<div class="container">
		<h1 class="section-title">Notre sélection</h1>
		<div class="products-slider swiper">
			<div class="swiper-wrapper">
				<?php foreach ($args['products']->products as $index => $product_id) :
					get_template_part('template-parts/content/home/product', '', ['id' => $product_id, 'delay' => ($index + 2) * 50]);
				endforeach; ?>
			</div>

			<?php get_template_part('template-parts/content/home/slider', 'controls'); ?>
		</div>
	</div>
</section>
<?php endif; ?>
