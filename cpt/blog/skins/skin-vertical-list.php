<?php
namespace Shadhinplugins\Widgets\Blog\Skins;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Skin_Base as Elementor_Skin_Base;

use Shadhinplugins\Lib;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Vertical_List extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/mh-ele-blog/mh_general/after_section_end', [ $this, 'register_layout_controls' ] );
	}

	public function get_id() {
		return 'skin-vertical-list';
	}


	public function get_title() {
		return __( 'Style - Vertical List', 'shadhin-plugins' );
	}


	public function register_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'vertical_list-options', [
				'label' => esc_html__( 'Vertical List Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'thumb_options',
			[
				'label' => esc_html__( 'Thumb Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_responsive_control(
			'thumb_custom_width',
			[
				'label' => esc_html__( "Custom Thumb Width", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 300,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article .entry-header img' => 'width: {{SIZE}}{{UNIT}};max-width: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_responsive_control(
			'thumb_margin',
			[
				'label' => esc_html__( 'Thumb Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article .entry-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'thumb_border_radius',
			[
				'label' => esc_html__( 'Thumb Border Radius', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article .entry-header img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'vertical_flex_options',
			[
				'label' => esc_html__( 'Vertical Placement Option', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'flex_vertical',
			[
				'label' => esc_html__( "Vertical Alignment", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_disply_flex_vertical_align_elementor(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article' => 'align-items: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'post_meta_placement', [
				'label' => esc_html__( "Post Meta Placement", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'top' => esc_html__( 'Top', 'shadhin-plugins' ),
					'center' => esc_html__( 'Middle', 'shadhin-plugins' ),
					'bottom' => esc_html__( 'Bottom', 'shadhin-plugins' ),
				],
				'default' => 'center',
			]
		);


		$this->start_controls_tabs('tabs_bullet_style');
		$this->start_controls_tab(
			'normal',
			[
				'label' => esc_html__('Normal', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'margin_options',
			[
				'label' => esc_html__( 'Padding/Margin Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'List Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'margin',
			[
				'label' => esc_html__( 'List Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'bg_options',
			[
				'label' => esc_html__( 'Background Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'bg_color',
			[
				'label' => esc_html__( "Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'bg_theme_colored',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'boxshadow',
				'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .blog-vertical-list article',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .blog-vertical-list article',
			]
		);
		$this->end_controls_tab();



		$this->start_controls_tab(
			'hover',
			[
				'label' => esc_html__('Hover', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'hover_bg_options',
			[
				'label' => esc_html__( 'Background Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'hover_bg_color',
			[
				'label' => esc_html__( "Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article:hover' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'hover_bg_theme_colored',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article:hover' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'hover_boxshadow',
				'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .blog-vertical-list article:hover',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'hover_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .blog-vertical-list article:hover',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'vertical_last_item_list_active',
			[
				'label' => esc_html__('Last Item', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'last_item_margin_options',
			[
				'label' => esc_html__( 'Padding/Margin Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_responsive_control(
			'last_item_padding',
			[
				'label' => esc_html__( 'List Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article:last-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'last_item_margin',
			[
				'label' => esc_html__( 'List Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .blog-vertical-list article:last-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'last_item_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .blog-vertical-list article:last-child',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();
		$class_instance =  '';

		if(isset($settings['post_meta_options']) && !empty($settings['post_meta_options'])) {
			$settings['post_meta_options'] = implode(",", $settings['post_meta_options']);
		}
		$settings['holder_id'] = shadhin_get_isotope_holder_ID('blog');

		$this->render_output( $class_instance, $settings );
	}

	public function render_output( $class_instance, $settings ) {
		$settings['the_query'] = $this->parent->query_posts();

		//button classes
		$settings['btn_classes'] = shadhin_plugins_prepare_button_classes_from_params( $settings );

		//classes
		$classes = array();
		$settings['classes'] = $classes;


		$settings['settings'] = $settings;

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_cpt_shortcode_template_part( 'blog', $settings['_skin'], 'blog/tpl/design-style', $settings, true );

		echo $html;
	}
}
