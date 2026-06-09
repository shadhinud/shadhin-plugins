<?php $settings['settings'] = $settings; ?>
<?php if ( $the_query->have_posts() ) : ?>
	<div class="mh-sc-projects mh-sc-projects-grid <?php if( !empty($classes) ) echo esc_attr(implode(' ', $classes)); ?>">
		<?php include('filter.php'); ?>


		<!-- gsap pin spacer added -->
		<?php if(isset($mh_gsap_pin) && !empty($mh_gsap_pin) && $mh_gsap_pin == 'yes' ) { $classes[] = 'gsap-pin-' . esc_attr($mh_gsap_pin); } ?>

		<!-- Isotope Gallery Grid -->
		<div id="<?php echo esc_attr( $holder_id ) ?>" class="project-layout <?php if( !empty($classes) ) echo esc_attr(implode(' ', $classes)); ?>">
				<!-- the loop -->
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<?php shadhin_plugins_get_cpt_shortcode_template_part( 'each-item', $_skin, 'projects/tpl', $settings, false ); ?>
				<?php endwhile; ?>
				<!-- end of the loop -->
		</div>
		<?php wp_reset_postdata(); ?>
	</div>


<?php else : ?>
	<?php shadhin_plugins_no_posts_match_criteria_text(); ?>
<?php endif; ?>