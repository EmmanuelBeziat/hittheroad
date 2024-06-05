<?php
/**
 * Custom Post tipes functions.
 */
class HTR_CustomPostTypes {
	/**
	 * Add WordPress' actions and filters.
	 */
	function __construct () {
		add_action('init', [$this, 'register_movies_post_type']);
	}

	public function register_movies_post_type () {
		register_post_type('movie', [
			'labels' => [
				'name' => 'Films',
				'singular_name' => 'Film',
				'add_new' => 'Ajouter un film',
				'add_new_item' => 'Ajouter un film',
				'edit_item' => 'Modifier un film',
				'new_item' => 'Nouveau film',
				'view_item' => 'Voir le film',
				'view_items' => 'Voir les films',
				'search_items' => 'Chercher des films',
				'all_items' => 'Tous les films',
			],
			'menu_icon' => 'dashicons-editor-video',
			'menu_position' => 20,
			'public' => true,
			'supports' => [
				'title',
			]
		]);
	}
}

new HTR_CustomPostTypes();
