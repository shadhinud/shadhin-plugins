<?php
/**
 * Slider Item Template
 */
if (!isset($slider_item)) {
	return;
}

// Get image
$image_id = isset($slider_item['image']['id']) ? $slider_item['image']['id'] : '';
$image_url = isset($slider_item['image']['url']) ? $slider_item['image']['url'] : '';
$image_size = !empty($slider_item['image_size']) ? $slider_item['image_size'] : (isset($featured_image_size) ? $featured_image_size : 'medium_large');

if ($image_id) {
	$image_html = wp_get_attachment_image($image_id, $image_size, false, array('class' => 'img-fluid'));
} else {
	$image_html = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($slider_item['title']) . '" class="img-fluid">';
}

// Get link
$link_url = '';
$link_target = '_self';
$link_nofollow = '';

if (!empty($slider_item['link']['url'])) {
	$link_url = $slider_item['link']['url'];
	$link_target = !empty($slider_item['link']['is_external']) ? '_blank' : '_self';
	$link_nofollow = ! empty( $slider_item['link']['nofollow'] );
}

?>
<div class="tm-vertical-image-slider-item">
	<div class="slider-image">
		<?php if (!empty($link_url)) : ?>
			<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"<?php if ( $link_nofollow ) : ?> rel="nofollow"<?php endif; ?>>
				<?php echo wp_kses_post( $image_html ); ?>
			</a>
		<?php else : ?>
			<?php echo wp_kses_post( $image_html ); ?>
		<?php endif; ?>
	</div>

	<?php if (isset($show_title) && $show_title === 'yes' && !empty($slider_item['title'])) : ?>
		<div class="slider-title-wrapper">
			<h3 class="slider-title"><?php echo esc_html($slider_item['title']); ?></h3>
		</div>
	<?php endif; ?>
</div>


