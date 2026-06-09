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
class TM_Elementor_Circle_Text extends Widget_Base {
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        $direction_suffix = is_rtl() ? '.rtl' : '';

        wp_register_style( 'tm-circle-text', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/circle-text' . $direction_suffix . '.css' );
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
		return 'tm-ele-circle-text';
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
		return esc_html__( 'TM - Circle Text', 'shadhin-plugins' );
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

	public function get_style_depends() {
		return [ 'tm-circle-text' ];
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
			'circle_text_title',
			[
				'label' => esc_html__( "Circle Text", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( "Welcome to our website", 'shadhin-plugins' ),
			]
		);
		$this->add_control(
			'center_content_type',
			[
				'label' => esc_html__( "Center Content Type", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'text' => esc_html__( 'Inner Text', 'shadhin-plugins' ),
					'video' => esc_html__( 'Video Popup', 'shadhin-plugins' ),
					'icon' => esc_html__( 'Icon', 'shadhin-plugins' ),
					'image' => esc_html__( 'Image', 'shadhin-plugins' ),
				],
			]
		);
		$this->add_control(
			'inner_text',
			[
				'label' => esc_html__( "Inner Text", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'center_content_type' => 'text',
				],
			]
		);
		$this->add_control(
			'popup_video_url',
			[
				'label' => esc_html__( "Play Video URL", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_url( 'https://www.youtube.com/watch?v=K1QICrgxTjA', 'shadhin-plugins' ),
				'condition' => [
					'center_content_type' => 'video',
				],
			]
		);
		$this->add_control(
			'icon',
			[
				'label' => __('Icon', 'shadhin-plugins'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-google-play',
					'library' => 'font-awesome',
				],
				'condition' => [
					'center_content_type' => 'icon',
				],
			]
		);
		$this->add_control(
			'thumb_image',
			[
				'label' => esc_html__( "Thumbnail Image", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				"description" => esc_html__( "Upload the center thumbnail image", 'shadhin-plugins' ),
				'condition' => [
					'center_content_type' => 'image',
				],
			]
		);
		$this->add_responsive_control(
			'svg_width',
			[
				'label' => esc_html__( 'Box Width', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();









		$this->start_controls_section(
			'circle_text_section',
			[
				'label' => esc_html__( 'Circle Text Options', 'shadhin-plugins' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs('circle_text_options_tabs');
		$this->start_controls_tab(
			'circle_text_options_tab_default',
			[
				'label' => esc_html__('Default', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'circle_text_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} text' => 'fill: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'circle_text_theme_colored',
			[
				'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} text' => 'fill: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'circle_text_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} text',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'circle_text_options_tab_hover',
			[
				'label' => esc_html__('Hover', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'circle_text_text_color_hover',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover text' => 'fill: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'circle_text_theme_colored_hover',
			[
				'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover text' => 'fill: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'circle_text_typography_hover',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}}:hover text',
			]
		);
	$this->end_controls_tab();
	$this->end_controls_tabs();
	$this->end_controls_section();





	$this->start_controls_section(
		'inner_text_section',
		[
			'label' => esc_html__( 'Inner Text Options', 'shadhin-plugins' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [
				'center_content_type' => 'text',
			],
		]
	);
	$this->start_controls_tabs('inner_text_options_tabs');
	$this->start_controls_tab(
		'inner_text_options_tab_default',
		[
			'label' => esc_html__('Default', 'shadhin-plugins'),
		]
	);
	$this->add_control(
		'inner_text_color',
		[
			'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .inner-text' => 'color: {{VALUE}};'
			]
		]
	);
	$this->add_control(
		'inner_text_theme_colored',
		[
			'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'options' => shadhin_plugins_theme_color_list(),
			'default' => '',
			'selectors' => [
				'{{WRAPPER}} .inner-text' => 'color: var(--theme-color{{VALUE}});'
			],
		]
	);
	$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name' => 'inner_text_typography',
			'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
			'selector' => '{{WRAPPER}} .inner-text',
		]
	);
	$this->end_controls_tab();
	$this->start_controls_tab(
		'inner_text_options_tab_hover',
		[
			'label' => esc_html__('Hover', 'shadhin-plugins'),
		]
	);
	$this->add_control(
		'inner_text_color_hover',
		[
			'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}}:hover .inner-text' => 'color: {{VALUE}};'
			]
		]
	);
	$this->add_control(
		'inner_text_theme_colored_hover',
		[
			'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'options' => shadhin_plugins_theme_color_list(),
			'default' => '',
			'selectors' => [
				'{{WRAPPER}}:hover .inner-text' => 'color: var(--theme-color{{VALUE}});'
			],
		]
	);
	$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name' => 'inner_text_typography_hover',
			'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
			'selector' => '{{WRAPPER}}:hover .inner-text',
		]
	);
	$this->end_controls_tab();
	$this->end_controls_tabs();
	$this->end_controls_section();





	$this->start_controls_section(
		'video_icon_section',
		[
			'label' => esc_html__( 'Video Icon Options', 'shadhin-plugins' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [
				'center_content_type' => 'video',
			],
		]
	);
	$this->start_controls_tabs('video_icon_options_tabs');
	$this->start_controls_tab(
		'video_icon_options_tab_default',
		[
			'label' => esc_html__('Default', 'shadhin-plugins'),
		]
	);
	$this->add_control(
		'video_icon_color',
		[
			'label' => esc_html__( "Icon Color", 'shadhin-plugins' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .video-popup-link i, {{WRAPPER}} .lightgallery-trigger i' => 'color: {{VALUE}};'
			]
		]
	);
	$this->add_control(
		'video_icon_theme_colored',
		[
			'label' => esc_html__( "Icon Theme Colored", 'shadhin-plugins' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'options' => shadhin_plugins_theme_color_list(),
			'default' => '',
			'selectors' => [
				'{{WRAPPER}} .video-popup-link i, {{WRAPPER}} .lightgallery-trigger i' => 'color: var(--theme-color{{VALUE}});'
			],
		]
	);
	$this->add_responsive_control(
		'video_icon_size',
		[
			'label' => esc_html__( 'Icon Size', 'shadhin-plugins' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range' => [
				'px' => [
					'min' => 10,
					'max' => 200,
					'step' => 1,
				],
				'em' => [
					'min' => 1,
					'max' => 10,
					'step' => 0.1,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 36,
			],
			'selectors' => [
				'{{WRAPPER}} .video-popup-link i, {{WRAPPER}} .lightgallery-trigger i' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]
	);
	$this->end_controls_tab();
	$this->start_controls_tab(
		'video_icon_options_tab_hover',
		[
			'label' => esc_html__('Hover', 'shadhin-plugins'),
		]
	);
	$this->add_control(
		'video_icon_color_hover',
		[
			'label' => esc_html__( "Icon Color", 'shadhin-plugins' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .video-popup-link:hover i, {{WRAPPER}} .lightgallery-trigger:hover i' => 'color: {{VALUE}};'
			]
		]
	);
	$this->add_control(
		'video_icon_theme_colored_hover',
		[
			'label' => esc_html__( "Icon Theme Colored", 'shadhin-plugins' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'options' => shadhin_plugins_theme_color_list(),
			'default' => '',
			'selectors' => [
				'{{WRAPPER}} .video-popup-link:hover i, {{WRAPPER}} .lightgallery-trigger:hover i' => 'color: var(--theme-color{{VALUE}});'
			],
		]
	);
	$this->add_responsive_control(
		'video_icon_size_hover',
		[
			'label' => esc_html__( 'Icon Size', 'shadhin-plugins' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range' => [
				'px' => [
					'min' => 10,
					'max' => 200,
					'step' => 1,
				],
				'em' => [
					'min' => 1,
					'max' => 10,
					'step' => 0.1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .video-popup-link:hover i, {{WRAPPER}} .lightgallery-trigger:hover i' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]
	);
	$this->end_controls_tab();
	$this->end_controls_tabs();
	$this->end_controls_section();





	$this->start_controls_section(
		'icon_section',
		[
			'label' => esc_html__( 'Icon Options', 'shadhin-plugins' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [
				'center_content_type' => 'icon',
			],
		]
	);
		$this->start_controls_tabs('icon_options_tabs');
		$this->start_controls_tab(
			'icon_options_tab_default',
			[
				'label' => esc_html__('Default', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'icon_text_color',
			[
				'label' => esc_html__( "Icon Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .icon i' => 'color: {{VALUE}};'
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
					'{{WRAPPER}} .icon i' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .icon i',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'icon_options_tab_hover',
			[
				'label' => esc_html__('Hover', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'icon_text_color_hover',
			[
				'label' => esc_html__( "Icon Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .icon i' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'icon_theme_colored_hover',
			[
				'label' => esc_html__( "Icon Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .icon i' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography_hover',
				'label' => esc_html__( 'Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}}:hover .icon i',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'rotate',
			[
				'label' => esc_html__( 'Rotate', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 0,
				],
				'range' => [
					'deg' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .icon i, {{WRAPPER}} .icon img' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_section();




	$this->start_controls_section(
		'img_options',
		[
			'label' => esc_html__( 'Image Options', 'shadhin-plugins' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [
				'center_content_type' => 'image',
			],
		]
	);
		$this->add_responsive_control(
			'img_width',
			[
				'label' => esc_html__( 'Width', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'img_height',
			[
				'label' => esc_html__( 'Height', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'img_object_fit',
			[
				'label' => esc_html__( 'Object Fit', 'shadhin-plugins' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'fill' => esc_html__( 'Fill', 'shadhin-plugins' ),
					'contain' => esc_html__( 'Contain', 'shadhin-plugins' ),
					'cover' => esc_html__( 'Cover', 'shadhin-plugins' ),
					'none' => esc_html__( 'None', 'shadhin-plugins' ),
					'scale-down' => esc_html__( 'Scale Down', 'shadhin-plugins' ),
				],
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text img' => 'object-fit: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'img_object_position',
			[
				'label' => esc_html__( 'Object Position', 'shadhin-plugins' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'center center' => esc_html__( 'Center Center', 'shadhin-plugins' ),
					'center left' => esc_html__( 'Center Left', 'shadhin-plugins' ),
					'center right' => esc_html__( 'Center Right', 'shadhin-plugins' ),
					'top center' => esc_html__( 'Top Center', 'shadhin-plugins' ),
					'top left' => esc_html__( 'Top Left', 'shadhin-plugins' ),
					'top right' => esc_html__( 'Top Right', 'shadhin-plugins' ),
					'bottom center' => esc_html__( 'Bottom Center', 'shadhin-plugins' ),
					'bottom left' => esc_html__( 'Bottom Left', 'shadhin-plugins' ),
					'bottom right' => esc_html__( 'Bottom Right', 'shadhin-plugins' ),
				],
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text img' => 'object-position: {{VALUE}};',
				],
				'condition' => [
					'img_object_fit!' => 'fill',
				],
			]
		);
		$this->end_controls_section();






		$this->start_controls_section(
			'icon_bg_options',
			[
				'label' => esc_html__( 'Icon Background Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => esc_html__( 'Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label' => esc_html__( "Border Radius", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'icon_bg_size',
			[
				'label' => esc_html__( 'Size (Width & Height)', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs('icon_option_tabs');
		$this->start_controls_tab(
			'icon_option_tab_default',
			[
				'label' => esc_html__('Default', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'icon_bg_color',
			[
				'label' => esc_html__( "Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .icon' => 'background-color: {{VALUE}};'
				]
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
					'{{WRAPPER}} .icon' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .icon',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .icon',
			]
		);
		$this->add_responsive_control(
			'icon_bg_blur',
			[
				'label' => esc_html__( 'Background Blur', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .icon' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'icon_option_tab_hover',
			[
				'label' => esc_html__('Hover', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'icon_bg_color_hover',
			[
				'label' => esc_html__( "Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .icon' => 'background-color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'icon_bg_theme_colored_hover',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .icon' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_border_hover',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}}:hover .icon',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_box_shadow_hover',
				'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}}:hover .icon',
			]
		);
		$this->add_responsive_control(
			'icon_bg_blur_hover',
			[
				'label' => esc_html__( 'Background Blur', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .icon' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();





		$this->start_controls_section(
			'wrapper_bg_options',
			[
				'label' => esc_html__( 'Wrapper Background Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label' => esc_html__( 'Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'wrapper_border_radius',
			[
				'label' => esc_html__( "Border Radius", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->start_controls_tabs('wrapper_option_tabs');
		$this->start_controls_tab(
			'wrapper_option_tab_default',
			[
				'label' => esc_html__('Default', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'wrapper_bg_color',
			[
				'label' => esc_html__( "Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text' => 'background-color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'wrapper_bg_theme_colored',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'wrapper_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .tm-circle-text',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wrapper_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .tm-circle-text',
			]
		);
		$this->add_responsive_control(
			'wrapper_bg_blur',
			[
				'label' => esc_html__( 'Background Blur', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .tm-circle-text' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'wrapper_option_tab_hover',
			[
				'label' => esc_html__('Hover', 'shadhin-plugins'),
			]
		);
		$this->add_control(
			'wrapper_bg_color_hover',
			[
				'label' => esc_html__( "Background Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .tm-circle-text' => 'background-color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'wrapper_bg_theme_colored_hover',
			[
				'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .tm-circle-text' => 'background-color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'wrapper_border_hover',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}}:hover .tm-circle-text',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'wrapper_box_shadow_hover',
				'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
				'separator' => 'before',
				'selector' => '{{WRAPPER}}:hover .tm-circle-text',
			]
		);
		$this->add_responsive_control(
			'wrapper_bg_blur_hover',
			[
				'label' => esc_html__( 'Background Blur', 'shadhin-plugins' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .tm-circle-text' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
				'separator' => 'before',
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

		$html = shadhin_plugins_get_shortcode_template_part( 'circle-text', null, 'circle-text/tpl', $settings, true );

		echo $html;
	}
}


