<?php
namespace Shadhinplugins\CPT\Projects;

use Shadhinplugins\Lib;

/**
 * Singleton class
 * class CPT_Projects
 * @package Shadhinplugins\CPT\Projects;
 */
final class CPT_Projects implements Lib\Shadhin_plugins_Interface_PostType {

	/**
	 * @var string
	 */
	public  $ptKey;
	public 	$ptKeyRewriteBase;
	public  $ptTaxKey;
	public  $ptTaxKeyRewriteBase;
	private $ptMenuIcon;
	private $ptSingularName;
	private $ptPluralName;

	/**
	 * Call this method to get singleton
	 *
	 * @return CPT_Projects
	 */
	public static function Instance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new CPT_Projects();
		}
		return $inst;
	}

	/**
	 * Private ctor so nobody else can instance it
	 *
	 */
	private function __construct() {
		$this->ptSingularName = esc_html__( 'Projects Item', 'shadhin-plugins' );
		$this->ptPluralName = esc_html__( 'Projects', 'shadhin-plugins' );
		$this->ptKey = 'projects';
		$this->ptKeyRewriteBase = $this->ptKey;
		$this->ptTaxKey = 'projects_category';
		$this->ptTaxKeyRewriteBase = str_replace( '_', '-', $this->ptTaxKey );
		$this->ptMenuIcon = 'dashicons-portfolio';
		add_filter( 'manage_edit-'.$this->ptKey.'_columns', array($this, 'customColumnsSettings') ) ;
		add_filter( 'manage_'.$this->ptKey.'_posts_custom_column', array($this, 'customColumnsContent') ) ;
		add_filter( 'rwmb_meta_boxes', array($this, 'regMetaBoxes') ) ;
	}

	/**
	 * @return string
	 */
	public function getPTKey() {
		return $this->ptKey;
	}

	/**
	 * @return string
	 */
	public function getPTTaxKey() {
		return $this->ptTaxKey;
	}

	/**
	 * registers custom post type & Tax
	 */
	public function register() {
		if ( class_exists( 'ReduxFramework' ) ) {
			if( ! shadhin_plugins_get_redux_option( 'cpt-settings-projects-enable', true ) ) {
				return;
			}
		}

		$this->ptPluralName = shadhin_plugins_get_redux_option( 'cpt-settings-projects-label', esc_html__( 'Projects', 'shadhin-plugins' ) );
		$this->ptMenuIcon = shadhin_plugins_get_redux_option( 'cpt-settings-projects-admin-dashicon', $this->ptMenuIcon );
		$this->ptKeyRewriteBase = shadhin_plugins_get_redux_option( 'cpt-settings-projects-slug', $this->ptKeyRewriteBase );
		$this->ptTaxKeyRewriteBase = shadhin_plugins_get_redux_option( 'cpt-settings-projects-cat-slug', $this->ptKeyRewriteBase );

		$this->registerCustomPostType();
		$this->registerCustomTax();
	}

	/**
	 * Regsiters custom post type
	 */
	private function registerCustomPostType() {

		$labels = array(
			'name'					=> $this->ptPluralName,
			'singular_name'			=> $this->ptPluralName . ' ' . esc_html__( 'Item', 'shadhin-plugins' ),
			'menu_name'				=> $this->ptPluralName,
			'name_admin_bar'		=> $this->ptPluralName,
			'archives'				=> esc_html__( 'Item Archives', 'shadhin-plugins' ),
			'attributes'			=> esc_html__( 'Item Attributes', 'shadhin-plugins' ),
			'parent_item_colon'		=> esc_html__( 'Parent Item:', 'shadhin-plugins' ),
			'all_items'				=> esc_html__( 'All Items', 'shadhin-plugins' ),
			'add_new_item'			=> esc_html__( 'Add New Item', 'shadhin-plugins' ),
			'add_new'				=> esc_html__( 'Add New', 'shadhin-plugins' ),
			'new_item'				=> esc_html__( 'New Item', 'shadhin-plugins' ),
			'edit_item'				=> esc_html__( 'Edit Item', 'shadhin-plugins' ),
			'update_item'			=> esc_html__( 'Update Item', 'shadhin-plugins' ),
			'view_item'				=> esc_html__( 'View Item', 'shadhin-plugins' ),
			'view_items'			=> esc_html__( 'View Items', 'shadhin-plugins' ),
			'search_items'			=> esc_html__( 'Search Item', 'shadhin-plugins' ),
			'not_found'				=> esc_html__( 'Not found', 'shadhin-plugins' ),
			'not_found_in_trash'	=> esc_html__( 'Not found in Trash', 'shadhin-plugins' ),
			'featured_image'		=> esc_html__( 'Featured Image', 'shadhin-plugins' ),
			'set_featured_image'	=> esc_html__( 'Set featured image', 'shadhin-plugins' ),
			'remove_featured_image'	=> esc_html__( 'Remove featured image', 'shadhin-plugins' ),
			'use_featured_image'	=> esc_html__( 'Use as featured image', 'shadhin-plugins' ),
			'insert_into_item'		=> esc_html__( 'Insert into item', 'shadhin-plugins' ),
			'uploaded_to_this_item'	=> esc_html__( 'Uploaded to this item', 'shadhin-plugins' ),
			'items_list'			=> esc_html__( 'Items list', 'shadhin-plugins' ),
			'items_list_navigation'	=> esc_html__( 'Items list navigation', 'shadhin-plugins' ),
			'filter_items_list'		=> esc_html__( 'Filter items list', 'shadhin-plugins' ),
		);

		$args = array(
			'label'						=> $this->ptSingularName,
			'description'				=> esc_html__( 'Post Type Description', 'shadhin-plugins' ),
			'labels'					=> $labels,
			'supports'					=> array( 'title', 'thumbnail', 'editor', 'excerpt', 'page-attributes' ),
			'taxonomies'				=> array( $this->ptTaxKey ),
			'hierarchical'				=> false,
			'public'					=> true,
			'show_ui'					=> true,
			'show_in_menu'				=> true,
			'menu_position'				=> 31,
			'menu_icon'					=> $this->ptMenuIcon,
			'show_in_admin_bar'			=> true,
			'show_in_nav_menus'			=> true,
			'can_export'				=> true,
			'has_archive'				=> false,
			'exclude_from_search'		=> false,
			'publicly_queryable'		=> true,
			'capability_type'			=> 'page',
			'rewrite'					=> array( 'slug' => $this->ptKeyRewriteBase, 'with_front' => false ),
		);
		register_post_type( $this->ptKey, $args );

	}

	/**
	 * Regsiters custom Taxonomy
	 */
	private function registerCustomTax() {

		$labels = array(
			'name'						=> _x( 'Projects Categories', 'Taxonomy General Name', 'shadhin-plugins' ),
			'singular_name'				=> _x( 'Project Category', 'Taxonomy Singular Name', 'shadhin-plugins' ),
			'menu_name'					=> $this->ptSingularName . esc_html__( ' Categories', 'shadhin-plugins' ),
			'all_items'					=> esc_html__( 'All ', 'shadhin-plugins' ) . $this->ptSingularName . esc_html__( ' Categories', 'shadhin-plugins' ),
			'parent_item'				=> esc_html__( 'Parent Item', 'shadhin-plugins' ),
			'parent_item_colon'			=> esc_html__( 'Parent Item:', 'shadhin-plugins' ),
			'new_item_name'				=> esc_html__( 'New ', 'shadhin-plugins' ) . $this->ptSingularName . esc_html__( ' Category', 'shadhin-plugins' ),
			'add_new_item'				=> esc_html__( 'Add ', 'shadhin-plugins' ) . $this->ptSingularName . esc_html__( ' Category', 'shadhin-plugins' ),
			'edit_item'					=> esc_html__( 'Edit ', 'shadhin-plugins' ) . $this->ptSingularName . esc_html__( ' Category', 'shadhin-plugins' ),
			'update_item'				=> esc_html__( 'Update ', 'shadhin-plugins' ) . $this->ptSingularName . esc_html__( ' Category', 'shadhin-plugins' ),
			'view_item'					=> esc_html__( 'View ', 'shadhin-plugins' ) . $this->ptSingularName . esc_html__( ' Category', 'shadhin-plugins' ),
			'separate_items_with_commas'=> esc_html__( 'Separate items with commas', 'shadhin-plugins' ),
			'add_or_remove_items'		=> esc_html__( 'Add or remove items', 'shadhin-plugins' ),
			'choose_from_most_used'		=> esc_html__( 'Choose from the most used', 'shadhin-plugins' ),
			'popular_items'				=> esc_html__( 'Popular Items', 'shadhin-plugins' ),
			'search_items'				=> esc_html__( 'Search Items', 'shadhin-plugins' ),
			'not_found'					=> esc_html__( 'Not Found', 'shadhin-plugins' ),
			'no_terms'					=> esc_html__( 'No items', 'shadhin-plugins' ),
			'items_list'				=> esc_html__( 'Items list', 'shadhin-plugins' ),
			'items_list_navigation'		=> esc_html__( 'Items list navigation', 'shadhin-plugins' ),
		);
		$args = array(
			'labels'					=> $labels,
			'hierarchical'				=> true,
			'public'					=> true,
			'show_ui'					=> true,
			'show_admin_column'			=> true,
			'show_in_nav_menus'			=> true,
			'show_tagcloud'				=> true,
			'rewrite'					=> array( 'slug' => $this->ptTaxKeyRewriteBase, 'with_front' => false ),
		);
		register_taxonomy( $this->ptTaxKey, array( $this->ptKey ), $args );
	}

	/**
	 * Custom Columns Settings
	 */
	public function customColumnsSettings( $columns ) {

		$columns = array(
			'cb'			=> '<input type="checkbox" />',
			'title'			=> esc_html__( 'Title', 'shadhin-plugins' ),
			'thumbnail'		=> esc_html__( 'Thumbnail', 'shadhin-plugins' ),
			'category'		=> esc_html__( 'Category', 'shadhin-plugins' ),
			'date'			=> esc_html__( 'Date', 'shadhin-plugins' ),
		);
		return $columns;
	}

	/**
	 * Custom Columns Content
	 */
	public function customColumnsContent( $columns ) {
		global $post;
		switch( $columns ) {
			case 'category' :
				$post_terms = array();
				$taxonomy 	= $this->ptTaxKey;
				$post_type 	= get_post_type( $post->ID );
				$terms 		= get_the_terms( $post->ID, $taxonomy );

				if ( ! empty( $terms ) ) {
					foreach ( $terms as $term ) {
						$post_terms[] = "<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " . esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $taxonomy, 'edit' ) ) . "</a>";
					}
					echo join( ', ', $post_terms );
				}
				else echo '<i>No categories.</i>';
			break;

			case 'thumbnail' :
				echo get_the_post_thumbnail( $post->ID, array( 64, 64 ) );
			break;

			default :
			break;
		}
	}

	/**
	 * Registers Meta Boxes
	 */
	public function regMetaBoxes( $meta_boxes ) {
		$meta_boxes[] = array(
			'id'		 => 'projects_meta_box',
			'title'	  => esc_html__( 'Projects Meta Box', 'shadhin-plugins' ),
			'post_types' => $this->ptKey,
			'priority'   => 'high',
			'fields'	 => array(
				array(
					'id'     => 'shadhin_' . 'projects_mb_settings',
					// Group field
					'type'   => 'group',
					// Clone whole group?
					'clone'  => false,
					// Drag and drop clones to reorder them?
					'sort_clone' => false,
					// Sub-fields
					'fields' => array(
						array(
							'id'	=> 'project_subtitle',
							'name'		=> esc_html__( 'Project Sub Title', 'shadhin-plugins' ),
							'type'	=> 'text',
						),
					),
				),
			),
		);
		return $meta_boxes;
	}

}