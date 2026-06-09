<?php
namespace Shadhinplugins;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;
	public $widgets = array();
	public $widgets_shop = array();
	public $widgets_core = array();
	public $woocommerce_status = false;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		if( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			wp_enqueue_script( 'swiper' );
			wp_enqueue_style( 'swiper' );
		}
		wp_register_script( 'mascot-core-hellojs', plugins_url( '/assets/js/elementor-mhshadhin.js', __FILE__ ), [ 'jquery' ], false, true );
	}

	public function widget_styles() {
		wp_enqueue_style( 'mascot-core-elementor-css', plugins_url( '/assets/css/elementor-mhshadhin.css', __FILE__ ) );
	}

	public function widget_styles_frontend() {
		$direction_suffix = is_rtl() ? '.rtl' : '';
		wp_enqueue_style( 'mh-header-search', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/header-search' . $direction_suffix . '.css' );
		wp_enqueue_style( 'mascot-core-widgets-style', SHADHIN_PLUGINS_ASSETS_URI . '/css/widgets-core/mhshadhin-core-widgets-style' . $direction_suffix . '.css' );
	}


	public function woocommerce_status() {

		if ( class_exists( 'WooCommerce' ) ) {
			$this->woocommerce_status = true;
		}

		return $this->woocommerce_status;
	}


	// collected from mascot-core
	public function widgets_core_list() {
		$this->widgets_core = array_merge(
			$this->widgets_core, array(
				'accordion',
				'animated-layers',
				'bg-angle-left-right',
				'blank-box',
				'button',
				'clients-logo',
				'contact-form-7',
				'contact-list',
				'floating-objects',
				'funfact-counter',
				'header-top-info',
				'icon-box',
				'image-background-text-effect',
				'image-with-rotated-text',
				'info-box',
				'list',
				'navigation-menu',
				'newsletter',
				'paroller-animation',
				'pie-chart',
				'progress-bar',
				'rotated-text',
				'section-title',
				'social-links',
				'tabs',
				'text-editor',
				'text-editor-advanced',
				'unordered-list',
				'vertical-bg-img-list',
				'video-popup'
			)
		);
		return $this->widgets_core;
	}
	//widgets core
	private function include_widgets_core_files() {
		foreach( $this->widgets_core_list() as $widget ) {
			require_once( __DIR__ . '/widgets-core/'. $widget .'/widget.php' );

			foreach( glob( __DIR__ . '/widgets-core/'. $widget .'/skins/*.php') as $filepath ) {
				include $filepath;
			}
		}
	}



	public function widgets_list() {
		$this->widgets = array(
			'hero-slider',
			'circle-text',
			'blog-list',
			'before-after-slider',
			'theme-button',
			'award-block',
			'skill-block',
			'features-block',
			'pricing-block',
			'working-block',
			'service-block',
			'showcase-block',
			'team-block',
			'testimonial-block',
			'counter-block',
			'countdown-timer',
			'header-primary-nav',
			'header-nav-side-icons',
			'page-title',
			'image-gallery',
			'pricing-plan',
			'pricing-plan-switcher',
			'site-logo',
			'app-button',
			'spin-text-around-logo',
			'moving-text-repeater',
			'interactive-list',
			'interactive-tabs-title',
			'interactive-tabs-content',
			'swiper-carousel-arrow',
			'projects-pre-next',
			'vertical-image-slider'
		);


		return $this->widgets;
	}


	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		foreach( $this->widgets_list() as $widget ) {
			require_once( __DIR__ . '/widgets/'. $widget .'/widget.php' );

			foreach( glob( __DIR__ . '/widgets/'. $widget .'/skins/*.php') as $filepath ) {
				include $filepath;
			}
		}
	}
	private function include_widgets_files_cpt() {
		//cpt
		require_once( __DIR__ . '/cpt/projects/loader.php' );
		require_once( __DIR__ . '/cpt/blog/widget.php' );

		$cpt_list = array(
			'projects',
			'blog',
		);

		foreach( $cpt_list as $cpt ) {
			foreach( glob( __DIR__ . '/cpt/'. $cpt .'/skins/*.php') as $filepath ) {
				include $filepath;
			}
		}
	}
	private function include_widgets_files_current_theme() {
	}


	//shop
	public function widgets_list_shop() {
		// woocommerce_status.
		if ( $this->woocommerce_status() ) {
			$this->widgets_shop = array_merge(
				$this->widgets_shop, array(
					'header-cart',
					'header-search',
					'info-banner',
					'wc-products',
					'product-category',
					'product-list',
					'vertical-menu',
					'wishlist',
					'product-tabs'
				)
			);
		}
		return $this->widgets_shop;
	}

	private function include_widgets_files_shop() {
		foreach( $this->widgets_list_shop() as $widget ) {
			require_once( __DIR__ . '/widgets-shop/'. $widget .'/widget.php' );

			foreach( glob( __DIR__ . '/widgets-shop/'. $widget .'/skins/*.php') as $filepath ) {
				include $filepath;
			}
		}
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();
		$this->include_widgets_files_cpt();
		$this->include_widgets_files_current_theme();

		// WooCommerce.
		$this->include_widgets_files_shop();

		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\HeroSlider\MH_Elementor_HeroSlider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Circle_Text() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Blog_List() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Before_After_Slider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\ThemeButton\MH_Elementor_Theme_Button() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\AwardBlock\MH_Elementor_AwardBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\SkillBlock\MH_Elementor_SkillBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\FeaturesBlock\MH_Elementor_FeaturesBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\ServiceBlock\MH_Elementor_ServiceBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\PricingBlock\MH_Elementor_PricingBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\ShowcaseBlock\MH_Elementor_ShowcaseBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\WorkingBlock\MH_Elementor_WorkingBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\ImageGallery\MH_Elementor_Image_Gallery() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TeamBlock\MH_Elementor_TeamBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TestimonialBlock\MH_Elementor_TestimonialBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\CounterBlock\MH_Elementor_CounterBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\CountdownTimer\MH_Elementor_Countdown_Timer() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Page_Title() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Site_Logo() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Top_Primary_Nav() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Header_Nav_Side_Icons() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_App_Button() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\InteractiveList\MH_Elementor_InteractiveList() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MovingTextRepeater\MH_Elementor_MovingTextRepeater() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Spin_Text_Around_Logo() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\InteractiveTabs\MH_Elementor_InteractiveTabsTitle() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\InteractiveTabs\MH_Elementor_InteractiveTabsContent() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\PricingPlan\MH_Elementor_Pricing_Plan() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\PricingPlanSwitcher\MH_Elementor_Pricing_Plan_Switcher() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Swiper_Carousel_Arrow() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Projects_Pre_Next() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\VerticalImageSlider\MH_Elementor_Vertical_Image_Slider() );




		//Collected from mascot-core
		$this->include_widgets_core_files();

		//shortcodes
		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Accordion\MH_Elementor_Accordion() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Animated_Layers() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_BG_Aangle_Left_Right() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Blank_Box() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Button() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Clients_logo() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Contact_Form_7() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Contact_List() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Floating_Objects() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Funfact_Counter() );
		//header shortcodes
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Header_Top_Info() );

		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Iconbox() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Image_Background_Text_Effect() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Image_With_Rotated_Text() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\InfoBox\MH_Elementor_InfoBox() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_List() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Navigation_Menu() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Newsletter() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Paroller_Animation() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Pie_Chart() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Progress_Bar() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Rotated_Text() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Section_Title() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Social_Links() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Tabs\MH_Elementor_Tabs() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_TextEditor() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_TextEditorAdvanced() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Unordered_List() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\VerticalBgImgList\MH_Elementor_Vertical_Bg_Img_List() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\VideoPopup\MH_Elementor_Video_Popup() );


		//cpt
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Projects\MH_Elementor_Projects() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Blog\MH_Elementor_Blog() );

		//Shop Widgets
		if ( $this->woocommerce_status() ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Header_Cart() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Header_Search() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Products\MH_Elementor_WC_Products() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_InfoBanner() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Products_Category\MH_Elementor_Products_Category() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Product_List\MH_Elementor_Product_List() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Product_Tabs() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Vertical_Menu() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MH_Elementor_Wishlist() );
		}

	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'widget_styles' ] );

		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'widget_styles_frontend' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'widget_styles_frontend' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}
}

// Instantiate Plugin Class
Plugin::instance();

//elementor elements
require_once( __DIR__ . '/elementor-elements/loader.php' );
