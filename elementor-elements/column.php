<?php

class Shadhin_plugins_Column_Handler {
	private static $instance;
	public $sections = array();

	public function __construct() {
		add_action( 'elementor/element/column/layout/after_section_end', array( $this, 'mh_elementor_column_options' ), 10, 2 );
		add_action( 'elementor/element/column/layout/after_section_end', array( $this, 'render_parallax_options' ), 10, 2 );
		add_action( 'elementor/frontend/column/before_render', array( $this, 'section_before_render' ) );
		add_action( 'elementor/frontend/element/before_render', array( $this, 'section_before_render' ) );
	}

	public static function get_instance() {
		if ( self::$instance === null ) {
			return new self();
		}

		return self::$instance;
	}

	public function mh_elementor_column_options( $element ){

		$element->start_controls_section(
			'mh_element_section_title',
			[
				'label' => MH_ELEMENTOR_WIDGET_BADGE . __('TM BG Stretched Options', 'shadhin-plugins'),
				'tab' => Elementor\Controls_Manager::TAB_LAYOUT,
			]
		);

		$element->add_control(
			'mh_bg_color',
			[
				'label'			=> esc_html__( 'Column Background Color', 'shadhin-plugins' ),
				'description'	=> esc_html__( 'Pre-defined Background Color for this Column', 'shadhin-plugins' ),
				'type'			=> Elementor\Controls_Manager::SELECT,
				'default'		=> '',
				'prefix_class'	=> 'mh-bg-color-yes mh-elementor-bg-color-',
				'options' => [
					'' 			=> esc_attr__( 'Transparent', 'shadhin-plugins' ),
					'white'		=> esc_attr__( 'White', 'shadhin-plugins' ),
					'light'		=> esc_attr__( 'Light', 'shadhin-plugins' ),
					'blackish'	=> esc_attr__( 'Blackish', 'shadhin-plugins' ),
					'globalcolor'	=> esc_attr__( 'Global Color', 'shadhin-plugins' ),
					'secondary'	=> esc_attr__( 'Secondary Color', 'shadhin-plugins' ),
					'gradient'	=> esc_attr__( 'Gradient Color', 'shadhin-plugins' ),
				],
			]
		);

		$element->add_control(
			'mh_text_color',
			[
				'label'			=> esc_html__( 'Column Text Color', 'shadhin-plugins' ),
				'description'	=> esc_html__( 'Pre-defined Text Color in this Column', 'shadhin-plugins' ),
				'type'			=> Elementor\Controls_Manager::SELECT,
				'default'		=> '',
				'prefix_class'	=> 'mh-text-color-',
				'options' => [
					'' 			=> __( 'Default', 'shadhin-plugins' ),
					'white'		=> __( 'White', 'shadhin-plugins' ),
					'blackish'	=> __( 'Blackish', 'shadhin-plugins' ),
				],
			]
		);

		$element->add_control(
			'mh-bg-image-color-order',
			[
				'label'			=> esc_attr__( 'BG Image - BG Color Order', 'shadhin-plugins' ),
				'description'	=> esc_attr__( 'You can show BG image over BG Color or reverse too.', 'shadhin-plugins' ),
				'type'			=> 'mh_imgselect',
				'label_block'	=> true,
				'thumb_width'	=> '110px',
				'default'		=> 'none',
				'prefix_class'	=> 'mh-bg-',
				'default'		=> 'color-over-image',
				'options'		=> [
                    'image-over-color'  => SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/elementor/img-over-color.png',
                    'color-over-image'  => SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/elementor/color-over-img.png',
				],
			]
		);

		$element->end_controls_section();
	}


	public function render_parallax_options( $section, $args ) {
		$section->start_controls_section(
			'mh_core_options',
			[
				'label' => MH_ELEMENTOR_WIDGET_BADGE . esc_html__( 'Mascot - Core Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_LAYOUT,
			]
		);
		$section->add_responsive_control(
			'mh_section_bg_theme_colored',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} > .elementor-widget-wrap' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$section->add_responsive_control(
			'mh_section_appear_animation',
			[
				'label' => esc_html__( "Appear Animation", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' =>  esc_html__( 'No Animation', 'shadhin-plugins' ),
					'mh-item-appear-clip-path'  =>  esc_html__( 'Clip Path Animation', 'shadhin-plugins' ),
					'mh-appear-block-holder'  =>  esc_html__( 'Block Clip Path Animation', 'shadhin-plugins' ),
				],
			]
		);
		$section->add_control(
			'mh_section_appear_animationbg_theme_colored1',
			[
				'label' => esc_html__( "Color1", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'mh_section_appear_animation' => array('mh-appear-block-holder')
				],
				'selectors' => [
					'{{WRAPPER}}.mh-appear-block-holder:before' => 'background-color: {{VALUE}};'
				],
			]
		);
		$section->add_control(
			'mh_section_appear_animationbg_theme_colored2',
			[
				'label' => esc_html__( "Color2", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'mh_section_appear_animation' => array('mh-appear-block-holder')
				],
				'selectors' => [
					'{{WRAPPER}}.mh-appear-block-holder:after' => 'background-color: {{VALUE}};'
				],
			]
		);
		$section->end_controls_section();





		//Stretched BG
		$section->start_controls_section(
			'stretched_bg',
			[
				'label' => MH_ELEMENTOR_WIDGET_BADGE . esc_html__( 'Mascot - Stretched BG', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_LAYOUT,
			]
		);
		$section->add_control(
			'stretched_bg_direction',
			[
				'label'        => esc_html__( 'Stretched Background Direction', 'shadhin-plugins'),
				'type'         => \Elementor\Controls_Manager::SELECT,
				'default'      => 'no',
				'options' => [
					'no'    => esc_html__( 'No', 'shadhin-plugins' ),
					'mh-stretched-bg-both'  => esc_html__( 'Both', 'shadhin-plugins' ),
					'mh-stretched-bg-left'  => esc_html__( 'Left', 'shadhin-plugins' ),
					'mh-stretched-bg-right' => esc_html__( 'Right', 'shadhin-plugins' )
				],
			]
		);
		$section->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'stretched_bg_image_opt',
				'label' => esc_html__('Stretched Background Image', 'shadhin-plugins'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .mh-stretched-bg',
				'condition' => [
					'stretched_bg_direction' => array('mh-stretched-bg-both', 'mh-stretched-bg-left', 'mh-stretched-bg-right')
				]
			]
		);
		$section->add_responsive_control(
			'stretched_bg_theme_color',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'condition' => [
					'stretched_bg_direction' => array('mh-stretched-bg-both', 'mh-stretched-bg-left', 'mh-stretched-bg-right')
				],
				'selectors' => [
					'{{WRAPPER}} .mh-stretched-bg' => 'background-color: var(--theme-color{{VALUE}});',
					'[data-col-id="elementor-element-{{ID}}"].mh-stretched-bg' => 'background-color: var(--theme-color{{VALUE}});',
					'.elementor-edit-area-active .elementor-element-{{ID}}' => 'background-color: var(--theme-color{{VALUE}});',
				],
			]
		);
		$section->add_control(
			'stretched_bg_color',
			[
				'label' => esc_html__( "Custom Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'stretched_bg_direction' => array('mh-stretched-bg-both', 'mh-stretched-bg-left', 'mh-stretched-bg-right')
				]
			]
		);
		$section->add_control(
			'stretched_bg_custom_css_class',
			[
				'label' => esc_html__( "Stretched Background Custom CSS class", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'stretched_bg_direction' => array('mh-stretched-bg-both', 'mh-stretched-bg-left', 'mh-stretched-bg-right')
				]
			]
		);
		$section->add_control(
			'stretched_bg_style',
			[
				'label' => esc_html__( "Stretched Background Custom Inline CSS", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				"description" => esc_html__( "Example: background-color: #f1f1f1;", 'shadhin-plugins' ),
				'condition' => [
					'stretched_bg_direction' => array('mh-stretched-bg-both', 'mh-stretched-bg-left', 'mh-stretched-bg-right')
				]
			]
		);
		$section->end_controls_section();
	}

	public function section_before_render( $widget ) {
		$data     = $widget->get_data();
		$type     = isset( $data['elType'] ) ? $data['elType'] : 'section';
		$settings = $data['settings'];

		if ( 'column' === $type ) {
			if ( isset( $settings['mh_section_appear_animation'] ) && $settings['mh_section_appear_animation'] != '' ) {
				$widget->add_render_attribute( '_wrapper', 'class', $settings['mh_section_appear_animation'] );
			}




			//Stretched BG
			if ( isset( $settings['stretched_bg_direction'] ) ) {
				$output= '';
				if ( $settings['stretched_bg_direction'] != 'no' ) {
					$stretched_bg_classes = array();
					$stretched_bg_classes[] = $settings['stretched_bg_direction'];
					if( empty($settings['stretched_bg_custom_css_class']) ) {
						$settings['stretched_bg_custom_css_class'] = '';
					}
					$stretched_bg_classes[] = $settings['stretched_bg_custom_css_class'];
					//$stretched_bg_classes[] = 'bg-theme-colored' . $settings['stretched_bg_theme_color'];
					$stretched_bg_inline_css = '';
					if( isset( $settings['stretched_bg_color'] ) && !empty( $settings['stretched_bg_color'] ) ) {;
						$stretched_bg_inline_css .= 'background-color: '.$settings['stretched_bg_color'].' !important;';
					}
					if( isset( $settings['stretched_bg_style'] ) && !empty( $settings['stretched_bg_style'] ) ) {;
						$stretched_bg_inline_css .= $settings['stretched_bg_style'];
					}
					$output .= '<div data-col-id="elementor-element-'. esc_attr($data['id']).'" class="mh-stretched-bg '. esc_attr(implode(' ', $stretched_bg_classes)).'" style="'. esc_attr($stretched_bg_inline_css).'"></div>';
				}
				echo $output;
			}
		}
	}
}

if ( ! function_exists( 'shadhin_plugins_init_column_handler' ) ) {
	function shadhin_plugins_init_column_handler() {
		Shadhin_plugins_Column_Handler::get_instance();
	}

	// Priority 20 ensures it runs after plugin initialization (priority 5) and theme framework (priority 10)
	add_action( 'init', 'shadhin_plugins_init_column_handler', 20 );
}