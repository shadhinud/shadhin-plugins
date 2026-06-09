<?php
/**
 * Mouse helper
 *
 */


// Add dynamic CSS to insert it to the footer
if ( ! function_exists('mh_shadhin_addons_add_inline_css') ) {
	function mh_shadhin_addons_add_inline_css($css) {
		global $MH_MOUSEHELPER_STORAGE;
		$MH_MOUSEHELPER_STORAGE['inline_css'] = ( ! empty($MH_MOUSEHELPER_STORAGE['inline_css']) ? $MH_MOUSEHELPER_STORAGE['inline_css'] : '' ) . $css;
	}
}

// Add variables to the frontend
if ( !function_exists( 'mh_shadhin_addons_localize_scripts_front' ) ) {
	add_action("wp_footer", 'mh_shadhin_addons_localize_scripts_front');
	function mh_shadhin_addons_localize_scripts_front() {
		//added after menuzord plugin because it causes error
		wp_localize_script( 'menuzord', 'MH_MOUSEHELPER_STORAGE', apply_filters('mh_addons_filter_localize_script', array(
			// AJAX parameters
			'ajax_url'	=> esc_url(admin_url('admin-ajax.php')),
			'ajax_nonce'=> esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))),
			// Site base url
			'site_url'	=> esc_url(get_home_url()),
			// Is single page/post
			'post_id' => get_the_ID(),
			// VC frontend edit mode
			// Is preview mode
			'is_preview_elm'=> shadhin_plugins_is_preview(),
			// Mobile breakpoints for JS (if window width less then)
			'mobile_breakpoint_fixedrows_off' => 768,
			'mobile_breakpoint_fixedcolumns_off' => 768,
			'mobile_breakpoint_stacksections_off' => 768,
			'mobile_breakpoint_fullheight_off' => 1025,
			'mobile_breakpoint_mousehelper_off' => 1025,
		) ) );
	}
}

// Enqueue frontend scripts and styles priority
if ( ! defined( 'MH_ENQUEUE_SCRIPTS_PRIORITY' ) ) define( 'MH_ENQUEUE_SCRIPTS_PRIORITY', 11 );

// Enqueue responsive styles priority
if ( ! defined( 'MH_ENQUEUE_RESPONSIVE_PRIORITY' ) ) define( 'MH_ENQUEUE_RESPONSIVE_PRIORITY', 2000 );

// Load required styles and scripts for the frontend
if ( ! function_exists( 'mh_shadhin_cursor_mouse_helper_load_scripts_front' ) ) {
	add_action( 'wp_enqueue_scripts', 'mh_shadhin_cursor_mouse_helper_load_scripts_front', MH_ENQUEUE_SCRIPTS_PRIORITY);
	add_action( 'mh_addons_action_pagebuilder_preview_scripts', 'mh_shadhin_cursor_mouse_helper_load_scripts_front', 10, 1 );
	function mh_shadhin_cursor_mouse_helper_load_scripts_front( $force = false ) {
		static $loaded = false;
		$preview_elm = shadhin_plugins_is_preview();
		$need        = ! $loaded && ( ! $preview_elm ) && (
						$force === true
							|| ( $preview_elm )
							|| (int) shadhin_plugins_get_redux_option('mouse_helper') > 0
						);
		if ( ! $loaded && $need ) {
			$loaded = true;
			wp_enqueue_style(  'mh_addons-mouse-helper', plugins_url( '/mouse-helper.css', __FILE__ ), array(), null );
			wp_enqueue_script( 'mh_addons-mouse-helper', plugins_url( '/mouse-helper.js', __FILE__ ), array('jquery', 'menuzord'), null, true );
			do_action( 'mh_addons_action_load_scripts_front', $force, 'mouse_helper' );
		}
		if ( ! $loaded && $preview_elm ) {
			do_action( 'mh_addons_action_load_scripts_front', false, 'mouse_helper', 2 );
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'mh_shadhin_cursor_mouse_helper_load_scripts_front_responsive' ) ) {
	add_action( 'wp_enqueue_scripts', 'mh_shadhin_cursor_mouse_helper_load_scripts_front_responsive', MH_ENQUEUE_RESPONSIVE_PRIORITY );
	add_action( 'mh_addons_action_load_scripts_front_mouse_helper', 'mh_shadhin_cursor_mouse_helper_load_scripts_front_responsive', 10, 1 );
	function mh_shadhin_cursor_mouse_helper_load_scripts_front_responsive( $force = false ) {
		static $loaded = false;
		$preview_elm = shadhin_plugins_is_preview();
		$need        = ! $loaded && ( ! $preview_elm ) && (
						$force === true
							|| ( $preview_elm )
							|| (int) shadhin_plugins_get_redux_option('mouse_helper') > 0
						);
		if ( ! $loaded && $need ) {
			$loaded = true;
			wp_enqueue_style( 'mh_addons-mouse-helper-responsive', plugins_url( '/mouse-helper.responsive.css', __FILE__ ));
		}
	}
}



// Add mouse_helper to the list with JS vars
if ( !function_exists( 'mh_shadhin_cursor_mouse_helper_localize_script' ) ) {
	add_action("mh_addons_filter_localize_script", 'mh_shadhin_cursor_mouse_helper_localize_script');
	function mh_shadhin_cursor_mouse_helper_localize_script($vars) {
		$vars['mouse_helper']            = (int) shadhin_plugins_get_redux_option('mouse_helper');
		$vars['mouse_helper_delay']      = max( 1, min( 20, (int) shadhin_plugins_get_redux_option('mouse_helper_delay') ) );
		$vars['mouse_helper_centered']   = (int) shadhin_plugins_get_redux_option('mouse_helper_centered');
		$vars['msg_mouse_helper_anchor'] = (int) shadhin_plugins_get_redux_option('mouse_helper') > 0 ? esc_attr__( 'Scroll to', 'shadhin-plugins' ) : '';
		return $vars;
	}
}



//========================================================================
//  Add params to the Theme Addons Options and layout to the page
//========================================================================



// Add params to the Theme Addons Options.
if ( ! function_exists( 'mh_shadhin_cursor_mouse_helper_add_redux_options' ) ) {
	add_action('setup_theme', 'mh_shadhin_cursor_mouse_helper_add_redux_options');
	function mh_shadhin_cursor_mouse_helper_add_redux_options() {

		if ( ! class_exists( 'Redux' ) ) {
			return;
		}
		// This is your option name where all the Redux data is stored.
		$opt_name = "shadhin_redux_theme_opt";

		// -> START Custom HTML/JS Codes
		Redux::setSection( $opt_name, array(
			'title'  => esc_html__( 'Cursor Mouse helper', 'shadhin-plugins' ),
			'id'     => 'mouse_helper_section',
			'desc'   => '',
			'icon'   => 'dashicons-before dashicons-arrow-up',
			'priority'   => 21,
			'fields' => array(
				array(
					'id'       => 'mouse_helper',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show mouse helper', 'shadhin-plugins' ),
					'subtitle' => esc_html__( 'Display animated helper near the mouse cursor on desktop and notebooks', 'shadhin-plugins' ),
					'default'  => 0,
					'on'       => esc_html__( 'Yes', 'shadhin-plugins' ),
					'off'      => esc_html__( 'No', 'shadhin-plugins' ),
				),
				array(
					'id'       => 'mouse_helper_permanent',
					'type'     => 'switch',
					'title'    => esc_html__( 'Always visible', 'shadhin-plugins' ),
					'subtitle' => esc_html__( 'Display the mouse helper permanently or only when hovering over the corresponding object', 'shadhin-plugins' ),
					'default'  => 0,
					'on'       => esc_html__( 'Yes', 'shadhin-plugins' ),
					'off'      => esc_html__( 'No', 'shadhin-plugins' ),
					'required' => array(
						array( 'mouse_helper', '=', '1' ),
					)
				),
				array(
					'id'       => 'mouse_helper_centered',
					'type'     => 'switch',
					'title'    => esc_html__( 'Centered', 'shadhin-plugins' ),
					'subtitle' => esc_html__( 'Place the center of the helper in the cursor position', 'shadhin-plugins' ),
					'default'  => 0,
					'on'       => esc_html__( 'Yes', 'shadhin-plugins' ),
					'off'      => esc_html__( 'No', 'shadhin-plugins' ),
					'required' => array(
						array( 'mouse_helper', '=', '1' ),
					)
				),
				array(
					'id'       => 'mouse_helper_on_swiper_slider',
					'type'     => 'switch',
					'title'    => esc_html__( 'Show cursor in swiper slider', 'shadhin-plugins' ),
					'default'  => 0,
					'on'       => esc_html__( 'Yes', 'shadhin-plugins' ),
					'off'      => esc_html__( 'No', 'shadhin-plugins' ),
					'required' => array(
						array( 'mouse_helper', '=', '1' ),
					)
				),
				array(
					'id'            => 'mouse_helper_delay',
					'type'          => 'slider',
					'title'         => esc_html__( 'Delay', 'shadhin-plugins' ),
					'subtitle'      => esc_html__( 'The coefficient of lag between the helper and the cursor (1 - the helper moves with the cursor)', 'shadhin-plugins' ),
					'desc'          => '',
					'default'       => 10,
					'min'           => 1,
					'step'          => 1,
					'max'           => 20,
					'display_value' => 'text',
					'required' => array(
						array( 'mouse_helper', '=', '1' ),
					)
				),


				array(
					'id'       => 'mouse_helper_replace_cursor',
					'type'     => 'button_set',
					'compiler' =>true,
					'title'    => esc_html__( 'System cursor', 'shadhin-plugins' ),
					'subtitle' => esc_html__( 'Replace system cursor with custom image', 'shadhin-plugins' ),
					'options' => array(
						"0"    => esc_html__( 'Default', 'shadhin-plugins' ),
						"1"    => esc_html__( 'Replace', 'shadhin-plugins' ),
						"hide" => esc_html__( 'Hide', 'shadhin-plugins' ),
					),
					'default' => '0',
					'required' => array(
						array( 'mouse_helper', '=', '1' ),
					)
				),
				array(
					'id'       => 'mouse_helper_replace_cursor_default',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__( 'Default cursor image', 'shadhin-plugins' ),
					'subtitle' => esc_html__( 'Select or upload image to use it as default cursor. If you select animated cursor .ANI - select alternative cursor for not supported browsers in the next field', 'shadhin-plugins' ),
					'compiler' => 'true',
					'desc'     => '',
					'required' => array(
						array( 'mouse_helper_replace_cursor', '=', '1' )
					)
				),
				array(
					'id'       => 'mouse_helper_replace_cursor_default2',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__( 'Default cursor image (alternative)', 'shadhin-plugins' ),
					'subtitle' => esc_html__( 'Select or upload image to use it as alternative cursor', 'shadhin-plugins' ),
					'compiler' => 'true',
					'desc'     => '',
					'required' => array(
						array( 'mouse_helper_replace_cursor', '=', '1' ),
					)
				),
				array(
					'id'       => 'mouse_helper_replace_cursor_links',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__( 'Cursor image over links', 'shadhin-plugins' ),
					'subtitle' => esc_html__( 'Select or upload image to use it as cursor over links and buttons.  If you select animated cursor .ANI - select alternative cursor for not supported browsers in the next field', 'shadhin-plugins' ),
					'compiler' => 'true',
					'desc'     => '',
					'required' => array(
						array( 'mouse_helper_replace_cursor', '=', '1' ),
					)
				),
				array(
					'id'       => 'mouse_helper_replace_cursor_links2',
					'type'     => 'media',
					'url'      => false,
					'title'    => esc_html__( 'Cursor image over links (alternative)', 'shadhin-plugins' ),
					'subtitle' => esc_html__( 'Select or upload image to use it as alternative cursor', 'shadhin-plugins' ),
					'compiler' => 'true',
					'desc'     => '',
					'required' => array(
						array( 'mouse_helper_replace_cursor', '=', '1' ),
					)
				),
			)
		) );
	}
}


// Add mouse helper to the page
if ( !function_exists( 'mh_shadhin_cursor_mouse_helper_add_to_html' ) ) {
	add_action('wp_footer', 'mh_shadhin_cursor_mouse_helper_add_to_html');
	function mh_shadhin_cursor_mouse_helper_add_to_html() {
		if ( (int) shadhin_plugins_get_redux_option( 'mouse_helper' ) > 0 ) {
			// Add mouse helper layout
			?><div class="<?php
				echo esc_attr( apply_filters( 'mh_addons_filter_mouse_helper_classes',
							'mh_cursor_mouse_helper'
							. ( (int) shadhin_plugins_get_redux_option( 'mouse_helper_permanent' ) > 0
									? ' mh_cursor_mouse_helper_permanent'
									: ''
									)
							. ( (int) shadhin_plugins_get_redux_option( 'mouse_helper_centered' ) > 0
									? ' mh_cursor_mouse_helper_centered'
									: ''
									)
						)
					);
				?>"
				<?php
				do_action( 'mh_addons_action_mouse_helper_attributes' );
			?>><?php
				do_action( 'mh_addons_action_mouse_helper_layout' );
			?></div><?php
			// Load addon-specific scripts and styles
			mh_shadhin_cursor_mouse_helper_load_scripts_front( true );
		}
	}
}

// Replace system cursor
if ( !function_exists( 'mh_shadhin_cursor_mouse_helper_replace_system_cursor' ) ) {
	add_filter('body_class', 'mh_shadhin_cursor_mouse_helper_replace_system_cursor');
	function mh_shadhin_cursor_mouse_helper_replace_system_cursor( $classes ) {
		if ( (int) shadhin_plugins_get_redux_option( 'mouse_helper_replace_cursor' ) == 1 ) {
			$classes[]  = 'mh_addons_custom_cursor';
			$cur_defa   = shadhin_plugins_get_redux_option( 'mouse_helper_replace_cursor_default', false, 'url' );
			$cur_defa2  = shadhin_plugins_get_redux_option( 'mouse_helper_replace_cursor_default2', false, 'url' );
			$cur_links  = shadhin_plugins_get_redux_option( 'mouse_helper_replace_cursor_links', false, 'url' );
			$cur_links2 = shadhin_plugins_get_redux_option( 'mouse_helper_replace_cursor_links2', false, 'url' );
			if ( ! empty( $cur_defa ) ) {
				mh_addons_add_inline_css(
					join( ',', apply_filters( 'mh_addons_filter_custom_cursor_default', array(
						'body',
						'body *'
					) ) )
					. ' { cursor: '
						. 'url(' . esc_url($cur_defa) . ')'
						. ( ! empty($cur_defa2) ? ',url(' . esc_url($cur_defa2) . ')' : '' )
						. ', auto !important; }'
					);
			}
			if ( ! empty( $cur_links ) ) {
				mh_addons_add_inline_css(
					join( ',', apply_filters( 'mh_addons_filter_custom_cursor_links', array(
						'body a',
						'body a *',
						'body button',
						'body input[type="submit"]',
						'body input[type="button"]',
						'body input[type="reset"]'
					) ) )
					. ' { cursor: '
						. 'url(' . esc_url($cur_links) . ')'
						. ( ! empty($cur_links2) ? ',url(' . esc_url($cur_links2) . ')' : '' )
						. ', pointer !important; }'
					);
			}
		} else if ( in_array( shadhin_plugins_get_redux_option( 'mouse_helper_replace_cursor' ), array( '2', 'hide' ) ) ) {
			if ( ! shadhin_plugins_is_preview() ) {
				$classes[]  = 'mh_addons_hide_cursor';
			}
		}
		return $classes;
	}
}




//========================================================================
//  Highlight on mouse hover for Heading
//========================================================================

// Add 'mouse_helper_highlight' to the 'Heading' params
if ( ! function_exists( 'mh_shadhin_cursor_mouse_helper_highlight_add_heading_param_in_elementor' ) ) {
	add_action( 'elementor/element/before_section_end', 'mh_shadhin_cursor_mouse_helper_highlight_add_heading_param_in_elementor', 10, 3 );
	function mh_shadhin_cursor_mouse_helper_highlight_add_heading_param_in_elementor( $element, $section_id, $args ) {
		if ( ! is_object($element) ) return;
		$el_name = $element->get_name();
		if ( 'mh-ele-section-title' == $el_name && 'title_options' === $section_id && (int) shadhin_plugins_get_redux_option('mouse_helper') > 0 ) {
			$element->add_control( 'mouse_helper_highlight', array(
									'type' => \Elementor\Controls_Manager::SWITCHER,
									'label' => __("Highlight on mouse hover", 'shadhin-plugins'),
									'label_on' => __( 'On', 'shadhin-plugins' ),
									'label_off' => __( 'Off', 'shadhin-plugins' ),
									'return_value' => '1',
									'default' => '',
								) );
			$element->add_control( 'title_text_color_mousehelper', array(
									'type' => \Elementor\Controls_Manager::COLOR,
									'label' => esc_html__( "Text Color(Must use opacity)", 'shadhin-plugins' ),
									'selectors' => [
										'{{WRAPPER}} .title' => 'color: {{VALUE}}!important;'
									],
									'condition' => [
										'mouse_helper_highlight' => array('1')
									]
								) );
			$element->add_control( 'title_text_highlight_circle_color_mousehelper', array(
									'type' => \Elementor\Controls_Manager::COLOR,
									'label' => esc_html__( "Highlight Circle Color", 'shadhin-plugins' ),
									'selectors' => [
										'{{WRAPPER}} .title' => 'background-image: radial-gradient(closest-side, {{VALUE}} 78%, transparent 0); background-size: 4em 4em; background-repeat: no-repeat;'
									],
									'condition' => [
										'mouse_helper_highlight' => array('1')
									]
								) );
		}
	}
}


// Add data parameter and color styles to the Heading
if ( ! function_exists( 'mh_shadhin_cursor_mouse_helper_highlight_before_render_heading_in_elementor' ) ) {
	// Before Elementor 2.1.0
	add_action( 'elementor/frontend/element/before_render', 'mh_shadhin_cursor_mouse_helper_highlight_before_render_heading_in_elementor', 10, 1 );
	// After Elementor 2.1.0
	add_action( 'elementor/frontend/widget/before_render', 'mh_shadhin_cursor_mouse_helper_highlight_before_render_heading_in_elementor', 10, 1 );
	function mh_shadhin_cursor_mouse_helper_highlight_before_render_heading_in_elementor( $element ) {
		if ( is_object( $element ) && (int) shadhin_plugins_get_redux_option( 'mouse_helper' ) > 0 ) {
			$el_name = $element->get_name();
			if ( 'mh-ele-section-title' == $el_name ) {
				$highlight = $element->get_settings( 'mouse_helper_highlight' );
				if ( ! empty( $highlight ) ) {
					$element->add_render_attribute( 'title', 'data-mouse-helper', 'highlight' );
					$title_color = $element->get_settings( 'title_text_color' );
				}
			}
		}
	}
}




//========================================================================
//  Mouse Helper for all elements
//========================================================================

// Add "Mouse helper" params to all elements
if (!function_exists('mh_shadhin_cursor_mouse_helper_add_params_to_elements')) {
	add_action( 'elementor/element/before_section_start', 'mh_shadhin_cursor_mouse_helper_add_params_to_elements', 10, 3 );
	add_action( 'elementor/widget/before_section_start', 'mh_shadhin_cursor_mouse_helper_add_params_to_elements', 10, 3 );
	function mh_shadhin_cursor_mouse_helper_add_params_to_elements($element, $section_id, $args) {

		if ( !is_object($element) ) return;

		if ( in_array( $element->get_name(), array( 'container', 'section', 'column', 'common' ) ) && $section_id == '_section_responsive' && (int) shadhin_plugins_get_redux_option( 'mouse_helper' ) > 0 ) {

			$element->start_controls_section( 'section_mh_mouse_helper', array(
																		'tab' => !empty($args['tab']) ? $args['tab'] : \Elementor\Controls_Manager::TAB_ADVANCED,
																		'label' => MH_ELEMENTOR_WIDGET_BADGE . __( 'Mascot - Mouse Helper', 'shadhin-plugins' )
																	) );
			$element->add_control( 'mouse_helper', array(
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label' => __("Enable mouse helper", 'shadhin-plugins'),
				'label_on' => __( 'On', 'shadhin-plugins' ),
				'label_off' => __( 'Off', 'shadhin-plugins' ),
				'return_value' => '1',
				'default' => '',
			) );

			$element->add_control( 'mouse_helper_action', array(
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => __( 'Action', 'shadhin-plugins' ),
				'label_block' => false,
				'options' => apply_filters( 'mh_addons_filter_mouse_helper_action', array(
					'hover' => esc_html__( 'Hover', 'shadhin-plugins' ),
				) ),
				'condition' => array(
					'mouse_helper' => '1'
				),
				'default' => 'hover',
			) );

			if ( shadhin_plugins_get_redux_option('mouse_helper_replace_cursor') != 'hide' ) {
				$element->add_control( 'mouse_helper_hide_cursor', array(
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label' => __("Hide system cursor", 'shadhin-plugins'),
					'label_on' => __( 'On', 'shadhin-plugins' ),
					'label_off' => __( 'Off', 'shadhin-plugins' ),
					'return_value' => '1',
					'default' => '',
					'condition' => array(
						'mouse_helper' => '1',
					),
				) );
			}

			if ( (int) shadhin_plugins_get_redux_option('mouse_helper_centered') == 0 ) {
				$element->add_control( 'mouse_helper_centered', array(
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label' => __("Cursor in the center", 'shadhin-plugins'),
					'label_on' => __( 'On', 'shadhin-plugins' ),
					'label_off' => __( 'Off', 'shadhin-plugins' ),
					'return_value' => '1',
					'default' => '',
					'condition' => array(
						'mouse_helper' => '1',
					),
				) );
			}

			$element->add_control( 'mouse_helper_magnet', array(
				'label' => __( 'Magnet distance', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => array(
					'size' => 0,
					'unit' => 'px'
				),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 100
					),
				),
				'size_units' => array( 'px' ),
				'condition' => array(
					'mouse_helper' => '1'
				),
			) );

			$element->add_control( 'mouse_helper_bg_color', array(
				'label' => __( 'Background color', 'shadhin-plugins' ),
				'label_block' => false,
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => array(
					'mouse_helper' => '1',
				),
			) );

			$element->add_control( 'mouse_helper_bd_color', array(
				'label' => __( 'Border color', 'shadhin-plugins' ),
				'label_block' => false,
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => array(
					'mouse_helper' => '1',
				),
			) );

			$element->add_control( 'mouse_helper_color', array(
				'label' => __( 'Text color', 'shadhin-plugins' ),
				'label_block' => false,
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
				'condition' => array(
					'mouse_helper' => '1',
				),
			) );

			$element->add_control( 'mouse_helper_mode', array(
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => __( 'Overlay mode', 'shadhin-plugins' ),
				'label_block' => false,
				'options' => apply_filters( 'mh_addons_filter_mouse_helper_mode', array(
					'' => esc_html__( 'Default', 'shadhin-plugins' ),
					'normal' => esc_html__( 'Normal', 'shadhin-plugins' ),
					'multiply'  => esc_html__( 'Multiply', 'shadhin-plugins' ),
					'screen'  => esc_html__( 'Screen', 'shadhin-plugins' ),
					'overlay'  => esc_html__( 'Overlay', 'shadhin-plugins' ),
					'darken'  => esc_html__( 'Darken', 'shadhin-plugins' ),
					'lighten'  => esc_html__( 'Lighten', 'shadhin-plugins' ),
					'color-dodge'  => esc_html__( 'Color Dodge', 'shadhin-plugins' ),
					'color-burn'  => esc_html__( 'Color Burn', 'shadhin-plugins' ),
					'hard-light'  => esc_html__( 'Hard Light', 'shadhin-plugins' ),
					'soft-light'  => esc_html__( 'Soft Light', 'shadhin-plugins' ),
					'difference'  => esc_html__( 'Difference', 'shadhin-plugins' ),
					'exclusion'  => esc_html__( 'Exclusion', 'shadhin-plugins' ),
					'hue'  => esc_html__( 'Hue', 'shadhin-plugins' ),
					'saturation'  => esc_html__( 'Saturation', 'shadhin-plugins' ),
					'color'  => esc_html__( 'Color', 'shadhin-plugins' ),
					'luminosity'  => esc_html__( 'Luminosity', 'shadhin-plugins' ),
				) ),
				'condition' => array(
					'mouse_helper' => '1'
				),
				'default' => '',
			) );

			$element->add_control( 'mouse_helper_axis', array(
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => __( 'Motion axis', 'shadhin-plugins' ),
				'label_block' => false,
				'options' => array(
					'xy' => esc_html__( 'Both', 'shadhin-plugins' ),
					'x'  => esc_html__( 'X only', 'shadhin-plugins' ),
					'y'  => esc_html__( 'Y only', 'shadhin-plugins' ),
				),
				'condition' => array(
					'mouse_helper' => '1'
				),
				'default' => 'xy',
			) );

			$element->add_control( 'mouse_helper_delay', array(
				'label' => __( 'Motion delay', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => array(
					'size' => (int) shadhin_plugins_get_redux_option( 'mouse_helper_delay' ),
					'unit' => 'px'
				),
				'range' => array(
					'px' => array(
						'min' => 1,
						'max' => 20
					),
				),
				'size_units' => array( 'px' ),
				'condition' => array(
					'mouse_helper' => '1'
				),
			) );

			$element->add_control( 'mouse_helper_text', array(
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __( 'Helper text', 'shadhin-plugins' ),
				'label_block' => false,
				'condition' => array(
					'mouse_helper' => '1'
				),
			) );

			$element->add_control( 'mouse_helper_text_size', array(
				'label' => __( 'Text size', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => array(
					'size' => '',
					'unit' => 'px'
				),
				'range' => array(
					'px' => array(
						'min' => 0.2,
						'max' => 2,
						'step' => 0.1
					),
				),
				'size_units' => array( 'px' ),
				'condition' => array(
					'mouse_helper' => '1',
					'mouse_helper_text!' => ''
				),
			) );

			$element->add_control( 'mouse_helper_text_round', array(
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label' => __("Rotate text in a circle", 'shadhin-plugins'),
				'label_on' => __( 'On', 'shadhin-plugins' ),
				'label_off' => __( 'Off', 'shadhin-plugins' ),
				'return_value' => '1',
				'default' => '',
				'condition' => array(
					'mouse_helper' => '1',
					'mouse_helper_text!' => ''
				),
			) );


			$element->add_control( 'mouse_helper_icon_size', array(
				'label' => __( 'Icon size', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => array(
					'size' => '',
					'unit' => 'px'
				),
				'range' => array(
					'px' => array(
						'min' => 1,
						'max' => 5,
						'step' => 0.1
					),
				),
				'size_units' => array( 'px' ),
				'condition' => array(
					'mouse_helper' => '1',
					'mouse_helper_icon[value]!' => '',
					'mouse_helper_icon[library]!' => ''
				),
			) );

			$element->add_control( 'mouse_helper_icon_color', array(
				'label' => __( 'Icon color', 'shadhin-plugins' ),
				'label_block' => false,
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => array(
					'mouse_helper' => '1',
					'mouse_helper_icon!' => array( '', 'none' ),
				),
			) );

			$element->add_control( 'mouse_helper_image', array(
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label' => __( 'Image', 'shadhin-plugins' ),
				'default' => array(
					'url' => '',
				),
				'condition' => array(
					'mouse_helper' => '1'
				),
			) );

			$element->add_control( 'mouse_helper_layout', array(
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label' => __( 'Custom layout', 'shadhin-plugins' ),
				'condition' => array(
					'mouse_helper' => '1'
				),
			) );

			$element->add_control( 'mouse_helper_callback', array(
				'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __( 'JS Callback', 'shadhin-plugins' ),
				'condition' => array(
					'mouse_helper' => '1'
				),
			) );

			$element->end_controls_section();
		}
	}
}

// Add "data-mouse-helper" to the wrapper of the row
if ( !function_exists( 'mh_shadhin_cursor_mouse_helper_before_render_elements' ) ) {
	// Before Elementor 2.1.0
	add_action( 'elementor/frontend/element/before_render',  'mh_shadhin_cursor_mouse_helper_before_render_elements', 10, 1 );
	// After Elementor 2.1.0
	add_action( 'elementor/frontend/section/before_render', 'mh_shadhin_cursor_mouse_helper_before_render_elements', 10, 1 );
	add_action( 'elementor/frontend/column/before_render', 'mh_shadhin_cursor_mouse_helper_before_render_elements', 10, 1 );
	add_action( 'elementor/frontend/widget/before_render', 'mh_shadhin_cursor_mouse_helper_before_render_elements', 10, 1 );
	function mh_shadhin_cursor_mouse_helper_before_render_elements($element) {
		if ( is_object($element) ) {
			$mouse_helper = $element->get_settings( 'mouse_helper' );
			if ( ! empty( $mouse_helper ) ) {
        		$settings = $element->get_settings_for_display();
				$element->add_render_attribute( '_wrapper', array(
					'data-mouse-helper' => ! empty( $settings['mouse_helper_action'] ) ? $settings['mouse_helper_action'] : 'hover',
					'data-mouse-helper-centered' => (int) shadhin_plugins_get_redux_option('mouse_helper_centered') == 0
														? ( ! empty( $settings['mouse_helper_centered'] ) ? $settings['mouse_helper_centered'] : 0 )
														: 1,
					'data-mouse-helper-magnet' => ! empty( $settings['mouse_helper_magnet'] ) ? max(0, $settings['mouse_helper_magnet']['size'] ) : 0,
					'data-mouse-helper-color' => ! empty( $settings['mouse_helper_color'] ) ? $settings['mouse_helper_color'] : '',
					'data-mouse-helper-bg-color' => ! empty( $settings['mouse_helper_bg_color'] ) ? $settings['mouse_helper_bg_color'] : '',
					'data-mouse-helper-bd-color' => ! empty( $settings['mouse_helper_bd_color'] ) ? $settings['mouse_helper_bd_color'] : '',
					'data-mouse-helper-mode' => ! empty( $settings['mouse_helper_mode'] ) ? $settings['mouse_helper_mode'] : '',
					'data-mouse-helper-axis' => ! empty( $settings['mouse_helper_axis'] ) ? $settings['mouse_helper_axis'] : 'xy',
					'data-mouse-helper-delay' => ! empty( $settings['mouse_helper_delay'] )
													?  $settings['mouse_helper_delay']['size']
													: ( shadhin_plugins_get_redux_option( 'mouse_helper_delay' )
														? (int) shadhin_plugins_get_redux_option( 'mouse_helper_delay' )
														: 10
														),
					'data-mouse-helper-text' => ! empty( $settings['mouse_helper_text'] ) ? $settings['mouse_helper_text'] : '',
					'data-mouse-helper-text-size'  => ! empty( $settings['mouse_helper_text'] ) && ! empty( $settings['mouse_helper_text_size']['size'] ) ? $settings['mouse_helper_text_size']['size'] : '',
					'data-mouse-helper-text-round' => ! empty( $settings['mouse_helper_text_round'] ) ? $settings['mouse_helper_text_round'] : 0,
					'data-mouse-helper-icon' => ! empty( $settings['mouse_helper_icon'] ) ? $settings['mouse_helper_icon'] : '',
					'data-mouse-helper-icon-size'  => ! empty( $settings['mouse_helper_icon'] ) && ! empty( $settings['mouse_helper_icon_size']['size'] ) ? $settings['mouse_helper_icon_size']['size'] : '',
					'data-mouse-helper-icon-color' => ! empty( $settings['mouse_helper_icon_color'] ) ? $settings['mouse_helper_icon_color'] : '',
					'data-mouse-helper-image' => ! empty( $settings['mouse_helper_image']['url'] ) ? $settings['mouse_helper_image']['url'] : '',
					'data-mouse-helper-layout' => ! empty( $settings['mouse_helper_layout'] ) ? $settings['mouse_helper_layout'] : '',
					'data-mouse-helper-callback' => ! empty( $settings['mouse_helper_callback'] ) ? $settings['mouse_helper_callback'] : '',
				) );
				if ( ! shadhin_plugins_is_preview() ) {
					$element->add_render_attribute( '_wrapper', array(
						'data-mouse-helper-hide-cursor' => ! empty( $settings['mouse_helper_hide_cursor'] ) ? $settings['mouse_helper_hide_cursor'] : 0,
					) );
				}
			}
		}
	}
}



// Add mouse_helper_in_swiper_slider to the list with JS vars
if ( ! function_exists( 'mh_shadhin_skin_mouse_helper_in_swiper_slider_localize_script' ) ) {
	add_action( 'mh_addons_filter_localize_script', 'mh_shadhin_skin_mouse_helper_in_swiper_slider_localize_script' );
	function mh_shadhin_skin_mouse_helper_in_swiper_slider_localize_script( $vars = array() ) {
		$vars['mouse_helper_on_swiper_slider'] = (int) shadhin_plugins_get_redux_option('mouse_helper_on_swiper_slider', 1);
        return $vars;
	}
}