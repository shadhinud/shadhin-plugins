<div class="btn-view-details <?php if(isset($button_alignment)) echo esc_attr( $button_alignment );?>">
    <a  
      <?php echo isset($link['is_external']) ? ' target="_blank"' : '';?>
      href="<?php if(isset($link['url'])) echo esc_url( $link['url'] );?>"
      class="<?php echo esc_attr(implode(' ', $btn_classes)); ?>">
      <?php echo esc_html( $view_details_button_text  ); ?>
    </a>
</div>