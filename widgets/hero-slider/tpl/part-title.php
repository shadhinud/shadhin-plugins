	<?php if( !empty( $title ) ) : ?>
	<<?php echo esc_attr( $title_tag );?> class="slider-title">
		<?php echo wp_kses_post( $title ); ?>
	</<?php echo esc_attr( $title_tag );?>>
	<?php endif; ?>