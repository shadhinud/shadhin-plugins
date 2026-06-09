<?php
namespace Shadhinplugins\Widgets\Skins;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Mini_Cart extends Elementor_Skin_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
	}

	protected function _register_controls_actions() {
		add_action( 'elementor/element/mh-ele-header-nav-side-icons/mh_general/after_section_end', [ $this, 'register_layout_controls' ] );
	}

	public function get_id() {
		return 'skin-mini-cart';
	}


	public function get_title() {
		return __( 'Skin - Mini Cart Icon', 'shadhin-plugins' );
	}


	public function register_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;





		$this->start_controls_section(
			'mini_cart_options',
			[
				'label' => esc_html__( 'Mini Cart Icon Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'mini_cart_color',
			[
				'label' => esc_html__( "Icon Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mini-cart-icon' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'mini_cart_color_hover',
			[
				'label' => esc_html__( "Icon Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .mini-cart-icon' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'mini_cart_theme_colored',
			[
				'label' => esc_html__( "Icon Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mini-cart-icon' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'mini_cart_theme_colored_hover',
			[
				'label' => esc_html__( "Icon Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .mini-cart-icon' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_section();





		$this->start_controls_section(
			'mini_cart_count_options',
			[
				'label' => esc_html__( 'Mini Cart Item Count Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'mini_cart_count_bg_color',
			[
				'label' => esc_html__( "Item Count BG Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mini-cart-icon .items-count' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'mini_cart_count_bg_color_hover',
			[
				'label' => esc_html__( "Item Count BG Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .mini-cart-icon .items-count' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'mini_cart_count_bg_theme_colored',
			[
				'label' => esc_html__( "Item Count BG Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mini-cart-icon .items-count' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'mini_cart_count_bg_theme_colored_hover',
			[
				'label' => esc_html__( "Item Count BG Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .mini-cart-icon .items-count' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'mini_cart_count_text_options',
			[
				'label' => esc_html__( 'Text Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'mini_cart_count_color',
			[
				'label' => esc_html__( "Item Count Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mini-cart-icon .items-count' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'mini_cart_count_color_hover',
			[
				'label' => esc_html__( "Item Count Text Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .mini-cart-icon .items-count' => 'color: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'mini_cart_count_theme_colored',
			[
				'label' => esc_html__( "Item Count Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mini-cart-icon .items-count' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'mini_cart_count_theme_colored_hover',
			[
				'label' => esc_html__( "Item Count Text Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .mini-cart-icon .items-count' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_section();

	}

	public function render() {
		$html = '';
		$settings = $this->parent->get_settings_for_display();


		//classes
		$classes = array();
		$classes[] = 'mh-sc-header-primary-nav';
		$settings['classes'] = $classes;

		$settings['holder_id'] = shadhin_plugins_get_isotope_holder_ID($settings['_skin']);

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_template_part( 'tpl', $settings['_skin'], 'header-nav-side-icons/tpl', $settings, true );

		echo $html;
	}
}
