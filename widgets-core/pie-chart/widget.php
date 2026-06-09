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
class MH_Elementor_Pie_Chart extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script( 'jquery-easypiechart', SHADHIN_PLUGINS_ASSETS_URI . '/js/plugins/jquery.easypiechart.min.js', array('jquery'), false, true );

		$direction_suffix = is_rtl() ? '.rtl' : '';

		wp_register_style( 'mh-pie-chart-style', SHADHIN_PLUGINS_ASSETS_URI . '/css/widgets-core/pie-chart' . $direction_suffix . '.css' );
		wp_register_script( 'mh-pie-chart', SHADHIN_PLUGINS_ASSETS_URI . '/js/widgets/pie-chart.js', array('jquery', 'jquery-easypiechart'), false, true );
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
		return 'mh-ele-pie-chart';
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
		return esc_html__( 'Pie Chart', 'shadhin-plugins' );
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
		return [ 'mascot-core-hellojs', 'jquery-easypiechart', 'mh-pie-chart' ];
	}

	public function get_style_depends() {
		return [ 'mh-pie-chart-style' ];
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
		$this->add_responsive_control(
			'chart_flex_alignment',
			[
				'label' => esc_html__( "Chart Alignment(Flex)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_disply_flex_horizontal_align_elementor(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => 'display:flex; justify-content: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'percent',
			[
				'label' => esc_html__( "Percentage Value", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( "Add a Percentage Value. Maximum 100. Default: 85", 'shadhin-plugins' ),
				'separator' => 'before',
				'default' => '85'
			]
		);
		$this->add_control(
			'barcolor',
			[
				'label' => esc_html__( "Bar Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'description' => esc_html__( "The color of the curcular bar. Leave empty for default value", 'shadhin-plugins' ),
				'default' => '#ef1e25'
			]
		);
		$this->add_control(
			'trackcolor',
			[
				'label' => esc_html__( "Track Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'description' => esc_html__( "The color of the track, or false to disable rendering. Leave empty for default value", 'shadhin-plugins' ),
				'default' => '#f2f2f2'
			]
		);
		$this->add_control(
			'linewidth',
			[
				'label' => esc_html__( "Line Width", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( "Width of the chart line in px. Default: 3", 'shadhin-plugins' ),
				'default' => '3'
			]
		);
		$this->add_control(
			'linecap',
			[
				'label' => esc_html__( "Line Cap", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
				'square' => esc_html__( 'Square', 'shadhin-plugins' ),
				'butt' => esc_html__( 'Butt', 'shadhin-plugins' ),
				'round' => esc_html__( 'Round', 'shadhin-plugins' ),
				],
				'default' => 'square'
			]
		);
		$this->add_control(
			'size',
			[
				'label' => esc_html__( "Size", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( "Size of the pie chart in px. It will always be a square. Default: 110", 'shadhin-plugins' ),
				'default' => '110'
			]
		);
		$this->add_control(
			'scalecolor',
			[
				'label' => esc_html__( "Scale  Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'description' => esc_html__( "The color of the scale lines, false to disable rendering. Leave empty for default value", 'shadhin-plugins' ),
				'default' => '#dfe0e0'
			]
		);
		$this->add_control(
			'scalelength',
			[
				'label' => esc_html__( "Scale Length", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( "Length of the scale lines (reduces the radius of the chart). Default: 5", 'shadhin-plugins' ),
				'default' => '5'
			]
		);

		$this->end_controls_section();






		$this->start_controls_section(
			'percent_options',
			[
				'label' => esc_html__( 'Percent Value Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'percent_color',
			[
				'label' => esc_html__( "Percent Value Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .percent' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'percent_color_hover',
			[
				'label' => esc_html__( "Percent Value Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .percent' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'percent_theme_colored',
			[
				'label' => esc_html__( "Percent Value Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .percent' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'percent_theme_colored_hover',
			[
				'label' => esc_html__( "Percent Value Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .percent' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'percent_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .percent',
			]
		);
		$this->end_controls_section();






		$this->start_controls_section(
			'title_options',
			[
				'label' => esc_html__( 'Title Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'show_title',
			[
				'label' => esc_html__( "Show Title?", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( "Title", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				"description" => esc_html__( "Add your Progress/Skill Title Text. Default: WordPress", 'shadhin-plugins' ),
			]
		);
		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( "Title Tag", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_heading_tag_list(),
				'default' => 'h3'
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-sc-pie-chart .title',
			]
		);
		$this->add_control(
			'title_text_color',
			[
				'label' => esc_html__( "Title Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-sc-pie-chart .title' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'title_text_color_hover',
			[
				'label' => esc_html__( "Title Text Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .mh-sc-pie-chart .title' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'title_theme_colored',
			[
				'label' => esc_html__( "Title Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-sc-pie-chart .title' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'title_theme_colored_hover',
			[
				'label' => esc_html__( "Title Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .mh-sc-pie-chart .title' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Title Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-sc-pie-chart .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		//classes
		$classes = array();
		$settings['classes'] = $classes;

		wp_register_script( 'jquery-easypiechart', SHADHIN_PLUGINS_ASSETS_URI . '/js/plugins/jquery.easypiechart.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-easypiechart' );

		$settings['box_inline_css'] = shadhin_plugins_get_inline_css( shadhin_plugins_sc_pie_chart_box_css( $settings ) );

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_widgetcore_template_part( 'pie-chart', null, 'pie-chart/tpl', $settings, true );

		echo $html;
	}
}
if(!function_exists('shadhin_plugins_sc_pie_chart_box_css')) {
	/**
	 * Get Parent Box Styles
	 */
	function shadhin_plugins_sc_pie_chart_box_css( $settings ) {
		$css_array = array();

		if( $settings['size'] != '' ) {
			$css_array[] = 'width: '.shadhin_plugins_if_numeric_add_suffix($settings['size'], 'px');
			$css_array[] = 'height: '.shadhin_plugins_if_numeric_add_suffix($settings['size'], 'px');
			$css_array[] = 'line-height: '.shadhin_plugins_if_numeric_add_suffix($settings['size'], 'px');
		}
		return implode( '; ', $css_array );
	}
}