
				<div id="basic-coupon-clock" class="final-countdown-timer pt-10 pb-10"></div>

				<!-- Final Countdown Timer Script -->
				<script type="text/javascript">
				  $(document).ready(function() {
					$('#basic-coupon-clock').countdown('<?php echo esc_html( $launch_date.' '.$launch_hour.':'.$launch_minute );?>', function(event) {
					  $(this).html(event.strftime('<?php echo esc_html( $style1_format );?>'));
					});
				  });
				</script>