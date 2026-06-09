<?php

if(!function_exists('shadhin_plugins_get_social_share_links')) {
	/**
	 * Function that Renders Social Share Links
	 * @return HTML
	 */
	function shadhin_plugins_get_social_share_links() {
		$params = array();

		if( !shadhin_get_redux_option( 'sharing-settings-enable-sharing' ) ) {
			return;
		}

		// Don't show social sharing on password protected posts
		if ( post_password_required() ) {
			return;
		}


		$title_encoded = urlencode( addslashes_gpc( esc_attr( get_the_title() ) ) );
		$url_encoded = urlencode( get_permalink() );
		$excerpt_encoded = urlencode( addslashes_gpc( get_the_excerpt() ) );
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		if( $featured_image !== false ) {
			$featured_image_url = $featured_image[0];
		} else {
			$featured_image_url = '';
		}

		$params['enabled_social_networks'] = shadhin_get_redux_option( 'sharing-settings-networks', false, 'Enabled' );
		$params['sharing_heading'] = shadhin_get_redux_option( 'sharing-settings-heading' );
		$params['tooltip_directions'] = shadhin_get_redux_option( 'sharing-settings-tooltip-directions' );

		//icon type
		$params['social_icon_type'] = shadhin_get_redux_option( 'sharing-settings-icon-type' );

		//icon property
		$params['social_links_icon_color'] = shadhin_get_redux_option( 'sharing-settings-social-links-color' );
		$params['social_links_icon_style'] = shadhin_get_redux_option( 'sharing-settings-social-links-icon-style' );
		$params['social_links_icon_size'] = shadhin_get_redux_option( 'sharing-settings-social-links-icon-size' );
		$params['social_links_animation_effect'] = shadhin_get_redux_option( 'sharing-settings-social-links-icon-animation-effect' );
		$params['social_links_icon_border_style'] = shadhin_get_redux_option( 'sharing-settings-social-links-icon-border-style' );
		$params['social_links_icon_theme_colored'] = shadhin_get_redux_option( 'sharing-settings-social-links-theme-colored' );


		$params['social_network_list'] = array(
			'twitter' => array(
				"name" => "Twitter",
				"icon" => "twitter",
				"color" => "#02B0E8",
				"target" => "_blank",
				"href" => "//twitter.com/intent/tweet?text=" . $title_encoded .
						"&amp;url=" . $url_encoded,
				"text" => shadhin_get_redux_option( 'sharing-settings-tooltip-twitter' )
			),
			'facebook' => array(
				"name" => "Facebook",
				"icon" => "facebook",
				"color" => "#3B5998",
				"target" => "_blank",
				"href" => "//www.facebook.com/sharer.php?u=" . $url_encoded .
						"&amp;t=" . $title_encoded .
						"&amp;description=" . $excerpt_encoded .
						"&amp;picture=" . $featured_image_url,
				"text" => shadhin_get_redux_option( 'sharing-settings-tooltip-facebook' )
			),
			'linkedin' => array(
				"name" => "Linkedin",
				"icon" => "linkedin",
				"color" => "#007BB6",
				"target" => "_blank",
				"href" => "//linkedin.com/shareArticle?mini=true&amp;url=" . $url_encoded .
						"&amp;title=" . $title_encoded,
				"text" => shadhin_get_redux_option( 'sharing-settings-tooltip-linkedin' )
			),
			'tumblr' => array(
				"name" => "Tumblr",
				"icon" => "tumblr",
				"color" => "#35455C",
				"target" => "_blank",
				"href" => "//www.tumblr.com/share/link?url=" . $url_encoded .
						"&amp;name=" . $title_encoded .
						"&amp;description=" . $excerpt_encoded,
				"text" => shadhin_get_redux_option( 'sharing-settings-tooltip-tumblr' )
			),
			'email' => array(
				"name" => "Email",
				"icon" => "envelope-o",
				"color" => "#787482",
				"target" => "_blank",
				"href" => "mailto:?subject=" . esc_attr( get_the_title() ) .
						"&amp;body=" . esc_attr( get_the_excerpt() ) . " " . esc_attr( get_permalink() ),
				"text" => shadhin_get_redux_option( 'sharing-settings-tooltip-email' )
			),
			'vk' => array(
				"name" => "VK",
				"icon" => "vk",
				"color" => "#4C75A3",
				"target" => "_blank",
				"href" => "//vkontakte.ru/share.php?url=" . $url_encoded .
						"&amp;title=" . $title_encoded .
						"&amp;description=" . $excerpt_encoded,
				"text" => shadhin_get_redux_option( 'sharing-settings-tooltip-vk' )
			),
			'pinterest' => array(
				"name" => "Pinterest",
				"icon" => "pinterest",
				"color" => "#E71F28",
				"target" => "_blank",
				"href" => "//pinterest.com/pin/create/button/?url=" . $url_encoded .
						"&amp;description=" . $title_encoded .
						"&amp;media=" . $featured_image_url,
				"text" => shadhin_get_redux_option( 'sharing-settings-tooltip-pinterest' )
			),
			'reddit' => array(
				"name" => "Reddit",
				"icon" => "reddit",
				"color" => "#6CC0FF",
				"target" => "_blank",
				"href" => "//www.reddit.com/submit?url=" . $url_encoded .
						"&amp;title=" . $title_encoded,
				"text" => shadhin_get_redux_option( 'sharing-settings-tooltip-reddit' )
			),
			'print' => array(
				"name" => "Print",
				"icon" => "print",
				"color" => "#9ACE5B",
				"target" => "_self",
				"href" => "javascript:window.print();",
				"text" => shadhin_get_redux_option( 'sharing-settings-tooltip-print' )
			),
		);

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters)
		$html = shadhin_plugins_get_inc_folder_template_part( 'social-share', null, 'social-share/tpl', $params );

		return $html;
	}
}