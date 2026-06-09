<?php
namespace Shadhinplugins\Widgets\VideoPopup\Skins;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_CSS_Play_Button extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/mh-ele-video-popup/mh_general/before_section_end', [ $this, 'register_layout_controls' ] );
		add_action( 'elementor/element/mh-ele-video-popup/mh_general/after_section_end', [ $this, 'register_layout_controls_play_btn' ] );
	}

	public function get_id() {
		return 'css-button';
	}


	public function get_title() {
		return __( 'Skin - CSS Play Button', 'shadhin-plugins' );
	}


	public function register_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->add_control(
			'title',
			[
				'label' => esc_html__( "Title Text", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
	}








	public function register_layout_controls_play_btn( Widget_Base $widget ) {
		$this->parent = $widget;
		$this->start_controls_section(
			'icon_styling',
			[
				'label' => esc_html__( 'Play Button Styling', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'icon_size_options',
			[
				'label' => esc_html__( 'Size Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_responsive_control(
			'icon_area_width',
			[
				'label' => esc_html__( "Dimension (Width and Height)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 240,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .animated-css-play-button .bg-block' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .animated-css-play-button .play-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .animated-css-play-button .play-icon:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .animated-css-play-button .play-icon:after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->start_controls_tabs('tabs_icon_style');
		$this->start_controls_tab(
			'icon_normal',
			[
				'label' => esc_html__('Normal', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'icon_options',
			[
				'label' => esc_html__( 'Icon Color Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( "Icon Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .animated-css-play-button .play-icon i' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'icon_theme_colored',
			[
				'label' => esc_html__( "Icon Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .animated-css-play-button .play-icon i' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'label' => esc_html__( 'Icon Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .animated-css-play-button .play-icon i',
			]
		);
		$this->add_control(
			'icon_bg_options',
			[
				'label' => esc_html__( 'Background Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'iconb_bg_color',
			[
				'label' => esc_html__( "Icon Custom Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .animated-css-play-button .bg-block' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .animated-css-play-button .play-icon:after' => 'background-color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'icon_bg_theme_colored',
			[
				'label' => esc_html__( "Icon Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .animated-css-play-button .bg-block' => 'background-color: var(--theme-color{{VALUE}});',
					'{{WRAPPER}} .animated-css-play-button .play-icon:after' => 'background-color: var(--theme-color{{VALUE}});',
				],
			]
		);
		$this->add_control(
			'icon_bg_color_opacity',
			[
				'label' => esc_html__( 'BG Colored Opacity', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .animated-css-play-button .bg-block' => 'opacity: {{SIZE}};',
				]
			]
		);
		$this->add_responsive_control(
			'icon_area_border_radius',
			[
				'label' => esc_html__( "Border Radius", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .animated-css-play-button .bg-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .animated-css-play-button .play-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .animated-css-play-button .play-icon:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .animated-css-play-button .play-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		$this->end_controls_tab();


		$this->start_controls_tab(
			'icon_hover',
			[
				'label' => esc_html__('Hover', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'icon_options_hover',
			[
				'label' => esc_html__( 'Icon Color Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( "Icon Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-sc-video-popup:hover .animated-css-play-button .play-icon i' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'icon_theme_colored_hover',
			[
				'label' => esc_html__( "Icon Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-sc-video-popup:hover .animated-css-play-button .play-icon i' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'icon_bg_options_hover',
			[
				'label' => esc_html__( 'Background Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'icon_bg_color_hover',
			[
				'label' => esc_html__( "Icon Custom Background Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-sc-video-popup:hover .animated-css-play-button .bg-block' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mh-sc-video-popup:hover .animated-css-play-button .play-icon:after' => 'background-color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'icon_bg_theme_colored_hover',
			[
				'label' => esc_html__( "Icon Background Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-sc-video-popup:hover .animated-css-play-button .bg-block' => 'background-color: var(--theme-color{{VALUE}});',
					'{{WRAPPER}} .mh-sc-video-popup:hover .animated-css-play-button .play-icon:after' => 'background-color: var(--theme-color{{VALUE}});',
				],
			]
		);
		$this->add_control(
			'icon_bg_color_opacity_hover',
			[
				'label' => esc_html__( 'BG Colored Opacity', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mh-sc-video-popup:hover .animated-css-play-button .bg-block' => 'opacity: {{SIZE}};',
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();

		//classes
		$classes = array();
		$classes[] = 'mh-sc-video-popup';

		$settings['classes'] = $classes;

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_widgetcore_template_part( 'video-popup', $settings['_skin'], 'video-popup/tpl', $settings, true );

		echo $html;
	}
}