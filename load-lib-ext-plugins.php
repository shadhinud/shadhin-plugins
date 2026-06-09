<?php

//load lib
require_once SHADHIN_PLUGINS_ABS_PATH . 'lib/plugin-core-functions.php';
require_once SHADHIN_PLUGINS_ABS_PATH . 'lib/functions.php';
require_once SHADHIN_PLUGINS_ABS_PATH . 'lib/plugin-core-utility-variables-functions.php';

/* REDUX OPTIONS FRAMEWORK
================================================== */
if ( class_exists( 'ReduxFramework' ) ) {
require_once SHADHIN_PLUGINS_ABS_PATH . 'external-plugins/redux-framework/init-redux-args.php';
}

/* scss_parser
================================================== */
if ( ! class_exists( 'scss_parser' ) ) {
require_once SHADHIN_PLUGINS_ABS_PATH . 'external-plugins/scssphp/scss.inc.php';
}

/* WordPress Post Like System
================================================== */
if (!function_exists('shadhin_plugins_sl_get_simple_likes_button')) {
require_once SHADHIN_PLUGINS_ABS_PATH . 'external-plugins/wp-post-like-system/post-like.php';
}

//mouse helper addons
if( function_exists('shadhin_plugins_theme_installed' ) ) {
require_once SHADHIN_PLUGINS_ABS_PATH . 'external-plugins/mouse-helper/mouse-helper.php';
}