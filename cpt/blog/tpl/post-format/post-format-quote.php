<?php $settings['settings'] = $settings;?>
<article <?php post_class(); ?>>
	<div class="quote-content">
		<?php do_action( 'shadhin_blog_post_entry_header_start' ); ?>
		<?php shadhin_get_post_thumbnail( $post_format, $featured_image_size ); ?>
		<?php do_action( 'shadhin_blog_post_entry_header_end' ); ?>
	</div>
</article>