<?php
/**
 * The template for displaying Maintenance Mode Page
 *
 * This is the template that displays Maintenance Mode0 page by default.
 *
 */
add_filter( 'shadhin_filter_show_header', 'shadhin_return_false' );
add_filter( 'shadhin_filter_show_footer', 'shadhin_return_false' );

//change the page title
if( shadhin_get_redux_option( 'maintenance-mode-settings-title' ) != '' ) {
	add_filter('pre_get_document_title', 'shadhin_change_the_title');
	function shadhin_change_the_title() {
		return shadhin_get_redux_option( 'maintenance-mode-settings-title' );
	}
}

get_header();
?>

<?php
if ( shadhin_plugins_plugin_installed() ) {
	shadhin_plugins_get_maintenance_mode_parts();
}
?>

<?php get_footer();
