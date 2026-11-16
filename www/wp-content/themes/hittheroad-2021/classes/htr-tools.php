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

	/**
	 * Social network icon markup.
	 * Font Awesome 5 has no X icon: "twitter" is rendered with the X logo
	 * (Font Awesome Free 6.7.2 "x-twitter", CC BY 4.0, https://fontawesome.com/license/free).
	 *
	 * @param string $site Social network key (ACF "site" value).
	 * @return string Icon HTML.
	 */
	public static function social_icon ($site) {
		if ($site === 'twitter') {
			return '<svg class="svg-inline--fa fa-x-twitter fa-w-16" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>';
		}

		return '<i class="fab fa-' . esc_attr($site) . '" aria-hidden="true"></i>';
	}

	/**
	 * Social network display name ("Twitter" is now "X").
	 *
	 * @param array $site ACF "site" field (value, label).
	 * @return string Label.
	 */
	public static function social_label ($site) {
		return $site['value'] === 'twitter' ? 'X' : $site['label'];
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
