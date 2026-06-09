<li>
	<<?php echo esc_attr( $title_tag );?> 
		<?php 
		if($title_tag == 'a') { 
			$target = $link_url['is_external'] ? ' target="_blank"' : '';
			echo esc_attr($target)." href='".esc_url($link_url['url'])."'";
		}?>
		>
		<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
		<?php if(!empty($prefix)) {?><span class="prefix"><?php echo esc_html( $prefix );?></span><?php } ?><?php echo esc_html( $title );?></<?php echo esc_attr( $title_tag );?>>
</li>