<?php
namespace Shadhinplugins\Widgets\ShowcaseBlock;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class MH_Elementor_ShowcaseBlock extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		$direction_suffix = is_rtl() ? '.rtl' : '';
		wp_register_style( 'mh-showcase-block', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/showcase-block' . $direction_suffix . '.css' );
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
		return 'mh-ele-showcase-block';
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
		return esc_html__( 'Showcase Block', 'shadhin-plugins' );
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

	public function get_style_depends() {
		return [ 'mh-showcase-block' ];
	}


	/**
	 * Skins
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Style1( $this ) );
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
		//Link Options
		$this->start_controls_section(
			'service_icons_options', [
				'label' => esc_html__( 'Showcase Items', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( "Title", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "This is a section title", 'shadhin-plugins' ),
			]
		);
		$repeater->add_control(
			'title_tag',
			[
				'label' => esc_html__( "Title Tag", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_heading_tag_list(),
				'default' => 'h4'
			]
		);
		$repeater->add_control(
			'btn1_text',
			[
				'label' => esc_html__( "Button 1 Text", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "View Demo", 'shadhin-plugins' ),
			]
		);
		$repeater->add_control(
			'btn1_link',
			[
				'label' => esc_html__( "Button 1 Link URL", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::URL,
				'show_external' => true,
				'default' => [
					'url' => '',
				]
			]
		);
		$repeater->add_control(
			'btn2_text',
			[
				'label' => esc_html__( "Button 2 Text", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "View Demo", 'shadhin-plugins' ),
			]
		);
		$repeater->add_control(
			'btn2_link',
			[
				'label' => esc_html__( "Button 2 Link URL", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::URL,
				'show_external' => true,
				'default' => [
					'url' => '',
				]
			]
		);
		$repeater->add_control(
			'featured_image',
			[
				'label' => __('Featured Images', 'shadhin-plugins'),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);
		$repeater->add_control(
			'featured_image_size', [
				'label' => esc_html__( "Featured Image Size", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_get_available_image_sizes(),
				'default' => 'thumbnail',
			]
		);
		$this->add_control(
			'showcase_items_array',
			[
				'label' => esc_html__( "Showcase Items", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => esc_html__( 'Title #1', 'shadhin-plugins' ),
						'featured_image' => Utils::get_placeholder_image_src(),
						'btn1_text' => esc_html__( 'View Demo', 'shadhin-plugins' ),
						'btn2_text' => esc_html__( 'One Page', 'shadhin-plugins' ),
					],
					[
						'title' => esc_html__( 'Title #2', 'shadhin-plugins' ),
						'featured_image' => Utils::get_placeholder_image_src(),
						'btn1_text' => esc_html__( 'View Demo', 'shadhin-plugins' ),
						'btn2_text' => esc_html__( 'One Page', 'shadhin-plugins' ),
					],
					[
						'title' => esc_html__( 'Title #3', 'shadhin-plugins' ),
						'featured_image' => Utils::get_placeholder_image_src(),
						'btn1_text' => esc_html__( 'View Demo', 'shadhin-plugins' ),
						'btn2_text' => esc_html__( 'One Page', 'shadhin-plugins' ),
					],
				],
			]
		);
		$this->end_controls_section();







		$this->start_controls_section(
			'mh_general',
			[
				'label' => esc_html__( 'General', 'shadhin-plugins' ),
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











		$this->start_controls_section(
			'title_section',
			[
				'label' => esc_html__( 'Title Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'title_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .showcase-title', '{{WRAPPER}} .showcase-title a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'title_text_color_hover',
			[
				'label' => esc_html__( "Text Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .showcase-title:hover', '{{WRAPPER}} .showcase-title a:hover' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .showcase-title',
			]
		);
		$this->end_controls_section();







		//other settings
		$this->start_controls_section(
			'other_options',
			[
				'label' => esc_html__( 'Other Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'box_animation',
			[
				'label' => esc_html__( "Box Animation Style", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					''  =>  esc_html__( 'No Animation', 'shadhin-plugins' ),
					'iconbox-style1-current-theme-animation'  =>  esc_html__( 'Style 1 - Current Theme Animation', 'shadhin-plugins' ),
					'iconbox-style2-border-bottom'  =>  esc_html__( 'Style 2 - Border Bottom', 'shadhin-plugins' ),
					'iconbox-style3-moving-border-bottom' =>  esc_html__( 'Style 3 - Moving Border Bottom', 'shadhin-plugins' ),
					'iconbox-style4-bgcolor'  =>  esc_html__( 'Style 4 - Hover BG Color', 'shadhin-plugins' ),
					'iconbox-style5-moving-bgcolor' =>  esc_html__( 'Style 5 - Hover Moving BG Color', 'shadhin-plugins' ),
					'iconbox-style6-moving-double-bgcolor'  =>  esc_html__( 'Style 6 - Hover Moving Double BG Color', 'shadhin-plugins' ),
					'iconbox-style7-hover-moving-border'  =>  esc_html__( 'Style 7 - Hover Moving Border Around Box', 'shadhin-plugins' ),
				],
				'default' => '',
			]
		);
		$this->add_control(
			'box_shadow',
			[
				'label' => esc_html__( "Box Shadow?", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
			]
		);
		$this->add_control(
			'box_shadow_on_hover',
			[
				'label' => esc_html__( "Box Shadow only on Hover?", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
			]
		);
		$this->end_controls_section();



		$this->start_controls_section(
			'button_options',
			[
				'label' => esc_html__( 'Button Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		shadhin_plugins_get_viewdetails_button_arraylist($this, 1);
		shadhin_plugins_get_viewdetails_button_arraylist($this, 2);
		shadhin_plugins_get_button_arraylist($this, 1);
		$this->end_controls_section();



		$this->start_controls_section(
			'button_color_typo_options', [
				'label' => esc_html__( 'Button Color/Typography', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		shadhin_plugins_get_button_text_color_typo_arraylist($this, 1);
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


		//button classes
		$settings['btn_classes'] = shadhin_plugins_prepare_button_classes_from_params( $settings );



		$settings['holder_id'] = shadhin_get_isotope_holder_ID('showcase-block');

		$settings['settings'] = $settings;


		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_template_part( 'showcase', $settings['display_type'], 'showcase-block/tpl', $settings, true );

		echo $html;
	}
}
