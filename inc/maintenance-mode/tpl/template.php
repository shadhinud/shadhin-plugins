<section class="maintenance-mode fullscreen <?php echo esc_attr( $section_classes );?>">
	<div class="display-table">
		<div class="display-table-cell">
			<div class="container pt-0 pb-0">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<?php do_action( 'shadhin_page_maintenance_mode_content_start' ); ?>
						<?php if( isset( $page_logo ) ) : ?>
							<div class="logo">
								<img src="<?php echo esc_url( $page_logo );?>" alt="">
							</div>
						<?php endif; ?>
						<?php
							foreach ( $layout_ordering as $key => $value ) {
							if ( $key != "placebo" ) {
								shadhin_plugins_get_inc_folder_template_part( $key, null, 'maintenance-mode/tpl/parts', $params );
							}
							}
						?>
						<?php
							if( $enable_social_links ) {
							shadhin_get_social_links_layout();
							}
						?>
						<?php do_action( 'shadhin_page_maintenance_mode_content_end' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>