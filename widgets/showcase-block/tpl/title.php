<?php
	//link url
	$target = ( $btn1_link && $btn1_link['is_external'] ) ? ' target="_blank"' : '';
	$url = ( $btn1_link && $btn1_link['url'] ) ? $btn1_link['url'] : '';
?>

	<?php if( !empty( $title ) ) : ?>
	<<?php echo esc_attr( $title_tag );?> class="showcase-title">
		<?php if( !empty( $url ) ): ?>
		<a
			<?php if ( ! empty( $target ) ) : ?> target="_blank"<?php endif; ?>
			href="<?php echo esc_url( $url );?>">
			<?php echo wp_kses_post( $title ); ?>
		</a>
		<?php else: ?>
			<?php echo wp_kses_post( $title ); ?>
		<?php endif ?>
	</<?php echo esc_attr( $title_tag );?>>
	<?php endif; ?>