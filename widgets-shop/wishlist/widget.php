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
class MH_Elementor_Wishlist extends Widget_Base {
    protected $nav_menu_index = 1;

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		$direction_suffix = is_rtl() ? '.rtl' : '';
        wp_register_style( 'mh-woo-wishlist', SHADHIN_PLUGINS_ASSETS_URI . '/css/woo/wishlist' . $direction_suffix . '.css' );
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
		return 'mh-ele-woo-wishlist';
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
		return esc_html__( 'TM Wishlist', 'shadhin-plugins' );
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
		return [ 'mh-woo-wishlist' ];
	}

    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }

    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }

        return $options;
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
            'wishlist-icon-style',
            [
                'label' => esc_html__('Icon', 'shadhin-plugins'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_account_size',
            [
                'label'     => esc_html__('Size Icon', 'shadhin-plugins'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist .header-wishlist i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Icon Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist .header-wishlist:not(:hover) i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_theme_colored',
            [
                'label' => esc_html__( "Icon Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist .header-wishlist:not(:hover) i' => 'color: var(--theme-color{{VALUE}});'
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__('Icon Color (Hover)', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist:hover .header-wishlist i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_bg_theme_colored_hover',
            [
                'label' => esc_html__( "Icon Theme Colored (Hover)", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist:hover .header-wishlist i' => 'color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'wishlist-count-style',
            [
                'label' => esc_html__('Count', 'shadhin-plugins'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'show_count',
            [
                'label'        => esc_html__('Hide Count', 'shadhin-plugins'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'hide-count-wishlist-'
            ]
        );
        $this->add_control(
            'count_color',
            [
                'label'     => esc_html__('Text Color', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist .header-wishlist .count' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'count_text_theme_colored',
            [
                'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist .header-wishlist .count' => 'color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'count_color_hover',
            [
                'label'     => esc_html__('Text Color (Hover)', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist:hover .header-wishlist .count' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'count_text_theme_colored_hover',
            [
                'label' => esc_html__( "Text Theme Colored (Hover)", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist:hover .header-wishlist .count' => 'color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'count_background_color',
            [
                'label'     => esc_html__('Background', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist .header-wishlist .count' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'count_background_theme_colored',
            [
                'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist .header-wishlist .count' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->add_control(
            'count_background_color_hover',
            [
                'label'     => esc_html__('Background (Hover)', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist:hover .header-wishlist .count' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'count_background_theme_colored_hover',
            [
                'label' => esc_html__( "Background Theme Colored (Hover)", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist:hover .header-wishlist .count' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );
        $this->end_controls_section();



        $this->start_controls_section(
            'wishlist-bg-style',
            [
                'label' => esc_html__('Background', 'shadhin-plugins'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'icon_background_border_radius',
            [
                'label' => esc_html__( "Border Radius", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_responsive_control(
            'icon_bg_size',
            [
                'label'     => esc_html__('Background Size', 'shadhin-plugins'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 20,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .mh-header-wishlist' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_background_theme_colored',
            [
                'label' => esc_html__( "Background Theme Colored", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );

        $this->add_control(
            'icon_background_color_hover',
            [
                'label'     => esc_html__('Background Color (Hover)', 'shadhin-plugins'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_background_theme_colored_hover',
            [
                'label' => esc_html__( "Background Theme Colored (Hover)", 'shadhin-plugins' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => shadhin_plugins_theme_color_list(),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mh-header-wishlist:hover' => 'background-color: var(--theme-color{{VALUE}});'
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_alignment',
            [
                'label' => esc_html__('Cart Alignment', 'shadhin-plugins'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'label_block' => true,
                'options' => [
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
                    '{{WRAPPER}} .site-header-wishlist' => 'text-align: {{VALUE}};'
                ]
            ]
        );
        $this->end_controls_section();

    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'mh-elementor-wishlist-wrapper');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php
            if (function_exists('woosw_init')) {
                $key = \WPCleverWoosw::get_key();
                ?>
                <div class="mh-header-wishlist woosw-check">
                    <a class="header-wishlist" data-toggle="button-side" data-target=".mh-wishlist-side" href="<?php echo esc_url(\WPCleverWoosw::get_url($key, true)); ?>">
                        <i class="lnr lnr-icon-heart"></i>
                        <span class="count"><?php echo esc_html(\WPCleverWoosw::get_count($key)); ?></span>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}