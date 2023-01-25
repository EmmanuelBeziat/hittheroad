<?php
	$paged = get_query_var('paged') ?: 1;
	$postsPerPage = get_field('products-per-page', 'option');
	$args = [
		'post_type' => 'product',
		'paged' => $paged,
		'posts_per_page' => $postsPerPage,
		// 'offset' => ($paged - 1) * $postsPerPage,
		'orderby' => 'date',
		'post_status' => 'publish',
	];

	$components = parse_url($_SERVER['REQUEST_URI']);
	$metaQuery = [
	'relation' => 'AND',
		[
			'relation' => 'OR',
			[
				'key' => 'hide-from-shop',
				'compare' => 'NOT EXISTS',
			],
			[
				'key' => 'hide-from-shop',
				'value' => '0',
			]
		]
	];

	if (isset($components['query'])) {
		parse_str($components['query'], $params);
		$show = [
			'relation' => 'AND'
		];

		foreach ($params as $key => $value) :
			$show[] = [
				'taxonomy' => $key,
				'value' => $value,
				'compare' => 'IN',
			];
		endforeach;
		array_push($metaQuery, $show);
	}
	$args = array_merge($args, ['meta_query' => $metaQuery]);

	$loop = new WP_Query($args);
	$productsCount = $loop->found_posts;

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action('woocommerce_before_shop_loop');

	woocommerce_product_loop_start();

	if ($loop->have_posts()) :
		while ($loop->have_posts()) :
			$item = $loop->the_post();
			global $product;

			setup_postdata($loop->post->ID);

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action('woocommerce_shop_loop');

			wc_get_template_part('content', 'product');
		endwhile;
	else :
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action('woocommerce_no_products_found');
	endif;

	woocommerce_product_loop_end();

	$total = ceil($productsCount / $postsPerPage) ?: 1;
	$base = isset($base) ? $base : esc_url_raw(str_replace(999999999, '%#%', get_pagenum_link(999999999, false)));
	$format = isset($format) ? $format : '';

	if (!$total <= 1) : ?>
		<nav class="products-pagination" aria-label="Navigation pages produits" data-aos="fade-up" data-aos-delay="0" data-aos-duration="400">
			<?php echo paginate_links([
				'base' => $base,
				'format' => $format,
				'current' => max(1, $paged),
				'total' => $total,
				'type' => 'list',
				'prev_text' => '<i class="fas fa-chevron-left"></i><span class="screen-reader-text">Page précédente</span>',
				'next_text' => '<i class="fas fa-chevron-right"></i><span class="screen-reader-text">Page suivante</span>',
			]); ?>
		</nav>
		<?php
	endif;

	wp_reset_postdata();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action('woocommerce_after_shop_loop');
