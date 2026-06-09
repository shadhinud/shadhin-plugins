<?php
use Elementor\Controls_Manager;

if ( ! function_exists('shadhin_plugins_get_yes_no_select_array') ) {
	/**
	 * Returns array of yes no
	 * @return array
	 */
	function shadhin_plugins_get_yes_no_select_array($enable_default = true, $set_yes_to_be_first = false ) {
		$select_options = array();

		if ( $enable_default ) {
			$select_options[''] = esc_html__( 'Default', 'shadhin-plugins' );
		}

		if ( $set_yes_to_be_first ) {
			$select_options['yes'] = esc_html__( 'Yes', 'shadhin-plugins' );
			$select_options['no']  = esc_html__( 'No', 'shadhin-plugins' );
		} else {
			$select_options['no']  = esc_html__( 'No', 'shadhin-plugins' );
			$select_options['yes'] = esc_html__( 'Yes', 'shadhin-plugins' );
		}

		return $select_options;
	}
}
if( ! function_exists('shadhin_plugins_add_elementor_widget_categories') ) {
		function shadhin_plugins_add_elementor_widget_categories($elements_manager) {

			$elements_manager->add_category(
				'tm',
				[
					'title' => esc_html__('Mascot', 'shadhin-plugins'),
					'icon' => 'fa fa-plug',
				]
			);

		}

		add_action('elementor/elements/categories_registered', 'shadhin_plugins_add_elementor_widget_categories');
};



if(!function_exists('shadhin_plugins_get_button_arraylist')) {
	/**
	 * Return Button Array List
	 */
	function shadhin_plugins_get_button_arraylist( $control_object, $serial, $prefix = '', $btn_condition = false ) {
		$array = array();

		switch ( $serial ) {
			case '1':
				if( $btn_condition ) {
					$control_object->add_control(
						$prefix . "btn_design_style", [
							'label' => esc_html__( "Button Design Style", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => shadhin_plugins_get_btn_design_style(),
							'default' => 'btn-theme-colored1',
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_control(
						$prefix . "btn_design_style", [
							'label' => esc_html__( "Button Design Style", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => shadhin_plugins_get_btn_design_style(),
							'default' => 'btn-theme-colored1',
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_control(
						$prefix . "button_size", [
							'label' => esc_html__( "Button Size", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => shadhin_plugins_get_button_size(),
							'default' => '',
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_control(
						$prefix . "button_size", [
							'label' => esc_html__( "Button Size", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => shadhin_plugins_get_button_size(),
							'default' => '',
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_responsive_control(
						$prefix . "button_alignment", [
							'label' => esc_html__( "Button Alignment", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::CHOOSE,
							'options' => shadhin_plugins_text_align_choose(),
							'selectors' => [
								'{{WRAPPER}} .btn-view-details' => 'text-align: {{VALUE}};'
							],
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
					$control_object->add_responsive_control(
						$prefix . "button_text_alignment", [
							'label' => esc_html__( "Button Text Alignment", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::CHOOSE,
							'options' => shadhin_plugins_text_align_choose(),
							'selectors' => [
								'{{WRAPPER}} .btn-view-details > a' => 'text-align: {{VALUE}};'
							],
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_responsive_control(
						$prefix . "button_alignment", [
							'label' => esc_html__( "Button Alignment", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::CHOOSE,
							'options' => shadhin_plugins_text_align_choose(),
							'selectors' => [
								'{{WRAPPER}} .btn-view-details' => 'text-align: {{VALUE}};'
							],
						]
					);
					$control_object->add_responsive_control(
						$prefix . "button_text_alignment", [
							'label' => esc_html__( "Button Text Alignment", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::CHOOSE,
							'options' => shadhin_plugins_text_align_choose(),
							'selectors' => [
								'{{WRAPPER}} .btn-view-details > a' => 'text-align: {{VALUE}};'
							],
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_control(
						$prefix . "button_hover_animation_effect", [
							'label' => esc_html__( "Animation Effect", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => array(
								''	=> 	esc_html__( 'None', 'shadhin-plugins' ),
								'hvr-sweep-to-right'	=> 	esc_html__( 'Sweep To Right', 'shadhin-plugins' ),
								'hvr-bounce-to-right'	=> 	esc_html__( 'Bounce To Right', 'shadhin-plugins' ),
								'hvr-shutter-out-horizontal'	=> 	esc_html__( 'Shutter Out Horizontal', 'shadhin-plugins' ),
								'btn-arrow-hover-animation'	=> 	esc_html__( 'Arrow Hover Animation', 'shadhin-plugins' ),
							),
							'default' => '',
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_control(
						$prefix . "button_hover_animation_effect", [
							'label' => esc_html__( "Animation Effect", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => array(
								''	=> 	esc_html__( 'None', 'shadhin-plugins' ),
								'hvr-sweep-to-right'	=> 	esc_html__( 'Sweep To Right', 'shadhin-plugins' ),
								'hvr-bounce-to-right'	=> 	esc_html__( 'Bounce To Right', 'shadhin-plugins' ),
								'hvr-shutter-out-horizontal'	=> 	esc_html__( 'Shutter Out Horizontal', 'shadhin-plugins' ),
								'btn-arrow-hover-animation'	=> 	esc_html__( 'Arrow Hover Animation', 'shadhin-plugins' ),
							),
							'default' => '',
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_control(
						$prefix . "btn_class", [
							'label' => esc_html__( "Custom CSS Class", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::TEXT,
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_control(
						$prefix . "btn_class", [
							'label' => esc_html__( "Custom CSS Class", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::TEXT,
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_control(
						$prefix . "btn_outlined", [
							'label' => esc_html__( "Make Button Outlined", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_control(
						$prefix . "btn_outlined", [
							'label' => esc_html__( "Make Button Outlined", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_control(
						$prefix . "btn_round", [
							'label' => esc_html__( "Make Button Round", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_control(
						$prefix . "btn_round", [
							'label' => esc_html__( "Make Button Round", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_control(
						$prefix . "btn_flat", [
							'label' => esc_html__( "Make Button Flat", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_control(
						$prefix . "btn_flat", [
							'label' => esc_html__( "Make Button Flat", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_responsive_control(
						$prefix . "btn_block", [
							'label' => esc_html__( "Button Fullwidth (Block Level Button)", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'selectors' => [
								'{{WRAPPER}} .btn-view-details' => 'display:grid;'
							],
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_responsive_control(
						$prefix . "btn_block", [
							'label' => esc_html__( "Button Fullwidth (Block Level Button)", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'selectors' => [
								'{{WRAPPER}} .btn-view-details' => 'display:grid;'
							],
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_control(
						$prefix . "btn_threed_effect", [
							'label' => esc_html__( "3D Effect", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_control(
						$prefix . "btn_threed_effect", [
							'label' => esc_html__( "3D Effect", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_control(
						$prefix . "btn_gradient_effect", [
							'label' => esc_html__( "Gradient Effect", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_control(
						$prefix . "btn_gradient_effect", [
							'label' => esc_html__( "Gradient Effect", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::SWITCHER,
						]
					);
				}

				if( $btn_condition ) {
					$control_object->add_responsive_control(
						$prefix . "btn_link_color", [
							'label' => esc_html__( "Link Color", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .btn-view-details a' => 'color: {{VALUE}};'
							],
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_responsive_control(
						$prefix . "btn_link_color", [
							'label' => esc_html__( "Link Color", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .btn-view-details a' => 'color: {{VALUE}};'
							],
						]
					);
				}
				break;

			case '13':
				if( $btn_condition ) {
					$control_object->add_responsive_control(
						$prefix . "btn_link_color_hover", [
							'label' => esc_html__( "Link Color on Hover", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .btn-view-details a' => 'color: {{VALUE}};'
							],
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_responsive_control(
						$prefix . "btn_link_color_hover", [
							'label' => esc_html__( "Link Color on Hover", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .btn-view-details a' => 'color: {{VALUE}};'
							],
						]
					);
				}
				break;

			case '14':
				if( $btn_condition ) {
					$control_object->add_responsive_control(
						$prefix . "btn_bg_color", [
							'label' => esc_html__( "Link Background Color", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .btn-view-details a' => 'background-color: {{VALUE}};'
							],
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_responsive_control(
						$prefix . "btn_bg_color", [
							'label' => esc_html__( "Link Background Color", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .btn-view-details a' => 'background-color: {{VALUE}};'
							],
						]
					);
				}
				break;

			case '15':
				if( $btn_condition ) {
					$control_object->add_responsive_control(
						$prefix . "btn_bg_color_hover", [
							'label' => esc_html__( "Link Background Color on Hover", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .btn-view-details a' => 'background-color: {{VALUE}};'
							],
							'condition' => [
								$prefix . 'show_view_details_button' => array('yes')
							]
						]
					);
				} else {
					$control_object->add_responsive_control(
						$prefix . "btn_bg_color_hover", [
							'label' => esc_html__( "Link Background Color on Hover", 'shadhin-plugins' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}}:hover .btn-view-details a' => 'background-color: {{VALUE}};'
							],
						]
					);
				}
				break;

			default:
				# code...
				break;
		}

		return $array;
	}
}



















if(!function_exists('shadhin_plugins_get_button_text_color_typo_arraylist')) {
	/**
	 * Return Button Text Colro Typo Array List
	 */
	function shadhin_plugins_get_button_text_color_typo_arraylist( $control_object, $serial) {
		$array = array();

		switch ( $serial ) {
			case '1':
				$control_object->start_controls_tabs('tabs_button_wrapper_style');
				$control_object->start_controls_tab(
					'button_typo_normal',
					[
						'label' => esc_html__('Normal', 'shadhin-plugins'),
					]
				);
				$control_object->add_control(
					'button_bg_custom_color_options',
					[
						'label' => esc_html__( 'Background Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
					]
				);
				$control_object->add_responsive_control(
					'button_bg_custom_color', [
						'label' => esc_html__( "BG Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn' => 'background-color: {{VALUE}};'
						]
					]
				);
				$control_object->add_responsive_control(
					'button_bg_theme_colored', [
						'label' => esc_html__( "BG Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn' => 'background-color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->add_control(
					'button_text_color_options',
					[
						'label' => esc_html__( 'Text Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'button_text_color', [
						'label' => esc_html__( "Button Text Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn' => 'color: {{VALUE}} !important;',
						]
					]
				);
				$control_object->add_responsive_control(
					'button_text_theme_colored', [
						'label' => esc_html__( "Button Text Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn' => 'color: var(--theme-color{{VALUE}}) !important;'
						],
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Typography::get_type(), [
						'name' => 'button_text_typography',
						'label' => esc_html__( 'Button Text Typography', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .btn',
					]
				);
				$control_object->add_control(
					'button_arrow_color_options',
					[
						'label' => esc_html__( 'Arrow Color Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'button_arrow_color', [
						'label' => esc_html__( "Arrow Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn:after' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .btn:before' => 'color: {{VALUE}} !important;',
						]
					]
				);
				$control_object->add_responsive_control(
					'button_arrow_theme_colored', [
						'label' => esc_html__( "Arrow Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn:after' => 'color: var(--theme-color{{VALUE}}) !important;',
							'{{WRAPPER}} .btn:before' => 'color: var(--theme-color{{VALUE}}) !important;',
						],
					]
				);
				$control_object->add_control(
					'btn_border_options',
					[
						'label' => esc_html__( 'Border Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'btn_border',
						'label' => esc_html__( 'Border', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .btn',
					]
				);
				$control_object->add_responsive_control(
					'btn_border_radius',
					[
						'label' => esc_html__( "Border Radius", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				);
				$control_object->add_responsive_control(
					'btn_border_custom_color', [
						'label' => esc_html__( "Border Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn' => 'border-color: {{VALUE}} !important;'
						]
					]
				);
				$control_object->add_responsive_control(
					'btn_border_theme_colored', [
						'label' => esc_html__( "Border Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn' => 'border-color: var(--theme-color{{VALUE}}) !important;'
						],
					]
				);



				$control_object->add_control(
					'btn_boxshadow_options',
					[
						'label' => esc_html__( 'Box Shadow Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'btn_boxshadow',
						'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .btn',
					]
				);
				$control_object->add_control(
					'btn_padding_options',
					[
						'label' => esc_html__( 'Padding Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'btn_padding',
					[
						'label' => esc_html__( 'Button Padding', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$control_object->add_responsive_control(
					'btn_margin',
					[
						'label' => esc_html__( 'Button Margin', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$control_object->add_control(
					'button_icon_color_options',
					[
						'label' => esc_html__( 'Icon Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'button_icon_color', [
						'label' => esc_html__( "Button Icon Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn:after, {{WRAPPER}} .btn:before' => 'color: {{VALUE}};'
						]
					]
				);
				$control_object->add_responsive_control(
					'button_icon_theme_colored', [
						'label' => esc_html__( "Button Icon Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn:after, {{WRAPPER}} .btn:before' => 'color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->end_controls_tab();









				$control_object->start_controls_tab(
					'button_typo_hover',
					[
						'label' => esc_html__('Hover', 'shadhin-plugins'),
					]
				);
				$control_object->add_control(
					'button_bg_custom_color_options_hover',
					[
						'label' => esc_html__( 'Background Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
					]
				);
				$control_object->add_responsive_control(
					'button_bg_color_hover', [
						'label' => esc_html__( "BG Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn:hover,{{WRAPPER}} .btn:focus' => 'background-color: {{VALUE}};'
						]
					]
				);
				$control_object->add_responsive_control(
					'button_bg_color_hover_animated', [
						'label' => esc_html__( "BG Color (Hover Animated)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn:hover:before,{{WRAPPER}} .btn:focus:before' => 'background-color: {{VALUE}};'
						]
					]
				);
				$control_object->add_responsive_control(
					'button_bg_theme_colored_hover', [
						'label' => esc_html__( "BG Theme Colored (Hover Animated)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn:hover:before' => 'background-color: var(--theme-color{{VALUE}});',
							'{{WRAPPER}} .btn:hover:after' => 'background-color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->add_responsive_control(
					'button_bg_theme_colored_hover_only', [
						'label' => esc_html__( "BG Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn:hover' => 'background-color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->add_control(
					'button_text_color_options_hover',
					[
						'label' => esc_html__( 'Text Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'button_text_color_hover', [
						'label' => esc_html__( "Button Text Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn:hover' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .btn:focus' => 'color: {{VALUE}} !important;',
						]
					]
				);
				$control_object->add_responsive_control(
					'button_text_theme_colored_hover', [
						'label' => esc_html__( "Button Text Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn:hover' => 'color: var(--theme-color{{VALUE}}) !important;',
							'{{WRAPPER}} .btn:focus' => 'color: var(--theme-color{{VALUE}}) !important;'
						],
					]
				);
				$control_object->add_control(
					'button_arrow_color_options_hover',
					[
						'label' => esc_html__( 'Arrow Color Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'button_arrow_color_hover', [
						'label' => esc_html__( "Arrow Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn:hover:after' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .btn:focus:after' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .btn:hover:before' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .btn:focus:before' => 'color: {{VALUE}} !important;',
						]
					]
				);
				$control_object->add_responsive_control(
					'button_arrow_theme_colored_hover', [
						'label' => esc_html__( "Arrow Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn:hover:after' => 'color: var(--theme-color{{VALUE}}) !important;',
							'{{WRAPPER}} .btn:focus:after' => 'color: var(--theme-color{{VALUE}}) !important;',
							'{{WRAPPER}} .btn:hover:before' => 'color: var(--theme-color{{VALUE}}) !important;',
							'{{WRAPPER}} .btn:focus:before' => 'color: var(--theme-color{{VALUE}}) !important;',
						],
					]
				);
				$control_object->add_control(
					'btn_border_options_hover',
					[
						'label' => esc_html__( 'Border Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'btn_border_custom_color_hover', [
						'label' => esc_html__( "Border Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn:hover' => 'border-color: {{VALUE}} !important;',
							'{{WRAPPER}} .btn:focus' => 'border-color: {{VALUE}} !important;',
						]
					]
				);
				$control_object->add_responsive_control(
					'btn_border_theme_colored_hover', [
						'label' => esc_html__( "Border Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn:hover' => 'border-color: var(--theme-color{{VALUE}}) !important;',
							'{{WRAPPER}} .btn:focus' => 'border-color: var(--theme-color{{VALUE}}) !important;'
						],
					]
				);
				$control_object->add_control(
					'btn_boxshadow_options_hover',
					[
						'label' => esc_html__( 'Box Shadow Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'btn_boxshadow_hover',
						'label' => esc_html__( 'Box Shadow(Hover)', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .btn:hover',
					]
				);
				$control_object->add_control(
					'button_icon_color_options_hover',
					[
						'label' => esc_html__( 'Icon Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'button_icon_color_hover', [
						'label' => esc_html__( "Button Icon Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .btn:hover:after, {{WRAPPER}} .btn:hover:before' => 'color: {{VALUE}};'
						]
					]
				);
				$control_object->add_responsive_control(
					'button_icon_theme_colored_hover', [
						'label' => esc_html__( "Button Icon Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .btn:hover:after, {{WRAPPER}} .btn:hover:before' => 'color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->end_controls_tab();




				$control_object->start_controls_tab(
					'button_typo_wrapper_hover',
					[
						'label' => esc_html__('Wrapper Hover', 'shadhin-plugins'),
					]
				);
				$control_object->add_control(
					'button_bg_custom_color_options_wrapper_hover',
					[
						'label' => esc_html__( 'Background Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
					]
				);
				$control_object->add_responsive_control(
					'button_bg_color_wrapper_hover', [
						'label' => esc_html__( "BG Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}:hover .btn' => 'background-color: {{VALUE}};'
						]
					]
				);
				$control_object->add_responsive_control(
					'button_bg_theme_colored_wrapper_hover', [
						'label' => esc_html__( "BG Theme Colored (Hover Animated)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}}:hover .btn:before' => 'background-color: var(--theme-color{{VALUE}});',
							'{{WRAPPER}}:hover .btn:after' => 'background-color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->add_responsive_control(
					'button_bg_theme_colored_hoverwrapper__only', [
						'label' => esc_html__( "BG Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}}:hover .btn' => 'background-color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->add_control(
					'button_text_color_options_wrapper_hover',
					[
						'label' => esc_html__( 'Text Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'button_text_color_wrapper_hover', [
						'label' => esc_html__( "Button Text Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}:hover .btn' => 'color: {{VALUE}} !important;',
						]
					]
				);
				$control_object->add_responsive_control(
					'button_text_theme_colored_wrapper_hover', [
						'label' => esc_html__( "Button Text Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}}:hover .btn' => 'color: var(--theme-color{{VALUE}}) !important;',
						],
					]
				);
				$control_object->add_control(
					'button_arrow_color_options_wrapper_hover',
					[
						'label' => esc_html__( 'Arrow Color Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'button_arrow_color_wrapper_hover', [
						'label' => esc_html__( "Arrow Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}:hover .btn:after' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}}:hover .btn:before' => 'color: {{VALUE}} !important;',
						]
					]
				);
				$control_object->add_responsive_control(
					'button_arrow_theme_colored_wrapper_hover', [
						'label' => esc_html__( "Arrow Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}}:hover .btn:after' => 'color: var(--theme-color{{VALUE}}) !important;',
							'{{WRAPPER}}:hover .btn:before' => 'color: var(--theme-color{{VALUE}}) !important;',
						],
					]
				);
				$control_object->add_control(
					'btn_border_options_wrapper_hover',
					[
						'label' => esc_html__( 'Border Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'btn_border_custom_color_wrapper_hover', [
						'label' => esc_html__( "Border Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}:hover .btn' => 'border-color: {{VALUE}} !important;',
						]
					]
				);
				$control_object->add_responsive_control(
					'btn_border_theme_colored_wrapper_hover', [
						'label' => esc_html__( "Border Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}}:hover .btn' => 'border-color: var(--theme-color{{VALUE}}) !important;',
						],
					]
				);
				$control_object->add_control(
					'btn_boxshadow_options_wrapper_hover',
					[
						'label' => esc_html__( 'Box Shadow Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'btn_boxshadow_wrapper_hover',
						'label' => esc_html__( 'Box Shadow(Hover)', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}}:hover .btn',
					]
				);
				$control_object->add_control(
					'button_icon_color_options_wrapper_hover',
					[
						'label' => esc_html__( 'Icon Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'button_icon_color_wrapper_hover', [
						'label' => esc_html__( "Button Icon Color (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}:hover .btn:after, {{WRAPPER}}:hover .btn:before' => 'color: {{VALUE}};'
						]
					]
				);
				$control_object->add_responsive_control(
					'button_icon_theme_colored_wrapper_hover', [
						'label' => esc_html__( "Button Icon Theme Colored (Hover)", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}}:hover .btn:after, {{WRAPPER}}:hover .btn:before' => 'color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->end_controls_tab();
				$control_object->end_controls_tabs();
				break;
			default:
				# code...
				break;
		}

		return $array;
	}
}










if(!function_exists('shadhin_plugins_get_viewdetails_button_arraylist')) {
	/**
	 * Return Button Show Array List
	 */
	function shadhin_plugins_get_viewdetails_button_arraylist( $control_object, $serial, $btn_text = '', $prefix = '', $std = 'true' ) {
		$array = array();
		if( $btn_text == '' ) $btn_text = esc_html__( 'Read More', 'shadhin-plugins' );

		switch ( $serial ) {
			case '1':
				$control_object->add_control(
					$prefix . "show_view_details_button", [
						'label' => sprintf( esc_html__( "Show %s Button", 'shadhin-plugins' ), $btn_text ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'no',
					]
				);
				break;

			case '2':
				$control_object->add_control(
					$prefix . "view_details_button_text", [
						'label' => sprintf( esc_html__( "%s Button Text", 'shadhin-plugins' ), $btn_text ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => esc_html( $btn_text ),
						'condition' => [
							$prefix . 'show_view_details_button' => array('yes')
						]
					]
				);
				break;

			default:
				# code...
				break;
		}
	}
}

if(!function_exists('shadhin_plugins_get_button_control')) {
	/**
	 * Return Button Show Array List
	 */
	function shadhin_plugins_get_button_control($control_object, $show_btn_switcher = false ) {

		if( $show_btn_switcher ) {
			$control_object->start_controls_section(
				'button_show_hide', [
					'label' => esc_html__( 'Button Show/Hide', 'shadhin-plugins' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
			shadhin_plugins_get_viewdetails_button_arraylist($control_object, 1);
			shadhin_plugins_get_viewdetails_button_arraylist($control_object, 2);
			$control_object->end_controls_section();
		}

		if( $show_btn_switcher ) {
			$control_object->start_controls_section(
				'button_options', [
					'label' => esc_html__( 'Button Options', 'shadhin-plugins' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
					'condition' => [
						'show_view_details_button' => array('yes')
					]
				]
			);
		} else {
			$control_object->start_controls_section(
				'button_options', [
					'label' => esc_html__( 'Button Options', 'shadhin-plugins' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
		}
		shadhin_plugins_get_button_arraylist($control_object, 1);
		$control_object->add_responsive_control(
			'tm_btn_padding',
			[
				'label' => esc_html__( 'Button Padding', 'shadhin-plugins' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$control_object->end_controls_section();




		if( $show_btn_switcher ) {
			$control_object->start_controls_section(
				'button_color_typo_options', [
					'label' => esc_html__( 'Button Color/Typography', 'shadhin-plugins' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
					'condition' => [
						'show_view_details_button' => array('yes')
					]
				]
			);
		} else {
			$control_object->start_controls_section(
				'button_color_typo_options', [
					'label' => esc_html__( 'Button Color/Typography', 'shadhin-plugins' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);
		}
		shadhin_plugins_get_button_text_color_typo_arraylist($control_object, 1);
		$control_object->end_controls_section();
	}
}

if(!function_exists('shadhin_plugins_get_loadmore_button_control')) {
	/**
	 * Return Loadmore Button Show Array List
	 */
	function shadhin_plugins_get_loadmore_button_control($control_object) {
		$control_object->start_controls_section(
			'loadmore_button_options', [
					'label' => esc_html__( 'Loadmore Button Options', 'shadhin-plugins' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		shadhin_plugins_get_viewdetails_button_arraylist($control_object, 1,  esc_html__( "Load More", 'shadhin-plugins' ), 'loadmore_');
		shadhin_plugins_get_viewdetails_button_arraylist($control_object, 2,  esc_html__( "Load More", 'shadhin-plugins' ), 'loadmore_');
		shadhin_plugins_get_button_arraylist($control_object, 1, 'loadmore_');
		$control_object->end_controls_section();
	}
}

if(!function_exists('shadhin_plugins_font_style_list')) {
	/**
	 * Font Style List
	 */
	function shadhin_plugins_font_style_list() {
		$font_style_list = array(
			''	=>	esc_html__( 'Normal', 'shadhin-plugins'),
			'italic'	=>	esc_html__( 'Italic', 'shadhin-plugins')
		);
		return $font_style_list;
	}
}

if(!function_exists('shadhin_plugins_font_weight_list')) {
	/**
	 * Font weight List
	 */
	function shadhin_plugins_font_weight_list() {
		$font_weight_list = array(
			''			=>	esc_html__( 'Default', 'shadhin-plugins'),
			'100'   => '100',
			'200'   => '200',
			'300'   => '300',
			'400'   => '400',
			'500'   => '500',
			'600'   => '600',
			'700'   => '700',
			'800'   => '800',
		);
		return $font_weight_list;
	}
}

if(!function_exists('shadhin_plugins_text_transform_list')) {
	/**
	 * Text Transform List
	 */
	function shadhin_plugins_text_transform_list() {
		$text_transform_list = array(
			''	=>	esc_html__( 'Default', 'shadhin-plugins'),
			'none'	=>	esc_html__( 'None', 'shadhin-plugins'),
			'capitalize'	=>	esc_html__( 'Capitalize', 'shadhin-plugins'),
			'uppercase'	=>	esc_html__( 'Uppercase', 'shadhin-plugins'),
			'lowercase'	=>	esc_html__( 'Lowercase', 'shadhin-plugins'),
			'initial'	=>	esc_html__( 'Initial', 'shadhin-plugins'),
			'inherit'	=>	esc_html__( 'Inherit', 'shadhin-plugins')
		);
		return $text_transform_list;
	}
}

if(!function_exists('shadhin_plugins_get_btn_design_style')) {
	/**
	 * Return Design Style
	 */
	function shadhin_plugins_get_btn_design_style() {
		$array = array(
			'theme-btn-style-one'	=>	esc_html__( 'Theme Button 1', 'shadhin-plugins'),
			'theme-btn-style-two'	=>	esc_html__( 'Theme Button 2', 'shadhin-plugins'),
			'btn-circle-arrow'	=>	esc_html__( 'Circle With Arrow', 'shadhin-plugins'),
			'btn-plain-text'	=>	esc_html__( 'Plain Text', 'shadhin-plugins'),
			'btn-plain-text-with-arrow'	=>	esc_html__( 'Plain Text + Arrow Left', 'shadhin-plugins'),
			'btn-plain-text-with-arrow-right'	=>	esc_html__( 'Plain Text + Arrow Right', 'shadhin-plugins'),
			'btn-dark'	=>	esc_html__( 'Button Dark', 'shadhin-plugins'),
			'btn-light'	=>	esc_html__( 'Button Light', 'shadhin-plugins'),
			'btn-modern-white'	=>	esc_html__( 'Button Modern White', 'shadhin-plugins'),
			'btn-modern-theme-colored'	=>	esc_html__( 'Button Modern Theme Colored', 'shadhin-plugins'),
			'btn-primary'	=>	esc_html__( 'Button Primary', 'shadhin-plugins'),
			'btn-secondary'	=>	esc_html__( 'Button Secondary', 'shadhin-plugins'),
			'btn-success'	=>	esc_html__( 'Button Success', 'shadhin-plugins'),
			'btn-danger'	=>	esc_html__( 'Button Danger', 'shadhin-plugins'),
			'btn-warning'	=>	esc_html__( 'Button Warning', 'shadhin-plugins'),
			'btn-info'	=>	esc_html__( 'Button Info', 'shadhin-plugins'),
			'btn-gray'	=>	esc_html__( 'Button Gray', 'shadhin-plugins'),
		);

		$array_theme_color = array();
		for ($i=1; $i <= shadhin_plugins_number_of_theme_colors(); $i++) {
			$array_theme_color[ 'btn-theme-colored' . $i ] = esc_html__( 'Button Theme Colored', 'shadhin-plugins') . ' ' . $i;
		}

		$array = array_merge($array_theme_color, $array);
		return $array;
	}
}

if(!function_exists('shadhin_plugins_get_button_size')) {
	/**
	 * Return Button Size
	 */
	function shadhin_plugins_get_button_size() {
		$array = array(
			''	=>	esc_html__( 'Default', 'shadhin-plugins'),
			'btn-lg'	=>	esc_html__( 'Large', 'shadhin-plugins'),
			'btn-sm'	=>	esc_html__( 'Small', 'shadhin-plugins'),
			'btn-xs'	=>	esc_html__( 'Extra Small', 'shadhin-plugins')
		);
		return $array;
	}
}


if ( ! function_exists( 'shadhin_plugins_get_available_image_sizes' ) ) {
	/**
	 * Get information about available image sizes
	 */
	function shadhin_plugins_get_available_image_sizes() {
		$size = array();
		$available_image_sizes = shadhin_plugins_get_available_image_sizes_array();

		// Create the full array with sizes and crop info
		foreach( $available_image_sizes as $key => $value ) {
			$sizes[ $key ]	=	$key . ( ($value['crop'] == 1) ? ' - cropped' : '') . ' - (' .$value['width'] . 'x' . $value['height'] . ')';
		}
		return $sizes;
	}
}


if ( ! function_exists( 'shadhin_plugins_get_available_image_sizes_array' ) ) {
	/**
	 * Get information about available image sizes
	 */
	function shadhin_plugins_get_available_image_sizes_array( $size = '' ) {

		global $_wp_additional_image_sizes;

		$sizes = array();
		$get_intermediate_image_sizes = get_intermediate_image_sizes();

		// Create the full array with sizes and crop info
		foreach( $get_intermediate_image_sizes as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large', 'full' ) ) ) {
				$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
				$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
				$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
				if ( $_size == 'large' ) {
					$sizes[ 'full' ] ['width'] = 0;
					$sizes[ 'full' ] ['height'] = 0;
					$sizes[ 'full' ] ['crop'] = false;
				}
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width' => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
				);
			}
		}

		// Get only 1 size if found
		if ( $size ) {
			if( isset( $sizes[ $size ] ) ) {
				return $sizes[ $size ];
			} else {
				return false;
			}
		}
		return $sizes;
	}
}




if(!function_exists('shadhin_plugins_get_cat_filter_arraylist')) {
	/**
	 * Return Category Filter Array List
	 */
	function shadhin_plugins_get_cat_filter_arraylist( $control_object, $serial, $dependency = array() ) {
		$array = array();

		switch ( $serial ) {
			case '1':
				$control_object->add_control(
					"show_cat_filter", [
						'label' => esc_html__( "Show Category Filter?", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'default' => 'no',
						'condition' => $dependency
					]
				);
				break;

			case '2':
				$control_object->add_control(
					'cat_filter_style', [
						'label' => esc_html__( "Filter Style", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => [
							'filter-style-1'	=>	esc_html__( 'Style 1', 'shadhin-plugins' ),
							'filter-style-2'	=>	esc_html__( 'Style 2', 'shadhin-plugins' ),
							'filter-style-3'	=>	esc_html__( 'Style 3', 'shadhin-plugins' ),
							'filter-style-4'	=>	esc_html__( 'Style 4', 'shadhin-plugins' ),
							'filter-style-5'	=>	esc_html__( 'Style 5', 'shadhin-plugins' ),
							'filter-style-6'	=>	esc_html__( 'Style 6', 'shadhin-plugins' ),
							'filter-style-7'	=>	esc_html__( 'Style 7', 'shadhin-plugins' ),
							'filter-style-8'	=>	esc_html__( 'Style 8', 'shadhin-plugins' ),
							'filter-style-9'	=>	esc_html__( 'Style 9', 'shadhin-plugins' ),
							'filter-style-10'	=>	esc_html__( 'Style 10', 'shadhin-plugins' ),
							'filter-style-11'	=>	esc_html__( 'Style 11', 'shadhin-plugins' ),
							'filter-style-12'	=>	esc_html__( 'Style 12', 'shadhin-plugins' ),
							'filter-style-13'	=>	esc_html__( 'Style 13', 'shadhin-plugins' ),
							'filter-style-14'	=>	esc_html__( 'Style 14', 'shadhin-plugins' ),
							'filter-style-15'	=>	esc_html__( 'Style 15', 'shadhin-plugins' ),
							'filter-style-16'	=>	esc_html__( 'Style 16', 'shadhin-plugins' ),
							'filter-style-flat'	=>	esc_html__( 'Style flat', 'shadhin-plugins' )
						],
						'default' => 'filter-style-3',
						'condition' => [
							'show_cat_filter' => array('yes')
						]
					]
				);
				break;

			case '3':
				$control_object->add_responsive_control(
					'filter_alignment',
					[
						'label' => esc_html__( "Filter Alignment", 'shadhin-plugins' ),
						'type' => Controls_Manager::CHOOSE,
						'label_block' => false,
						'options' => shadhin_plugins_text_align_choose(),
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter' => 'text-align: {{VALUE}};'
						],
						'default' => 'center',
					]
				);
				break;

			case '4':
				$control_object->start_controls_tabs('tabs_iconbox_wrapper_style');
				$control_object->start_controls_tab(
					'filter_normal',
					[
						'label' => esc_html__('Normal', 'shadhin-plugins'),
					]
				);
				$control_object->add_control(
					'filter_bg_color_options',
					[
						'label' => esc_html__( 'Background Color Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_control(
					'filter_custom_bg_color',
					[
						'label' => esc_html__( "Filter Custom BG Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a' => 'background-color: {{VALUE}};'
						]
					]
				);
				$control_object->add_control(
					'filter_bg_theme_colored',
					[
						'label' => esc_html__( "BG Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a' => 'background-color: var(--theme-color{{VALUE}});'
						],
					]
				);



				//text Icon
				$control_object->add_control(
					'filter_text_options',
					[
						'label' => esc_html__( 'Text Color Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_control(
					'filter_text_color',
					[
						'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a' => 'color: {{VALUE}};'
						]
					]
				);
				$control_object->add_control(
					'filter_theme_colored',
					[
						'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a' => 'color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'filter_typography',
						'label' => esc_html__( 'Text Typography', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .isotope-layout-filter a',
						'separator' => 'before',
					]
				);
				$control_object->add_responsive_control(
					'filter_margin',
					[
						'label' => esc_html__( 'Margin', 'shadhin-plugins' ),
						'type' => Controls_Manager::DIMENSIONS,
						'separator' => 'before',
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$control_object->add_responsive_control(
					'filter_padding',
					[
						'label' => esc_html__( 'Padding', 'shadhin-plugins' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$control_object->add_control(
					'filter_border_options',
					[
						'label' => esc_html__( 'Border Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'filter_box_shadow',
						'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .isotope-layout-filter a',
					]
				);
				$control_object->add_responsive_control(
					'filter_border_radius',
					[
						'label' => esc_html__( "Border Radius", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
						]
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'filter_border',
						'label' => esc_html__( 'Border', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .isotope-layout-filter a',
					]
				);
				$control_object->add_control(
					'filter_border_theme_colored',
					[
						'label' => esc_html__( "Border Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a' => 'border-color: var(--theme-color{{VALUE}});'
						],
					]
				);
				$control_object->end_controls_tab();


				$control_object->start_controls_tab(
					'filter_hover',
					[
						'label' => esc_html__('Hover', 'shadhin-plugins'),
					]
				);
				$control_object->add_control(
					'filter_bg_color_options_hover',
					[
						'label' => esc_html__( 'Background Color Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
					]
				);
				$control_object->add_control(
					'filter_custom_bg_color_hover',
					[
						'label' => esc_html__( "Filter Custom BG Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a:hover' => 'background-color: {{VALUE}};',
						]
					]
				);
				$control_object->add_control(
					'filter_bg_theme_colored_hover',
					[
						'label' => esc_html__( "BG Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a:hover' => 'background-color: var(--theme-color{{VALUE}});',
						],
					]
				);
				//text Icon
				$control_object->add_control(
					'filter_text_options_hover',
					[
						'label' => esc_html__( 'Text Color Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_control(
					'filter_text_color_hover',
					[
						'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a:hover' => 'color: {{VALUE}};',
						]
					]
				);
				$control_object->add_control(
					'filter_theme_colored_hover',
					[
						'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a:hover' => 'color: var(--theme-color{{VALUE}});',
						],
					]
				);
				$control_object->add_control(
					'filter_border_options_hover',
					[
						'label' => esc_html__( 'Border Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'filter_box_shadow_hover',
						'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .isotope-layout-filter a:hover',
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'filter_border_hover',
						'label' => esc_html__( 'Border', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .isotope-layout-filter a:hover',
					]
				);
				$control_object->add_control(
					'filter_border_theme_colored_hover',
					[
						'label' => esc_html__( "Border Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a:hover' => 'border-color: var(--theme-color{{VALUE}});',
						],
					]
				);
				$control_object->end_controls_tab();


				$control_object->start_controls_tab(
					'filter_active',
					[
						'label' => esc_html__('Active', 'shadhin-plugins'),
					]
				);
				$control_object->add_control(
					'filter_bg_color_options_active',
					[
						'label' => esc_html__( 'Background Color Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
					]
				);
				$control_object->add_control(
					'filter_custom_bg_color_active',
					[
						'label' => esc_html__( "Filter Custom BG Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a.active' => 'background-color: {{VALUE}};',
						]
					]
				);
				$control_object->add_control(
					'filter_bg_theme_colored_active',
					[
						'label' => esc_html__( "BG Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a.active' => 'background-color: var(--theme-color{{VALUE}});',
						],
					]
				);
				//text Icon
				$control_object->add_control(
					'filter_text_options_active',
					[
						'label' => esc_html__( 'Text Color Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_control(
					'filter_text_color_active',
					[
						'label' => esc_html__( "Text Color", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a.active' => 'color: {{VALUE}};',
						]
					]
				);
				$control_object->add_control(
					'filter_theme_colored_active',
					[
						'label' => esc_html__( "Text Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a.active' => 'color: var(--theme-color{{VALUE}});',
						],
					]
				);
				$control_object->add_control(
					'filter_border_options_active',
					[
						'label' => esc_html__( 'Border Options', 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'filter_box_shadow_active',
						'label' => esc_html__( 'Box Shadow', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .isotope-layout-filter a.active',
					]
				);
				$control_object->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'filter_border_active',
						'label' => esc_html__( 'Border', 'shadhin-plugins' ),
						'selector' => '{{WRAPPER}} .isotope-layout-filter a.active',
					]
				);
				$control_object->add_control(
					'filter_border_theme_colored_active',
					[
						'label' => esc_html__( "Border Theme Colored", 'shadhin-plugins' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'options' => shadhin_plugins_theme_color_list(),
						'default' => '',
						'selectors' => [
							'{{WRAPPER}} .isotope-layout-filter a.active' => 'border-color: var(--theme-color{{VALUE}});',
						],
					]
				);
				$control_object->end_controls_tab();
				$control_object->end_controls_tabs();
				break;

			default:
				# code...
				break;
		}

		return $array;
	}
}

if (!function_exists('shadhin_plugins_shortcode_get_blog_post_format')) {
  /**
   * Return Shortcode Blog Post Format HTML
   */
  function shadhin_plugins_shortcode_get_blog_post_format( $post_format = '', $params = array() ) {

    $format = $post_format ? : 'standard';
    $params['post_format'] = $format;

    //Produce HTML version by using the parameters (filename, variation, folder name, parameters)
    $html = shadhin_plugins_get_cpt_shortcode_template_part( 'post-format', $format, 'blog/tpl/post-format', $params, true );
    return $html;
  }
}

if(!function_exists('shadhin_plugins_get_animation_type')) {
	/**
	 * Return animation type
	 */
	function shadhin_plugins_get_animation_type() {
		$array = array(
			''  =>  esc_html__( 'None', 'shadhin-plugins' ),
			'tm-animation-floating'  =>  esc_html__( 'Floating Animation', 'shadhin-plugins' ),
			'tm-animation-slide-horizontal'  =>  esc_html__( 'Horizontal Slide Animation', 'shadhin-plugins' ),
			'tm-animation-flicker'  =>  esc_html__( 'Flicker Animation', 'shadhin-plugins' ),
			'tm-animation-spin'  =>  esc_html__( 'Spin Animation', 'shadhin-plugins' ),
			'tm-animation-random-animation1'	=>	esc_html__( 'Random Animation 1', 'shadhin-plugins' ),
			'tm-animation-random-animation2'	=>	esc_html__( 'Random Animation 2', 'shadhin-plugins' ),
		);
		return $array;
	}
}

if(!function_exists('shadhin_plugins_text_align_choose')) {
	/**
	 * Text Alignment List - Elementor CHOOSE Control
	 */
	function shadhin_plugins_text_align_choose() {
		$alignment_list = array(
			'left' => [
				'title' => esc_html__('Left', 'shadhin-plugins'),
				'icon' => 'eicon-h-align-left',
			],
			'center' => [
				'title' => esc_html__('Center', 'shadhin-plugins'),
				'icon' => 'eicon-h-align-center',
			],
			'right' => [
				'title' => esc_html__('Right', 'shadhin-plugins'),
				'icon' => 'eicon-h-align-right',
			],
		);
		return $alignment_list;
	}
}




if(!function_exists('shadhin_plugins_get_shortcode_snippet')) {
	function shadhin_plugins_get_shortcode_snippet( $shortcode_object, $params ) {
		$atts = array();

		if ( empty( $shortcode_object ) || ! is_object( $shortcode_object ) ) {
			return '';
		}

		if ( ! empty( $params ) ) {
			foreach ( $params as $key => $value ) {
				if ( is_array( $value ) || 'shortcode_snippet' === $key ) {
					continue;
				}

				$atts[] = $key . '="' . esc_attr( $value ) . '"';
			}
		}

		return sprintf(
			'<textarea rows="3" readonly>[%s %s]</textarea>',
			$shortcode_object->get_name(),
			implode( ' ', $atts )
		);
	}
}




if(!function_exists('shadhin_plugins_get_wpcf7_list')) {
    /**
     * Get Contact Form 7 [ if exists ]
     */
    function shadhin_plugins_get_wpcf7_list()
    {
        $options = array();

        if (function_exists('wpcf7')) {
            $wpcf7_form_list = get_posts(array(
                'post_type' => 'wpcf7_contact_form',
                'showposts' => 999,
            ));
            $options[0] = esc_html__('Select a Contact Form', 'shadhin-plugins');
            if (!empty($wpcf7_form_list) && !is_wp_error($wpcf7_form_list)) {
                foreach ($wpcf7_form_list as $post) {
                    $options[$post->ID] = $post->post_title;
                }
            } else {
                $options[0] = esc_html__('Create a Form First', 'shadhin-plugins');
            }
        }
        return $options;
    }
}



if(!function_exists('shadhin_plugins_isotope_gutter_list_elementor')) {
	/**
	 * Masorny Gutter list Elementor
	 */
	function shadhin_plugins_isotope_gutter_list_elementor() {
		$gutter_list = array(
			'gutter' 		=>  esc_html__( 'Default', 'shadhin-plugins' ),
			'gutter-0'		=>  '0',
			'gutter-2'  	=>  '2px',
			'gutter-5'  	=>  '5px',
			'gutter-10'  	=>  '10px',
			'gutter-15'  	=>  '15px',
			'gutter-20'  	=>  '20px',
			'gutter-30'  	=>  '30px',
			'gutter-40'  	=>  '40px',
			'gutter-50'  	=>  '50px',
			'gutter-60'  	=>  '60px',
		);
		return $gutter_list;
	}
}



if(!function_exists('shadhin_plugins_disply_type_list_elementor')) {
	/**
	 * Display Property list Elementor
	 */
	function shadhin_plugins_disply_type_list_elementor() {
		$list = array(
			'flex' => esc_html__('Flex', 'shadhin-plugins'),
			'block' => esc_html__('Block', 'shadhin-plugins'),
			'inline' => esc_html__('Inline', 'shadhin-plugins'),
			'inline-flex' => esc_html__('Inline Flex', 'shadhin-plugins'),
			'inline-block' => esc_html__('Inline Block', 'shadhin-plugins'),
			'inherit' => esc_html__('Inherit', 'shadhin-plugins'),
			'initial' => esc_html__('Initial', 'shadhin-plugins'),
		);
		return $list;
	}
}



if(!function_exists('shadhin_plugins_disply_flex_horizontal_align_elementor')) {
	/**
	 * Horizontal Align list Elementor
	 */
	function shadhin_plugins_disply_flex_horizontal_align_elementor() {
		$list = array(
			'' => esc_html__( 'Default', 'shadhin-plugins' ),
			'flex-start' => esc_html__( 'Start', 'shadhin-plugins' ),
			'center' => esc_html__( 'Center', 'shadhin-plugins' ),
			'flex-end' => esc_html__( 'End', 'shadhin-plugins' ),
			'space-between' => esc_html__( 'Space Between', 'shadhin-plugins' ),
			'space-around' => esc_html__( 'Space Around', 'shadhin-plugins' ),
			'space-evenly' => esc_html__( 'Space Evenly', 'shadhin-plugins' ),
		);
		return $list;
	}
}



if(!function_exists('shadhin_plugins_disply_flex_vertical_align_elementor')) {
	/**
	 * Vertical Align list Elementor
	 */
	function shadhin_plugins_disply_flex_vertical_align_elementor() {
		$list = array(
			'' => esc_html__( 'Default', 'shadhin-plugins' ),
			'flex-start' => esc_html__( 'Top', 'shadhin-plugins' ),
			'center' => esc_html__( 'Middle', 'shadhin-plugins' ),
			'flex-end' => esc_html__( 'Bottom', 'shadhin-plugins' ),
		);
		return $list;
	}
}



if(!function_exists('shadhin_plugins_disply_flex_direction_elementor')) {
	/**
	 * flex-direction list Elementor
	 */
	function shadhin_plugins_disply_flex_direction_elementor() {
		$list = array(
			'' => esc_html__( 'Default', 'shadhin-plugins' ),
			'row' => esc_html__( 'Displayed horizontally', 'shadhin-plugins' ),
			'row-reverse' => esc_html__( 'Displayed horizontally but in reverse order', 'shadhin-plugins' ),
			'column' => esc_html__( 'Displayed vertically, as a column', 'shadhin-plugins' ),
			'column-reverse' => esc_html__( 'Displayed vertically but in reverse order', 'shadhin-plugins' ),
		);
		return $list;
	}
}



if(!function_exists('shadhin_plugins_php_date_format')) {
	/**
	 * Masorny Gutter list Elementor
	 */
	function shadhin_plugins_php_date_format( $type = 'day' ) {
		$day_list = array(
			'd' =>  esc_html__( 'The day of the month (from 01 to 31)', 'shadhin-plugins' ),
			'D' =>  esc_html__( 'A textual representation of a day (three letters)', 'shadhin-plugins' ),
			'j' =>  esc_html__( 'The day of the month without leading zeros', 'shadhin-plugins' ),
			'l' =>  esc_html__( 'A full textual representation of a day', 'shadhin-plugins' ),
			'w' =>  esc_html__( 'A numeric representation of the day (1 for Monday, 7 for Sunday)', 'shadhin-plugins' ),
		);
		$month_list = array(
			'F' =>  esc_html__( 'A full textual representation of a month (January through December)', 'shadhin-plugins' ),
			'm' =>  esc_html__( 'A numeric representation of a month (from 01 to 12)', 'shadhin-plugins' ),
			'M' =>  esc_html__( 'A short textual representation of a month (three letters)', 'shadhin-plugins' ),
			'n' =>  esc_html__( 'A numeric representation of a month, without leading zeros', 'shadhin-plugins' ),
		);
		$year_list = array(
			'Y' =>  esc_html__( 'A four digit representation of a year', 'shadhin-plugins' ),
			'y' =>  esc_html__( 'A two digit representation of a year', 'shadhin-plugins' ),
		);



		switch ($type) {
			case 'day':
				return $day_list;
				break;
			case 'month':
				return $month_list;
				break;
			case 'year':
				return $year_list;
				break;

			default:
				return $day_list;
				break;
		}
	}
}

if(!function_exists('shadhin_plugins_get_elementor_templates')) {
	/**
	 * Get Elementor Templates
	 */
    function shadhin_plugins_get_elementor_templates() {
        $templates = get_posts([
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
        ]);

        if (!empty($templates) && !is_wp_error($templates)) {

            foreach ($templates as $template) {
                $options[$template->ID] = $template->post_title;
            }

            update_option('temp_count', $options);

            return $options ?? [];
        }
    }
}



// Return true if Elementor exists and mode is preview
if ( !function_exists( 'shadhin_plugins_is_edit' ) ) {
	function shadhin_plugins_is_edit() {
		static $is_edit = -1;
		if ( $is_edit === -1 ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				$is_edit = true;
			} else {
				$is_edit = false;
			}
		}
		return $is_edit;
	}
}
if ( !function_exists( 'shadhin_plugins_is_preview' ) ) {
	function shadhin_plugins_is_preview() {
		static $is_preview = -1;
		if ( $is_preview === -1 ) {
			if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				$is_preview = true;
			} else {
				$is_preview = false;
			}
		}
		return $is_preview;
	}
}


if ( !function_exists( 'shadhin_plugins_header_mobile_full_page_nav_add_class_to_body' ) ) {
	function shadhin_plugins_header_mobile_full_page_nav_add_class_to_body ( $classes ) {
		$classes[] = 'menu-full-page';
		return $classes;
	}
	add_filter( 'body_class', 'shadhin_plugins_header_mobile_full_page_nav_add_class_to_body' );
}


if(!function_exists('shadhin_plugins_get_inline_attrs')) {
	/**
	 * Generate multiple inline attributes
	 *
	 * @param $attrs
	 *
	 * @return string
	 */
	function shadhin_plugins_get_inline_attrs($attrs) {
		$output = '';

		if(is_array($attrs) && count($attrs)) {
			foreach($attrs as $attr => $value) {
				$output .= ' '.shadhin_plugins_get_inline_attr($value, $attr);
			}
		}

		$output = ltrim($output);

		return $output;
	}
}


if(!function_exists('shadhin_plugins_get_inline_attributes')) {
	/**
	 * Get inline attributes and it's properties
	 */
	function shadhin_plugins_get_inline_attributes( $values, $attribute, $glue = '' ) {
		if( $values != '' ) {
			if( is_array( $values ) && count( $values ) ) {
				$properties = implode( $glue, $values );
			} elseif( $values !== '' ) {
				$properties = $values;
			}

			return $attribute . '="' . esc_attr($properties) . '"';
		}
		return '';
	}
}


if(!function_exists('shadhin_plugins_get_inline_css')) {
	/**
	 * Get inline CSS
	 */
	function shadhin_plugins_get_inline_css( $values ) {
		return shadhin_plugins_get_inline_attributes( $values, 'style', $glue = ';' );
	}
}


if(!function_exists('shadhin_plugins_get_inline_classes')) {
	/**
	 * Get inline classes
	 */
	function shadhin_plugins_get_inline_classes( $values ) {
		return shadhin_plugins_get_inline_attributes( $values, 'class', $glue = ' ' );
	}
}

if ( ! function_exists( 'shadhin_plugins_wp_enqueue_script_lightgallery' ) ) {
	/**
	 * wp_enqueue_script for lightgallery
	 */
	function shadhin_plugins_wp_enqueue_script_lightgallery() {
		wp_enqueue_script( 'lightgallery' );
		wp_enqueue_style( 'lightgallery' );
		wp_enqueue_script( 'jquery-mousewheel' );
		wp_enqueue_script( 'mediko-custom-lightgallery' );
	}
}

if ( ! function_exists( 'shadhin_plugins_no_posts_match_criteria_text' ) ) {
	/**
	 * Return no posts matched your criteria text
	 */
	function shadhin_plugins_no_posts_match_criteria_text() {
		return '<p>' . esc_html_e( 'Sorry, no posts matched your criteria.', 'shadhin-plugins' ) . '</p>';
	}
}

if(!function_exists('shadhin_plugins_if_numeric_add_suffix')) {
	/**
	 * Add Suffix from String
	 */
	function shadhin_plugins_if_numeric_add_suffix( $string, $suffix )
	{
		if( $string != '' && is_numeric($string) ) {
			$string = $string.$suffix;
		}
		return $string;
	}
}

if ( ! function_exists( 'shadhin_plugins_get_isotope_holder_ID' ) ) {
	/**
	 * Returns Portfolio Holder ID
	 *
	 */
	function shadhin_plugins_get_isotope_holder_ID( $id_prefix = 'id' ) {
		$random_number = wp_rand( 111111, 999999 );
		$holder_id = $id_prefix . '-holder-' . $random_number;
		return $holder_id;
	}
}




if(!function_exists('shadhin_plugins_heading_tag_list_all')) {
	/**
	 * Heading Tag List
	 */
	function shadhin_plugins_heading_tag_list_all() {
		$heading_tag_list_all = array(
			'h1' => 'h1',
			'h2' => 'h2',
			'h3' => 'h3',
			'h4' => 'h4',
			'h5' => 'h5',
			'h6' => 'h6',
			'p'  => 'p',
			'a'  => 'a',
			'span'  => 'span',
			'div'  => 'div',
		);
		return $heading_tag_list_all;
	}
}