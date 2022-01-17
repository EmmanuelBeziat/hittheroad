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
		add_filter('the_content', array($this, 'the_content'), 999);
	}

	/**
	 * Add classes to body.
	 *
	 * @param $body_classes array Current body classes.
	 *
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
	}

	/**
	 * Filters the content.
	 *
	 * @param $content mixed The content.
	 *
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
