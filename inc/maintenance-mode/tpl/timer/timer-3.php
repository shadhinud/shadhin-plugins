<?php
	wp_register_style( 'classycountdown-css', MASCOT_TEMPLATE_URI . '/assets/js/classycountdown/css/jquery.classycountdown.css', array(), MASCOT_THEME_VERSION );
	wp_register_script( 'jquery-knob', MASCOT_TEMPLATE_URI . '/assets/js/classycountdown/js/jquery.knob.js', array('jquery'), null, true );
	wp_register_script( 'jquery-throttle', MASCOT_TEMPLATE_URI . '/assets/js/classycountdown/js/jquery.throttle.js', array('jquery'), null, true );
	wp_register_script( 'classycountdown-js', MASCOT_TEMPLATE_URI . '/assets/js/classycountdown/js/jquery.classycountdown.js', array('jquery'), null, true );


	//Enque Styles
	wp_enqueue_style( array( 'classycountdown-css' ) );

	//Enque Scripts
	wp_enqueue_script( array( 'jquery-knob', 'jquery-throttle', 'classycountdown-js' ) );

	$date_array = explode('/', $launch_date); //example 11/24/2016
	$string_date = $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1] . ' '  . $launch_hour . ':' . $launch_minute. ':00';
	
	$format = 'Y-m-d H:i:s';
	$dtime = DateTime::createFromFormat($format, $string_date);
	$timestamp = $dtime->format('U');
?>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div id="classy-countdown-timer" class="ClassyCountdownDemo"></div>
		<!-- Classy Countdown Script -->
		<script type="text/javascript">
		  $(document).ready(function() {
			$('#classy-countdown-timer').ClassyCountdown({
				theme: "flat-colors-very-wide",
				end: '<?php echo esc_html( $timestamp );?>',
				now: '<?php echo time();?>',
			});
		  });
		</script>
	</div>
</div>