<?php
/**
 * Global position functions
 */
class HTR_Locations {
	/**
	 * Post type name.
	 */
	protected $post_type = 'location';

	/**
	 * Taxonomy name.
	 */
	protected $taxonomy = 'location_country';

	function __construct() {
		add_filter('bulk_post_updated_messages', [$this, 'bulk_updated_messages'], 10, 2);
		add_action('init', [$this, 'init_post_type']);
		add_filter('post_updated_messages', [$this, 'updated_messages']);
		add_filter('query_vars', [$this, 'ctp_query_vars']);

		if (isset($this->taxonomy)) {
			add_action('init', [$this, 'init_taxonomy']);
		}
	}

	function ctp_query_vars($qvars) {
    $qvars[] = 'place';
    return $qvars;
	}

	/**
	 * Add bulk updated messages for locations.
	 *
	 * @param $bulk_messages array Current messages.
	 * @param $bulk_counts array Number of posts by status.
	 *
	 * @return $bulk_messages array All messages.
	 */
	public function bulk_updated_messages($bulk_messages, $bulk_counts) {
		global $post, $post_ID;

		$bulk_messages[$this->post_type] = array(
			'updated' => _n('%s pays mis à jour.', '%s pays mis à jour.', $bulk_counts['updated']),
			'locked' => _n('%s pays n’a pas été mis à jour : quelqu’un est déjà en train de la modifier.', '%s pays n’ont pas été mis à jour : quelqu’un est déjà en train de les modifier.', $bulk_counts['locked']),
			'deleted' => _n('%s pays supprimé définitivement.', '%s pays supprimés définitivement.', $bulk_counts['deleted']),
			'trashed' => _n('%s pays déplacé dans la corbeille.', '%s pays déplacés dans la corbeille.', $bulk_counts['trashed']),
			'untrashed' => _n('%s pays récupéré depuis la corbeille.', '%s pays récupérés depuis la corbeille.', $bulk_counts['untrashed']),
		);

		return $bulk_messages;
	}

	/**
	 * Get post type arguments.
	 *
	 * @return $args array Array of arguments.
	 */
	public function get_post_type_args() {
		$args = [
			'labels' => $this->get_post_type_labels(),
			'public' => true,
			'show_in_nav_menus' => false,
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-airplane',
			'has_archive' => false,
			'delete_with_user' => false,
		];

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
		$labels = [
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
		];

		return $labels;
	}

	/**
	 * Get taxonomy arguments.
	 *
	 * @return $args array Array of arguments.
	 */
	public function get_taxonomy_args() {
		$args = [
			'labels' => $this->get_taxonomy_labels(),
			'public' => true,
			'show_in_rest' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_quick_edit' => false,
			'meta_box_cb' => false,
			'rewrite' => [
				'slug' => 'country',
			],
		];

		return $args;
	}

	/**
	 * Get locations categories labels.
	 *
	 * @return $labels array locations categories labels.
	 */
	public function get_taxonomy_labels() {
		$labels = [
			'name' => 'Pays',
			'singular_name' => 'Pays',
			'search_items' => 'Rechercher dans les pays',
			'popular_items' => 'Pays les plus utilisés',
			'all_items' => 'Tous les pays',
			'parent_item' => 'Pays parent',
			'edit_item' => 'Modifier le pays',
			'view_item' => 'Voir le pays',
			'update_item' => 'Mettre à jour le pays',
			'add_new_item' => 'Ajouter un pays',
			'new_item_name' => 'Nom de le nouvelle pays',
			'separate_items_with_commas' => 'Séparez les pays par des virgules',
			'add_or_remove_items' => 'Ajouter ou supprimer des pays',
			'choose_from_most_used' => 'Choisissez parmi les pays les plus utilisée',
			'not_found' => 'Aucun pays trouvée',
			'no_terms' => 'Pas de pays',
			'filter_by_item' => 'Filtrer par pays',
			'items_list_navigation' => 'Navigation dans la liste des pays',
			'items_list' => 'Liste des pays',
			'back_to_items' => 'Retour aux pays',
			'item_link' => 'Lien vers le pays',
			'item_link_description' => 'Un lien vers un pays',
		];

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

	/**
	 * Create taxonomy.
	 */
	public function init_taxonomy() {
		$taxonomy = register_taxonomy($this->taxonomy, $this->post_type, $this->get_taxonomy_args());

		if (is_wp_error($taxonomy)) {
			HTR_Tools::debug($taxonomy, true);
		}
	}

	/**
	 * Add updated messages for locations.
	 *
	 * @param $messages array Current messages.
	 *
	 * @return $messages array All messages.
	 */
	public function updated_messages($messages) {
		global $post, $post_ID;

		$view_post_link = esc_url(get_permalink($post_ID));
		$preview_post_link = esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)));

		$messages[$this->post_type] = [
			0 => '',
			1 => sprintf('Pays mis à jour. <a href="%s" target="_blank">Voir le pays</a>', $view_post_link),
			2 => 'Champ personnalisé mis à jour.',
			3 => 'Champ personnalisé supprimé.',
			4 => 'Pays mis à jour.',
			5 => isset($_GET['revision']) ? sprintf('Pays restauré à la révision du %s', wp_post_revision_title((int) $_GET['revision'], false)) : false,
			6 => sprintf('Pays mis en ligne. <a href="%s" target="_blank">Voir le pays</a>', $view_post_link),
			7 => 'Pays enregistré.',
			8 => sprintf('Pays transmis. <a href="%s" target="_blank">Prévisualiser le pays</a>', $preview_post_link),
			9 => sprintf('Pays planifié pour le <strong>%1$s</strong>. <a href="%2$s" target="_blank">Prévisualiser le pays</a>', date_i18n('j M Y à G:i', strtotime($post->post_date)), $view_post_link),
			10 => sprintf('Le brouillon de le pays a été mis à jour. <a href="%s" target="_blank">Prévisualiser le pays</a>', $preview_post_link),
		];

		return $messages;
	}
}

new HTR_Locations();
