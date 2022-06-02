<?php
/**
 * Templates functions
 */
class HTR_Templates {
	/**
	 * Add WordPress' actions and filters
	 */
	function __construct () {
		add_action('after_setup_theme', [$this, 'image_sizes']);
		add_action('body_class', [$this, 'body_classes']);
		add_filter('the_content', [$this, 'the_content'], 999);
		add_filter('intermediate_image_sizes_advanced', [$this, 'remove_default_image_sizes']);
	}

	/**
	 * Add classes to body.
	 * @param $body_classes array Current body classes.
	 * @return $body_classes array All body classes.
	 */
	public function body_classes ($body_classes) {
		$classes = [
			'body',
		];
		$body_classes = array_merge($body_classes, $classes);
		return $body_classes;
	}

	/**
	 * Add custom sizes for images.
	 */
	public function image_sizes () {
		update_option('thumbnail_size_h', 0);
		update_option('thumbnail_size_w', 0);
		update_option('medium_size_h', 0);
		update_option('medium_size_w', 0);
		update_option('large_size_h', 0);
		update_option('large_size_w', 0);

		update_option('woocommerce_thumbnail', 0);
		update_option('woocommerce_single', 0);
		update_option('woocommerce_gallery_thumbnail', 0);
		update_option('shop_catalog', 0);
		update_option('shop_single', 0);
		update_option('shop_thumbnail', 0);

		remove_image_size('woocommerce_thumbnail');
		remove_image_size('woocommerce_single');
		remove_image_size('woocommerce_gallery_thumbnail');
		remove_image_size('shop_catalog');
		remove_image_size('shop_single');
		remove_image_size('shop_thumbnail');

		add_image_size('author-picture-small', 300, 300, true);
		add_image_size('author-picture-medium', 640, 640, true);
		add_image_size('author-picture', 640);

		add_image_size('product-thumbnail', 300, 300, true);
		add_image_size('product-preview', 768);
		add_image_size('product-full', 1920);
	}

	/**
	 * Remove default image sizes.
	 * @param $sizes array Current image sizes.
	 * @return $sizes array All image sizes.
	 */
	public function remove_default_image_sizes ($sizes) {
		unset($sizes['medium']);
		unset($sizes['medium_large']);
		unset($sizes['large']);
		unset($sizes['2048x2048']);
		unset($sizes['1536x1536']);
		return $sizes;
	}

	/**
	 * Filters the content.
	 * @param $content mixed The content.
	 * @return $content mixed The filtered content.
	 * */
	public function the_content($content) {
		if (strstr($content, 'youtube')) {
			$content = preg_replace('#https://www.youtube.com/#', 'https://www.youtube-nocookie.com/', $content);
		}

		return $content;
	}
}

new HTR_Templates();
