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
						get_template_part('template-parts/content/home/product', '', ['id' => get_the_ID(), 'delay' => ($index + 2) * 50]);
						$index++;
					endwhile;
				endif; ?>
			</div>

			<?php get_template_part('template-parts/content/home/slider', 'controls'); ?>
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
