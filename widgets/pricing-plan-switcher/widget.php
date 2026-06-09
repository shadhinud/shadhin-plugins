<?php
namespace Shadhinplugins\Widgets\PricingPlanSwitcher;

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
class MH_Elementor_Pricing_Plan_Switcher extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		$direction_suffix = is_rtl() ? '.rtl' : '';
		wp_register_script( 'mh-pricing-plan-switcher', SHADHIN_PLUGINS_ASSETS_URI . '/js/widgets/pricing-plan-switcher.js', array('jquery'), false, true );

		wp_register_style( 'mh-pricing-plan-switcher', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/pricing-plan/pricing-switcher' . $direction_suffix . '.css' );
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
		return 'mh-ele-pricing-plan-switcher';
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
		return esc_html__( 'Pricing Plan Switcher - Shadhin', 'shadhin-plugins' );
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
		return [ 'mascot-core-hellojs', 'mh-pricing-plan-switcher' ];
	}
	public function get_style_depends() {
		return [ 'mh-pricing-plan-switcher' ];
	}

	/**
	 * Skins
	 */
	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Style1( $this ) );
		$this->add_skin( new Skins\Skin_Style2( $this ) );
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
				'label' => esc_html__( 'Switcher Variants', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'variant_text_default',
			[
				'label' => esc_html__( "Default Variant Name", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "Monthly", 'shadhin-plugins' ),
				"description" => esc_html__( "Enter the default switcher variant name", 'shadhin-plugins' ),
			]
		);
		$this->add_control(
			'variant_text_secondary',
			[
				'label' => esc_html__( "Secondary Variant Name", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "Yearly", 'shadhin-plugins' ),
				"description" => esc_html__( "Enter the secondary switcher variant name", 'shadhin-plugins' ),
			]
		);
		$this->add_control(
			'variant_text_offer',
			[
				'label' => esc_html__( "Offer Text", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( "20% Off", 'shadhin-plugins' ),
			]
		);
		$this->end_controls_section();




		//Title
		$this->start_controls_section(
			'variant_text_default_options',
			[
				'label' => esc_html__( 'Default Variant Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);
		$this->add_control(
			'variant_text_default_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .title-normal' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'variant_text_default_text_theme_colored',
			[
				'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .title-normal' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'variant_text_default_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-pricing-plan-switcher .title-normal',
			]
		);
		$this->add_responsive_control(
			'variant_text_default_margin',
			[
				'label' => esc_html__( 'Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .title-normal' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();




		//Title
		$this->start_controls_section(
			'variant_text_secondary_options',
			[
				'label' => esc_html__( 'Secondary Variant Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);
		$this->add_control(
			'variant_text_secondary_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .title-secondary' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'variant_text_secondary_text_theme_colored',
			[
				'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .title-secondary' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'variant_text_secondary_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-pricing-plan-switcher .title-secondary',
			]
		);
		$this->add_responsive_control(
			'variant_text_secondary_margin',
			[
				'label' => esc_html__( 'Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .title-secondary' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();




		//Title
		$this->start_controls_section(
			'variant_text_offer_options',
			[
				'label' => esc_html__( 'Offer Text Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);
		$this->add_control(
			'variant_text_offer_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .price-offer' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'variant_text_offer_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-pricing-plan-switcher .price-offer',
			]
		);
		$this->add_control(
			'variant_text_offer_custom_bg_color',
			[
				'label' => esc_html__( "Text Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .price-offer' => 'background-color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'variant_text_offer_bg_theme_colored',
			[
				'label' => esc_html__( "Text BG Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .price-offer' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'variant_text_offer_padding',
			[
				'label' => esc_html__( 'Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .price-offer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();






		//Title
		$this->start_controls_section(
			'variant_bullet_options',
			[
				'label' => esc_html__( 'Bullet Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);
		$this->add_control(
			'variant_bullet_custom_bg_color',
			[
				'label' => esc_html__( "Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .pricing-switcher-btn .btn-toggle' => 'background-color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'variant_bullet_custom_bg_color_active',
			[
				'label' => esc_html__( "Background Color (Active)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .pricing-switcher-btn .btn-toggle.secondary-active' => 'background-color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'variant_bullet_bg_theme_colored',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .pricing-switcher-btn .btn-toggle' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'variant_bullet_bg_theme_colored_active',
			[
				'label' => esc_html__( "Background Theme Colored (Active)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-pricing-plan-switcher .pricing-switcher-btn .btn-toggle.secondary-active' => 'background-color: var(--theme-color{{VALUE}});'
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

		$html = shadhin_plugins_get_shortcode_template_part( 'switcher-skin-style1', null, 'pricing-plan-switcher/tpl', $settings, true );

		echo $html;
	}
}
