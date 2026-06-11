
	<?php if (  $loadmore_show_view_details_button === 'yes' && $the_query->max_num_pages > 1 ) { ?>
		<div class="clearfix"></div>
		<div class="mh-loadmore-container">
			<button
				id="mh-loadmore-btn-<?php echo esc_attr( $holder_id );?>"
				data-target="<?php echo esc_attr( $holder_id );?>"
			  	class="mh-btn-loadmore <?php echo esc_attr(implode(' - ', $loadmore_btn_classes)); ?>">
			 	<?php echo esc_html( $loadmore_view_details_button_text  ); ?>
			</button>
			<a
				id="mh-loadmore-btn-<?php echo esc_attr( $holder_id );?>-trigger-lightgallery"
				class="mh-loadmore-btn-trigger-lightgallery d-none">
			</a>
		</div>
	<?php } ?>