<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "shadhin_redux_theme_opt";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => esc_html__( 'Theme Options', 'shadhin-plugins' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Theme Options', 'shadhin-plugins' ),
        'page_title'           => esc_html__( 'Theme Options', 'shadhin-plugins' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyBliGynKGbW5yf2YgZv_Dov38wUipnsiII',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => true,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-admin-settings dashicons-mascot-theme-options',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => 'shadhin_redux_theme_opt',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => esc_html__( 'Right', 'shadhin-plugins' ),
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    /*$args['admin_bar_links'][] = array(
        'id'    => 'redux-docs',
        'href'  => 'http://docs.reduxframework.com/',
        'title' => esc_html__( 'Documentation', 'shadhin-plugins' ),
    );

    $args['admin_bar_links'][] = array(
        //'id'    => 'redux-support',
        'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
        'title' => esc_html__( 'Support', 'shadhin-plugins' ),
    );*/

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'mailto:mhshadhin@gmail.com',
        'title' => 'Send an email to MhShadhin',
        'icon'  => 'el el-icon-envelope'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/mhshadhin',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://themeforest.net/user/mhshadhin',
        'title' => 'Contact with Author',
        'icon'  => 'el el-icon-link'
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        //$args['intro_text'] = sprintf( esc_html__( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'shadhin-plugins' ), $v );
    } else {
        //$args['intro_text'] = esc_html__( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'shadhin-plugins' );
    }

    // Add content after the form.
    $args['footer_text'] = '';

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'shadhin-plugins' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'shadhin-plugins' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'shadhin-plugins' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'shadhin-plugins' )
        )
    );
    Redux::set_help_tab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'shadhin-plugins' );
    Redux::set_help_sidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */




    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => esc_html__( 'Section via hook', 'shadhin-plugins' ),
                'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'shadhin-plugins' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }


    /* This section is removed due to "Resource caching" plugin territory issue */

    //maintenance section opt added into the theme
    function shadhin_plugins_redux_opt_maintenance_section() {
        $site_url = site_url();
        $maintenance_site_url = '<a href="' . esc_url( $site_url . '?view-maintenance-mode=true' ) . '" target="_blank">click here</a>';
        // -> START Maintenance Mode Settings
        $maintenance_section =  array(
            'title'  => esc_html__( 'Maintenance Mode', 'shadhin-plugins' ),
            'id'     => 'maintenance-mode-settings',
            'desc'   => wp_kses_post( sprintf( esc_html__( 'Add a maintenance page to your website to let visitors know your site is down for maintenance. Only users with admin rights get full access to the site. And as an administrator, you will not be able to see the maintenance page. If you want to see it then %s', 'shadhin-plugins' ), $maintenance_site_url ) ),
            'icon'   => 'dashicons-before dashicons-hammer',
            'fields' => array(

                array(
                    'id'       => 'maintenance-mode-settings-status',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Maintenance Mode', 'shadhin-plugins' ),
                    'subtitle' => '',
                    'default'  => 0,
                    'on'       => 'Enabled',
                    'off'      => 'Disabled',
                ),
                array(
                    'id'       => 'maintenance-mode-layout-ordering',
                    'type'     => 'sorter',
                    'title'    => esc_html__( 'Layout Ordering', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Reorder them by shifting up and down.', 'shadhin-plugins' ),
                    'desc'     => '',
                    'compiler' => 'true',
                    'options'  => array(
                        'ordering' => array(
                            'title'     => 'Title',
                            'content'    => 'Content',
                            'timer' => 'Countdown Timer',
                        ),
                    ),
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),

                array(
                    'id'       => 'maintenance-mode-settings-enable-social-links',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Social Links', 'shadhin-plugins' ),
                    'subtitle' => '',
                    'default'  => 0,
                    'on'       => esc_html__( 'Yes', 'shadhin-plugins' ),
                    'off'      => esc_html__( 'No', 'shadhin-plugins' ),
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),





                //Logo Starts
                array(
                    'id'       => 'maintenance-mode-settings-logo-status',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Logo', 'shadhin-plugins' ),
                    'subtitle' => '',
                    'default'  => 0,
                    'on'       => esc_html__( 'Yes', 'shadhin-plugins' ),
                    'off'      => esc_html__( 'No', 'shadhin-plugins' ),
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-logo',
                    'type'     => 'media',
                    'url'      => false,
                    'title'    => esc_html__( 'Logo', 'shadhin-plugins' ),
                    'compiler' => 'true',
                    //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                    'desc'     => esc_html__( 'Basic media uploader with disabled URL input field.', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Upload a 32px x 32px png/gif image that will represent your website favicon.', 'shadhin-plugins' ),
                    //'default'  => array( 'url' => MASCOT_ASSETS_URI . '/images/logo/logo-wide.png' ),
                    'required' => array(
                        array( 'maintenance-mode-settings-logo-status', '=', '1' )
                    )
                ),
                array(
                    'id'       => 'maintenance-mode-settings-logo-max-width',
                    'type'    => 'spinner',
                    'title'   => esc_html__( 'Logo Maximum Width', 'shadhin-plugins' ),
                    'desc'    => esc_html__( 'Set maximum width for uploaded logo (in px)', 'shadhin-plugins' ),
                    'default' => '200',
                    'min'     => '20',
                    'step'    => '1',
                    'max'     => '1000',
                    'required' => array(
                        array( 'maintenance-mode-settings-logo-status', '=', '1' )
                    )
                ),




                //section Title Starts
                array(
                    'id'       => 'maintenance-mode-settings-title-typography-starts',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Title', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Define text and styles for Title.', 'shadhin-plugins' ),
                    'indent'   => true, // Indent all options below until the next 'section' option is set.
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-title',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Title Text', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Set page title to show', 'shadhin-plugins' ),
                    'desc'     => '',
                    'default'  => esc_html__( 'Site Under Construction', 'shadhin-plugins' ),
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'            => 'maintenance-mode-settings-title-typography',
                    'type'          => 'typography',
                    'title'         => esc_html__( 'Title Typography', 'shadhin-plugins' ),
                    'subtitle'      => '',
                    //'compiler'    => true,  // Use if you want to hook in your own CSS compiler
                    'google'        => true,
                    // Disable google fonts. Won't work if you haven't defined your google api key
                    'font-backup'   => false,
                    // Select a backup non-google font in addition to a google font
                    'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'font-weight'   => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'subsets'       => false, // Only appears if google is true and subsets not set to false
                    'font-size'     => true,
                    'line-height'   => true,
                    'word-spacing'  => true,  // Defaults to false
                    'letter-spacing'=> true,  // Defaults to false
                    'text-transform'=> true,  // Defaults to false
                    'color'         => true,
                    'preview'       => true, // Disable the previewer
                    'all_styles'    => true,
                    'units'         => 'px',
                    'required'      => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-title-margin-top-bottom',
                    'type'     => 'spacing',
                    // An array of CSS selectors to apply this font style to
                    'mode'     => 'margin',
                    // absolute, padding, margin, defaults to padding
                    'all'      => false,
                    // Have one field that applies to all
                    'top'      => true,     // Disable the top
                    'right'    => false,     // Disable the right
                    'bottom'   => true,     // Disable the bottom
                    'left'     => false,     // Disable the left
                    'units'    => 'px',      // You can specify a unit value. Possible: px, em, %
                    //'units_extended'=> 'true',    // Allow users to select any type of unit
                    'display_units' => true,   // Set to false to hide the units if the units are specified
                    'title'    => esc_html__( 'Margin Top & Bottom', 'shadhin-plugins' ),
                    'subtitle' => '',
                    'desc'     => '',
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-title-typography-ends',
                    'type'   => 'section',
                    'indent' => false, // Indent all options below until the next 'section' option is set.
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),






                //section Content Starts
                array(
                    'id'       => 'maintenance-mode-settings-content-typography-starts',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Content', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Define text and styles for Content.', 'shadhin-plugins' ),
                    'indent'   => true, // Indent all options below until the next 'section' option is set.
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-content',
                    'type'     => 'editor',
                    'title'    => esc_html__( 'Content Text', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Enter the content for maintenance page which will be showed below logo and countdown timer if those are selected', 'shadhin-plugins' ),
                    'default'  => 'Sorry, server is down for maintenance. We are improving and fixing problems of our website. <br> We will be back very soon...',
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'            => 'maintenance-mode-settings-content-typography',
                    'type'          => 'typography',
                    'title'         => esc_html__( 'Content Typography', 'shadhin-plugins' ),
                    'subtitle'      => '',
                    //'compiler'    => true,  // Use if you want to hook in your own CSS compiler
                    'google'        => true,
                    // Disable google fonts. Won't work if you haven't defined your google api key
                    'font-backup'   => false,
                    // Select a backup non-google font in addition to a google font
                    'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'font-weight'   => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'subsets'       => false, // Only appears if google is true and subsets not set to false
                    'font-size'     => true,
                    'line-height'   => true,
                    'word-spacing'  => true,  // Defaults to false
                    'letter-spacing'=> true,  // Defaults to false
                    'text-transform'=> true,  // Defaults to false
                    'color'         => true,
                    'preview'       => true, // Disable the previewer
                    'all_styles'    => true,
                    'units'         => 'px',
                    'required'      => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-content-margin-top-bottom',
                    'type'     => 'spacing',
                    // An array of CSS selectors to apply this font style to
                    'mode'     => 'margin',
                    // absolute, padding, margin, defaults to padding
                    'all'      => false,
                    // Have one field that applies to all
                    'top'      => true,     // Disable the top
                    'right'    => false,     // Disable the right
                    'bottom'   => true,     // Disable the bottom
                    'left'     => false,     // Disable the left
                    'units'    => 'px',      // You can specify a unit value. Possible: px, em, %
                    //'units_extended'=> 'true',    // Allow users to select any type of unit
                    'display_units' => true,   // Set to false to hide the units if the units are specified
                    'title'    => esc_html__( 'Margin Top & Bottom', 'shadhin-plugins' ),
                    'subtitle' => '',
                    'desc'     => '',
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-content-typography-ends',
                    'type'   => 'section',
                    'indent' => false, // Indent all options below until the next 'section' option is set.
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),




                //section custom background
                array(
                    'id'       => 'maintenance-mode-settings-custom-background-starts',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Custom Background', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Define Custom Background for maintenance page.', 'shadhin-plugins' ),
                    'indent'   => true, // Indent all options below until the next 'section' option is set.
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-custom-background-status',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Custom Background', 'shadhin-plugins' ),
                    'subtitle' => '',
                    'default'  => 0,
                    'on'       => esc_html__( 'Yes', 'shadhin-plugins' ),
                    'off'      => esc_html__( 'No', 'shadhin-plugins' ),
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-bg',
                    'type'     => 'background',
                    'title'    => esc_html__( 'Background', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Choose background image or color.', 'shadhin-plugins' ),
                    'required' => array(
                        array( 'maintenance-mode-settings-custom-background-status', '=', '1' )
                    )
                ),
                array(
                    'id'       => 'maintenance-mode-settings-bg-layer-overlay-status',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Add Background Overlay', 'shadhin-plugins' ),
                    'subtitle' => '',
                    'default'  => 0,
                    'on'       => esc_html__( 'Yes', 'shadhin-plugins' ),
                    'off'      => esc_html__( 'No', 'shadhin-plugins' ),
                    'required' => array(
                        array( 'maintenance-mode-settings-custom-background-status', '=', '1' )
                    )
                ),
                array(
                    'id'       => 'maintenance-mode-settings-bg-layer-overlay',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Background Overlay Opacity', 'shadhin-plugins' ),
                    'subtitle'      => esc_html__( 'Overlay on background image on footer.', 'shadhin-plugins' ),
                    'desc'          => '',
                    'default'       => 7,
                    'min'           => 1,
                    'step'          => 1,
                    'max'           => 9,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'maintenance-mode-settings-bg-layer-overlay-status', '=', '1' )
                    )
                ),
                array(
                    'id'       => 'maintenance-mode-settings-bg-layer-overlay-color',
                    'type'     => 'button_set',
                    'compiler' =>true,
                    'title'    => esc_html__( 'Background Overlay Color', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Select Dark or White Overlay on background image.', 'shadhin-plugins' ),
                    'options'  => array(
                        'dark'          => esc_html__( 'Dark', 'shadhin-plugins' ),
                        'white'         => esc_html__( 'White', 'shadhin-plugins' ),
                        'theme-colored' => esc_html__( 'Primary Theme Color', 'shadhin-plugins' )
                    ),
                    'default' => 'dark',
                    'required' => array(
                        array( 'maintenance-mode-settings-bg-layer-overlay-status', '=', '1' )
                    )
                ),
                array(
                    'id'       => 'maintenance-mode-settings-custom-background-status-section-ends',
                    'type'     => 'section',
                    'title'    => '',
                    'subtitle' => '',
                    'indent'   => false, // Indent all options below until the next 'section' option is set.
                ),




                //section Countdown Timer
                array(
                    'id'       => 'maintenance-mode-settings-countdown-timer-section-starts',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Countdown Timer', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Define time and styles for Countdown Timer.', 'shadhin-plugins' ),
                    'indent'   => true, // Indent all options below until the next 'section' option is set.
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-countdown-timer-status',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Countdown Timer', 'shadhin-plugins' ),
                    'subtitle' => '',
                    'default'  => 0,
                    'on'       => esc_html__( 'Yes', 'shadhin-plugins' ),
                    'off'      => esc_html__( 'No', 'shadhin-plugins' ),
                    'required' => array( 'maintenance-mode-settings-status', '=', '1' ),
                ),
                array(
                    'id'       => 'maintenance-mode-settings-countdown-timer-day',
                    'type'     => 'date',
                    'title'    => esc_html__( 'Launch Date', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Enter the date when your website will be launched. The countdown will count to that day.', 'shadhin-plugins' ),
                    'desc'     => '',
                    'default'  => date('m/d/Y', strtotime('+2 Years')),
                    'placeholder'     => 'Choose Date',
                    'required' => array(
                        array( 'maintenance-mode-settings-countdown-timer-status', '=', '1' )
                    )
                ),
                array(
                    'id'            => 'maintenance-mode-settings-countdown-timer-hour',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Launch Hour', 'shadhin-plugins' ),
                    'subtitle'      => esc_html__( 'Choose launcing hour in between 0 to 23 (24 hour format).', 'shadhin-plugins' ),
                    'desc'          => '',
                    'default'       => 7,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 23,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'maintenance-mode-settings-countdown-timer-status', '=', '1' )
                    )
                ),
                array(
                    'id'            => 'maintenance-mode-settings-countdown-timer-minute',
                    'type'          => 'slider',
                    'title'         => esc_html__( 'Launch Minute', 'shadhin-plugins' ),
                    'subtitle'      => esc_html__( 'Choose launcing Minute in between 0 to 59.', 'shadhin-plugins' ),
                    'desc'          => '',
                    'default'       => 30,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 59,
                    'display_value' => 'text',
                    'required' => array(
                        array( 'maintenance-mode-settings-countdown-timer-status', '=', '1' )
                    )
                ),
                array(
                    'id'       => 'maintenance-mode-settings-countdown-timer-margin-top-bottom',
                    'type'     => 'spacing',
                    // An array of CSS selectors to apply this font style to
                    'mode'     => 'margin',
                    // absolute, padding, margin, defaults to padding
                    'all'      => false,
                    // Have one field that applies to all
                    'top'      => true,     // Disable the top
                    'right'    => false,     // Disable the right
                    'bottom'   => true,     // Disable the bottom
                    'left'     => false,     // Disable the left
                    'units'    => 'px',      // You can specify a unit value. Possible: px, em, %
                    //'units_extended'=> 'true',    // Allow users to select any type of unit
                    'display_units' => true,   // Set to false to hide the units if the units are specified
                    'title'    => esc_html__( 'Margin Top & Bottom', 'shadhin-plugins' ),
                    'subtitle' => '',
                    'desc'     => '',
                    'required' => array(
                        array( 'maintenance-mode-settings-countdown-timer-status', '=', '1' )
                    )
                ),
                array(
                    'id'       => 'maintenance-mode-settings-countdown-timer-style',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Countdown Timer Style', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Choose one from different styles', 'shadhin-plugins' ),
                    'desc'     => '',
                    'options'  => array(
                        '1' => 'Style 1 - Final Countdown',
                        '2' => 'Style 2 - Flip Clock',
                        '3' => 'Style 3 - Classy Countdown',
                    ),
                    'default'  => '1',
                    'required' => array(
                        array( 'maintenance-mode-settings-countdown-timer-status', '=', '1' )
                    )
                ),
                array(
                    'id'       => 'maintenance-mode-settings-countdown-timer-style1-format',
                    'type'     => 'textarea',
                    'title'    => esc_html__( 'Date Time Format', 'shadhin-plugins' ),
                    'subtitle' => esc_html__( 'Enter the date time format to display', 'shadhin-plugins' ),
                    'desc'     => '',
                    'default'  => '%D <span>Days</span> %H <span>Hours</span> %M <span>Minutes</span> %S <span>Seconds</span>',
                    'required' => array(
                        array( 'maintenance-mode-settings-countdown-timer-style', '=', '1' )
                    )
                ),
                array(
                    'id'            => 'maintenance-mode-settings-countdown-timer-typography',
                    'type'          => 'typography',
                    'title'         => esc_html__( 'Countdown Timer Typography', 'shadhin-plugins' ),
                    'subtitle'      => '',
                    //'compiler'    => true,  // Use if you want to hook in your own CSS compiler
                    'google'        => true,
                    // Disable google fonts. Won't work if you haven't defined your google api key
                    'font-backup'   => false,
                    // Select a backup non-google font in addition to a google font
                    'font-style'    => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'font-weight'   => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'subsets'       => false, // Only appears if google is true and subsets not set to false
                    'font-size'     => true,
                    'line-height'   => true,
                    'word-spacing'  => true,  // Defaults to false
                    'letter-spacing'=> true,  // Defaults to false
                    'text-transform'=> true,  // Defaults to false
                    'color'         => true,
                    'preview'       => true, // Disable the previewer
                    'all_styles'    => true,
                    'units'         => 'px',
                    'required' => array(
                        array( 'maintenance-mode-settings-countdown-timer-style', '=', '1' )
                    )
                ),
                array(
                    'id'       => 'maintenance-mode-settings-countdown-timer-section-ends',
                    'type'     => 'section',
                    'title'    => '',
                    'subtitle' => '',
                    'indent'   => false, // Indent all options below until the next 'section' option is set.
                ),
            )
        );
        return $maintenance_section;
    }

    if ( ! shadhin_plugins_theme_installed() ) {
        Redux::setSection( $opt_name, shadhin_plugins_redux_opt_maintenance_section() );
    }