<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop'); ?>

<div class="container">
<?php
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');
?>
<header class="woocommerce-products-header">
	<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
		<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>

		<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	// do_action('woocommerce_archive_description');
	?>
</header>
<?php
if (woocommerce_product_loop()) :
	$paged = get_query_var('paged') ?: 1;
	$postsPerPage = get_field('products-per-page', 'option');
	$args = [
		'post_type' => 'product',
		'paged' => $paged,
		'posts_per_page' => $postsPerPage,
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
else :
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action('woocommerce_no_products_found');
endif;

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action('woocommerce_sidebar');
?>
</div>
<?php
get_footer('shop');
