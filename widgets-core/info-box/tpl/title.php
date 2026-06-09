
      <?php if( !empty( $title ) ) : ?>
      <<?php echo esc_attr( $title_tag );?> class="title">
        <?php if( !empty( $url ) && $link_title === 'yes' ): ?>
        <a 
          <?php if ( ! empty( $link['is_external'] ) ) : ?> target="_blank"<?php endif; ?>
          href="<?php echo esc_url( $url );?>">
          <?php echo ( $title );?>
        </a>
        <?php else: ?>
          <?php echo ( $title );?>
        <?php endif ?>
      </<?php echo esc_attr( $title_tag );?>>
      <?php endif; ?>