<?php $settings['settings'] = $settings; ?>
<?php
	//Swiper Slider Data
	$swiper_slide_data_info = shadhin_plugins_swiper_data_params( $settings );
?>
<?php if ( $hero_slider_items_array ) : ?>
	<div id="<?php echo esc_attr( $holder_id ) ?>" class="mh-sc-hero-slider mh-horizontal-hero-slider <?php if( !empty($classes) ) echo esc_attr(implode(' ', $classes)); ?>" <?php echo html_entity_decode( esc_attr( implode(' ', $swiper_slide_data_info) ) ) ?>>
		<div class="swiper-container-inner">
			<div class="swiper-wrapper">
				<!-- the loop -->
				<?php foreach (  $hero_slider_items_array as $hero_slider_item ) { ?>
					<?php $settings['hero_slider_item'] = $hero_slider_item; ?>
					<?php
						$animation = "";
						$animation_delay = "";
						if(isset($hero_slider_item['wow_appear_animation']) && !empty($hero_slider_item['wow_appear_animation'])) {
							$animation = $hero_slider_item['wow_appear_animation'];
						}
						if(isset($hero_slider_item['wow_animation_delay']) && !empty($hero_slider_item['wow_animation_delay'])) {
							$animation_delay = $hero_slider_item['wow_animation_delay'] . 'ms';
						}
					?>
					<div class="swiper-slide elementor-repeater-item-<?php echo esc_attr( $hero_slider_item['_id'] ); ?> <?php echo esc_attr($animation);?>" data-wow-delay="<?php echo esc_attr($animation_delay);?>">
						<?php shadhin_plugins_get_shortcode_template_part( 'slider-item', $_skin, 'hero-slider/tpl', $settings, false ); ?>
					</div>
				<?php } ?>
				<!-- end of the loop -->
			</div>
		</div>


		<div class="mh-parts-thumbnail">
			<div class="swiper swiper-item-wrap mh-hero-slider-thumb">
				<div class="swiper-wrapper">
					<?php foreach (  $hero_slider_items_array as $hero_slider_item ) { ?>
					<?php $settings['hero_slider_item'] = $hero_slider_item; ?>
					<div class="swiper-slide">
						<?php shadhin_plugins_get_shortcode_template_part( 'slider-item-thumb', $_skin, 'hero-slider/tpl', $settings, false ); ?>
					</div>
					<?php } ?>
					<!-- end of the loop -->
				</div>
			</div>
		</div>

		<div class="swiper-pagination <?php if( $bullets !== 'yes' ) echo esc_attr( "d-none" ); ?>"></div>

		<div class="mh-swiper-arrow-wrap mh-swiper-button-wrap <?php if( $arrow !== 'yes' ) echo esc_attr( "d-none" ); ?>">
			<div class="mh-swiper-arrow mh-swiper-button-prev"><i class="lnr-icon-arrow-left"></i></div>
			<div class="mh-swiper-arrow mh-swiper-button-next"><i class="lnr-icon-arrow-right"></i></div>
		</div>
	</div>

<?php else : ?>
	<?php shadhin_plugins_no_posts_match_criteria_text(); ?>
<?php endif; ?>