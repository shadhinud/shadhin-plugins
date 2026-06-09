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
class MH_Elementor_Top_Primary_Nav extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		$direction_suffix = is_rtl() ? '.rtl' : '';
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
		return 'mh-ele-header-primary-nav';
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
		return esc_html__( 'Header Top Primary Nav', 'shadhin-plugins' );
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
			'top_menu_color_options',
			[
				'label' => esc_html__( 'Top Menu Items Typography/Color', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'menu_item_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .menuzord-menu > li.menu-item > a',
			]
		);
		$this->add_control(
			'menu_item_color',
			[
				'label' => esc_html__( "Menu Item Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu > li.menu-item > a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'menu_item_color_hover',
			[
				'label' => esc_html__( "Menu Item Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu > li.menu-item:hover > a, {{WRAPPER}} .menuzord-menu > li.menu-item.active  > a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'menu_item_theme_colored',
			[
				'label' => esc_html__( "Menu Item Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu > li.menu-item > a' => 'color: var(--theme-color{{VALUE}});'
				]
			]
		);
		$this->add_control(
			'menu_item_theme_colored_hover',
			[
				'label' => esc_html__( "Menu Item Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu > li.menu-item:hover > a, {{WRAPPER}} .menuzord-menu > li.menu-item.active  > a' => 'color: var(--theme-color{{VALUE}});'
				]
			]
		);
		$this->end_controls_section();






		$this->start_controls_section(
			'menu_item_padding_options',
			[
				'label' => esc_html__( 'Top Menu Items Padding/Border Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'menu_item_vertical_padding',
			[
				'label' => esc_html__( 'Items Vertical(Top Bottom) Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'@media (min-width: 1025px){ {{WRAPPER}} .menuzord-menu > li.menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
					'@media (min-width: 1025px){ header#header {{WRAPPER}} .menuzord-menu > li.menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
				],
			]
		);
		$this->add_responsive_control(
			'menu_item_leftright_padding',
			[
				'label' => esc_html__( 'Item Left Right Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'@media (min-width: 1025px){ {{WRAPPER}} .menuzord-menu > li.menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
					'@media (min-width: 1025px){ header#header {{WRAPPER}} .menuzord-menu > li.menu-item > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
				],
			]
		);
		$this->add_responsive_control(
			'menu_item_margin',
			[
				'label' => esc_html__( 'Menu Items Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'@media (min-width: 1025px){ {{WRAPPER}} .menuzord-menu > li.menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
					'@media (min-width: 1025px){ header#header {{WRAPPER}} .menuzord-menu > li.menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'menu_item_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .menuzord-menu > li.menu-item',
			]
		);
		$this->end_controls_section();




		$this->start_controls_section(
			'menu_item_last_child_padding_options',
			[
				'label' => esc_html__( 'Top Menu Last Item Padding/Border Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'menu_item_last_child_vertical_padding',
			[
				'label' => esc_html__( 'Items Vertical(Top Bottom) Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'@media (min-width: 1025px){ {{WRAPPER}} .menuzord-menu > li.menu-item:last-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
					'@media (min-width: 1025px){ header#header {{WRAPPER}} .menuzord-menu > li.menu-item:last-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
				],
			]
		);
		$this->add_responsive_control(
			'menu_item_last_child_leftright_padding',
			[
				'label' => esc_html__( 'Item Left Right Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'@media (min-width: 1025px){ {{WRAPPER}} .menuzord-menu > li.menu-item:last-child > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
					'@media (min-width: 1025px){ header#header {{WRAPPER}} .menuzord-menu > li.menu-item:last-child > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
				],
			]
		);
		$this->add_responsive_control(
			'menu_item_last_child_margin',
			[
				'label' => esc_html__( 'Menu Items Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'@media (min-width: 1025px){ {{WRAPPER}} .menuzord-menu > li.menu-item:last-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
					'@media (min-width: 1025px){ header#header {{WRAPPER}} .menuzord-menu > li.menu-item:last-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'menu_item_last_child_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .menuzord-menu > li.menu-item:last-child',
			]
		);
		$this->end_controls_section();







		$this->start_controls_section(
			'dropdown_menu_item_options',
			[
				'label' => esc_html__( 'Dropdown Menu Items Typography/Color', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'dropdown_menu_item_typography',
				'label' => esc_html__( 'Dropdown Menu Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .menuzord-menu li.menu-item ul.dropdown li a',
			]
		);
		$this->add_control(
			'dropdown_menu_item_color',
			[
				'label' => esc_html__( "Dropdown Menu Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu li.menu-item ul.dropdown li a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'dropdown_menu_item_color_hover',
			[
				'label' => esc_html__( "Dropdown Menu Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu .menuzord-menu li.menu-item ul.dropdown li:hover a, {{WRAPPER}} .menuzord-menu .menuzord-menu li.menu-item ul.dropdown li.active a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'dropdown_menu_item_theme_colored',
			[
				'label' => esc_html__( "Dropdown Menu Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu li.menu-item ul.dropdown li a' => 'color: var(--theme-color{{VALUE}});'
				]
			]
		);
		$this->add_control(
			'dropdown_menu_item_theme_colored_hover',
			[
				'label' => esc_html__( "Dropdown Menu Text Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu .menuzord-menu li.menu-item ul.dropdown li:hover a, {{WRAPPER}} .menuzord-menu .menuzord-menu li.menu-item ul.dropdown li.active a' => 'color: var(--theme-color{{VALUE}});'
				]
			]
		);
		$this->add_control(
			'dropdown_menu_item_bg_options',
			[
				'label' => esc_html__( 'Background Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'dropdown_menu_item_bg_color',
			[
				'label' => esc_html__( "Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu li.menu-item ul.dropdown li a' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'dropdown_menu_item_bg_color_hover',
			[
				'label' => esc_html__( "Background Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu li.menu-item ul.dropdown li:hover a' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'dropdown_menu_item_hover_bg_theme_colored',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu li.menu-item ul.dropdown li a' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'dropdown_menu_item_bg_theme_colored',
			[
				'label' => esc_html__( "Background Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu li.menu-item ul.dropdown li:hover a' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'dropdown_menu_item_padding_options',
			[
				'label' => esc_html__( 'Padding/Border Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_responsive_control(
			'dropdown_menu_item_padding',
			[
				'label' => esc_html__( 'Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .menuzord-menu li.menu-item ul.dropdown li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'dropdown_menu_item_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .menuzord-menu li.menu-item ul.dropdown li',
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


		$settings['holder_id'] = shadhin_plugins_get_isotope_holder_ID();


		//Primary Navigation Menu Only For This Page
		$settings['custom_primary_nav_menu'] = "";
		if( shadhin_plugins_theme_active() ) {
			$current_page_id = shadhin_get_page_id();
			$settings['custom_primary_nav_menu'] = shadhin_get_rwmb_group( 'shadhin_' . "page_mb_header_settings", 'custom_primary_nav_menu', $current_page_id );
		}



		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_template_part( 'nav1', null, 'header-primary-nav/tpl', $settings, true );

		echo $html;
	}
}
