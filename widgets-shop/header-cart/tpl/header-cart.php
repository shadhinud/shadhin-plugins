<div class="woocommerce top-nav-mini-cart-icon-container">
	<div class="top-nav-mini-cart-icon-contents">
		<a class="mini-cart-icon" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'shadhin-plugins' ); ?>"><i class="lnr lnr-icon-cart1"></i>
			<?php if ( WC()->cart ) { ?>
			<span class="items-count"><?php echo esc_html( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'shadhin-plugins' ), WC()->cart->get_cart_contents_count() ) ); ?></span> <span class="cart-quick-info"><?php echo esc_html( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'shadhin-plugins' ), WC()->cart->get_cart_contents_count() ) ); ?> - <?php echo wp_kses_post( WC()->cart->get_cart_total() ); ?></span>
			<?php }?>
		</a>

		<div class="dropdown-content">
			<?php if(WC()->cart){?>
			<?php woocommerce_mini_cart(); ?>
			<?php }?>
		</div>
	</div>
</div>


<?php
	if( class_exists('Woocommerce') && shadhin_plugins_plugin_installed() ) {
		if( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		} else if( $search_dropdown_content_style == 'style-side-panel' ) {
			shadhin_floating_cart_sidebar();
		}
	}
?>