<?php

class Shadhin_plugins_Container_Handler {
    private static $instance;
    public $sections = array();

    public function __construct() {
        add_action('elementor/editor/before_enqueue_scripts', array( $this, 'mh_elementor_enqueue_base_scripts' ));
        add_action( 'wp_enqueue_scripts', array( $this, 'mh_elementor_enqueue_front_scripts' ) );
        add_action( 'elementor/controls/controls_registered', array( $this, 'mh_elementor_init_controls' ));
        add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'extend_elementor_section_options' ), 10, 2 );
        add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'extend_elementor_gsap_scroll_fixed_options' ), 10, 2 );
        add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'render_core_options' ), 10, 2 );
        add_action( 'elementor/element/common/section_layout/after_section_end', array( $this, 'render_core_options' ), 10, 2 );
        //add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'register_controls_section_bg_box' ), 10, 2 );
        add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'register_controls_custom_width' ), 10, 2 );
        add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'register_controls_equal_height' ), 10, 2 );
        add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'other_options' ), 10, 2 );
        add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'bg_move_effect_options' ), 10, 2 );
        add_action( 'elementor/element/container/section_layout/after_section_end', array( $this, 'render_curve_bg_options' ), 10, 2 );
        add_action( 'elementor/frontend/container/before_render', array( $this, 'section_before_render' ) );
        add_action( 'elementor/frontend/before_render', array( $this, 'section_before_render' ) );
        add_action( 'elementor/frontend/container/before_render', [ $this, 'equal_height_before_render' ] );
        add_action( 'elementor/frontend/container/before_render', [ $this, 'other_options_before_render' ] );
        add_action( 'elementor/frontend/container/before_render', [ $this, 'bg_move_effect_options_before_render' ] );


		add_action('elementor/frontend/before_render', [$this, 'mh_gsap_before_section_render'], 3);
    }

    public static function get_instance() {
        if ( self::$instance === null ) {
            return new self();
        }

        return self::$instance;
    }

    public function mh_elementor_enqueue_base_scripts(){
        wp_enqueue_script( 'mh-elementor-base', SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/mh-stretch-base.js' );
    }

    public function mh_elementor_enqueue_front_scripts(){
        wp_enqueue_script( 'mh-elementor-script', SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/mh-stretch.js' );
        wp_enqueue_style( 'mh-elementor-style', SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/mh-stretch.css' );
        if ( defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
            wp_enqueue_script(  'mh-elementor-frontview', SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/elementor-frontview.js' );
        }
    }



    //add new control type
    public function mh_elementor_init_controls() {
        require_once( 'controls/control-mh-imgselect.php' );
        if ( class_exists( 'DSVY_imgselect' ) ) {
            \Elementor\Plugin::$instance->controls_manager->register_control( 'mh_imgselect', new DSVY_imgselect() );
        }
    }

    public function mh_gsap_before_section_render($element)
	{
		$gsap_scroll_fixed = $element->get_settings_for_display('gsap_scroll_fixed');
		$gsap_scroll_fixed_stop_under = $element->get_settings_for_display('gsap_scroll_fixed_stop_under');

		if (
			($gsap_scroll_fixed && !empty($gsap_scroll_fixed)) || ($gsap_scroll_fixed_stop_under && !empty($gsap_scroll_fixed_stop_under))
		) {
			$element->add_render_attribute(
				'_wrapper',
				[
					'class' => [$gsap_scroll_fixed],
                    'data-stop-under' => [$gsap_scroll_fixed_stop_under]
				]
			);
		}
	}

    //for extending elementor sections
    public function extend_elementor_gsap_scroll_fixed_options( $element ){

        $element->start_controls_section(
            'mh_element_gsap_scroll_fixed_section',
            [
                'label' => MH_ELEMENTOR_WIDGET_BADGE . __('TM GSAP Pin Scroll Fixed', 'shadhin-plugins'),
                'tab' => Elementor\Controls_Manager::TAB_LAYOUT,
            ]
        );
		$element->add_control(
			'gsap_scroll_fixed',
			[
				'label'     => __('Pin Scroll Fixed', 'shadhin-plugins'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'options'   => [
					'' => __('Default', 'shadhin-plugins'),
					'gsap-pin-fixed-boxed' 	=> __('Enable For Boxed Parent Container', 'shadhin-plugins'),
					'gsap-pin-fixed-fullwidth' 	=> __('Enable For Fullwidth Parent Container', 'shadhin-plugins')
				],
				'default'   => '',
			]
		);
		$element->add_control(
			'gsap_scroll_fixed_start_at',
			[
				'label' => esc_html__( 'Start at (e.g. 200)', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -1000,
				'max' => 1000,
				'step' => 2,
                'prefix_class' => 'start-',
                'condition' => [
                    'gsap_scroll_fixed' => ['gsap-pin-fixed-boxed', 'gsap-pin-fixed-fullwidth']
                ]
			]
		);
        $element->add_control(
			'gsap_scroll_fixed_responsive_condition',
			[
				'label' => esc_html__('Responsive Condition', 'shadhin-plugins'),
				'type'  => \Elementor\Controls_Manager::HEADING,
				'classes' => 'rs-control-type-heading',
                'condition' => [
                    'gsap_scroll_fixed' => ['gsap-pin-fixed-boxed', 'gsap-pin-fixed-fullwidth']
                ]
			]
		);
        $element->add_control(
			'gsap_scroll_fixed_stop_under',
			[
				'label'     => __('Stop Under Devices', 'shadhin-plugins'),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'options'   => [
					'' => __('None', 'shadhin-plugins'),
					'laptop' 	=> __('Laptop', 'shadhin-plugins'),
					'tablet' 	=> __('Tablet', 'shadhin-plugins'),
					'mobile' 	=> __('Mobile', 'shadhin-plugins'),
				],
				'default'   => 'mobile',
                'condition' => [
                    'gsap_scroll_fixed' => ['gsap-pin-fixed-boxed', 'gsap-pin-fixed-fullwidth']
                ]
			]
		);
        $element->end_controls_section();
    }

    //for extending elementor sections
    public function extend_elementor_section_options( $element ){

        $element->start_controls_section(
            'mh_element_section_title',
            [
                'label' => MH_ELEMENTOR_WIDGET_BADGE . __('TM BG Stretched Options', 'shadhin-plugins'),
                'tab' => Elementor\Controls_Manager::TAB_LAYOUT,
            ]
        );

        $element->add_control(
            'mh-extended-column',
            [
                'label'         => esc_attr__( 'Extend Column for background image', 'shadhin-plugins' ),
                'description'   => esc_attr__( 'Select which column will be extended with background image.', 'shadhin-plugins' ),
                'type'          => 'mh_imgselect',
                'label_block'   => true,
                'hide_in_inner' => true,
                'thumb_width'   => '110px',
                'default'       => 'none',
                'prefix_class'  => 'mh-col-stretched-',
                'options' => [
                    'none'          => SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/elementor/bg-stretched-none.png',
                    'left'          => SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/elementor/bg-stretched-first.png',
                    'right'         => SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/elementor/bg-stretched-last.png',
                    'both'          => SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/elementor/bg-stretched-both.png',
                ],
            ]
        );

        $element->add_control(
            'mh-strech-content-left',
            [
                'label'         => esc_attr__( 'Also stretch left content too?', 'shadhin-plugins' ),
                'description'   => esc_attr__( 'Also stretch left content too?', 'shadhin-plugins' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'prefix_class'  => 'mh-left-col-stretched-content-',
                'hide_in_inner' => true,
                'label_on'      => esc_attr__( 'Yes', 'shadhin-plugins' ),
                'label_off'     => esc_attr__( 'No', 'shadhin-plugins' ),
                'return_value'  => 'yes',
                'default'       => '',
                'condition'     => [
                    'mh-extended-column' => array('left', 'both'),
                ]
            ]
        );
        $element->add_control(
            'mh-strech-content-right',
            [
                'label'         => esc_attr__( 'Also stretch right content too?', 'shadhin-plugins' ),
                'description'   => esc_attr__( 'Also stretch right content too?', 'shadhin-plugins' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'prefix_class'  => 'mh-right-col-stretched-content-',
                'hide_in_inner' => true,
                'label_on'      => esc_attr__( 'Yes', 'shadhin-plugins' ),
                'label_off'     => esc_attr__( 'No', 'shadhin-plugins' ),
                'return_value'  => 'yes',
                'default'       => '',
                'condition'     => [
                    'mh-extended-column' => array('right', 'both'),
                ]
            ]
        );
        $element->add_control(
            'mh-left-margin',
            [
                'label'         => esc_html__( 'Left Content Area Margin', 'shadhin-plugins' ),
                'description'   => esc_html__( 'This is useful if you like to overlap columns on each other.', 'shadhin-plugins' ),
                'type'          => Elementor\Controls_Manager::DIMENSIONS,
                'separator'     => 'before',
                'selectors' => [
                    '{{WRAPPER}} .mh-stretched-div.mh-stretched-left' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $element->add_control(
            'mh-right-margin',
            [
                'label'         => esc_html__( 'Right Content Area Margin', 'shadhin-plugins' ),
                'description'   => esc_html__( 'This is useful if you like to overlap columns on each other.', 'shadhin-plugins' ),
                'type'          => Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .mh-stretched-div.mh-stretched-right' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $element->add_control(
            'mh_bg_color',
            [
                'label'         => esc_html__( 'Container Background Color', 'shadhin-plugins' ),
                'description'   => esc_html__( 'Pre-defined Background Color for this Container (ROW)', 'shadhin-plugins' ),
                'type'          => Elementor\Controls_Manager::SELECT,
                'default'       => '',
                'separator'     => 'before',
                'prefix_class'  => 'mh-bg-color-yes mh-elementor-bg-color-',
                'options'       => [
                    ''              => esc_attr__( 'Transparent', 'shadhin-plugins' ),
                    'white'         => esc_attr__( 'White', 'shadhin-plugins' ),
                    'light'         => esc_attr__( 'Light', 'shadhin-plugins' ),
                    'blackish'      => esc_attr__( 'Blackish', 'shadhin-plugins' ),
                    'globalcolor'   => esc_attr__( 'Global Color', 'shadhin-plugins' ),
                    'secondary'     => esc_attr__( 'Secondary Color', 'shadhin-plugins' ),
                    'gradient'      => esc_attr__( 'Gradient Color', 'shadhin-plugins' ),
                ],
            ]
        );

        $element->add_control(
            'mh_text_color',
            [
                'label'         => esc_html__( 'Container Text Color', 'shadhin-plugins' ),
                'description'   => esc_html__( 'Pre-defined Text Color in this Container (ROW)', 'shadhin-plugins' ),
                'type'          => Elementor\Controls_Manager::SELECT,
                'default'       => '',
                'prefix_class'  => 'mh-text-color-',
                'options' => [
                    ''          => __( 'Default', 'shadhin-plugins' ),
                    'white'     => __( 'White', 'shadhin-plugins' ),
                    'blackish'  => __( 'Blackish', 'shadhin-plugins' ),
                ],
            ]
        );

        $element->add_control(
            'mh-bg-image-color-order',
            [
                'label'         => esc_attr__( 'BG Image - BG Color Order', 'shadhin-plugins' ),
                'description'   => esc_attr__( 'You can show BG image over BG Color or reverse too.', 'shadhin-plugins' ),
                'type'          => 'mh_imgselect',
                'label_block'   => true,
                'thumb_width'   => '110px',
                'default'       => 'none',
                'prefix_class'  => 'mh-bg-',
                'default'       => 'color-over-image',
                'options'       => [
                    'image-over-color'  => SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/elementor/img-over-color.png',
                    'color-over-image'  => SHADHIN_PLUGINS_ASSETS_URI . '/section-col-stretch/elementor/color-over-img.png',
                ],
            ]
        );

        $element->end_controls_section();
    }

    public function render_core_options( $section, $args ) {
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
                    '{{WRAPPER}}' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $section->add_responsive_control(
            'mh_core_content_width',
            [
                'label' => esc_html__( 'Section Custom Width (px)', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1700,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} > .elementor-container .elementor-container' => 'max-width: 100% !important;',
                ],
                'condition' => [
                    'layout' => [ 'boxed' ],
                ],
                'separator' => 'before',
            ]
        );
        $section->add_responsive_control(
            'mh_section_bg_overlay_display_type',
            [
                'label' => esc_html__( "BG Overlay Display Type", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'block' =>  esc_html__( "Show", 'shadhin-plugins' ),
                    'none'  =>  esc_html__( "Hide", 'shadhin-plugins' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} > .elementor-background-overlay' => 'display: {{VALUE}};'
                ],
            ]
        );

        $section->add_control(
            'mh_section_appear_animation_heading',
            [
                'label' => esc_html__( 'Clip Path Animation', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $section->add_control(
            'mh_section_appear_animation',
            [
                'label' => esc_html__( "Clip Path Appear Animation", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' =>  esc_html__( 'No Animation', 'shadhin-plugins' ),
                    'mh-item-appear-clip-path'  =>  esc_html__( 'Clip Path Animation', 'shadhin-plugins' ),
                    'mh-item-appear-clip-path-right'  =>  esc_html__( 'Clip Path Animation Right to Left', 'shadhin-plugins' ),
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
        $section->add_control(
            'mh_section_wow_appear_animation_heading',
            [
                'label' => esc_html__( 'Wow Animation', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $section->add_control(
            'mh_section_wow_appear_animation',
            [
                'label' => esc_html__( "Wow Appear Animation", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_animate_css_animation_list(),
            ]
        );
        $section->add_control(
            'mh_section_wow_animate_delay',
            [
                'label' => esc_html__( "Wow Animate Delay(ms or s)", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '0',
                'description' => 'Enter number. Default 0ms',
                'condition' => [
                    'mh_section_wow_appear_animation!' => ''
                ],
            ]
        );


        $section->add_control(
            'activate_text_gradient_background_fill', [
                'label' => esc_html__( "Activate Gradient BG Fill/Clip?", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'separator' => 'before',
            ]
        );
        $section->add_responsive_control(
            "text_gradient_background_fill", [
                'label' => esc_html__( "Text Gradient Background Fill Effect?", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'block' => [
                        'title' => __( 'Show', 'shadhin-plugins' ),
                        'icon' => 'eicon-check',
                    ],
                    'none' => [
                        'title' => __( 'Hide', 'shadhin-plugins' ),
                        'icon' => 'eicon-ban',
                    ],
                ],
                'condition' => [
                    'activate_text_gradient_background_fill' => array('yes')
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => '-webkit-background-clip: text;-webkit-text-fill-color: transparent;'
                ],
            ]
        );
        $section->end_controls_section();
    }

    public function render_curve_bg_options( $section, $args ) {
        $section->start_controls_section(
            'mh_curve_bg_options',
            [
                'label' => MH_ELEMENTOR_WIDGET_BADGE . esc_html__( 'Mascot - Curve BG Options', 'shadhin-plugins' ),
                'tab'   => \Elementor\Controls_Manager::TAB_LAYOUT,
            ]
        );
        $section->add_control(
            'mh_curve_bg_enable',
            [
                'label'         => esc_attr__( 'Enable Curve BG?', 'shadhin-plugins' ),
                'type'          => \Elementor\Controls_Manager::SWITCHER,
                'prefix_class'  => 'mh-curve-cta-',
                'label_on'      => esc_attr__( 'Yes', 'shadhin-plugins' ),
                'label_off'     => esc_attr__( 'No', 'shadhin-plugins' ),
                'return_value'  => 'yes',
                'default'       => '',
            ]
        );
        $section->add_control(
            'mh_curve_bg_theme_colored',
            [
                'label' => esc_html__( "Curve BG 1st Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.mh-curve-cta-yes:after' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $section->add_control(
            'mh_curve_bg_custom_color',
            [
                'label' => esc_html__( "Curve BG 1st Custom Color", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.mh-curve-cta-yes:after' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $section->add_responsive_control(
            'mh_curve_bg_custom_width',
            [
                'label' => esc_html__( 'Curve BG 1st Custom Width', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.mh-curve-cta-yes:after' => 'width: {{SIZE}}%;',
                ],
                'separator' => 'none',
            ]
        );


        $section->add_control(
            'mh_curve_bg_theme_colored2',
            [
                'label' => esc_html__( "Curve BG 2nd Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.mh-curve-cta-yes:before' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $section->add_control(
            'mh_curve_bg_custom_color2',
            [
                'label' => esc_html__( "Curve BG 2nd Custom Color", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.mh-curve-cta-yes:before' => 'background-color: {{VALUE}};'
                ],
            ]
        );
        $section->add_responsive_control(
            'mh_curve_bg_custom_width2',
            [
                'label' => esc_html__( 'Curve BG 2nd Custom Width', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.mh-curve-cta-yes:before' => 'width: {{SIZE}}%;',
                ],
                'separator' => 'none',
            ]
        );
        $section->end_controls_section();
    }

    public function register_controls_custom_width($section, $args) {

        $section->start_controls_section(
            'mh_section_custom_width_controls',
            [
                'label' => MH_ELEMENTOR_WIDGET_BADGE . esc_html__( 'Mascot - Container Custom Width', 'shadhin-plugins' ),
                'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
            ]
        );
        $section->add_responsive_control(
            'mh_section_custom_width',
            [
                'label' => esc_html__( 'Container Custom Width (px)', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1600,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                ],
                'separator' => 'none',
            ]
        );
        $section->add_responsive_control(
            'mh_section_custom_margin_auto',
            [
                'label' => esc_html__('Container Left/Right Margin Auto', 'shadhin-plugins'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'e-auto' => [
                        'title' => esc_html__('Left Auto', 'shadhin-plugins'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    's-auto' => [
                        'title' => esc_html__('Right Auto', 'shadhin-plugins'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'm',
            ]
        );
        $section->add_responsive_control(
            'mh_section_content_width',
            [
                'label' => esc_html__( 'Container Inner Custom Width (px)', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'separator' => 'before',
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1600,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} > .elementor-container' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} > .elementor-container .elementor-container' => 'margin-left: auto !important; margin-right: auto !important;',
                ],
                'separator' => 'none',
            ]
        );
        $section->end_controls_section();

    }

    public function register_controls_equal_height($section, $args) {

        $section->start_controls_section(
            'mh_section_equal_height_controls',
            [
                'label' => MH_ELEMENTOR_WIDGET_BADGE . esc_html__( 'Mascot - Equal Height', 'shadhin-plugins' ),
                'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
            ]
        );
        $section->add_control(
            'mh_section_equal_height_on',
            [
                'label'        => esc_html__( 'Enable Equal Height', 'shadhin-plugins' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'description'  => esc_html__( 'You can equal your column/widgets height equal by enable this option.', 'shadhin-plugins' ),
            ]
        );
        $section->add_control(
            'mh_section_equal_height_selector',
            [
                'label'     => esc_html__( 'Equal Height For', 'shadhin-plugins' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'options'   => [
                    'column'     => 'Columns',
                    'widgets'    => 'Widgets',
                    'widgets_c1' => 'Widgets > Child',
                    'widgets_c2' => 'Widgets > Child > Child',
                    'widgets_c3' => 'Widgets > Child > Child > Child',
                    'custom'     => 'Custom Selector',
                ],
                'default'   => 'widgets',
                'condition' => [
                    'mh_section_equal_height_on' => 'yes',
                ],
            ]
        );
        $section->add_control(
            'mh_section_equal_height_custom_selector',
            [
                'label'       => esc_html__( 'Custom Selector', 'shadhin-plugins' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => '.class-name',
                'condition'   => [
                    'mh_section_equal_height_on' => 'yes',
                    'mh_section_equal_height_selector' => 'custom',
                ],
            ]
        );
        $section->add_control(
            'mh_section_equal_height_disable_on_tablet',
            [
                'label'        => esc_html__( 'Disable On Tablet', 'shadhin-plugins' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => 'no',
                'condition'   => [
                    'mh_section_equal_height_on' => 'yes',
                ],
            ]
        );
        $section->add_control(
            'mh_section_equal_height_disable_on_mobile',
            [
                'label'        => esc_html__( 'Disable On Mobile', 'shadhin-plugins' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'condition'   => [
                    'mh_section_equal_height_on' => 'yes',
                ],
            ]
        );
        $section->end_controls_section();

    }

    public function other_options( $section, $args ) {
        $section->start_controls_section(
            'mh_other_options',
            [
                'label' => MH_ELEMENTOR_WIDGET_BADGE . esc_html__( 'Mascot - Other Options', 'shadhin-plugins' ),
                'tab'   => \Elementor\Controls_Manager::TAB_LAYOUT,
            ]
        );
        $section->add_control(
            'mh_four_vertical_line',
            [
                'label' => esc_html__( "Show Four Vertical Lines in Background?", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $section->add_control(
            'mh_small_vertical_line',
            [
                'label' => esc_html__( "Show Smaill Vertical Lines in Background?", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $section->end_controls_section();
    }

    public function bg_move_effect_options( $section, $args ) {
        $section->start_controls_section(
            'mh_bg_move_effect_options',
            [
                'label' => MH_ELEMENTOR_WIDGET_BADGE . esc_html__( 'Mascot - BG Gsap Clip Path Effect', 'shadhin-plugins' ),
                'tab'   => \Elementor\Controls_Manager::TAB_LAYOUT,
            ]
        );
        $section->add_control(
            'mh_bg_move_effect_enable',
            [
                'label' => esc_html__( "Enable BG Move Effect?", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $section->end_controls_section();
    }

    public function section_before_render( $widget ) {
        $data     = $widget->get_data();
        $type     = isset( $data['elType'] ) ? $data['elType'] : 'container';
        $settings = $data['settings'];

        if ( 'container' === $type || 'widget' === $type ) {
          if ( isset( $settings['mh_section_appear_animation'] ) && $settings['mh_section_appear_animation'] != '' ) {
            $widget->add_render_attribute( '_wrapper', 'class', $settings['mh_section_appear_animation'] );
          }
          if ( isset( $settings['mh_section_wow_appear_animation'] ) && $settings['mh_section_wow_appear_animation'] != '' ) {
            $widget->add_render_attribute( '_wrapper', 'class', 'wow '.$settings['mh_section_wow_appear_animation'] );
            $widget->add_render_attribute( '_wrapper', 'data-wow-delay', $settings['mh_section_wow_animate_delay'] );
          }
        }
    }


    public function equal_height_before_render($section) {
        $settings = $section->get_settings_for_display();
        if( $settings[ 'mh_section_equal_height_on' ] == 'yes' ) {
            wp_enqueue_script( 'matchHeight' );

            $height_option = '';

            if ( 'column' == $settings['mh_section_equal_height_selector']) {
                $height_option = '.e-con-inner';
            }

            if ( 'widgets' == $settings['mh_section_equal_height_selector']) {
                $height_option = '.e-con-inner .elementor-widget > .elementor-widget-container';
            }

            if ( 'widgets_c1' == $settings['mh_section_equal_height_selector']) {
                $height_option = '.e-con-inner .elementor-widget > .elementor-widget-container > div:nth-of-type(1)';
            }

            if ( 'widgets_c2' == $settings['mh_section_equal_height_selector']) {
                $height_option = '.e-con-inner .elementor-widget > .elementor-widget-container > div > div:nth-of-type(1)';
            }

            if ( 'widgets_c3' == $settings['mh_section_equal_height_selector']) {
                $height_option = '.e-con-inner .elementor-widget > .elementor-widget-container > div > div > div:nth-of-type(1)';
            }

            if ( 'custom' == $settings['mh_section_equal_height_selector'] and $settings['mh_section_equal_height_custom_selector']) {
                $height_option = '' . esc_attr($settings['mh_section_equal_height_custom_selector']) ;
            }

            if ($height_option) {
                $section->add_render_attribute( '_wrapper', 'data-mh-equal-height-col', $height_option );

                if (  $settings['mh_section_equal_height_disable_on_tablet'] === 'yes' ) {
                    $section->add_render_attribute( '_wrapper', 'class', 'mh-eqh-disable-on-tablet' );
                }
                if (  $settings['mh_section_equal_height_disable_on_mobile'] === 'yes' ) {
                    $section->add_render_attribute( '_wrapper', 'class', 'mh-eqh-disable-on-mobile' );
                }
            }
        }
    }



    public function other_options_before_render( $section ) {
        $settings = $section->get_settings_for_display();
        if( $settings['mh_four_vertical_line'] == 'yes' ) {
            $section->add_render_attribute( '_wrapper', 'class', 'mh-enable-four-vertical-line' );
        }
        if( $settings['mh_small_vertical_line'] == 'yes' ) {
            $section->add_render_attribute( '_wrapper', 'class', 'mh-one-vertical-line' );
        }
    }
    public function bg_move_effect_options_before_render( $section ) {
        $settings = $section->get_settings_for_display();
        if( $settings['mh_bg_move_effect_enable'] == 'yes' ) {
            $section->add_render_attribute( '_wrapper', 'class', 'mh-enable-bg-move-effect' );
            wp_enqueue_script( 'gsap' );
            wp_enqueue_script( 'gsap-scrolltrigger' );
            wp_enqueue_script( 'mh-gsap-bg-animation' );
        }
    }
}

if ( ! function_exists( 'shadhin_plugins_init_section_handler' ) ) {
    function shadhin_plugins_init_section_handler() {
        Shadhin_plugins_Container_Handler::get_instance();
    }

    // Priority 20 ensures it runs after plugin initialization (priority 5) and theme framework (priority 10)
    add_action( 'init', 'shadhin_plugins_init_section_handler', 20 );
}