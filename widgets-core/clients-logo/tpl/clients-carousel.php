<?php
	wp_enqueue_style( 'swiper' );
	wp_enqueue_script( 'swiper' );
	//Swiper Slider Data
	$swiper_slide_data_info = shadhin_plugins_swiper_data_params( $settings );
?>
<?php if ( $clients_logo_array ) : ?>
	<div class="mh-sc-clients-logo clients-carousel mh-swiper-container <?php if( !empty($classes) ) echo esc_attr(implode(' ', $classes)); ?>" <?php echo html_entity_decode( esc_attr( implode(' ', $swiper_slide_data_info) ) ) ?>>
		<div class="swiper-container-inner">
			<div class="swiper-wrapper">
				<!-- the loop -->
				<?php foreach (  $clients_logo_array as $clients_logo ) { ?>
					<div class="swiper-slide">
						<?php include( 'common.php' ); ?>
					</div>
				<?php } ?>
				<!-- end of the loop -->
			</div>
		</div>

		<div class="swiper-pagination <?php if( $bullets !== 'yes' ) echo esc_attr( "d-none" ); ?>"></div>

		<div class="mh-swiper-arrow mh-swiper-button-wrap <?php if( $arrow !== 'yes' ) echo esc_attr( "d-none" ); ?>">
			<div class="mh-swiper-arrow mh-swiper-button-prev"><i class="lnr-icon-arrow-left"></i></div>
			<div class="mh-swiper-arrow mh-swiper-button-next"><i class="lnr-icon-arrow-right"></i></div>
		</div>
	</div>
<?php else : ?>
	<?php shadhin_plugins_no_posts_match_criteria_text(); ?>
<?php endif; ?>