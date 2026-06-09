<?php
// Block direct requests
if ( !defined('ABSPATH') ) die('-1');


if(!function_exists('shadhin_plugins_register_widgets')) {
	/**
	 * Register all widgets
	 */
	function shadhin_plugins_register_widgets() {
		$widget_list = array(
			'Shadhin_plugins_Widget_BlogList',
		);

		//apply filter
		if( has_filter('shadhin_plugins_register_widgets_add_widgets') ) {
			$widget_list = apply_filters('shadhin_plugins_register_widgets_add_widgets', $widget_list);
		}

		foreach( $widget_list as $each_widget ) {
			register_widget( $each_widget );
		}

	}
	/* Register the widget */
	shadhin_plugins_register_widgets();
}
