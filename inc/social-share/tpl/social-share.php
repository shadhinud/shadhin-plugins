
<?php if ( $enabled_social_networks ) : ?>
	<div class="mh-social-share-icons">
		<div class="title"><i class="fa fa-share-alt"></i> <?php echo esc_html( $sharing_heading );?></div>
		<?php
			if( $social_icon_type == 'icon' ) {
				shadhin_plugins_get_inc_folder_template_part( 'icon', null, 'social-share/tpl', $params );
			} else if ( $social_icon_type == 'text' ) {
				shadhin_plugins_get_inc_folder_template_part( 'text', null, 'social-share/tpl', $params );
			} else if ( $social_icon_type == 'icon-brand' ) {
				shadhin_plugins_get_inc_folder_template_part( 'icon-brand', null, 'social-share/tpl', $params );
			}
		?>
	</div>
<?php endif; ?>