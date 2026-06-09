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
class TM_Elementor_Page_Title extends Widget_Base {
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
		return 'tm-ele-page-title';
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
		return esc_html__( 'Page Title', 'shadhin-plugins' );
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
			'item_type', [
				'label' => esc_html__( "Choose Item", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'title' => esc_html__( 'Title', 'shadhin-plugins' ),
					'breadcrumb' => esc_html__( 'Breadcrumb', 'shadhin-plugins' ),
					'subtitle' => esc_html__( 'Subtitle', 'shadhin-plugins' ),
				],
				'default' => 'title'
			]
		);
		$this->add_responsive_control(
			'icon_text_alignment',
			[
				'label' => esc_html__( "Text Alignment", 'shadhin-plugins' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => shadhin_plugins_text_align_choose(),
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};'
				]
			]
		);
		$this->end_controls_section();










		$this->start_controls_section(
			'title_options',
			[
				'label' => esc_html__( 'Title Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'item_type' => array('title')
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Text Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .title',
			]
		);
		$this->add_control(
			'title_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'title_theme_colored',
			[
				'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();













		$this->start_controls_section(
			'subtitle_options',
			[
				'label' => esc_html__( 'Sub Title Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'item_type' => array('subtitle')
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Text Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .subtitle',
			]
		);
		$this->add_control(
			'subtitle_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .subtitle' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'subtitle_theme_colored',
			[
				'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .subtitle' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label' => esc_html__( 'Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();






















		$this->start_controls_section(
			'breadcrumb_options',
			[
				'label' => esc_html__( 'Breadcrumb Items Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'item_type' => array('breadcrumb')
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'breadcrumb_typography',
				'label' => esc_html__( 'Text Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .breadcrumbs',
			]
		);
		$this->add_control(
			'breadcrumb_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs .trail-item:not(.trail-end)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .breadcrumbs a:not(.btn)' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'breadcrumb_text_color_hover',
			[
				'label' => esc_html__( "Text Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs .trail-item:not(.trail-end):hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .breadcrumbs a:not(.btn):hover' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'breadcrumb_theme_colored',
			[
				'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs .trail-item:not(.trail-end)' => 'color: var(--theme-color{{VALUE}});',
					'{{WRAPPER}} .breadcrumbs a:not(.btn)' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'breadcrumb_theme_colored_hover',
			[
				'label' => esc_html__( "Text Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs .trail-item:not(.trail-end):hover' => 'color: var(--theme-color{{VALUE}});',
					'{{WRAPPER}} .breadcrumbs a:not(.btn):hover' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'list_margin',
			[
				'label' => esc_html__( 'Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs li:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'list_padding',
			[
				'label' => esc_html__( 'Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs li:not(:last-child)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();




		$this->start_controls_section(
			'breadcrumb_global_settings',
			[
				'label' => esc_html__( 'Breadcrumb Wrapper Global Border/Spacing', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'item_type' => array('breadcrumb')
				]
			]
		);
		$this->add_control(
			'breadcrumb_disply_type',
			[
				'label' => esc_html__('Display Property', 'shadhin-plugins'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'inline-block',
				'options' => shadhin_plugins_disply_type_list_elementor(),
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs' => 'display: {{UNIT}}',
				],
			]
		);
		$this->add_control(
			'breadcrumb_bg_color_options',
			[
				'label' => esc_html__( 'Background Color Option', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'breadcrumb_bg_color',
			[
				'label' => esc_html__( "Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs' => 'background-color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'breadcrumb_bg_color_hover',
			[
				'label' => esc_html__( "Background Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs:hover' => 'background-color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'breadcrumb_bg_theme_colored',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'breadcrumb_bg_theme_colored_hover',
			[
				'label' => esc_html__( "Background Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs:hover' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'breadcrumb_border_options',
			[
				'label' => esc_html__( 'Border Option', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'breadcrumb_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .breadcrumbs',
			]
		);
		$this->add_responsive_control(
			'breadcrumb_border_radius',
			[
				'label' => esc_html__( "Border Radius", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs' => 'border-radius: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'breadcrumb_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .breadcrumbs',
			]
		);
		$this->add_responsive_control(
			'breadcrumb_margin',
			[
				'label' => esc_html__( 'Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'breadcrumb_padding',
			[
				'label' => esc_html__( 'Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();










		$this->start_controls_section(
			'breadcrumb_last_item_options',
			[
				'label' => esc_html__( 'Breadcrumb Last Child/Item Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'item_type' => array('breadcrumb')
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'breadcrumb_last_item_typography',
				'label' => esc_html__( 'Text Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .breadcrumbs li:last-child, {{WRAPPER}} .breadcrumbs li:last-child a',
			]
		);
		$this->add_control(
			'breadcrumb_last_item_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs li:last-child' => 'color: {{VALUE}};',
					'{{WRAPPER}} .breadcrumbs li:last-child a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'breadcrumb_last_item_theme_colored',
			[
				'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs li:last-child' => 'color: var(--theme-color{{VALUE}});',
					'{{WRAPPER}} .breadcrumbs li:last-child a' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_section();













		$this->start_controls_section(
			'breadcrumb_bullet_options',
			[
				'label' => esc_html__( 'Breadcrumb Bullet/Icon Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'item_type' => array('breadcrumb')
				]
			]
		);
		$this->add_control(
			'custom_bullet_icon',
			[
				'label' => esc_html__( 'Bullet Icon from Library', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-arrow-right',
					'library' => 'solid',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'breadcrumb_bullet_typography',
				'label' => esc_html__( 'Bullet Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .breadcrumbs li .tm-breadcrumb-arrow-icon',
			]
		);
		$this->add_control(
			'breadcrumb_bullet_text_color',
			[
				'label' => esc_html__( "Bullet Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs li .tm-breadcrumb-arrow-icon' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'breadcrumb_bullet_theme_colored',
			[
				'label' => esc_html__( "Bullet Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .breadcrumbs li .tm-breadcrumb-arrow-icon' => 'color: var(--theme-color{{VALUE}});'
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
		switch ($settings['item_type']) {
			case 'title':
				shadhin_get_title_area_title();
				break;
			case 'breadcrumb':
				$icon_html = "";
				$custom_bullet_icon = $settings['custom_bullet_icon'];
				if(isset($custom_bullet_icon['value']) && !empty($custom_bullet_icon['value'])) {
					$icon_html = '<i class="tm-breadcrumb-arrow-icon '.$custom_bullet_icon['value'].'"></i>';
				}
				shadhin_display_breadcrumbs($icon_html);
				break;
			case 'subtitle':
				shadhin_get_title_area_subtitle();
				break;
			default:
				break;
		}
	}
}
