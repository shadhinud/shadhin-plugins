<?php $settings['settings'] = $settings;?>
<div class="tm-sc-info-box tm-info-box-skin9">
  <div class="info-box-wrapper">
    <div class="icon-wrapper elementor-icon"><?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
    <div class="info-text">
      <?php shadhin_plugins_get_widgetcore_template_part( 'title', null, 'info-box/tpl', $settings, false );?>
      <div class="text"><?php echo wp_kses( $content, 'post' ); ?></div>
    </div>
    <?php if ( $show_view_details_button == 'yes' ) : ?>
      <?php shadhin_plugins_get_widgetcore_template_part( 'button', null, 'info-box/tpl', $settings, false );?>
    <?php endif; ?>
  </div>
</div>