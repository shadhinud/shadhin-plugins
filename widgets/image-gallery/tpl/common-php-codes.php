<?php
	$masonry_tiles_image_size_class = '';
	$full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
	$full_image_url = $full_image_url[0];

	$gallery_images = colek_shadhin_get_rwmb_group_advanced( 'colek_shadhin_' . "gallery_mb_settings",  "gallery_images", null, false, 'all' );

	//if has no post thumbnail
	if( !has_post_thumbnail( get_the_ID() ) ) {
		if ( !empty( $gallery_images ) ) {
			$first_image_key = key($gallery_images);
			$full_image_url = $gallery_images[$first_image_key]['full_url'];
		} else {
			$full_image_url = "//placehold.it/1920x1080?text=Image Not Found!";
		}
	}

	$term_slugs_list = wp_get_post_terms( get_the_ID(), $ptTaxKey, array("fields" => "slugs") );
	$term_slugs_list_string = implode( ' ', $term_slugs_list );
	$term_names_list = wp_get_post_terms( get_the_ID(), $ptTaxKey, array("fields" => "names") );
	$params['full_image_url'] = $full_image_url;
	$params['gallery_images'] = $gallery_images;
	$params['term_names_list_string'] = $term_names_list_string = implode( ', ', $term_names_list );

	if ( $use_masonry_tiles_featured_image_size == 'yes' ) :
		$params['featured_image_size'] = $meta_featured_image_size = colek_shadhin_get_rwmb_group( 'colek_shadhin_' . "gallery_mb_settings", 'masonry_tiles_featured_image_size' );

		$masonry_tiles_image_size_class = 'mh-masonry-default';
		switch ( $meta_featured_image_size ) {
			case 'colek_shadhin_height':
				# code...
				$masonry_tiles_image_size_class = 'mh-masonry-large-height';
				break;

			case 'colek_shadhin_wide':
				# code...
				$masonry_tiles_image_size_class = 'mh-masonry-large-wide';
				break;

			case 'colek_shadhin_width_height':
				# code...
				$masonry_tiles_image_size_class = 'mh-masonry-large-width-height';
				break;

			case 'default':
				$masonry_tiles_image_size_class = 'mh-masonry-default';
				$params['featured_image_size'] = $featured_image_size;
				# code...
				break;

			default:
				# code...
				break;
		}

		if( $params['display_type'] != 'masonry-tiles') {
			$masonry_tiles_image_size_class = '';
		}
	endif;
?>