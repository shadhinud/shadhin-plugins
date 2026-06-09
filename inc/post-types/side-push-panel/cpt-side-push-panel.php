<?php
namespace Shadhinplugins\CPT\SidePushPanel;

use Shadhinplugins\Lib;

/**
 * Singleton class
 * class CPT_SidePushPanel
 * @package Shadhinplugins\CPT\SidePushPanel;
 */
final class CPT_SidePushPanel implements Lib\Shadhin_plugins_Interface_PostType {

	/**
	 * @var string
	 */
	public 	$ptKey;
	public 	$ptKeyRewriteBase;
	private $ptMenuIcon;
	private $ptSingularName;
	private $ptPluralName;

	/**
	 * Call this method to get singleton
	 *
	 * @return CPT_SidePushPanel
	 */
	public static function Instance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new CPT_SidePushPanel();
		}
		return $inst;
	}

	/**
	 * Private ctor so nobody else can instance it
	 *
	 */
	private function __construct() {
		$this->ptSingularName = esc_html__( 'Parts - Side Push Panel', 'shadhin-plugins' );
		$this->ptPluralName = esc_html__( 'Parts - Side Push Panel', 'shadhin-plugins' );
		$this->ptKey = 'side-push-panel';
		$this->ptKeyRewriteBase = $this->ptKey;
		$this->ptMenuIcon = 'dashicons-mascot';
		add_filter( 'manage_edit-'.$this->ptKey.'_columns', array($this, 'customColumnsSettings') ) ;
		add_filter( 'manage_'.$this->ptKey.'_posts_custom_column', array($this, 'customColumnsContent') ) ;
	}

	/**
	 * @return string
	 */
	public function getPTKey() {
		return $this->ptKey;
	}

	/**
	 * registers custom post type & Tax
	 */
	public function register() {
		$this->registerCustomPostType();
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
			'supports'					=> array( 'title', 'editor', ),
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
			'exclude_from_search'		=> true,
			'publicly_queryable'		=> true,
			'capability_type'			=> 'page',
			'rewrite'					=> array( 'slug' => $this->ptKeyRewriteBase, 'with_front' => false ),
		);
		register_post_type( $this->ptKey, $args );

	}

	/**
	 * Custom Columns Settings
	 */
	public function customColumnsSettings( $columns ) {

		$columns = array(
			'cb'			=> '<input type="checkbox" />',
			'title'			=> esc_html__( 'Title', 'shadhin-plugins' ),
			'active-side-push-panel'	=> esc_html__( 'Currently Active Side Push Panel', 'shadhin-plugins' ),
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
			case 'active-side-push-panel' :
				if( shadhin_plugins_theme_installed() ) {
					$active_headertop_id = shadhin_get_redux_option( 'header-settings-choose-side-push-panel-cpt-widget-area', 'default' );
					if( $post->ID == $active_headertop_id ) {
						echo '<a class="tm-btn tm-btn-danger tm-btn-sm disabled">Active</a>';
					}
				}
			break;

			default :
			break;
		}
	}

}