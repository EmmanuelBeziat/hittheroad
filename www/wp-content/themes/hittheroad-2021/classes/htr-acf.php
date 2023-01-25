<?php
/**
 * ACF functions.
 */
class HTR_ACF {
	/**
	 * Add Wordpress' actions and filters.
	 */
	function __construct () {
		add_action('acf/init', [$this, 'options_page']);
		add_action('acf/init', [$this, 'acf_fields']);
	}

	/**
	 * Add ACF options page.
	 */
	public function options_page () {
		acf_add_options_page();
	}

	/**
	 * ACF Content
	 */
	public function acf_fields () {

	}
}
new HTR_ACF();
