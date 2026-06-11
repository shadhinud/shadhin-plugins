<?php $settings['settings'] = $settings; ?>
<?php if ( $slider_items_array ) : ?>
	<div class="mh-twentytwenty-slider mh-twentytwenty-slider-basic">
		<!-- Isotope Gallery Grid -->
		<div id="<?php echo esc_attr( $holder_id ) ?>" class="feature-layout clearfix">
				<!-- the loop -->
				<?php foreach (  $slider_items_array as $slider_items ) { ?>
					<?php $settings['slider_items'] = $slider_items; ?>
					<?php shadhin_plugins_get_shortcode_template_part( 'before-after-slider', null, 'before-after-slider/tpl', $settings, false ); ?>
				<?php } ?>
				<!-- end of the loop -->
		</div>
		<?php wp_reset_postdata(); ?>
	</div>

<?php else : ?>
	<?php shadhin_plugins_no_posts_match_criteria_text(); ?>
<?php endif; ?>
