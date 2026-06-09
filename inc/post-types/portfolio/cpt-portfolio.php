<?php
namespace Shadhinplugins\CPT\Portfolio;

use Shadhinplugins\Lib;

/**
 * Singleton class
 * class CPT_Portfolio
 * @package Shadhinplugins\CPT\Portfolio;
 */
final class CPT_Portfolio implements Lib\Shadhin_plugins_Interface_PostType {

	/**
	 * @var string
	 */
	public 	$ptKey;
	public 	$ptKeyRewriteBase;
	public  $ptTaxKey;
	public  $ptTaxKeyRewriteBase;
	public  $ptTagTaxKey;
	public  $ptTagTaxKeyRewriteBase;
	private $ptMenuIcon;
	private $ptSingularName;
	private $ptPluralName;
	private $masonry_mode_image_size;

	/**
	 * Call this method to get singleton
	 *
	 * @return CPT_Portfolio
	 */
	public static function Instance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new CPT_Portfolio();
		}
		return $inst;
	}

	/**
	 * Private ctor so nobody else can instance it
	 *
	 */
	private function __construct() {
		$this->ptSingularName = esc_html__( 'Portfolio Item', 'shadhin-plugins' );
		$this->ptPluralName = esc_html__( 'Portfolio', 'shadhin-plugins' );
		$this->ptKey = 'portfolio-items';
		$this->ptKeyRewriteBase = $this->ptKey;
		$this->ptTaxKey = 'portfolio_category';
		$this->ptTaxKeyRewriteBase = str_replace( '_', '-', $this->ptTaxKey );
		$this->ptTagTaxKey = 'portfolio_tag';
		$this->ptTagTaxKeyRewriteBase = str_replace( '_', '-', $this->ptTagTaxKey );
		$this->ptMenuIcon = 'dashicons-screenoptions';


		$this->masonry_mode_image_size = shadhin_plugins_masonry_image_sizes();

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
			if( ! shadhin_plugins_get_redux_option( 'cpt-settings-portfolio-enable', true ) ) {
				return;
			}
		}

		$this->ptPluralName = shadhin_plugins_get_redux_option( 'cpt-settings-portfolio-label', esc_html__( 'Portfolio', 'shadhin-plugins' ) );
		$this->ptMenuIcon = shadhin_plugins_get_redux_option( 'cpt-settings-portfolio-admin-dashicon', $this->ptMenuIcon );
		$this->ptKeyRewriteBase = shadhin_plugins_get_redux_option( 'cpt-settings-portfolio-slug', $this->ptKeyRewriteBase );

		$this->registerCustomPostType();
		$this->registerCustomTax();
		$this->registerCustomTaxTag();
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
			'supports'			  		=> array( 'title', 'thumbnail', 'editor', 'excerpt', 'comments', 'page-attributes' ),
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
			'has_archive'				=> true,
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
			'name'						=> _x( 'Portfolio Items Categories', 'Taxonomy General Name', 'shadhin-plugins' ),
			'singular_name'				=> _x( 'Portfolio Item Category', 'Taxonomy Singular Name', 'shadhin-plugins' ),
			'menu_name'					=> $this->ptPluralName . esc_html__( ' Categories', 'shadhin-plugins' ),
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
	 * Regsiters custom Tag Taxonomy
	 */
	private function registerCustomTaxTag() {

		$labels = array(
			'name'						=> _x( 'Portfolio Items Tags', 'Taxonomy General Name', 'shadhin-plugins' ),
			'singular_name'				=> _x( 'Portfolio Item Tag', 'Taxonomy Singular Name', 'shadhin-plugins' ),
			'menu_name'					=> $this->ptPluralName . esc_html__( ' Tags', 'shadhin-plugins' ),
			'all_items'					=> esc_html__( 'All ', 'shadhin-plugins' ) . $this->ptPluralName . esc_html__( 'Tags', 'shadhin-plugins' ),
			'parent_item'				=> esc_html__( 'Parent Item', 'shadhin-plugins' ),
			'parent_item_colon'			=> esc_html__( 'Parent Item:', 'shadhin-plugins' ),
			'new_item_name'				=> esc_html__( 'New ', 'shadhin-plugins' ) . $this->ptSingularName . ' ' . esc_html__( 'Tag', 'shadhin-plugins' ),
			'add_new_item'				=> esc_html__( 'Add ', 'shadhin-plugins' ) . $this->ptSingularName . ' ' . esc_html__( 'Tag', 'shadhin-plugins' ),
			'edit_item'					=> esc_html__( 'Edit ', 'shadhin-plugins' ) . $this->ptSingularName . ' ' . esc_html__( 'Tag', 'shadhin-plugins' ),
			'update_item'				=> esc_html__( 'Update ', 'shadhin-plugins' ) . $this->ptSingularName . ' ' . esc_html__( 'Tag', 'shadhin-plugins' ),
			'view_item'					=> esc_html__( 'View ', 'shadhin-plugins' ) . $this->ptSingularName . ' ' . esc_html__( 'Tag', 'shadhin-plugins' ),
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
			'rewrite'					=> array( 'slug' => $this->ptTagTaxKeyRewriteBase, 'with_front' => false ),
		);
		register_taxonomy( $this->ptTagTaxKey, array( $this->ptKey ), $args );
	}

	/**
	 * Custom Columns Settings
	 */
	public function customColumnsSettings( $columns ) {

		$columns = array(
			'cb'			=> '<input type="checkbox" />',
			'title'			=> esc_html__( 'Title', 'shadhin-plugins' ),
			'thumbnail'		=> esc_html__( 'Thumbnail', 'shadhin-plugins' ),
			'img_size'		=> esc_html__( 'Masonry Mode Image Size', 'shadhin-plugins' ),
			'category'		=> esc_html__( 'Category', 'shadhin-plugins' ),
			'tag'			=> esc_html__( 'Tags', 'shadhin-plugins' ),
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
				$taxonomy = $this->ptTaxKey;
				$post_type = get_post_type( $post->ID );
				$terms = get_the_terms( $post->ID, $taxonomy );

				if ( ! empty( $terms ) ) {
					foreach ( $terms as $term ) {
						$post_terms[] = "<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " . esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $taxonomy, 'edit' ) ) . "</a>";
					}
					echo join( ', ', $post_terms );
				}
				else echo '<i>No categories.</i>';
			break;

			case 'tag' :
				$taxonomy = $this->ptTagTaxKey;
				$post_type = get_post_type( $post->ID );
				$terms = get_the_terms( $post->ID, $taxonomy );

				if ( ! empty( $terms ) ) {
					foreach ( $terms as $term ) {
						$post_terms[] = "<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " . esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $taxonomy, 'edit' ) ) . "</a>";
					}
					echo join( ', ', $post_terms );
				}
				else echo '<i>No tags.</i>';
			break;

			case 'thumbnail' :
				echo get_the_post_thumbnail( $post->ID, array( 64, 64 ) );
			break;

			case 'img_size' :
				if( shadhin_plugins_theme_installed() ) {
					$image_size = shadhin_get_rwmb_group( 'shadhin_' . 'portfolio_mb_gallery_images_settings', 'masonry_tiles_featured_image_size', $post->ID );
					echo $this->masonry_mode_image_size[ $image_size ];
				}
			break;

			default :
			break;
		}
	}

	/**
	 * Registers Meta Boxes
	 */
	public function regMetaBoxes( $meta_boxes ) {
		// Meta Box Settings for this Page
		$meta_boxes[] = array(
			'title'		=> esc_html__( 'Portfolio Settings', 'shadhin-plugins' ),
			'post_types' => $this->ptKey,
			'priority'   => 'high',

			// List of tabs, in one of the following formats:
			// 1) key => label
			// 2) key => array( 'label' => Tab label, 'icon' => Tab icon )
			'tabs'		=> array(
				'gallery_images' => array(
					'label' => esc_html__( 'Gallery Images', 'shadhin-plugins' ),
					'icon'  => 'dashicons-screenoptions', // Dashicon
				),
				'layout' => array(
					'label' => esc_html__( 'Layout', 'shadhin-plugins' ),
					'icon'  => 'dashicons-screenoptions', // Dashicon
				),
				'checklist' => array(
					'label' => esc_html__( 'Checklist', 'shadhin-plugins' ),
					'icon'  => 'dashicons-screenoptions', // Dashicon
				),
				'project_link' => array(
					'label' => esc_html__( 'Project Link', 'shadhin-plugins' ),
					'icon'  => 'dashicons-screenoptions', // Dashicon
				),
				'other' => array(
					'label' => esc_html__( 'Other Settings', 'shadhin-plugins' ),
					'icon'  => 'dashicons-screenoptions', // Dashicon
				),
			),

			// Tab style: 'default', 'box' or 'left'. Optional
			'tab_style' => 'left',

			// Show meta box wrapper around tabs? true (default) or false. Optional
			'tab_wrapper' => true,

			'fields'	=> array(
				array(
					'id'     => 'shadhin_' . 'portfolio_mb_gallery_images_settings',
					// Group field
					'type'   => 'group',
					// Clone whole group?
					'clone'  => false,
					// Drag and drop clones to reorder them?
					'sort_clone' => false,
					// tab
					'tab'  => 'gallery_images',
					// Sub-fields
					'fields' => array(
						//gallery_images tab starts
						array(
							'type' => 'heading',
							'name' => esc_html__( 'Portfolio Gallery Images', 'shadhin-plugins' ),
							'desc' => esc_html__( 'Changes of the following settings will be effective only for this page.', 'shadhin-plugins' ),
							'tab'  => 'gallery_images',
						),
						array(
							'name'		=> esc_html__( 'Featured Image Size in Masonry Tiles Mode', 'shadhin-plugins' ),
							'id'		=> 'masonry_tiles_featured_image_size',
							'type'		=> 'select',
							'options'   => $this->masonry_mode_image_size,
							'tab'		=> 'gallery_images',
						),
						array(
							'id'   => 'gallery_images',
							'name' => esc_html__( 'Portfolio Gallery Images', 'shadhin-plugins' ),
							'desc' => esc_html__( 'Choose your portfolio images.', 'shadhin-plugins' ),
							'type' => 'image_advanced',
							'tab'  => 'gallery_images',
						),
						//gallery_images tab ends
					),
				),
				array(
					'id'     => 'shadhin_' . 'portfolio_mb_layout_settings',
					// Group field
					'type'   => 'group',
					// Clone whole group?
					'clone'  => false,
					// Drag and drop clones to reorder them?
					'sort_clone' => false,
					// tab
					'tab'  => 'layout',
					// Sub-fields
					'fields' => array(
						//layout tab starts
						array(
							'type' => 'heading',
							'name' => esc_html__( 'Portfolio Layout Type', 'shadhin-plugins' ),
							'desc' => esc_html__( 'Changes of the following settings will be effective only for this page.', 'shadhin-plugins' ),
							'tab'  => 'layout',
						),
						array(
							'name'		=> esc_html__( 'Fullwidth?', 'shadhin-plugins' ),
							'id'		=> 'fullwidth',
							'type'		=> 'select',
							'desc'		=> esc_html__( 'Make the page fullwidth or not..', 'shadhin-plugins' ),
							'options'   => array(
								'inherit'   => esc_html__( 'Inherit from Theme Options', 'shadhin-plugins' ),
								'1'		=> esc_html__( 'Yes', 'shadhin-plugins' ),
								'0'		=> esc_html__( 'No', 'shadhin-plugins' ),
							),
							'tab'		=> 'layout',
						),
						array(
							'name'	=> esc_html__( 'Portfolio Details Type', 'shadhin-plugins' ),
							'id'		=> 'portfolio_details_type',
							'type'	=> 'image_select',
							'options' => array(
								'inherit'				=> MASCOT_ADMIN_ASSETS_URI . '/images/portfolio-single/type/inherit.png',
								'small-image'			=> MASCOT_ADMIN_ASSETS_URI . '/images/portfolio-single/type/small-image.png',
								'small-image-slider'	=> MASCOT_ADMIN_ASSETS_URI . '/images/portfolio-single/type/small-image-slider.png',
								'small-image-gallery'   => MASCOT_ADMIN_ASSETS_URI . '/images/portfolio-single/type/small-image-gallery.png',
								'big-image'			=> MASCOT_ADMIN_ASSETS_URI . '/images/portfolio-single/type/big-image.png',
								'big-image-slider'		=> MASCOT_ADMIN_ASSETS_URI . '/images/portfolio-single/type/big-image-slider.png',
								'big-image-gallery'	 => MASCOT_ADMIN_ASSETS_URI . '/images/portfolio-single/type/big-image-gallery.png',
							),
							'std'	 => 'inherit',
							'tab'	 => 'layout',
						),
						//layout tab ends
					),
				),
				array(
					'id'     => 'shadhin_' . 'portfolio_mb_checklist_settings',
					// Group field
					'type'   => 'group',
					// Clone whole group?
					'clone'  => false,
					// Drag and drop clones to reorder them?
					'sort_clone' => false,
					// tab
					'tab'  => 'checklist',
					// Sub-fields
					'fields' => array(
						//checklist tab starts
						array(
							'type' => 'heading',
							'name' => esc_html__( 'Portfolio Checklist', 'shadhin-plugins' ),
							'desc' => esc_html__( 'Changes of the following settings will be effective only for this page.', 'shadhin-plugins' ),
							'tab'  => 'checklist',
						),
						array(
							'id'	 => 'checklist',
							// Group field
							'type'   => 'group',
							// Clone whole group?
							'clone'  => true,
							// Drag and drop clones to reorder them?
							'sort_clone' => true,
							// Sub-fields
							'fields' => array(
								array(
									'name' => esc_html__( 'Checklist Title', 'shadhin-plugins' ),
									'id'   => 'checklist_title',
									'type' => 'text',
									'desc' => esc_html__( 'Title to describe the checklist items. Example: Skills.', 'shadhin-plugins' ),
								),
								array(
									'name' => esc_html__( 'Checklist Details', 'shadhin-plugins' ),
									'id'   => 'checklist_details',
									'type' => 'textarea',
									'desc' => esc_html__( 'Details of the checklist. Example: HTML, CSS & WordPress.', 'shadhin-plugins' ),
								),
							),
							'tab'  => 'checklist',
						),
						//checklist tab ends
					),
				),
				array(
					'id'     => 'shadhin_' . 'portfolio_mb_project_link_settings',
					// Group field
					'type'   => 'group',
					// Clone whole group?
					'clone'  => false,
					// Drag and drop clones to reorder them?
					'sort_clone' => false,
					// tab
					'tab'  => 'project_link',
					// Sub-fields
					'fields' => array(
						//project_link tab starts
						array(
							'type' => 'heading',
							'name' => esc_html__( 'Project Link', 'shadhin-plugins' ),
							'desc' => esc_html__( 'Changes of the following settings will be effective only for this page.', 'shadhin-plugins' ),
							'tab'  => 'project_link',
						),
						array(
							'name'		=> esc_html__( 'Project Link Title', 'shadhin-plugins' ),
							'id'		=> 'project_link_title',
							'desc'		=> esc_html__( 'The custom project text that will link.', 'shadhin-plugins' ),
							'type'		=> 'text',
							'tab'		=> 'project_link',
						),
						array(
							'name'		=> esc_html__( 'Project URL', 'shadhin-plugins' ),
							'id'		=> 'project_link_url',
							'desc'		=> esc_html__( 'The URL the project text links to.', 'shadhin-plugins' ),
							'type'		=> 'text',
							'tab'		=> 'project_link',
						),
						array(
							'name'		=> esc_html__( 'Project Link Target', 'shadhin-plugins' ),
							'id'		=> 'project_link_target',
							'desc'		=> esc_html__( 'Open in new window.', 'shadhin-plugins' ),
							'type'		=> 'checkbox',
							'tab'		=> 'project_link',
						),
						//project_link tab ends
					),
				),
				array(
					'id'     => 'shadhin_' . 'portfolio_mb_other_settings',
					// Group field
					'type'   => 'group',
					// Clone whole group?
					'clone'  => false,
					// Drag and drop clones to reorder them?
					'sort_clone' => false,
					// tab
					'tab'  => 'other',
					// Sub-fields
					'fields' => array(
						//other tab starts
						array(
							'type' => 'heading',
							'name' => esc_html__( 'Portfolio Meta', 'shadhin-plugins' ),
							'desc' => esc_html__( 'Changes of the following settings will be effective only for this page.', 'shadhin-plugins' ),
							'tab'  => 'other',
						),
						array(
							'name'		=> esc_html__( 'Portfolio Meta', 'shadhin-plugins' ),
							'id'		=> 'portfolio_meta',
							'type'		=> 'select',
							'desc'		=> esc_html__( 'Enable/Disabling this option will show/hide each Portfolio Meta on your Portfolio Details Page', 'shadhin-plugins' ),
							'options'   => array(
								'inherit'				=> esc_html__( 'Inherit from Theme Options', 'shadhin-plugins' ),
								'show-post-by-author'	=> esc_html__( 'Show By Author', 'shadhin-plugins' ),
								'show-post-date'		=> esc_html__( 'Show Date', 'shadhin-plugins' ),
								'show-post-date-split'	=> esc_html__( 'Show Date Split', 'shadhin-plugins' ),
								'show-post-category'	=> esc_html__( 'Show Category', 'shadhin-plugins' ),
								'show-post-tag'			=> esc_html__( 'Show Tag', 'shadhin-plugins' ),
								'show-post-checklist-custom-fields'	 => esc_html__( 'Show Checklist Custom Fields', 'shadhin-plugins' ),
							),
							'multiple'  => true,
							'std'		=> array(
								'inherit'
							),
							'tab'		=> 'other',
						),
						array(
							'name'		=> esc_html__( 'Show Share?', 'shadhin-plugins' ),
							'id'		=> 'show_share',
							'type'		=> 'select',
							'desc'		=> esc_html__( 'Enable/Disabling this option will show/hide share options on your page.', 'shadhin-plugins' ),
							'options'   => array(
								'inherit'   => esc_html__( 'Inherit from Theme Options', 'shadhin-plugins' ),
								'1'		=> esc_html__( 'Yes', 'shadhin-plugins' ),
								'0'		=> esc_html__( 'No', 'shadhin-plugins' ),
							),
							'tab'		=> 'other',
						),
						array(
							'name'		=> esc_html__( 'Show Next/Previous Single Post Navigation Link', 'shadhin-plugins' ),
							'id'		=> 'show_next_pre_post_link',
							'type'		=> 'select',
							'desc'		=> esc_html__( 'Enable/Disabling this option will show/hide link for Next & Previous Posts.', 'shadhin-plugins' ),
							'options'   => array(
								'inherit'   => esc_html__( 'Inherit from Theme Options', 'shadhin-plugins' ),
								'1'		=> esc_html__( 'Yes', 'shadhin-plugins' ),
								'0'		=> esc_html__( 'No', 'shadhin-plugins' ),
							),
							'tab'		=> 'other',
						),
						array(
							'name'		=> esc_html__( 'Show Related Portfolio Items', 'shadhin-plugins' ),
							'id'		=> 'show_related_posts',
							'type'		=> 'select',
							'desc'		=> esc_html__( 'Enable/Disabling this option will show/hide Related Posts List/Carousel on your page.', 'shadhin-plugins' ),
							'options'   => array(
								'inherit'   => esc_html__( 'Inherit from Theme Options', 'shadhin-plugins' ),
								'1'		=> esc_html__( 'Yes', 'shadhin-plugins' ),
								'0'		=> esc_html__( 'No', 'shadhin-plugins' ),
							),
							'tab'		=> 'other',
						),
						array(
							'name'		=> esc_html__( 'Show Comments', 'shadhin-plugins' ),
							'id'		=> 'show_comments',
							'type'		=> 'select',
							'desc'		=> esc_html__( 'Enable/Disabling this option will show/hide Comments on your page.', 'shadhin-plugins' ),
							'options'   => array(
								'inherit'   => esc_html__( 'Inherit from Theme Options', 'shadhin-plugins' ),
								'1'		=> esc_html__( 'Yes', 'shadhin-plugins' ),
								'0'		=> esc_html__( 'No', 'shadhin-plugins' ),
							),
							'tab'		=> 'other',
						),
						//other tab ends
					),
				),
			),
		);

		return $meta_boxes;
	}

}