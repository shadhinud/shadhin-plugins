<?php
namespace Shadhinplugins\Widgets\Products;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class MH_Elementor_WC_Products extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		$direction_suffix = is_rtl() ? '.rtl' : '';
		if( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
            wp_enqueue_style( 'shadhin-woo-shop');
		}
		wp_register_script( 'mh-countdown-script', SHADHIN_PLUGINS_ASSETS_URI . '/js/widgets/countdown.js' );

		wp_register_style( 'mh-wc-products', SHADHIN_PLUGINS_ASSETS_URI . '/css/woo/wc-products/wc-products-loader' . $direction_suffix . '.css' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'mh-ele-wc-products';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'WC(Woocommerce) Products', 'shadhin-plugins' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'mh-elementor-widget-icon';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'tm' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'mascot-core-hellojs' ];
	}
	public function get_style_depends() {
		return [ 'mh-wc-products' ];
	}

	/**
	 * Skins
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Current_Theme1( $this ) );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'mh_general',
			[
				'label' => esc_html__( 'General', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'custom_css_class',
			[
				'label' => esc_html__( "Custom CSS class", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'display_type', [
				'label' => esc_html__( "Display Type", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'grid'  =>  esc_html__( 'Grid', 'shadhin-plugins' ),
					'masonry' =>  esc_html__( 'Masonry', 'shadhin-plugins' ),
					'carousel' =>  esc_html__( 'Carousel/Slider', 'shadhin-plugins' ),
				],
				'default' => 'grid'
			]
		);
		$this->add_control(
			'columns', [
				'label' => esc_html__( "Columns Layout", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'  =>  '1',
					'2'  =>  '2',
					'3'  =>  '3',
					'4'  =>  '4',
					'5'  =>  '5',
					'6'  =>  '6',
				],
				'default' => '3',
				'condition' => [
					'display_type!' => array('carousel')
				]
			]
		);

		//responsive grid layout
		shadhin_plugins_elementor_grid_responsive_columns($this);

		$this->add_control(
			'gutter',
			[
				'label' => esc_html__( "Gutter", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_isotope_gutter_list_elementor(),
				'default' => 'gutter-10',
				'condition' => [
					'display_type' => array('grid', 'masonry', 'masonry-tiles')
				]
			]
		);




        $options_product_type = [
            'recent_products'      => esc_html__( 'Recent products', 'shadhin-plugins' ),
            'featured_products'    => esc_html__( 'Featured Products', 'shadhin-plugins' ),
            'top_rated_products'   => esc_html__( 'Top Rated Products', 'shadhin-plugins' ),
            'sale_products'        => esc_html__( 'Products on Sale', 'shadhin-plugins' ),
            'best_selling_products'=> esc_html__( 'Best Selling Products', 'shadhin-plugins' )
        ];

        if (shadhin_plugins_is_elementor_pro_activated()) {
            $options_product_type['ids'] = esc_html__('Product Ids', 'shadhin-plugins');
        }

        $this->add_control(
            'product_type',
            [
                'label'   => esc_html__('Product Type', 'shadhin-plugins'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'recent_products',
                'options' => $options_product_type,
            ]
        );

        if (shadhin_plugins_is_elementor_pro_activated()) {
            $this->add_control(
                'product_ids',
                [
                    'label'        => esc_html__('Product ids', 'shadhin-plugins'),
                    'type'         => \ElementorPro\Modules\QueryControl\Module::QUERY_CONTROL_ID,
                    'label_block'  => true,
                    'autocomplete' => [
                        'object' => \ElementorPro\Modules\QueryControl\Module::QUERY_OBJECT_POST,
                        'query'  => [
                            'post_type' => 'product',
                        ],
                    ],
                    'multiple'     => true,
                    'condition'    => [
                        'product_type' => 'ids'
                    ]
                ]
            );
        }

        $this->add_control(
            'limit',
            [
                'label'   => esc_html__('Posts Per Page', 'shadhin-plugins'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );
        $this->add_control(
            'image_size',
            [
                'label' => esc_html__( "Choose Image Size", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_get_available_image_sizes(),
                'default' => 'thumbnail',
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label'     => esc_html__('Advanced', 'shadhin-plugins'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__('Order By', 'shadhin-plugins'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'date',
                'options'   => [
                    'date'       => esc_html__('Date', 'shadhin-plugins'),
                    'id'         => esc_html__('Post ID', 'shadhin-plugins'),
                    'menu_order' => esc_html__('Menu Order', 'shadhin-plugins'),
                    'popularity' => esc_html__('Number of purchases', 'shadhin-plugins'),
                    'rating'     => esc_html__('Average Product Rating', 'shadhin-plugins'),
                    'title'      => esc_html__('Product Title', 'shadhin-plugins'),
                    'rand'       => esc_html__('Random', 'shadhin-plugins'),
                ],
                'condition' => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label'     => esc_html__('Order', 'shadhin-plugins'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'desc',
                'options'   => [
                    'asc'  => esc_html__('ASC', 'shadhin-plugins'),
                    'desc' => esc_html__('DESC', 'shadhin-plugins'),
                ],
                'condition' => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'       => esc_html__('Categories', 'shadhin-plugins'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'options'     => $this->get_product_categories(),
                'label_block' => true,
                'multiple'    => true,
                'condition'   => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label'     => esc_html__('Category Operator', 'shadhin-plugins'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'shadhin-plugins'),
                    'IN'     => esc_html__('IN', 'shadhin-plugins'),
                    'NOT IN' => esc_html__('NOT IN', 'shadhin-plugins'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $this->add_control(
            'tag',
            [
                'label'       => esc_html__('Tags', 'shadhin-plugins'),
                'type'        => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'options'     => $this->get_product_tags(),
                'multiple'    => true,
                'condition'   => [
                    'product_type!' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'tag_operator',
            [
                'label'     => esc_html__('Tag Operator', 'shadhin-plugins'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'shadhin-plugins'),
                    'IN'     => esc_html__('IN', 'shadhin-plugins'),
                    'NOT IN' => esc_html__('NOT IN', 'shadhin-plugins'),
                ],
                'condition' => [
                    'tag!' => ''
                ],
            ]
        );
		$this->end_controls_section();



		//Swiper Slider Options
		shadhin_plugins_get_swiper_slider_arraylist( $this, 1, '', array('display_type' => array('carousel') ) );
		shadhin_plugins_get_swiper_slider_nav_arraylist( $this, 1, '', array('display_type' => array('carousel') ) );
		shadhin_plugins_get_swiper_slider_dots_arraylist( $this, 1, '', array('display_type' => array('carousel') ) );







		//Category Filter
		$this->start_controls_section(
			'cat_filter_section', [
				'label' => esc_html__( 'Category Filter', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		shadhin_plugins_get_cat_filter_arraylist( $this, 1, array('display_type' => array('grid', 'masonry', 'masonry-tiles', 'carousel') ) );
		shadhin_plugins_get_cat_filter_arraylist( $this, 2 );
		shadhin_plugins_get_cat_filter_arraylist( $this, 3 );
		shadhin_plugins_get_cat_filter_arraylist( $this, 4 );

		$this->end_controls_section();





		$this->start_controls_section(
			'button_options', [
				'label' => esc_html__( 'Button Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		shadhin_plugins_get_button_arraylist($this, 1);
		$this->add_control(
			'padding-topbottom',
			[
				'label' => esc_html__( "Padding Top Bottom", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .btn' => 'padding-top: {{VALUE}};padding-bottom: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'padding-leftright',
			[
				'label' => esc_html__( "Padding Left Right", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .btn' => 'padding-left: {{VALUE}};padding-right: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();





		$this->start_controls_section(
			'loadmore_button_options', [
				'label' => esc_html__( 'Loadmore Button Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		shadhin_plugins_get_viewdetails_button_arraylist($this, 1,  esc_html__( "Load More", 'shadhin-plugins' ), 'loadmore_');
		shadhin_plugins_get_viewdetails_button_arraylist($this, 2,  esc_html__( "Load More", 'shadhin-plugins' ), 'loadmore_');
		shadhin_plugins_get_button_arraylist($this, 1, 'loadmore_');
		$this->end_controls_section();
	}

    protected function get_product_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }

        return $results;
    }

    protected function get_product_tags() {
        $tags = get_terms(array(
                'taxonomy'   => 'product_tag',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($tags)) {
            foreach ($tags as $tag) {
                $results[$tag->slug] = $tag->name;
            }
        }

        return $results;
    }

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$class_instance =  '';
        wp_enqueue_style( 'shadhin-woo-shop');

		$settings['holder_id'] = shadhin_plugins_get_isotope_holder_ID('wc-product');
		return $this->wc_render_output( $class_instance, $settings );
	}


	public function wc_render_output( $class_instance, $settings ) {
        global $woocommerce;
        $meta_query = '';
        $tax_query = array();
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        if ( 'recent_products' == $settings['product_type'] ) {
            $meta_query = WC()->query->get_meta_query();
        }

        if ( 'featured_products' == $settings['product_type'] ) {
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN', // or 'NOT IN' to exclude feature products
            );
        }

        $args = array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => $settings['limit'],
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'paged'               => $paged,
            'meta_query'          => $meta_query,
            'tax_query'          => $tax_query,
        );

        if ( 'sale_products' == $settings['product_type'] ) {
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $args['post__in'] = $product_ids_on_sale;
        }

        if ( 'best_selling_products' == $settings['product_type'] ) {
            $args['meta_key']   = 'total_sales';
            $args['orderby']    = 'meta_value_num';
        }

        if ( 'top_rated_products' == $settings['product_type'] ) {
            $args['meta_key']   = '_wc_average_rating';
            $args['orderby']    = 'meta_value_num';
        }

        //if category selected
        if( ! empty( $settings['categories'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => implode(',', $settings['categories']),
                    'operator' => $settings['cat_operator'],
                )
            );
        }

        if (!empty($settings['tag'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_tag',
                    'field' => 'slug',
                    'terms' => array_map( 'sanitize_title', explode( ',', implode(',', $settings['tag']) ) ),
                    'operator' => $settings['tag_operator'],
                )
            );
        }


        $the_query = new \WP_Query( $args );
		$settings['the_query'] = $the_query;


		//button classes
		$settings['btn_classes'] = shadhin_plugins_prepare_button_classes_from_params( $settings );
		$settings['loadmore_btn_classes'] = shadhin_plugins_prepare_button_classes_from_params( $settings, 'loadmore_' );

		$settings['params_array'] = $settings;


		//classes
		$classes = array();
		$classes[] = $settings['custom_css_class'];
		$settings['classes'] = $classes;

		$settings['settings'] = $settings;

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_shop_template_part( 'wc-products', $settings['display_type'], 'wc-products/tpl', $settings, true );

		echo $html;
	}
}