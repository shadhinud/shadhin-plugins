<?php

//load lib
require_once SHADHIN_PLUGINS_ABS_PATH . 'inc/widgets/lib/abstract-widgets.php';

/* Loads all widgets located in widgets folder
================================================== */
if( !function_exists('shadhin_plugins_load_all_widgets') ) {
	function shadhin_plugins_load_all_widgets() {
		foreach( glob(SHADHIN_PLUGINS_ABS_PATH.'inc/widgets/parts/*/loader.php') as $each_sc_loader ) {
			require_once $each_sc_loader;
		}
		require_once SHADHIN_PLUGINS_ABS_PATH . 'inc/widgets/parts/reg-widgets.php';
	}
	add_action('widgets_init', 'shadhin_plugins_load_all_widgets');
}
remove_filter('widget_text_content', 'wpautop');