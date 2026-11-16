<?php
defined('ABSPATH') || exit;
/**
 * Global useful functions.
 */
class HTR_Tools {
	/**
	 * Add WordPress' actions and filters.
	 */
	function __construct () {
		add_filter('upload_mimes', [$this, 'mime_types']);
		add_filter('clean_image_filenames_mime_types', [$this, 'custom_clean_image_filenames_mime_types']);
	}

	/**
	 * Display debug message and can stop program execution.
	 * @param $message mixed Variable or text to display
	 * @param $exit boolean Stop program execution
	 */
	public static function dd ($message, $exit = false) {
		echo '<pre style="padding: 1rem; margin: 1rem 0; background: #e8e8e8; color: #2f2f2f;">';
		var_dump($message);
		echo '</pre>';

		if ($exit) {
			exit();
		}
	}

	/**
	 * Log errors messages
	 * @param $message mixed Variable or text to log
	 * @param $exit boolean Stop program execution
	 */
	public static function log ($message, $exit = false) {
		error_log($message);

		if ($exit) {
			exit();
		}
	}

	/**
	 * Block video
	 * @param $url string Video URL
	 * @return HTMLElement iframe embed video
	 */
	/**
	 * Sanitize rich content (WYSIWYG fields) for output.
	 * Re-applies responsive image attributes that wp_kses_post() strips, like the_content does.
	 *
	 * @param string|null $html Content to sanitize.
	 * @return string Safe HTML.
	 */
	public static function kses_content ($html) {
		return wp_filter_content_tags(wp_kses_post((string) $html));
	}

	public static function blockVideo	($url) {
		return '<iframe class="video" src="' . esc_url($url) . '" frameborder="0" allow="picture-in-picture" allowfullscreen></iframe>';
	}

	/**
	 * Add support for SVG and WebP
	 * @param $mime_types array
	 * @return $mime_types array
	 */
	public function mime_types ($mime_types) {
		if (current_user_can('manage_options')) {
			$mime_types['svg'] = 'image/svg+xml';
		}
		$mime_types['webp'] = 'image/webp';

		return $mime_types;
	}

	/**
	 * Add custom mime types for uploaded files
	 * @param $mime_types array
	 * @return $mime_types array
	 */
	public function custom_clean_image_filenames_mime_types () {
    $mime_types = [
			'application/pdf',
			'image/jpeg',
			'image/png',
			'image/webp'
		];
		if (current_user_can('manage_options')) {
			$mime_types[] = 'image/svg+xml';
		}
    return $mime_types;
  }
}
new HTR_Tools();
