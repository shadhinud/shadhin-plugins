<?php
/**
 * The template for displaying Coming Soon Page
 *
 * This is the template that displays Coming Soon page by default.
 *
 */
add_filter( 'shadhin_plugins_filter_show_header', 'shadhin_plugins_return_false' );
add_filter( 'shadhin_plugins_filter_show_footer', 'shadhin_plugins_return_false' );

//change the page title
if( shadhin_plugins_get_redux_option( 'maintenance-mode-settings-title' ) != '' ) {
	add_filter('pre_get_document_title', 'shadhin_plugins_change_the_title');
	function shadhin_plugins_change_the_title() {
		return shadhin_plugins_get_redux_option( 'maintenance-mode-settings-title' );
	}
}

?>

<?php
	shadhin_plugins_get_maintenance_mode_parts();
?>
<?php
