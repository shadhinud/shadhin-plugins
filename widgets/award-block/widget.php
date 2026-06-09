<?php
namespace Shadhinplugins\Widgets\AwardBlock;

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
class TM_Elementor_AwardBlock extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		if( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$direction_suffix = is_rtl() ? '.rtl' : '';
			wp_enqueue_style( 'tm-award-block-loader', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/award-block/award-block-loader' . $direction_suffix . '.css' );
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
		return 'tm-ele-award-block';
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
		return esc_html__( 'Award Block', 'shadhin-plugins' );
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
		return 'tm-elementor-widget-icon';
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
		return [ 'tm-award-block' ];
	}


	/**
	 * Skins
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Style1( $this ) );
		$this->add_skin( new Skins\Skin_Style2( $this ) );
		$this->add_skin( new Skins\Skin_Style3( $this ) );
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
			'tm_general',
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






		//Link Options
		$this->start_controls_section(
			'service_icons_options', [
				'label' => esc_html__( 'Award Items', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'custom_css_class',
			[
				'label' => esc_html__( "Custom CSS class", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
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
			'subtitle',
			[
				'label' => esc_html__( "Subtitle", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "This is a section subtitle", 'shadhin-plugins' ),
			]
		);
		$repeater->add_control(
			'subtitle_tag',
			[
				'label' => esc_html__( "Subtitle Tag", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_heading_tag_list(),
				'default' => 'h5'
			]
		);
		$repeater->add_control(
			'count',
			[
				'label' => esc_html__( "Count", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "01", 'shadhin-plugins' ),
			]
		);
		$repeater->add_control(
			'year',
			[
				'label' => esc_html__( "Year", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "2023", 'shadhin-plugins' ),
			]
		);
		$repeater->add_control(
			'company',
			[
				'label' => esc_html__( "Company", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "Graphicriver", 'shadhin-plugins' ),
			]
		);
		$repeater->add_control(
			'feature_link',
			[
				'label' => esc_html__( "Link URL", 'shadhin-plugins' ),
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
		$repeater->add_control(
			'company_image',
			[
				'label' => __('Company Images', 'shadhin-plugins'),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);
		$repeater->add_control(
			'company_image_size', [
				'label' => esc_html__( "Company Image Size", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_get_available_image_sizes(),
				'default' => 'thumbnail',
			]
		);
		$repeater->add_control(
			'content',
			[
				'label' => esc_html__( "Paragraph", 'shadhin-plugins' ),
				"description" => esc_html__( "It will be displayed above/under title", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( "Write a short description, that will describe the title or something informational and useful.", 'shadhin-plugins' ),
			]
		);
		$repeater->add_control(
			'section_effects',
			[
				'label' => esc_html__( 'Motion Effects', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'wow_appear_animation',
			[
				'label' => esc_html__( "Wow Appear Animation", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_animate_css_animation_list(),
			]
		);
		$repeater->add_control(
			'wow_animation_delay',
			[
				'label' => esc_html__( 'Animation Delay', 'shadhin-plugins' ) . ' (ms)',
				'type' => Controls_Manager::NUMBER,
				'default' => '',
				'min' => 0,
				'step' => 100,
				'condition' => [
					'wow_appear_animation!' => '',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'award_items_array',
			[
				'label' => esc_html__( "Award Items", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => esc_html__( 'Title #1', 'shadhin-plugins' ),
						'subtitle' => esc_html__( 'subtitle #1', 'shadhin-plugins' ),
						'featured_image' => Utils::get_placeholder_image_src(),
						'content' => esc_html__( 'Item content. Click the edit button to change this text.', 'shadhin-plugins' ),
						'count' => esc_html__( '01', 'shadhin-plugins' ),
						'year' => esc_html__( '2018-2019', 'shadhin-plugins' ),
						'company' => esc_html__( 'Graphicriver', 'shadhin-plugins' ),
					],
					[
						'title' => esc_html__( 'Title #2', 'shadhin-plugins' ),
						'subtitle' => esc_html__( 'Title #2', 'shadhin-plugins' ),
						'featured_image' => Utils::get_placeholder_image_src(),
						'content' => esc_html__( 'Item content. Click the edit button to change this text.', 'shadhin-plugins' ),
						'count' => esc_html__( '02', 'shadhin-plugins' ),
						'year' => esc_html__( '2020-2021', 'shadhin-plugins' ),
						'company' => esc_html__( 'Bahance', 'shadhin-plugins' ),
					],
					[
						'title' => esc_html__( 'Title #3', 'shadhin-plugins' ),
						'subtitle' => esc_html__( 'Title #3', 'shadhin-plugins' ),
						'featured_image' => Utils::get_placeholder_image_src(),
						'content' => esc_html__( 'Item content. Click the edit button to change this text.', 'shadhin-plugins' ),
						'count' => esc_html__( '03', 'shadhin-plugins' ),
						'year' => esc_html__( '2022-2023', 'shadhin-plugins' ),
						'company' => esc_html__( 'Envato', 'shadhin-plugins' ),
					],
				],
			]
		);
		$this->end_controls_section();













		$this->start_controls_section(
			'icon_styling',
			[
				'label' => esc_html__( 'Icon Styling', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'animate_icon_on_hover',
			[
				'label' => esc_html__( "Animate Icon on Hover", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'shadhin-plugins' ),
					'rotate' => esc_html__( 'Rotate', 'shadhin-plugins' ),
					'rotate-x' => esc_html__( 'Rotate X', 'shadhin-plugins' ),
					'rotate-y' => esc_html__( 'Rotate Y', 'shadhin-plugins' ),
					'translate'  => esc_html__( 'Translate', 'shadhin-plugins' ),
					'translate-x'  => esc_html__( 'Translate X', 'shadhin-plugins' ),
					'translate-y'  => esc_html__( 'Translate Y', 'shadhin-plugins' ),
					'scale'  => esc_html__( 'Scale', 'shadhin-plugins' ),
				],
				'default' => '',
			]
		);

		$this->end_controls_section();




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
					'{{WRAPPER}} .feature-title', '{{WRAPPER}} .feature-title a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'title_text_color_hover',
			[
				'label' => esc_html__( "Text Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-title:hover', '{{WRAPPER}} .feature-title a:hover' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .feature-title',
			]
		);
		$this->end_controls_section();





		$this->start_controls_section(
			'subtitle_section',
			[
				'label' => esc_html__( 'Subtitle Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'subtitle_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-subtitle' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'subtitle_text_color_hover',
			[
				'label' => esc_html__( "Text Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-subtitle:hover' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .feature-subtitle',
			]
		);
		$this->end_controls_section();






		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Paragraph Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( "Paragraph Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-details' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'content_color_hover',
			[
				'label' => esc_html__( "Paragraph Color on Hover", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .feature-details' => 'color: {{VALUE}};'
				]
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


		if( $settings['animate_icon_on_hover'] ) {
			$classes[] = 'animate-hover animate-icon-'.$settings['animate_icon_on_hover'];
		}

		//icon classes
		$icon_classes = array();
		$settings['icon_classes'] = $icon_classes;

		//button classes
		$settings['btn_classes'] = shadhin_plugins_prepare_button_classes_from_params( $settings );


		//icon classes
		$icon_classes = array();
		$settings['icon_classes'] = $icon_classes;

		$settings['holder_id'] = shadhin_get_isotope_holder_ID('award-block');

		$settings['settings'] = $settings;


		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_template_part( 'award', $settings['display_type'], 'award-block/tpl', $settings, true );

		echo $html;
	}
}
