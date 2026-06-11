<?php
namespace Shadhinplugins\Widgets;

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
class MH_Elementor_Before_After_Slider extends Widget_Base {

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
		return 'mh-ele-before-after-slider';
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
		return esc_html__( 'Before After Slider', 'shadhin-plugins' );
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
		return [ 'shadhin-core-hellojs' ];
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
	protected function _register_controls() {

		$this->start_controls_section(
			'general',
			[
				'label' => esc_html__( 'General', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'before_image',
			[
				'label' => esc_html__( "Before Image", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				"description" => esc_html__( "Upload the before image", 'shadhin-plugins' ),
			]
		);
		$repeater->add_control(
			'after_image',
			[
				'label' => esc_html__( "After Image", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				"description" => esc_html__( "Upload the after image. Before and After image should have same dimension", 'shadhin-plugins' ),
			]
		);
		$this->add_control(
			'slider_items_array',
			[
				'label' => esc_html__( "Slider Items", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'before_image' => Utils::get_placeholder_image_src(),
						'after_image' => Utils::get_placeholder_image_src(),
					],
					[
						'before_image' => Utils::get_placeholder_image_src(),
						'after_image' => Utils::get_placeholder_image_src(),
					],
					[
						'before_image' => Utils::get_placeholder_image_src(),
						'after_image' => Utils::get_placeholder_image_src(),
					]
				],
			]
		);

		$this->add_control(
			'orientation',
			[
				'label' => esc_html__( "Orientation", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				"description" => esc_html__( "Orientation of the before and after images ('horizontal' or 'vertical')", 'shadhin-plugins' ),
				'options' => [
					'horizontal'  => esc_html__( 'Horizontal', 'shadhin-plugins' ),
					'vertical'  => esc_html__( 'Vertical', 'shadhin-plugins' ),
				],
				'default' => 'horizontal',
			]
		);
		$this->add_control(
			'before_label',
			[
				'label' => esc_html__( "Custom Before Label", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( "Default custom before label: 'Before'", 'shadhin-plugins' ),
				'default' => esc_html__( "Before", 'shadhin-plugins' ),
			]
		);
		$this->add_control(
			'after_label',
			[
				'label' => esc_html__( "Custom After Label", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( "Default custom after label: 'After'", 'shadhin-plugins' ),
				'default' => esc_html__( "After", 'shadhin-plugins' ),
			]
		);
		$this->add_control(
			'default_offset_pct',
			[
				'label' => esc_html__( "Offset Percentage", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( "How much of the before image is visible when the page loads(value must be between 0 to 1)", 'shadhin-plugins' ),
				'default' => '0.5',
			]
		);
		$this->add_control(
			'no_overlay',
			[
				'label' => esc_html__( "No Overlay", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'ON', 'shadhin-plugins' ),
				'label_off' => esc_html__( 'OFF', 'shadhin-plugins' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => esc_html__( "Do not show the overlay with before and after", 'shadhin-plugins' ),
			]
		);
		$this->end_controls_section();




		$this->start_controls_section(
			'mh_display_settings',
			[
				'label' => esc_html__( 'Display Settings', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'display_type', [
				'label' => esc_html__( "Display Type", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'grid'  =>  esc_html__( 'Grid', 'shadhin-plugins' ),
					'masonry' =>  esc_html__( 'Masonry', 'shadhin-plugins' ),
					'carousel'  =>  esc_html__( 'Carousel/Slider', 'shadhin-plugins' ),
					'basic'  =>  esc_html__( 'Basic', 'shadhin-plugins' )
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
				'default' => '4',
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
		$this->end_controls_section();


		//Swiper Slider Options
		shadhin_plugins_get_swiper_slider_arraylist( $this, 1, '', array('display_type' => array('carousel') ) );
		shadhin_plugins_get_swiper_slider_nav_arraylist( $this, 1, '', array('display_type' => array('carousel') ) );
		shadhin_plugins_get_swiper_slider_dots_arraylist( $this, 1, '', array('display_type' => array('carousel') ) );

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

		wp_register_style( 'twentytwenty', SHADHIN_PLUGINS_ASSETS_URI . '/js/plugins/twentytwenty/twentytwenty.css' );
		wp_register_script( 'jquery-event-move', SHADHIN_PLUGINS_ASSETS_URI . '/js/plugins/twentytwenty/jquery.event.move.js', array('jquery'), false, true );
		wp_register_script( 'jquery-twentytwenty', SHADHIN_PLUGINS_ASSETS_URI . '/js/plugins/twentytwenty/jquery.twentytwenty.js', array('jquery'), false, true );
		wp_register_script( 'before-after-slider', SHADHIN_PLUGINS_ASSETS_URI . '/js/widgets/before-after-slider.js', array('jquery'), false, true );

		wp_enqueue_style( array( 'twentytwenty' ) );
		wp_enqueue_script( array( 'jquery-event-move' ) );
		wp_enqueue_script( array( 'jquery-twentytwenty' ) );
		wp_enqueue_script( array( 'before-after-slider' ) );

		//classes
		$classes = array();
		$settings['classes'] = $classes;


		$settings['holder_id'] = shadhin_get_isotope_holder_ID('before-after-slider-block');

		$settings['settings'] = $settings;

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_template_part( 'slider', $settings['display_type'], 'before-after-slider/tpl', $settings, true );

		echo $html;
	}
}



