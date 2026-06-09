			<ul class="styled-icons icon-dark icon-circled icon-sm">
				<?php
				if( $social_links ): foreach( $social_links as $key => $value ) {
					if( !_empty( shadhin_get_redux_option( 'social-links-url-'.$key ) ) ) :
				?>
				<li><a href="<?php echo shadhin_get_redux_option( 'social-links-url-'.$key ); ?>" target="<?php echo shadhin_get_redux_option( 'social-links-open-in-window' ); ?>"><i class="fa fa-<?php echo esc_attr( $key ); ?>"></i></a></li>
				<?php endif; } endif; ?>
			</ul>