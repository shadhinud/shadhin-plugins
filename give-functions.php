<?php

function shadhin_plugins_goal_progress($form_id, $args) {
  $form        = new \Give_Donate_Form( $form_id );
  $goal_option = give_get_meta( $form->ID, '_give_goal_option', true );

  // Sanity check - ensure form has pass all condition to show goal.
  if ( ( isset( $args['show_goal'] ) && ! filter_var( $args['show_goal'], FILTER_VALIDATE_BOOLEAN ) )
     || empty( $form->ID )
     || ( is_singular( 'give_forms' ) && ! give_is_setting_enabled( $goal_option ) )
     || ! give_is_setting_enabled( $goal_option ) || 0 === $form->goal ) {
    return false;
  }

  $goal_format         = give_get_form_goal_format( $form_id );
  $price               = give_get_meta( $form_id, '_give_set_price', true );
  $color               = give_get_meta( $form_id, '_give_goal_color', true );
  $show_text           = isset( $args['show_text'] ) ? filter_var( $args['show_text'], FILTER_VALIDATE_BOOLEAN ) : true;
  $show_bar            = isset( $args['show_bar'] ) ? filter_var( $args['show_bar'], FILTER_VALIDATE_BOOLEAN ) : true;
  $goal_progress_stats = give_goal_progress_stats( $form );

  $income = $goal_progress_stats['raw_actual'];
  $goal   = $goal_progress_stats['raw_goal'];

  switch ( $goal_format ) {

    case 'donation':
      $progress           = $goal ? round( ( $income / $goal ) * 100, 2 ) : 0;
      $progress_bar_value = $income >= $goal ? 100 : $progress;
      break;

    case 'donors':
      $progress_bar_value = $goal ? round( ( $income / $goal ) * 100, 2 ) : 0;
      $progress           = $progress_bar_value;
      break;

    case 'percentage':
      $progress           = $goal ? round( ( $income / $goal ) * 100, 2 ) : 0;
      $progress_bar_value = $income >= $goal ? 100 : $progress;
      break;

    default:
      $progress           = $goal ? round( ( $income / $goal ) * 100, 2 ) : 0;
      $progress_bar_value = $income >= $goal ? 100 : $progress;
      break;

  }

  /**
   * Filter the goal progress output
   *
   * @since 1.8.8
   */
  $progress = apply_filters( 'give_goal_amount_funded_percentage_output', $progress, $form_id, $form );
  ?>
	<?php if ( ! empty( $show_bar ) ) : ?>
	<div class="give-goal-progress-bar">
		<div class="mh-sc-progress-bar" data-percent="<?php echo esc_attr( $progress_bar_value );?>" data-unit-right="%">
			<div class="progress-holder">
				<div class="progress-content"></div>
			</div>
		</div>
	</div>
	<?php endif; ?>
  <?php
}


function shadhin_plugins_give_progress_bar($total_earnings, $total_goal) {
  // Total Earnings.
  $total = give_maybe_sanitize_amount( $total_earnings );

  // Total Goal.
  $total_goal = give_maybe_sanitize_amount( $total_goal );

  // Bail out if total goal is empty.
  if ( empty( $total_goal ) ) {
    return false;
  }

  // Give total.
  $total = ! empty( $total ) ? $total : 0;

  /**
   * Filter the goal progress output
   *
   * @since 2.1
   */
  $progress = round( ( $total / $total_goal ) * 100, 2 );

  // Set progress to 100 percentage if total > total_goal
  $progress = $total >= $total_goal ? 100 : $progress;
  $progress = apply_filters( 'give_goal_totals_funded_percentage_output', $progress, $total, $total_goal );

  ?>
  <div class="give-goal-progress-bar">
    <div class="mh-sc-progress-bar" data-percent="<?php echo esc_attr( $progress );?>" data-unit-right="%">
      <div class="progress-holder">
        <div class="progress-content"></div>
      </div>
    </div>
  </div>
  <?php
}


function shadhin_plugins_give_amount_formatted($amount) {
  $currency = give_get_currency();
  $currency_symbol = give_currency_symbol( $currency );
  $currency_pos = give_get_currency_position();

  if( 'before' == $currency_pos ) {
    $amount = $currency_symbol . $amount;
  } else {
    $amount = $amount . $currency_symbol;
  }
  return $amount;
}