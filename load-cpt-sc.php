<?php

/* Loads all Custom Post Types located in post-types folder
================================================== */
require_once SHADHIN_PLUGINS_ABS_PATH . 'lib/interface-post-type.php';

foreach( glob( SHADHIN_PLUGINS_ABS_PATH . 'inc/post-types/*/loader.php' ) as $each_cpt_loader ) {
	require_once $each_cpt_loader;
}

//load shortcodes for custom-post-types
require_once SHADHIN_PLUGINS_ABS_PATH . 'inc/post-types/reg-post-type.php';

use Shadhinplugins\CPT;
use Shadhinplugins\Lib;

// activate custom post types
function shadhin_plugins_reg_custom_post_types() {
    CPT\Reg_Post_Type::get_instance()->register();
}

// flush_rewrite_rules after activating cpt
if ( ! function_exists( 'shadhin_plugins_myplugin_flush_rewrites' ) ) {
	function shadhin_plugins_myplugin_flush_rewrites() {
		// call your CPT registration function here (it should also be hooked into 'init')
		shadhin_plugins_reg_custom_post_types();
		//and flush the rules.
		flush_rewrite_rules();
	}
	register_activation_hook( __FILE__, 'shadhin_plugins_myplugin_flush_rewrites' );
}

//init cpt - priority 15 ensures it runs after plugin initialization (priority 5)
add_action('init', 'shadhin_plugins_reg_custom_post_types', 15);