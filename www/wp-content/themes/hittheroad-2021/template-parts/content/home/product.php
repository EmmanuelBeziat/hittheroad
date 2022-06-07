<?php
$delay = $args['delay'];
$product_id = $args['id'];
?>
<article data-aos="fade-up" data-aos-delay="<?= $delay ?>" data-aos-duration="500" class="product swiper-slide">
	<a href="<?= get_the_permalink(get_the_ID($product_id)) ?>" class="product-link">
		<h2 class="screen-reader-text"><?= get_the_title($product_id); ?></h2>
		<div class="product-picture">
			<img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'product-thumbnail')[0] ?>" alt>
		</div>
	</a>
</article>
