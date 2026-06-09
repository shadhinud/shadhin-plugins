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
class TM_Elementor_Site_Logo extends Widget_Base {
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		$direction_suffix = is_rtl() ? '.rtl' : '';
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
		return 'tm-ele-site-logo';
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
		return esc_html__( 'Site Logo', 'shadhin-plugins' );
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
			'logo_type',
			[
				'label' => esc_html__( "Logo Type", 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'logo-default' => esc_html__( 'Logo (Default)', 'shadhin-plugins' ),
					'logo-white' => esc_html__( 'Logo (White) For Dark Background', 'shadhin-plugins' ),
				],
				'default' => 'logo-default'
			]
		);
		$this->add_responsive_control(
			'site_logo_alignment',
			[
				'label' => esc_html__( "Logo Alignment", 'shadhin-plugins' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => shadhin_plugins_text_align_choose(),
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				]
			]
		);
		$this->add_responsive_control(
			'width',
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
					'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => esc_html__( 'Max Width', 'shadhin-plugins' ),
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
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
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
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'logo_margin',
			[
				'label' => esc_html__( 'Logo Margin', 'shadhin-plugins' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'header#header {{WRAPPER}} .menuzord-brand' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'logo_filter_options',
			[
				'label' => esc_html__( 'Logo Filter Options', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);


		$this->start_controls_tabs('tabs_current_theme_styling');
		$this->start_controls_tab(
			'tabs_current_theme_styling_normal',
			[
				'label' => esc_html__('Normal', 'shadhin-plugins'),
			]
		);


		$this->add_control(
			'logo_filter_white',
			[
				'label' => esc_html__( 'Filter Logo to White', 'shadhin-plugins' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} img.logo-default' => 'filter:brightness(0) invert(1);',
				],
			]
		);
		$this->add_control(
			'logo_filter_black',
			[
				'label' => esc_html__( 'Filter Logo to Black', 'shadhin-plugins' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} img.logo-default' => 'filter:brightness(0) invert(0);',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_current_theme_styling_hover',
			[
				'label' => esc_html__('Hover', 'shadhin-plugins'),
			]
		);


		$this->add_control(
			'logo_filter_white_hover',
			[
				'label' => esc_html__( 'Filter Logo to White (Hover)', 'shadhin-plugins' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} img.logo-default:hover' => 'filter:brightness(0) invert(1);',
				],
			]
		);


		$this->add_control(
			'logo_filter_black_hover',
			[
				'label' => esc_html__( 'Filter Logo to Black (Hover)', 'shadhin-plugins' ),
				'type' => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} img.logo-default:hover' => 'filter:brightness(0) invert(0);',
				],
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
		// do_action( 'shadhin_header_logo' );

		$logo_url = array();

		$use_logo = shadhin_get_redux_option( 'logo-settings-want-to-use-logo', false );
		$site_brand = esc_html( shadhin_get_redux_option( 'logo-settings-site-brand', get_bloginfo( 'name' ) ) );
		$use_switchable_logo = shadhin_get_redux_option( 'logo-settings-switchable-logo' );

		if ( $settings['logo_type'] == 'logo-default' ) {
			$logo_default = shadhin_get_redux_option( 'logo-settings-logo-default' );
		} else {
			$logo_default = shadhin_get_redux_option( 'logo-settings-logo-default-dark-bg' );
		}

		if( $use_switchable_logo ) {
			$logo_light = esc_url( shadhin_get_redux_option( 'logo-settings-logo-primary', false, 'url' ) );
			$logo_dark = esc_url( shadhin_get_redux_option( 'logo-settings-logo-on-sticky', false, 'url' ) );
		}

		?>
		<a class="menuzord-brand site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if( !$use_logo ): ?>
			<?php echo esc_html( $site_brand ); ?>
			<?php elseif( isset( $logo_default['url'] ) ): ?>
				<?php if( !$use_switchable_logo ): ?>
				<img class="logo-default" src="<?php echo esc_url( $logo_default['url'] ); ?>" <?php if( isset( $logo_default['height'] ) ) { ?> width="<?php echo esc_attr( $logo_default['width'] ); ?>" height="<?php echo esc_attr( $logo_default['height'] ); ?>" <?php } ?> alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php else: ?>
				<img class="logo-primary" src="<?php echo esc_url( $logo_light ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<img class="logo-on-sticky" src="<?php echo esc_url( $logo_dark ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php endif; ?>
			<?php endif; ?>
		</a>
		<?php
	}
}
