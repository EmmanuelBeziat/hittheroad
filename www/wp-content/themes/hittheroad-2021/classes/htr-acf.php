<?php
/**
 * ACF functions.
 */
class HTR_ACF {
	/**
	 * Add Wordpress' actions and filters.
	 */
	function __construct() {
		add_action('acf/init', [$this, 'options_page']);
	}

	public function options_page() {
		acf_add_options_page();
	}
}
new HTR_ACF();
