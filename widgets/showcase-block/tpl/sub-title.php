	<?php if( !empty( $subtitle ) ) : ?>
	<<?php echo esc_attr( $subtitle_tag );?> class="showcase-subtitle">
		<?php if( !empty( $url ) ): ?>
		<a
			<?php if ( ! empty( $target ) ) : ?> target="_blank"<?php endif; ?>
			href="<?php echo esc_url( $url );?>">
			<?php echo wp_kses_post( $subtitle ); ?>
		</a>
		<?php else: ?>
			<?php echo wp_kses_post( $subtitle ); ?>
		<?php endif ?>
	</<?php echo esc_attr( $subtitle_tag );?>>
	<?php endif; ?>

