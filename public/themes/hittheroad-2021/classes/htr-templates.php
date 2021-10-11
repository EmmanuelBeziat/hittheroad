<?php
/**
 * Templates functions
 */
class HTR_Templates {
	/**
	 * Add WordPress' actions and filters
	 */
	function __construct() {
		add_action('after_setup_theme', [$this, 'image_sizes']);
		add_action('body_class', [$this, 'body_classes']);
	}

	/**
	 * Add classes to body.
	 *
	 * @param $body_classes array Current body classes.
	 *
	 * @return $body_classes array All body classes.
	 */
	public function body_classes($body_classes) {
		$classes = [
			'body',
		];

		$body_classes = array_merge($body_classes, $classes);

		return $body_classes;
	}

	/**
	 * Add custom sizes for images.
	 */
	public function image_sizes() {
		update_option('thumbnail_size_h', 0);
		update_option('thumbnail_size_w', 0);
		update_option('medium_size_h', 0);
		update_option('medium_size_w', 0);
		update_option('large_size_h', 0);
		update_option('large_size_w', 0);
	}
}

new HTR_Templates();
