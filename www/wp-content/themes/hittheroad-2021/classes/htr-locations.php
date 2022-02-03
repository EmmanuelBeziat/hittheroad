<?php
/**
 * Global position functions
 */
class HTR_Locations {
	/**
	 * Post type name.
	 */
	protected $post_type = 'location';

	function __construct() {
		add_action('init', [$this, 'init_post_type']);
	}

	/**
	 * Get post type arguments.
	 *
	 * @return $args array Array of arguments.
	 */
	public function get_post_type_args() {
		$args = array(
			'labels' => $this->get_post_type_labels(),
			'public' => true,
			'show_in_nav_menus' => false,
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-airplane',
			'has_archive' => false,
			'delete_with_user' => false,
		);

		if (isset($this->taxonomy)) {
			$args['taxonomies'] = [
				$this->taxonomy,
			];
		}

		return $args;
	}

	/**
	 * Get recipes labels.
	 *
	 * @return $labels array Recipes labels.
	 */
	public function get_post_type_labels() {
		$labels = array(
			'name' => 'Emplacements',
			'singular_name' => 'Emplacement',
			'add_new_item' => 'Ajouter un nouvel emplacement',
			'edit_item' => 'Modifier l’emplacement',
			'new_item' => 'Nouvel emplacement',
			'view_item' => 'Voir l’emplacement',
			'view_items' => 'Voir les emplacements',
			'search_items' => 'Rechercher dans les emplacements',
			'not_found' => 'Aucun emplacement trouvé',
			'not_found_in_trash' => 'Aucun emplacement trouvé dans la corbeille',
			'parent_item_colon' => 'Emplacement parent',
			'all_items' => 'Tous les emplacements',
			'archives' => 'Emplacements archivés',
			'attributes' => 'Attributs de l’emplacement',
			'insert_into_item' => 'Insérer dans l’emplacement',
			'uploaded_to_this_item' => 'Téléversés sur cet emplacement',
			'filter_items_list' => 'Filtrer la liste des emplacements',
			'items_list_navigation' => 'Navigation dans la liste des emplacements',
			'items_list' => 'Liste des emplacements',
			'item_published' => 'Emplacement mis en ligne.',
			'item_published_privately' => 'Emplacement mis en ligne en privé.',
			'item_reverted_to_draft' => 'Emplacement repassé en brouillon.',
			'item_scheduled' => 'Emplacement programmé.',
			'item_updated' => 'Emplacement mis à jour.',
			'item_link' => 'Lien vers l’emplacement',
			'item_link_description' => 'Un lien vers un emplacement',
		);

		return $labels;
	}

	/**
	 * Create post type.
	 */
	public function init_post_type() {
		$post_type = register_post_type($this->post_type, $this->get_post_type_args());

		if (is_wp_error($post_type)) {
			HTR_Tools::dd($post_type, true);
		}
	}
}

new HTR_Locations();
