<?php
namespace Shadhinplugins\Widgets\CountdownTimer\Skins;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Style3 extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/mh-ele-counter-block/mh_general/after_section_end', [ $this, 'register_layout_controls' ] );
	}

	public function get_id() {
		return 'skin-style3';
	}


	public function get_title() {
		return __( 'Skin Style3', 'shadhin-plugins' );
	}


	public function register_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;

	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();

		$direction_suffix = is_rtl() ? '.rtl' : '';
		wp_enqueue_style( 'mh-countdown-timer-style3', SHADHIN_PLUGINS_ASSETS_URI . '/css/shortcodes/countdown-timer/countdown-timer-style3' . $direction_suffix . '.css' );

		//classes
		$classes = array();
		$settings['classes'] = $classes;

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, shortcode_ob_start)
		$html = shadhin_plugins_get_shortcode_template_part( 'tpl-skin-style3', null, 'countdown-timer/tpl', $settings, true );

		echo $html;
	}
}