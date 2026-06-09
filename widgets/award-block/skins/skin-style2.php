<?php
namespace Shadhinplugins\Widgets\AwardBlock\Skins;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Style2 extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/mh-ele-award-block/mh_general/after_section_end', [ $this, 'register_layout_controls' ] );
	}

	public function get_id() {
		return 'skin-style2';
	}


	public function get_title() {
		return __( 'Skin Style2', 'shadhin-plugins' );
	}


	public function register_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();

		$direction_suffix = is_rtl() ? '.rtl' : '';
		wp_enqueue_style( 'mh-award-block-skin-style2', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/award-block/award-block-skin-style2' . $direction_suffix . '.css' );
		wp_register_script( 'award-block2', SHADHIN_PLUGINS_ASSETS_URI . '/js/widgets/award-block2.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'award-block2' );

		if( $settings['animate_icon_on_hover'] ) {
			$classes[] = 'animate-hover animate-icon-'.$settings['animate_icon_on_hover'];
		}

		//icon classes
		$icon_classes = array();
		$settings['icon_classes'] = $icon_classes;

		//button classes
		$settings['btn_classes'] = shadhin_plugins_prepare_button_classes_from_params( $settings );


		//icon classes
		$icon_classes = array();
		$settings['icon_classes'] = $icon_classes;

		$settings['holder_id'] = shadhin_get_isotope_holder_ID('award-block');

		$settings['settings'] = $settings;

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_template_part( 'award', $settings['display_type'], 'award-block/tpl', $settings, true );

		echo $html;
	}
}