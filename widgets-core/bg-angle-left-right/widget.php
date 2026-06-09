<?php
namespace Shadhinplugins\Widgets;

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
class MH_Elementor_BG_Aangle_Left_Right extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_register_style( 'mh-bg-angle-left-right-style', SHADHIN_PLUGINS_ASSETS_URI . '/css/widgets-core/bg-angle-left-right' . $direction_suffix . '.css' );
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
		return 'mh-ele-bg-angle-left-right';
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
		return esc_html__( 'Bg Aangle Left Right', 'shadhin-plugins' );
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
		return [ 'mh-bg-angle-left-right-style' ];
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
			'hide_under_1201',
			[
				'label' => esc_html__( "Hide Under 1201px", 'shadhin-plugins' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'prefix_class' => 'elementor-',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hide-under-1201',
			]
		);
		$this->end_controls_section();













		$this->start_controls_section(
			'angle_border_top_options',
			[
				'label' => esc_html__( 'Border Top Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'angle_border_top_width',
			[
				'label' => esc_html__( "Border Top Width", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-top-width: {{VALUE}};border-top-style:solid;'
				]
			]
		);
		$this->add_control(
			'angle_border_top_color',
			[
				'label' => esc_html__( "Border Top Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-top-color: {{VALUE}};border-top-style:solid;'
				]
			]
		);
		$this->add_control(
			'angle_border_top_theme_colored',
			[
				'label' => esc_html__( "Border Top Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-top-color: var(--theme-color{{VALUE}});border-top-style:solid;'
				],
			]
		);
		$this->end_controls_section();













		$this->start_controls_section(
			'angle_border_right_options',
			[
				'label' => esc_html__( 'Border Right Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'angle_border_right_width',
			[
				'label' => esc_html__( "Border Right Width", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-right-width: {{VALUE}};border-right-style:solid;'
				]
			]
		);
		$this->add_control(
			'angle_border_right_color',
			[
				'label' => esc_html__( "Border Right Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-right-color: {{VALUE}};border-right-style:solid;'
				]
			]
		);
		$this->add_control(
			'angle_border_right_theme_colored',
			[
				'label' => esc_html__( "Border Right Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-right-color: var(--theme-color{{VALUE}});border-right-style:solid;'
				],
			]
		);
		$this->end_controls_section();













		$this->start_controls_section(
			'angle_border_bottom_options',
			[
				'label' => esc_html__( 'Border Bottom Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'angle_border_bottom_width',
			[
				'label' => esc_html__( "Border Bottom Width", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-bottom-width: {{VALUE}};border-bottom-style:solid;'
				]
			]
		);
		$this->add_control(
			'angle_border_bottom_color',
			[
				'label' => esc_html__( "Border Bottom Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-bottom-color: {{VALUE}};border-bottom-style:solid;'
				]
			]
		);
		$this->add_control(
			'angle_border_bottom_theme_colored',
			[
				'label' => esc_html__( "Border Bottom Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-bottom-color: var(--theme-color{{VALUE}});border-bottom-style:solid;'
				],
			]
		);
		$this->end_controls_section();













		$this->start_controls_section(
			'angle_border_left_options',
			[
				'label' => esc_html__( 'Border Left Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'angle_border_left_width',
			[
				'label' => esc_html__( "Border Left Width", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-left-width: {{VALUE}};border-left-style:solid;'
				]
			]
		);
		$this->add_control(
			'angle_border_left_color',
			[
				'label' => esc_html__( "Border Left Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-left-color: {{VALUE}};border-left-style:solid;'
				]
			]
		);
		$this->add_control(
			'angle_border_left_theme_colored',
			[
				'label' => esc_html__( "Border Left Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'border-left-color: var(--theme-color{{VALUE}});border-left-style:solid;'
				],
			]
		);
		$this->end_controls_section();







		$this->start_controls_section(
			'pos_options',
			[
				'label' => esc_html__( 'Position Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'angle_pos_top',
			[
				'label' => esc_html__( "Top", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'top: {{VALUE}};bottom:auto;'
				]
			]
		);
		$this->add_responsive_control(
			'angle_pos_right',
			[
				'label' => esc_html__( "Right", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'right: {{VALUE}};left:auto;'
				]
			]
		);
		$this->add_responsive_control(
			'angle_pos_bottom',
			[
				'label' => esc_html__( "Bottom", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'bottom: {{VALUE}};top:auto;'
				]
			]
		);
		$this->add_responsive_control(
			'angle_pos_left',
			[
				'label' => esc_html__( "Left", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .mh-bg-angle-left-right:after' => 'left: {{VALUE}};right:auto;'
				]
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

	//classes
	$classes = array();
	$classes[] = $settings['custom_css_class'];
	$settings['classes'] = $classes;

	//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
	$html = shadhin_plugins_get_widgetcore_template_part( 'bg-angle-left-right', null, 'bg-angle-left-right/tpl', $settings, true );

	echo $html;
	}
}