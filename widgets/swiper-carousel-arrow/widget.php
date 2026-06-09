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
class MH_Elementor_Swiper_Carousel_Arrow extends Widget_Base {
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        $direction_suffix = is_rtl() ? '.rtl' : '';

        wp_register_style( 'mh-swiper-carousel-arrow', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/swiper-carousel-arrow' . $direction_suffix . '.css' );
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
		return 'mh-ele-swiper-carousel-arrow';
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
		return esc_html__( 'TM - Swiper Carousel Arrow', 'shadhin-plugins' );
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
		return [ 'mh-swiper-carousel-arrow' ];
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
			'arrow_style', [
				'label' => esc_html__( "Arrow Style", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style1'  =>  esc_html__( 'Style 1', 'shadhin-plugins' ),
					'style2'  =>  esc_html__( 'Style 2', 'shadhin-plugins' )
				],
				'default' => 'style1'
			]
		);
		$this->end_controls_section();




		$this->start_controls_section(
			'swiper_arrow_styling', [
				'label' => esc_html__( 'Carousel Arrow Styling', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			"swiper_arrow_display_visibility", [
				'label' => esc_html__( "Visibility (Show/Hide)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex' => [
						'title' => __( 'Show', 'shadhin-plugins' ),
						'icon' => 'eicon-check',
					],
					'none' => [
						'title' => __( 'Hide', 'shadhin-plugins' ),
						'icon' => 'eicon-ban',
					],
				],
				'default' => 'flex',
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap' => 'display: {{VALUE}};'
				],
			]
		);

		$this->start_controls_tabs('tabs_swiper_arrow_styling');
		$this->start_controls_tab(
			'tabs_swiper_arrow_styling_normal',
			[
				'label' => esc_html__('Normal', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'swiper_arrow_bg_options',
			[
				'label' => esc_html__( 'Arrow BG Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'swiper_arrow_bg_color',
			[
				'label' => esc_html__( "Arrow BG Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'swiper_arrow_bg_theme_color',
			[
				'label' => esc_html__( "Arrow BG Theme Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);

		$this->add_control(
			'swiper_arrow_text_options',
			[
				'label' => esc_html__( 'Arrow Text Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'swiper_arrow_text_color',
			[
				'label' => esc_html__( "Arrow Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow i' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_responsive_control(
			'swiper_arrow_text_theme_color',
			[
				'label' => esc_html__( "Arrow Text Theme Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow i' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);


		$this->add_control(
			'swiper_arrow_size_options',
			[
				'label' => esc_html__( 'Arrow Size & Border', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'swiper_arrow_widthheight',
			[
				'label' => esc_html__( 'Dimension (Width and Height)', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 120,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swiper_arrow_border_radius',
			[
				'label' => esc_html__( "Border Radius", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'swiper_arrow_margin',
			[
				'label' => esc_html__( 'Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'swiper_arrow_border_title',
			[
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'swiper_arrow_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'swiper_arrow_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'swiper_arrow_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow i',
			]
		);

		$this->add_control(
			'swiper_arrow_opacity_options',
			[
				'label' => esc_html__( 'Arrow Opacity', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'swiper_arrow_opacity',
			[
				'label' => esc_html__( 'Opacity', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow' => 'opacity: {{SIZE}};'
				]
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_swiper_arrow_styling_hover',
			[
				'label' => esc_html__('Hover', 'shadhin-plugins'),
			]
		);
		$this->add_responsive_control(
			'swiper_arrow_bg_color_hover',
			[
				'label' => esc_html__( "Arrow BG Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow:hover' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'swiper_arrow_bg_theme_color_hover',
			[
				'label' => esc_html__( "Arrow BG Theme Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow:hover' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'swiper_arrow_text_color_hover',
			[
				'label' => esc_html__( "Arrow Text Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow:hover i' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_responsive_control(
			'swiper_arrow_text_theme_color_hover',
			[
				'label' => esc_html__( "Arrow Text Theme Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow:hover i' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'swiper_arrow_border_hover',
			[
				'label' => esc_html__( 'Border (Hover)', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'swiper_arrow_border_hover',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow:hover',
			]
		);
		$this->add_responsive_control(
			'swiper_arrow_opacity_hover',
			[
				'label' => esc_html__( 'Opacity (hover)', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mh-swiper-carousel-arrow-wrap .mh-swiper-arrow:hover' => 'opacity: {{SIZE}};'
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
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

		$html = shadhin_plugins_get_shortcode_template_part( 'swiper-carousel-arrow', null, 'swiper-carousel-arrow/tpl', $settings, true );

		echo $html;
	}
}
