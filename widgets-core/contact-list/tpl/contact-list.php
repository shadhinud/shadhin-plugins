<li class="clearfix">
	<div class="icon"><?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?></div>
	<?php if(!empty($prefix)) {?><div class="prefix"><?php echo esc_html( $prefix );?></div><?php } ?>
	<div class="text">
		<<?php echo esc_attr( $title_tag );?> 
		<?php 
		if($title_tag == 'a') { 
			$target = $link_url['is_external'] ? ' target="_blank"' : '';
			echo esc_attr($target)." href='".esc_url($link_url['url'])."'";
		}?>
		>
		<?php echo esc_html( $title );?>
		</<?php echo esc_attr( $title_tag );?>>
	</div>
</li>