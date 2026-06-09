<?php
namespace Shadhinplugins\Widgets\ImageGallery;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class MH_Elementor_Image_Gallery extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		if( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$direction_suffix = is_rtl() ? '.rtl' : '';
			wp_enqueue_style( 'mh-image-gallery-loader', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/image-gallery/image-gallery-loader' . $direction_suffix . '.css' );
		}
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
		return 'mh-ele-image-gallery2';
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
		return esc_html__( 'Image Gallery - Shadhin', 'shadhin-plugins' );
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


	/**
	 * Skins
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Style_Current_Theme1( $this ) );
		$this->add_skin( new Skins\Skin_Style_Current_Theme2( $this ) );
		$this->add_skin( new Skins\Skin_Style_Current_Theme3( $this ) );
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
			'display_type',
			[
				'label' => esc_html__( "Display Type", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'grid'  =>  esc_html__( 'Grid', 'shadhin-plugins' ),
					'masonry' =>  esc_html__( 'Masonry', 'shadhin-plugins' ),
					'masonry-tiles' =>  esc_html__( 'Masonry Tiles', 'shadhin-plugins' ),
					'carousel'  =>  esc_html__( 'Carousel/Slider', 'shadhin-plugins' )
				],
				'default' => 'grid'
			]
		);
        $this->add_control(
            'disable_hover_animation',
            [
                'label' => esc_html__( 'Disable Hover Animation', 'shadhin-plugins' ),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class'	=> 'hover-no-animation-',
				'condition' => [
					'_skin' => array('')
				]
            ]
        );
		$this->add_responsive_control(
			'img_min_height',
			[
				'label' => esc_html__( "Image Minimum Height", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mh-image-gallery img' => 'min-height: {{SIZE}}{{UNIT}}; object-fit: cover;'
				],
				'condition' => [
					'display_type' => array('masonry')
				]
			]
		);
		$this->add_control(
			'columns',
			[
				'label' => esc_html__( "Columns Layout", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description' => esc_html__( 'Define Columns Layout for Grid/Carousel', 'shadhin-plugins' ),
				'options' => [
					'1'  =>  '1',
					'2'  =>  '2',
					'3'  =>  '3',
					'4'  =>  '4',
					'5'  =>  '5',
					'6'  =>  '6',
					'7'  =>  '7',
					'8'  =>  '8',
					'9'  =>  '9',
					'10'  =>  '10',
				],
				'default' => '3',
				'condition' => [
					'display_type!' => array('carousel')
				]
			]
		);
		$this->add_control(
			'gutter',
			[
				'label' => esc_html__( "Gutter", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_isotope_gutter_list_elementor(),
				'default' => 'gutter-10',
				'condition' => [
					'display_type' => array('grid')
				]
			]
		);
		$this->add_control(
			'featured_image_size', [
				'label' => esc_html__( "Featured Image Size", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_get_available_image_sizes(),
			]
		);
		$this->end_controls_section();





		//Swiper Slider Options
		shadhin_plugins_get_swiper_slider_arraylist( $this, 1, '', array('display_type' => array('carousel') ) );
		shadhin_plugins_get_swiper_slider_nav_arraylist( $this, 1, '', array('display_type' => array('carousel') ) );
		shadhin_plugins_get_swiper_slider_dots_arraylist( $this, 1, '', array('display_type' => array('carousel') ) );



		$this->start_controls_section(
			'general2',
			[
				'label' => esc_html__( 'Image Collection', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new \Elementor\Repeater();
		//image
		$repeater->add_control(
			'logo', [
				'label' => esc_html__( "Logo", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'image_size', [
				'label' => esc_html__( "Image Size", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_get_available_image_sizes(),
			]
		);
		$repeater->add_responsive_control(
			'img_min_height_individual',
			[
				'label' => esc_html__( "Image Minimum Height", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .mh-image-gallery img' => 'min-height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$repeater->add_responsive_control(
			'img_max_height_individual',
			[
				'label' => esc_html__( "Or Maximum Height", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .mh-image-gallery img' => 'width: 100%; max-height: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( "Title", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'title_tag',
			[
				'label' => esc_html__( "Title Tag", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_heading_tag_list(),
				'default' => 'h5'
			]
		);
		$repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( "Sub Title", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'subtitle_tag',
			[
				'label' => esc_html__( "Sub Title Tag", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_heading_tag_list(),
				'default' => 'h4'
			]
		);
		$this->add_control(
			'gallery_images_array',
			[
				'label' => esc_html__( "Gallery Images", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'logo' => Utils::get_placeholder_image_src(),
					],
					[
						'logo' => Utils::get_placeholder_image_src(),
					],
					[
						'logo' => Utils::get_placeholder_image_src(),
					],
					[
						'logo' => Utils::get_placeholder_image_src(),
					],
					[
						'logo' => Utils::get_placeholder_image_src(),
					],
				],
			]
		);
		$this->end_controls_section();















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
		shadhin_plugins_wp_enqueue_script_lightgallery();

		$direction_suffix = is_rtl() ? '.rtl' : '';
		wp_enqueue_style( 'mh-image-gallery-default', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/image-gallery/image-gallery-default' . $direction_suffix . '.css' );

		//classes
		$classes = array();
		if( $settings['display_type'] == 'grid' ) {
			$classes[] = 'grid-' . $settings['columns'];
		}
		$settings['classes'] = $classes;

		$settings['holder_id'] = shadhin_plugins_get_isotope_holder_ID('gallery');


		$settings['settings'] = $settings;

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_template_part( 'gallery', $settings['display_type'], 'image-gallery/tpl', $settings, true );

		echo $html;
	}
}
