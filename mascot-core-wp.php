<?php
/**
 *
Plugin Name: Mascot Core - Shadhin
Plugin URI:  https://themeforest.net/user/thememascot/portfolio
Description: Mascot Core Plugin for Elementor. It includes all the required Shortcodes needed by Elementor.
Version:     2.0
Author:      ThemeMascot
Author URI:  https://themeforest.net/user/thememascot/portfolio
Text Domain: shadhin-plugins
Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Mascot Core - Shadhin Elementor Class
 *
 * The init class that runs the Hello World plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.0.0
 */
final class Shadhin_plugins_Elementor {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		if ( !defined('ELEMENTOR_VERSION') ) {
			return; // Exit if accessed directly.
		}
		define( 'SHADHIN_PLUGINS_VERSION', '1' );
		define( 'SHADHIN_PLUGINS_ABS_PATH', plugin_dir_path( __FILE__ ) );
		define( 'SHADHIN_PLUGINS_URI', plugin_dir_url( __FILE__ ) );
		define( 'SHADHIN_PLUGINS_ASSETS_URI', SHADHIN_PLUGINS_URI. 'assets' );
		if ( ! defined( 'TM_ELEMENTOR_WIDGET_BADGE' ) ) {
			define( 'TM_ELEMENTOR_WIDGET_BADGE', '<span class="tm-elementor-widget-badge"></span>' );
		}//Add prefix for all widgets

		// Load translation
		add_action( 'init', array( $this, 'i18n' ), 1 );

		// Init Plugin - must run after i18n to avoid translation warnings in WP 6.7.0+
		// Priority 5 ensures plugin loads before theme framework (priority 10)
		add_action( 'init', array( $this, 'init' ), 5 );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enque_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enque_scripts' ) );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook with priority 1 (early).
	 * Must run before init() method to avoid translation warnings in WP 6.7.0+
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'shadhin-plugins', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		//update elementor default value
		if(empty(get_option('elementor_allow_svg', ''))) update_option( 'elementor_allow_svg', 1 );
		if(empty(get_option('elementor_load_fa4_shim', ''))) update_option( 'elementor_load_fa4_shim', 'yes' );
		if(empty(get_option('elementor_disable_color_schemes', ''))) update_option( 'elementor_disable_color_schemes', 'yes' );
		if(empty(get_option('elementor_disable_typography_schemes', ''))) update_option( 'elementor_disable_typography_schemes', 'yes' );

		// Check for required Elementor version
		if ( defined('ELEMENTOR_VERSION') && ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}


        // load icons
        add_filter('elementor/icons_manager/additional_tabs', array($this, 'add_elementor_custom_icons'));


		/* Custom Nav Walker menu icon
		================================================== */
		// require_once( 'assets/flaticon-set-business/menu-icon.php' );


		require_once( 'functions.php' );
		require_once( 'functions-woo.php' );
		require_once( 'load-lib-ext-plugins.php' );
		require_once( 'load-cpt-sc.php' );
		require_once( 'load-other.php' );
		require_once( 'scripts-loader.php' );
		require_once( 'shortcode-loader.php' );

	}

	/**
	 * enque style
	 */
	public function admin_enque_scripts() {
		wp_enqueue_style( 'mascot-core-custom-admin', SHADHIN_PLUGINS_ASSETS_URI . '/css/custom-admin.css' );
	}

	public function enque_scripts() {
		if (function_exists('woosw_init')) {
			//wp_enqueue_script('mascot-core-wishlist', SHADHIN_PLUGINS_ASSETS_URI . '/js/woo/wishlist.js', array('jquery'), SHADHIN_PLUGINS_VERSION, true);
		}
	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'shadhin-plugins' ),
			'<strong>' . esc_html__( 'Mascot Core - Shadhin', 'shadhin-plugins' ) . '</strong>',
			'<strong>' . esc_html__( 'Mascot Core', 'shadhin-plugins' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'shadhin-plugins' ),
			'<strong>' . esc_html__( 'Mascot Core - Shadhin Elementor', 'shadhin-plugins' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'shadhin-plugins' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}


	/**
	 * Add Custom Icon
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public function add_elementor_custom_icons($settings)
    {
		$settings['flaticon-set-ev'] = [
			'name'          => 'flaticon-set-ev',
			'label'         => 'Shadhin Theme Icon Set',
			'url'           => '',
			'enqueue'       => array(
				SHADHIN_PLUGINS_ASSETS_URI . '/flaticon-set-ev/style.css',
			),
			'prefix'        => '',
			'displayPrefix' => '',
			'labelIcon'     => 'flaticon-set-ev',
			'ver'           => '1.0',
			'fetchJson'     => SHADHIN_PLUGINS_ASSETS_URI . '/flaticon-set-ev/icon-list.js',
			'native'        => 1,
		];
        $settings['mascot-flaticon-common'] = [
            'name'          => 'mascot-flaticon-common',
            'label'         => 'Shadhin Common Icons',
            'url'           => '',
            'enqueue'       => array(
                SHADHIN_PLUGINS_ASSETS_URI . '/flaticons-common/style.css',
            ),
            'prefix'        => '',
            'displayPrefix' => '',
            'labelIcon'     => 'flaticon-common-alarm',
            'ver'           => '1.0',
            'fetchJson'     => SHADHIN_PLUGINS_ASSETS_URI . '/flaticons-common/icon-list.js',
            'native'        => 1,
        ];
        return $settings;
    }

    /**
     * register fallback theme functions
     *
     * @return void
     */
    public function theme_fallback()
    {

        // custom kses allowed html
        if (!function_exists('shadhin_plugins_kses_allowed_html')) :
            function shadhin_plugins_kses_allowed_html($tags, $context)
            {
                switch ($context) {
                    case 'shadhin_plugins_allowed_tags':
                        $tags = array(
                            'a' => array('href' => array(), 'class' => array()),
                            'b' => array(),
                            'br' => array(),
                            'span' => array('class' => array()),
                            'img' => array('class' => array()),
                            'i' => array('class' => array()),
                            'p' => array('class' => array()),
                            'ul' => array('class' => array()),
                            'li' => array('class' => array()),
                            'div' => array('class' => array()),
                            'strong' => array()
                        );
                        return $tags;
                    default:
                        return $tags;
                }
            }

            add_filter('wp_kses_allowed_html', 'shadhin_plugins_kses_allowed_html', 10, 2);

        endif;
    }

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'shadhin-plugins' ),
			'<strong>' . esc_html__( 'Mascot Core - Shadhin Elementor', 'shadhin-plugins' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'shadhin-plugins' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}
}

// Instantiate Shadhin_plugins_Elementor.
new Shadhin_plugins_Elementor();


/* Aqua Resizer
================================================== */
if (!function_exists('shadhin_plugins_matthewruddy_image_resize')) {
	require_once( plugin_dir_path( __FILE__ ) . 'external-plugins/lib/matthewruddy-image-resizer.php' );
}


if( !function_exists('shadhin_plugins_theme_installed') ) {
	/**
	* Checks whether theme is installed or not
	* @return bool
	*/
	function shadhin_plugins_theme_installed() {
		return defined('SHADHIN_FRAMEWORK_VERSION');
	}
}


if( !function_exists('shadhin_plugins_theme_active') ) {
	/**
	* Checks whether theme is installed or not
	* @return bool
	*/
	function shadhin_plugins_theme_active() {
		return defined('MASCOT_THEME_ACTIVE');
	}
}



if (!function_exists('shadhin_plugins_get_fa_icons')) :

    function shadhin_plugins_get_fa_icons()
    {
        $data = get_transient('shadhin_plugins_fa_icons');

        if (empty($data)) {
            global $wp_filesystem;
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();

            $fontAwesome_file =   SHADHIN_PLUGINS_ABS_PATH . 'assets/fontawesome/css/all.min.css';

            $content = '';

            if ($wp_filesystem->exists($fontAwesome_file)) {
                $content = $wp_filesystem->get_contents($fontAwesome_file);
            } // End If Statement


            $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content/';

            $subject = $content;

            preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

            $all_matches = $matches;

            $icons = array();


            foreach ($all_matches as $match) {
                // $icons[] = array('value' => $match[1], 'label' => $match[1]);
                $icons[] = $match[1];
            }


            $data = $icons;
            set_transient('shadhin_plugins_fa_icons', $data, 10); // saved for one week
        }
        return array_combine($data, $data); // combined for key = value
    }
endif;


/**
 * making array of custom icon classes
 * which is saved in transient
 * @return array
 */
if (!function_exists('shadhin_plugins_get_flat_icons')) :

    function shadhin_plugins_get_flat_icons()
    {
        $data = get_transient('shadhin_plugins_flat_icons');

        if (empty($data)) {
            global $wp_filesystem;
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();

            //this font is used in service cpt and you must enque this css file in elementor widget at get_style_depends()
            //otherwise this font will not be visible.
            $template_icon_file = SHADHIN_PLUGINS_ABS_PATH . 'assets/flaticon-set-agri/style.css';
            $content = '';

            if ($wp_filesystem->exists($template_icon_file)) {
                $content .= $wp_filesystem->get_contents($template_icon_file);
            } // End If Statement

            $pattern_two = '/\.(flaticon-(?:\w+(?:-)?)+):before\s*{\s*content/';

            $subject = $content;

            preg_match_all($pattern_two, $subject, $matches_two, PREG_SET_ORDER);

            $all_matches = $matches_two;

            $icons = array();


            foreach ($all_matches as $match) {
                // $icons[] = array('value' => $match[1], 'label' => $match[1]);
                $icons[] = $match[1];
            }


            $data = $icons;
            set_transient('shadhin_plugins_flat_icons', $data, 10); // saved for one week
        }
        return array_combine($data, $data); // combined for key = value
    }
endif;