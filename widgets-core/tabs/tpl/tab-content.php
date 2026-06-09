    <div class="tab-pane fade <?php if($expand === 'yes') { echo esc_html( 'show active' ); }?>" id="<?php echo esc_attr($tab_id_list[$i]); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr($tab_id_list[$i]); ?>-tab">
      <div class="tab-content-inner">
      <?php
        if ( $tabs_content_type == 'content' ) {
            echo do_shortcode( $tabs_content );
        } else if ( $tabs_content_type == 'template' ) {
            $id = $tabs_content_templates;
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($id);
            echo $content;
        }
      ?>
      </div>
    </div>