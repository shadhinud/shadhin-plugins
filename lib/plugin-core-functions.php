<?php
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\ValueConverter;

// Null Funcion
function shadhin_plugins_null_function() {}

if(!function_exists('shadhin_plugins_get_cpt_template_part')) {
	/**
	 * Load a cpt template part into a template
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialised template.
	 * @param string $folder The name of the specialised folder.
	 * @param array $params array of parameters to pass to the template.
	 * @param boolean $shortcode_ob_start only for shortcodes to get HTML string.
	 */
	function shadhin_plugins_get_cpt_template_part( $slug, $name = null, $folder = '', $params = array(), $shortcode_ob_start  = false ) {

		$template_path = 'inc/post-types/' . $folder . '/' . $slug;

		return shadhin_plugins_get_template_part( $template_path, $name, $params, $shortcode_ob_start );

	}
}

if(!function_exists('shadhin_plugins_get_widget_template_part')) {
	/**
	 * Load a widget template part into a template
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialised template.
	 * @param string $folder The name of the specialised folder.
	 * @param array $params array of parameters to pass to the template.
	 * @param boolean $widget_ob_start only for widget to get HTML string.
	 */
	function shadhin_plugins_get_widget_template_part( $slug, $name = null, $folder = '', $params = array(), $widget_ob_start  = false ) {

		$template_path = 'inc/widgets/parts/' . $folder . '/' . $slug;

		return shadhin_plugins_get_template_part( $template_path, $name, $params, $widget_ob_start );

	}
}

if(!function_exists('shadhin_plugins_get_shortcodes_template_part')) {
	/**
	 * Load a shortcodes template part into a template
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialised template.
	 * @param string $folder The name of the specialised folder.
	 * @param array $params array of parameters to pass to the template.
	 * @param boolean $widget_ob_start only for widget to get HTML string.
	 */
	function shadhin_plugins_get_shortcodes_template_part( $slug, $name = null, $folder = '', $params = array(), $shortcode_ob_start  = false ) {

		$template_path = 'inc/shortcodes/parts/' . $folder . '/' . $slug;

		return shadhin_plugins_get_template_part( $template_path, $name, $params, $shortcode_ob_start );

	}
}

if(!function_exists('shadhin_plugins_get_inc_folder_template_part')) {
	/**
	 * Load a inc folder template part into a template
	 *
	 * @param string $slug The slug name for the generic template.
	 * @param string $name The name of the specialised template.
	 * @param string $folder The name of the specialised folder.
	 * @param array $params array of parameters to pass to the template.
	 * @param boolean $shortcode_ob_start only for shortcodes to get HTML string.
	 */
	function shadhin_plugins_get_inc_folder_template_part( $slug, $name = null, $folder = '', $params = array() ) {

		$template_path = 'inc/' . $folder . '/' . $slug;

		return shadhin_plugins_get_template_part( $template_path, $name, $params );

	}
}

if(!function_exists('shadhin_plugins_get_template_part')) {
	/**
	 * Load a template part into a template
	 *
	 * @param string $template_path path of the specialised template.
	 * @param string $name The name of the specialised template.
	 * @param array $params array of parameters to pass to the template.
	 * @param boolean $shortcode_ob_start only for shortcodes to get HTML string.
	 */
	function shadhin_plugins_get_template_part( $template_path, $name = null, $params = array(), $shortcode_ob_start = false ) {

		$output_html = '';

		if( is_array($params) && count($params) ) {
			extract($params);
		}

		$templates = array();
		$name = (string) $name;
		if ( '' !== $name )
			$templates[] = "{$template_path}-{$name}.php";

		$templates[] = "{$template_path}.php";

		$located = shadhin_plugins_locate_template($templates);

		if($located) {
			if( $shortcode_ob_start ) {
				ob_start();
				include($located);
				$output_html = ob_get_clean();
			} else {
				include($located);
			}
		}

		return $output_html;
	}
}

if(!function_exists('shadhin_plugins_locate_template')) {
	/**
	 * Retrieve the name of the highest priority template file that exists.
	 *
	 * Searches in the MASCOT_STYLESHEET_DIR before MASCOT_TEMPLATE_DIR
	 * so that themes which inherit from a parent theme can just overload one file.
	 *
	 * @param string|array $template_names Template file(s) to search for, in order.
	 * @return string The template filename if one is located.
	 */
	function shadhin_plugins_locate_template($template_names) {
		$located = '';
		foreach ( (array) $template_names as $template_name ) {
			if ( !$template_name ) {
				continue;
			}
			if ( file_exists(SHADHIN_PLUGINS_ABS_PATH . '/' . $template_name)) {
				$located = SHADHIN_PLUGINS_ABS_PATH . '/' . $template_name;
				break;
			}
		}
		return $located;
	}
}


if ( ! function_exists( 'shadhin_plugins_category_list_array_for_vc' ) ) {
	/**
	 * Return category list array for VC
	 */
	function shadhin_plugins_category_list_array_for_vc( $taxonomy ) {
		$list_categories = array(
			esc_html__( 'All', 'shadhin-plugins' ) => ''
		);
		$terms = get_terms( $taxonomy );

		if ( $terms && !is_wp_error( $terms ) ) :
			foreach ( $terms as $term ) {
				$list_categories[ $term->name ] = $term->slug;
			}
		endif;

		return $list_categories;
	}
}

if ( ! function_exists( 'shadhin_plugins_vc_add_css_editor' ) ) {
	/**
	 * Return array of VC css editor
	 */
	function shadhin_plugins_vc_add_css_editor( $name = 'css' ) {
		$data = array(
			'type'       => 'css_editor',
			'heading'    => esc_html__('Css', 'shadhin-plugins'),
			'param_name' => $name,
			'group'      => esc_html__('Design options', 'shadhin-plugins')
		);
		return apply_filters('shadhin_plugins_vc_add_css_editor', $data);
	}
}


if ( ! function_exists( 'shadhin_plugins_get_redux_option' ) ) {
	/**
	 * Retuns Redux Theme Option
	 */
	function shadhin_plugins_get_redux_option( $id, $fallback = false, $param = false ) {
		global $shadhin_redux_theme_opt;

		if ( $fallback == false ) $fallback = '';

		$output = ( isset( $shadhin_redux_theme_opt[$id] ) && $shadhin_redux_theme_opt[$id] !== '' ) ? $shadhin_redux_theme_opt[$id] : $fallback;

		if ( !empty( $shadhin_redux_theme_opt[$id] ) && $param ) {
			$output = $shadhin_redux_theme_opt[$id][$param];
		}
		return $output;
	}
}




/**
 * Admin Bar Menu Actions
 */
function shadhin_plugins_admin_menu_actions() {
	if( shadhin_plugins_theme_installed() ) {
		add_action( 'admin_bar_menu',  'shadhin_plugins_admin_bar_menu', 50 );
	}
}
add_action('init', 'shadhin_plugins_admin_menu_actions');

// Admin Bar Menu
function shadhin_plugins_admin_bar_menu( $wp_admin_bar ) {
	$icon = '<i class="ab-icon dashicons-admin-generic dashicons-mascot-help"></i>';

	$wp_admin_bar->add_menu(array(
		'id'	  => 'mascot-options',
		'title'   => $icon . 'Mascot Help',
		'href'	=> admin_url( 'admin.php?page=mascot-about' )
	));

	$wp_admin_bar->add_menu(array(
		'parent'  => 'mascot-options',
		'id'	  => 'mascot-options-about',
		'title'   => 'About',
		'href'	=> admin_url( 'admin.php?page=mascot-about' )
	));

	$wp_admin_bar->add_menu(array(
		'parent'  => 'mascot-options',
		'id'	  => 'mascot-help',
		'title'   => 'Support & Help',
		'href'	=> admin_url( 'admin.php?page=mascot-docs' )
	));

	$wp_admin_bar->add_menu(array(
		'parent'  => 'mascot-options',
		'id'	  => 'mascot-faq',
		'title'   => 'FAQ',
		'href'	=> admin_url( 'admin.php?page=mascot-faq' )
	));

	$wp_admin_bar->add_menu(array(
		'parent'  => 'mascot-options',
		'id'	  => 'mascot-options-sub',
		'title'   => 'Theme Options',
		'href'	=> admin_url( 'admin.php?page=ThemeOptions' )
	));

	if ( class_exists( 'OCDI_Plugin' ) ) {
		$wp_admin_bar->add_menu(array(
			'parent'  => 'mascot-options',
			'id'	  => 'mascot-demo-content-importer',
			'title'   => 'One Click Demo Import',
			'href'	=> admin_url( 'themes.php?page=tm-one-click-demo-import' )
		));
	}

	$plugins = shadhin_plugins_tgmpa_get_plugins_need_update();
	if ( count( $plugins ) ) {
		$wp_admin_bar->add_menu(array(
			'parent'  => 'mascot-options',
			'id'	  => 'mascot-update-plugins',
			'title'   => 'Update Required Plugins <span class="update-plugins"><span class="update-count">'.count( $plugins ).'</span></span>',
			'href'	=> admin_url( 'themes.php?page=tgmpa-install-plugins' )
		));
	}

	$wp_admin_bar->add_menu(array(
		'parent'  => 'mascot-options',
		'id'	  => 'mascot-system-status',
		'title'   => 'System Status',
		'href'	=> admin_url( 'admin.php?page=mascot-system-status' )
	));

	$wp_admin_bar->add_menu(array(
		'parent'  => 'mascot-options',
		'id'	  => 'mascot-themes',
		'title'   => 'Browse Our Themes',
		'href'	=> 'http://themeforest.net/user/MhShadhin/portfolio?ref=MhShadhin',
		'meta'	=> array( 'target' => '_blank' )
	));
}


function shadhin_plugins_theme_admin_menu_system_status() {
	include_once SHADHIN_PLUGINS_ABS_PATH . 'inc/admin-tpl/mhshadhin-system-status.php';
}

function shadhin_plugins_tgmpa_get_plugins_need_update() {
	$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
	$plugins  = array(
		//'all'	  => array(), // Meaning: all plugins which still have open actions.
		//'install'  => array(),
		'update'   => array(),
		//'activate' => array(),
	);
	foreach ( $instance->plugins as $slug => $plugin ) {
		if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
			// No need to display plugins if they are installed, up-to-date and active.
			continue;
		} else {
			$plugins['all'][ $slug ] = $plugin;
			if ( ! $instance->is_plugin_installed( $slug ) ) {
				$plugins['install'][ $slug ] = $plugin;
			} else {
				if ( false !== $instance->does_plugin_have_update( $slug ) ) {
					$plugins['update'][ $slug ] = $plugin;
				}
				if ( $instance->can_plugin_activate( $slug ) ) {
					$plugins['activate'][ $slug ] = $plugin;
				}
			}
		}
	}
	return $plugins['update'];
}

if(!function_exists('shadhin_plugins_get_url_params')) {
	/**
	 * retrieve values of parameters passing through the URL
	 */
	function shadhin_plugins_get_url_params( $param ) {
		return isset( $_GET[ $param ] ) ? $_GET[ $param ] : ( isset( $_REQUEST[ $param ] ) ? $_REQUEST[ $param ] : '' );
	}
}


if(!function_exists('_empty')) {
	/**
	 * return true
	 */
	function _empty( $val ) {
		return empty($val);
	}
}




if ( ! class_exists( 'Shadhin_plugins_T5_Richtext_Excerpt' ) ) {
	/**
	 * Replaces the default excerpt editor with TinyMCE.
	 */
	class Shadhin_plugins_T5_Richtext_Excerpt {
		/**
		 * Replaces the meta boxes.
		 *
		 * @return void
		 */
		public static function switch_boxes() {
			//if wocommerce then return
			global $pagenow;
			if (( $pagenow == 'post.php' ) || (get_post_type() == 'product')) {
				return;
			}
			if ( ! post_type_supports( $GLOBALS['post']->post_type, 'excerpt' ) ) {
				return;
			}

			remove_meta_box(
				'postexcerpt' // ID
			,   ''            // Screen, empty to support all post types
			,   'normal'      // Context
			);

			add_meta_box(
				'postexcerpt2'     // Reusing just 'postexcerpt' doesn't work.
			,   esc_html__( 'Excerpt', 'shadhin-plugins' )    // Title
			,   array ( __CLASS__, 'show' ) // Display function
			,   null              // Screen, we use all screens with meta boxes.
			,   'normal'          // Context
			,   'core'            // Priority
			);
		}

		/**
		 * Output for the meta box.
		 *
		 * @param  object $post
		 * @return void
		 */
		public static function show( $post ) {
		?>
			<label class="screen-reader-text" for="excerpt"><?php
			_e( 'Excerpt', 'shadhin-plugins' )
			?></label>
			<?php
			// We use the default name, 'excerpt', so we don’t have to care about
			// saving, other filters etc.
			wp_editor(
				self::unescape( $post->post_excerpt ),
				'excerpt',
				array (
				'textarea_rows' => 15
			,   'media_buttons' => FALSE
			,   'teeny'         => TRUE
			,   'tinymce'       => TRUE
				)
			);
		}

		/**
		 * The excerpt is escaped usually. This breaks the HTML editor.
		 *
		 * @param  string $str
		 * @return string
		 */
		public static function unescape( $str ) {
			return str_replace(
				array ( '&lt;', '&gt;', '&quot;', '&amp;', '&nbsp;', '&amp;nbsp;' )
			,   array ( '<',    '>',    '"',      '&',     ' ', ' ' )
			,   $str
			);
		}
	}
	add_action( 'add_meta_boxes', array ( 'Shadhin_plugins_T5_Richtext_Excerpt', 'switch_boxes' ) );
}

if(!function_exists('shadhin_plugins_slice_text_by_length')) {
	/**
	 * Slice Text by length
	 */
	function shadhin_plugins_slice_text_by_length( $text, $word_length = 0 ) {
		$text_return = '';
		if( function_exists('shadhin_slice_text_by_length') ) {
			$text_return = shadhin_slice_text_by_length( $text, $word_length);
		}
		return $text_return;
	}
}

if(!function_exists('shadhin_plugins_posted_on_date')) {
	/**
	 * Posted on Date
	 */
	function shadhin_plugins_posted_on_date() {
		$text_return = '';
		if( function_exists('shadhin_posted_on_date') ) {
			$text_return = shadhin_posted_on_date();
		}
		return $text_return;
	}
}



if(!function_exists('shadhin_plugins_variable_val_is_empty')) {
	/**
	 * Check if variable value is empty
	 */
	function shadhin_plugins_variable_val_is_empty( $variable ) {
		if ( ( is_array($variable) && empty($variable) ) || ( !is_array($variable) && $variable == '' ) ) {
			return true;
		} else {
			return false;
		}
	}
}



if(!function_exists('shadhin_plugins_theme_admin_login_custom_logo')) {
	/**
	 * Add Admin Login Custom Logo
	 */
	function shadhin_plugins_theme_admin_login_custom_logo() {
		$admin_login_logo = shadhin_plugins_get_redux_option( 'logo-settings-admin-login-logo' );
		if( !shadhin_plugins_variable_val_is_empty( $admin_login_logo ) ) {
	?>
		<style>
			#login h1 a, .login h1 a {
				background-image: url(<?php echo esc_url( $admin_login_logo['url'] ); ?>);
				height: 50px;
				width: 250px;
				background-size: 250px 50px;
				background-repeat: no-repeat;
			}
		</style>
	<?php
		}
	}
	add_action( 'login_enqueue_scripts', 'shadhin_plugins_theme_admin_login_custom_logo' );
}


if(!function_exists('shadhin_plugins_generate_css_for_custom_theme_color_from_scss')) {
	/**
	 * Generates css custom theme color from SCSS dynamically when a user presses the "Save Settings" button at Redux Framework theme options
	 */
	function shadhin_plugins_generate_css_for_custom_theme_color_from_scss() {
		if( shadhin_plugins_theme_installed() && class_exists('ScssPhp\ScssPhp\Compiler') ) {
			global $wp_filesystem;
			WP_Filesystem();

			if ( shadhin_is_css_colors_folder_writable() ) {
				$scss_dir = SHADHIN_ASSETS_DIR . '/scss/colors/';
				$css_colors_dir = SHADHIN_ASSETS_DIR . '/css/colors/';

				$scss = new Compiler();
				$scss->setImportPaths($scss_dir);
				$scss->replaceVariables(array(
					'$theme-color1' => ValueConverter::parseValue( shadhin_plugins_get_redux_option( 'theme-color-settings-custom-theme-color1' ) ),
					'$theme-color2' => ValueConverter::parseValue( shadhin_plugins_get_redux_option( 'theme-color-settings-custom-theme-color2' ) ),
					'$theme-color3' => ValueConverter::parseValue( shadhin_plugins_get_redux_option( 'theme-color-settings-custom-theme-color3' ) ),
					'$theme-color4' => ValueConverter::parseValue( shadhin_plugins_get_redux_option( 'theme-color-settings-custom-theme-color4' ) ),

					'$theme-color1-text-color' => ValueConverter::parseValue( shadhin_plugins_get_redux_option( 'theme-color-settings-custom-theme-text-color1' ) ),
					'$theme-color2-text-color' => ValueConverter::parseValue( shadhin_plugins_get_redux_option( 'theme-color-settings-custom-theme-text-color2' ) ),
					'$theme-color3-text-color' => ValueConverter::parseValue( shadhin_plugins_get_redux_option( 'theme-color-settings-custom-theme-text-color3' ) ),
					'$theme-color4-text-color' => ValueConverter::parseValue( shadhin_plugins_get_redux_option( 'theme-color-settings-custom-theme-text-color4' ) ),
				));
				$css =  $scss->compileString('@import "custom-theme-color.scss"')->getCss();

				//file name
				$css_file_name = 'custom-theme-color';

				if ( is_multisite() ) {
					$css_file_name .= '-msid-' .shadhin_get_multisite_blog_id() ;
				}

				$redux_css_file_name = shadhin_plugins_get_redux_option( 'theme-color-settings-custom-theme-color-filename' );
				if( !empty( $redux_css_file_name ) ) {
					$css_file_name = $redux_css_file_name;
				}


				$wp_filesystem->put_contents( $css_colors_dir . $css_file_name . '.css', $css);
			}
		}
	}
}