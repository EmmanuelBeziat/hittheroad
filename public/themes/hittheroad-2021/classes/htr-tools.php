<?php
/**
 * Global useful functions.
 */
class HTR_Tools {
	/**
	 * Add WordPress' actions and filters.
	 */
	function __construct() {
		add_filter('upload_mimes', array($this, 'mime_types'));
	}

	/**
	 * Display debug message and can stop program execution.
	 *
	 * @param $message mixed Variable or text to display.
	 * @param $exit boolean Stop program execution.
	 */
	public static function debug($message, $exit = false) {
		echo '<pre style="padding: 1rem; margin: 1rem 0; background: #e8e8e8; color: 2f2f2f;">';
		print_r($message);
		echo '</pre>';

		if ($exit) {
			exit();
		}
	}

	/**
	 * Add custom mime types.
	 *
	 * @param $mime_types array Current mime types.
	 *
	 * @return $mime_types array All mime types.
	 */
	public function mime_types($mime_types) {
		$mime_types['svg'] = 'image/svg+xml';
		$mime_types['webp'] = 'image/webp';

		return $mime_types;
	}
}
new HTR_Tools();
