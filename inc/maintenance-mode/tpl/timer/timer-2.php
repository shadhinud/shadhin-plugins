<?php
  $date_array = explode('/', $launch_date); //example 11/24/2016
  $new_date_string = $date_array[2] . ', ' . ($date_array[0]-1) . ', ' . $date_array[1] . ', ' . $launch_hour . ', ' . $launch_minute;
?>
				<div id="flipclock1" class="clock" style="margin:2em; width: auto; display: inline-block;"></div>
				<!-- FlipClock Script -->
				<script type="text/javascript">
				  var clock;
				  $(document).ready(function() {
					// Grab the current date
					var currentDate = new Date();
					// Set some date in the future. In this case, it's always Jan 1
					//Remember For month:  Jan = 0, Feb = 1, Mar = 2, ... , Oct = 9, Nov = 10 and Dec = 11;
					//var futureDate  = new Date(2017, 6, 10, 16, 24); //Date(year, month, day, hours, minutes, seconds, milliseconds);
					var futureDate  = new Date(<?php echo esc_html( $new_date_string );?>); //Date(year, month, day, hours, minutes, seconds, milliseconds);

					// Calculate the difference in seconds between the future and current date
					var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000;
					// Instantiate a coutdown FlipClock
					clock = $('#flipclock1').FlipClock(diff, {
					  clockFace: 'DailyCounter',
					  countdown: true
					});
				  });
				</script>