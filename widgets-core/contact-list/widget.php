<?php
namespace Shadhinplugins\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class MH_Elementor_Contact_List extends Widget_Base {
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        $direction_suffix = is_rtl() ? '.rtl' : '';

        wp_register_style( 'mh-contact-list-style', SHADHIN_PLUGINS_ASSETS_URI . '/css/widgets-core/contact-list' . $direction_suffix . '.css' );
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
		return 'mh-ele-contact-list';
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
		return esc_html__( 'Contact List Widget', 'shadhin-plugins' );
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
		return [ 'mh-contact-list-style' ];
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
			'custom_css_class',
			[
				'label' => esc_html__( "Custom CSS class", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
        $this->add_control(
            'design_style',
            [
                'label' => esc_html__( "Design Style", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'flat' => esc_html__( 'Flat', 'shadhin-plugins' ),
                    'round' => esc_html__( 'Round Background', 'shadhin-plugins' ),
                ],
                'default' => 'flat'
            ]
        );
		$this->add_control(
			'label_disply_type',
			[
				'label' => esc_html__('Parent Display Property', 'shadhin-plugins'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex',
				'options' => shadhin_plugins_disply_type_list_elementor(),
				'selectors' => [
						'{{WRAPPER}} .mh-contact-list li' => 'display: {{UNIT}}',
				],
			]
		);
		$this->add_control(
			'label_disply_type_child',
			[
				'label' => esc_html__('Childs Display Property', 'shadhin-plugins'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'flex',
				'options' => shadhin_plugins_disply_type_list_elementor(),
				'selectors' => [
						'{{WRAPPER}} .mh-contact-list li > *' => 'display: {{UNIT}}',
				],
			]
		);






		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'prefix',
			[
				'label' => esc_html__( "Prefix", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( "Text", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'title_tag',
			[
				'label' => esc_html__( "Text Tag", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_heading_tag_list(),
				'default' => 'div'
			]
		);
		$repeater->add_control(
			'link_url',
			[
				'label' => esc_html__( "Link URL", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::URL,
				'condition' => [
					'title_tag' => 'a'
				]
			]
		);
		$repeater->add_control(
			'icon_type',
			[
				'label' => esc_html__( "Icon Type", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'font-icon'
			]
		);
		$repeater->add_control(
			'icon',
			[
				'label' => __('Icon', 'shadhin-plugins'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-envelope',
					'library' => 'font-awesome',
				],
				'condition' => [
					'icon_type' => array('font-icon')
				]
			]
		);
		$this->add_control(
			'info_items',
			[
				'label' => esc_html__( "Info Items", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => esc_html__( "+1234567789", 'shadhin-plugins' ),
					],
					[
						'title' => esc_html__( "needhelp@company.com", 'shadhin-plugins' ),
					],
				]
			]
		);
		$this->end_controls_section();






		$this->start_controls_section(
			'text_options',
			[
				'label' => esc_html__( 'Text Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => esc_html__( 'Text Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-contact-list li > *',
			]
		);
		$this->add_control(
			'text_text_color',
			[
				'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li > *' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'text_theme_colored',
			[
				'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li > *' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_responsive_control(
			'text_margin',
			[
				'label' => esc_html__( 'Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .text > *' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();










		$this->start_controls_section(
			'icon_options',
			[
				'label' => esc_html__( 'Icon Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'icon_hide',
			[
				'label' => esc_html__( "Hide Icon?", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .icon' => 'display: none;',
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'label' => esc_html__( 'Icon Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-contact-list li .icon, {{WRAPPER}} .mh-contact-list li .icon svg',
			]
		);
		$this->add_control(
			'icon_margin',
			[
				'label' => esc_html__( 'Icon Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_area_width',
			[
				'label' => esc_html__( "Icon Container Width", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};flex-basis: {{SIZE}}{{UNIT}};',
				]
			]
		);


        $this->start_controls_tabs( 'tabs_icon_style' );
        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => esc_html__( 'Normal', 'shadhin-plugins' ),
            ]
        );
        $this->add_control(
            'icon_bacground',
            [
                'label'     => esc_html__( 'Background Color', 'shadhin-plugins' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mh-contact-list li .icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bacground_theme_color',
            [
                'label' => esc_html__('Background Theme Color', 'shadhin-plugins'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-contact-list li .icon' => 'background-color: var(--theme-color{{VALUE}})',
                ],
            ]
        );
		$this->add_control(
			'icon_text_color',
			[
				'label' => esc_html__( "Icon Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mh-contact-list li .icon svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .mh-contact-list li .icon' => 'color: var(--theme-color{{VALUE}});',
					'{{WRAPPER}} .mh-contact-list li .icon svg' => 'fill: var(--theme-color{{VALUE}});',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_area_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-contact-list li .icon',
			]
		);
		$this->add_responsive_control(
			'icon_area_border_radius',
			[
				'label' => esc_html__( "Border Radius", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
        $this->end_controls_tab();



        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => esc_html__( 'Hover', 'shadhin-plugins' ),
            ]
        );
        $this->add_control(
            'icon_bacground_hover',
            [
                'label'     => esc_html__( 'Background Color', 'shadhin-plugins' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mh-contact-list li:hover .icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bacground_theme_color_hover',
            [
                'label' => esc_html__('Background Theme Color', 'shadhin-plugins'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-contact-list li:hover .icon' => 'background-color: var(--theme-color{{VALUE}})',
                ],
            ]
        );
		$this->add_control(
			'icon_text_color_hover',
			[
				'label' => esc_html__( "Icon Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li:hover .icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mh-contact-list li:hover .icon svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .mh-contact-list li:hover .icon' => 'color: var(--theme-color{{VALUE}});',
					'{{WRAPPER}} .mh-contact-list li:hover .icon svg' => 'fill: var(--theme-color{{VALUE}});',
				],
			]
		);
        $this->add_control(
            'icon_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'shadhin-plugins' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mh-contact-list li:hover .icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
		$this->end_controls_section();





		$this->start_controls_section(
			'prefix_options',
			[
				'label' => esc_html__( 'Prefix Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'prefix_hide',
			[
				'label' => esc_html__( "Hide Prefix?", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .prefix' => 'display: none;',
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'prefix_typography',
				'label' => esc_html__( 'Prefix Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-contact-list li .prefix',
			]
		);
		$this->add_control(
			'prefix_color',
			[
				'label' => esc_html__( "Prefix Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .prefix' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'prefix_theme_colored',
			[
				'label' => esc_html__( "Prefix Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .prefix' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'prefix_margin',
			[
				'label' => esc_html__( 'Prefix Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li .prefix' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();





		$this->start_controls_section(
			'link_options',
			[
				'label' => esc_html__( 'Link Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'label' => esc_html__( 'Link Typography', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-contact-list li a',
			]
		);
		$this->add_control(
			'link_text_color',
			[
				'label' => esc_html__( "Link Color", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li a' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'link_text_color_hover',
			[
				'label' => esc_html__( "Link Color (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li a:hover' => 'color: {{VALUE}};'
				]
			]
		);
		$this->add_control(
			'link_theme_colored',
			[
				'label' => esc_html__( "Link Theme Colored", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li a' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->add_control(
			'link_theme_colored_hover',
			[
				'label' => esc_html__( "Link Theme Colored (Hover)", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => shadhin_plugins_theme_color_list(),
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li a:hover' => 'color: var(--theme-color{{VALUE}});'
				],
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'list_item_options',
			[
				'label' => esc_html__( 'Item Styling Options', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__( "Alignment", 'shadhin-plugins' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => shadhin_plugins_text_align_choose(),
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};'
				]
			]
		);
		$this->add_responsive_control(
			'list_item_margin',
			[
				'label' => esc_html__( 'Item Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'list_item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'list_item_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-contact-list li',
			]
		);
		$this->end_controls_section();








		$this->start_controls_section(
			'last_item_options',
			[
				'label' => esc_html__( 'Last Child Styling', 'shadhin-plugins' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'last_item_margin',
			[
				'label' => esc_html__( 'Item Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li:last-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'last_item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .mh-contact-list li:last-child' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'last_item_border',
				'label' => esc_html__( 'Border', 'shadhin-plugins' ),
				'selector' => '{{WRAPPER}} .mh-contact-list li:last-child',
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
		$html = '';
		//classes
		$classes = array();
		$classes[] = 'mh-contact-list';
		$classes[] = $settings['custom_css_class'];
        if( $settings['design_style'] ) {
            $classes[] = 'contact-list-' . $settings['design_style'];
        }
		$settings['classes'] = $classes;
	?>
		<div class="<?php if( !empty($classes) ) echo esc_attr(implode(' ', $classes)); ?>">
			<ul>
	<?php
		if ( $settings['info_items'] ) {
			$settings['iter'] = 1;
			foreach (  $settings['info_items'] as $item ) {

				//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
				$html .= shadhin_plugins_get_widgetcore_template_part( 'contact-list', null, 'contact-list/tpl', $item, true );
			}
		}
		echo $html;
	?>    </ul>
		</div>
	<?php
	}
}