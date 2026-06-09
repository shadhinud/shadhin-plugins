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
class MH_Elementor_Header_Search extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
        wp_enqueue_script('mh-header-search-popup', SHADHIN_PLUGINS_ASSETS_URI . '/js/woo/header-search-popup.js', array('jquery'), SHADHIN_PLUGINS_VERSION, true);
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
		return 'mh-ele-header-search';
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
		return esc_html__( 'Header Search', 'shadhin-plugins' );
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
            'search-form-settings',
            [
                'label' => esc_html__('Settings', 'shadhin-plugins'),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );

        $this->add_control(
            'search_layout',
            [
                'label'   => esc_html__('Layout', 'shadhin-plugins'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Search Form', 'shadhin-plugins'),
                    'form-cat' => esc_html__('Search Form with Category', 'shadhin-plugins'),
                    'icon'    => esc_html__('Icon', 'shadhin-plugins'),
                ],
            ]
        );

        $this->add_control(
            'search_type',
            [
                'label'   => esc_html__('Search Type', 'shadhin-plugins'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default Search', 'shadhin-plugins'),
                    'product' => esc_html__('Product Search', 'shadhin-plugins'),
                ],
                'condition' => [
                    'search_layout!' => array('form-cat')
                ]
            ]
        );

        $this->add_control(
            'search_submit_style',
            [
                'label'   => esc_html__('Submit Button Style', 'shadhin-plugins'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'submit-icon',
                'options' => [
                    'submit-text' => esc_html__('Submit Text', 'shadhin-plugins'),
                    'submit-icon'    => esc_html__('Submit Icon', 'shadhin-plugins'),
                ],
                'prefix_class'	=> 'search-',
                'condition' => [
                    'search_layout!' => array('icon')
                ]
            ]
        );

        $this -> add_responsive_control(
            'search_layout_alignment',
            [
                'label'       => esc_html__( 'Alignment', 'shadhin-plugins' ),
                'type'        => Controls_Manager::CHOOSE,
                'default'     => 'left',
                'options'     => [
                    'left' => [
                        'title' => esc_html__('Left', 'shadhin-plugins'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'shadhin-plugins'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'shadhin-plugins'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'label_block' => false,
                'selectors'   => [
                    '{{WRAPPER}} .mh-widget-search-form' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'search_layout' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'placeholder_text',
            [
                'label' => esc_html__( "Placeholder Text", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( "Search Product...", 'shadhin-plugins' ),
                'condition' => [
                    'search_layout!' => 'icon'
                ]
            ]
        );
        $this->end_controls_section();











        $this->start_controls_section(
            'form_cat_search-form-style',
            [
                'label' => esc_html__('Style Form', 'shadhin-plugins'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                        'search_layout' => 'form-cat'
                ]
            ]
        );
        $this->add_control(
            'border_color_options',
            [
                'label' => esc_html__( 'Border Option', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control(
            'form_cat_border_width',
            [
                'label'      => esc_html__('Border width', 'shadhin-plugins'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .search-form-cat' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'form_cat_border_color',
            [
                'label'     => esc_html__('Border Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .search-form-cat' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'form_cat_icon_color_form',
            [
                'label'     => esc_html__('Color Icon', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button i' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'form_cat_input_field_options',
            [
                'label' => esc_html__( 'Input Field Options', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'form_cat_background_form',
            [
                'label'     => esc_html__('Background', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_cat_input_text_color',
            [
                'label'     => esc_html__('Input Text Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'form_cat_input_placeholder_color',
            [
                'label'     => esc_html__('Placeholder Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );




        $this->add_control(
            'form_cat_submit_button_options',
            [
                'label' => esc_html__( 'Submit Button Options', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'form_cat_submit_button_bg_theme_colored',
            [
                'label' => esc_html__( "Icon BG Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .search-submit' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'form_cat_submit_button_bg_theme_colored_hover',
            [
                'label' => esc_html__( "Icon BG Theme Colored (Hover)", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .search-submit:hover' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'form_cat_submit_button_custom_bg_color',
            [
                'label' => esc_html__( "Icon BG Custom Color", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-submit' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'form_cat_submit_button_custom_bg_color_hover',
            [
                'label' => esc_html__( "Icon BG Custom Color (Hover)", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .search-submit:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );


        $this->add_control(
            'form_cat_submit_icon_options',
            [
                'label' => esc_html__( 'Submit Search Icon Options', 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'form_cat_submit_icon_color',
            [
                'label' => esc_html__( "Search Icon Color", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} form button i' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'form_cat_submit_icon_color_hover',
            [
                'label' => esc_html__( "Search Icon Color (Hover)", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} form button:hover i' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_responsive_control(
            'form_cat_submit_icon_size',
            [
                'label'      => esc_html__('Icon Size', 'shadhin-plugins'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 40,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} form button i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();















        $this->start_controls_section(
            'search-form-style',
            [
                'label' => esc_html__('Style Form', 'shadhin-plugins'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                        'search_layout' => 'default'
                ]
            ]
        );
        $this->add_responsive_control(
            'border_width',
            [
                'label'      => esc_html__('Border width', 'shadhin-plugins'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} form input[type=search]' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'border_radius',
            [
                'label'      => esc_html__('Border Radius', 'shadhin-plugins'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}  form input[type=search]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__('Border Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_form_border_theme_colored',
            [
                'label' => esc_html__( "Border Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'border-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'border_color_focus',
            [
                'label'     => esc_html__('Border Color Focus', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_form_border_theme_colored_focus',
            [
                'label' => esc_html__( "Border Focus Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]:focus' => 'border-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'background_form',
            [
                'label'     => esc_html__('Background Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_form_bg_theme_colored',
            [
                'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'search-form-text-style',
            [
                'label' => esc_html__('Style Form - Input Text', 'shadhin-plugins'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                        'search_layout' => 'default'
                ]
            ]
        );
        $this->add_control(
            'input_text_color',
            [
                'label'     => esc_html__('Input Text Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'input_placeholder_color',
            [
                'label'     => esc_html__('Placeholder Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();



        $this->start_controls_section(
            'search-form-submit-btn-style',
            [
                'label' => esc_html__('Style Form - Submit Button', 'shadhin-plugins'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                        'search_layout' => 'default'
                ]
            ]
        );
        $this->add_responsive_control(
            'form_submit_bg_size',
            [
                'label'     => esc_html__('Submit Button Background Size', 'shadhin-plugins'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 20,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} form button' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_submit_icon_size',
            [
                'label'      => esc_html__('Icon Size', 'shadhin-plugins'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 40,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} form button i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_submit_pos_top',
            [
                'label'     => esc_html__('Position - Top', 'shadhin-plugins'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} form button' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_submit_pos_right',
            [
                'label'     => esc_html__('Position - Right', 'shadhin-plugins'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} form button' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_form',
            [
                'label'     => esc_html__('Color Icon', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_form_hover',
            [
                'label'     => esc_html__('Color Icon (Hover)', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_border_width',
            [
                'label'      => esc_html__('Border width', 'shadhin-plugins'),
                'type'       => Controls_Manager::SLIDER,
                'separator' => 'before',
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} form button' => 'border-width: {{SIZE}}{{UNIT}};border-style: solid;',
                ],
            ]
        );
        $this->add_control(
            'icon_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'shadhin-plugins'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}}  form button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_color',
            [
                'label'     => esc_html__('Border Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_theme_colored',
            [
                'label' => esc_html__( "Border Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form button' => 'border-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'icon_border_color_hover',
            [
                'label'     => esc_html__('Border Color (Hover)', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_border_theme_colored_hover',
            [
                'label' => esc_html__( "Border (Hover) Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover' => 'border-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'icon_background_color',
            [
                'label'     => esc_html__('Background Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_theme_colored',
            [
                'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form button' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'icon_background_color_hover',
            [
                'label'     => esc_html__('Background Color(Hover)', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_theme_colored_hover',
            [
                'label' => esc_html__( "Background Theme Colored(Hover)", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} form button:hover' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->end_controls_section();





        $this->start_controls_section(
            'search-icon-form-style',
            [
                'label' => esc_html__('Style Icon', 'shadhin-plugins'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_layout' => 'icon'
                ]
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Icon Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .icon-search-popup' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__('Color Icon', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .icon-search-popup:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => esc_html__('Icon Size', 'shadhin-plugins'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 40,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .icon-search-popup' => 'font-size: {{SIZE}}{{UNIT}};',
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

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_shop_template_part( 'tpl-search', $settings['search_layout'], 'header-search/tpl', $settings, true );

		echo $html;
	}
}
