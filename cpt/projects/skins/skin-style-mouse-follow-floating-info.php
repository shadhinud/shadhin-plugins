<?php
namespace Shadhinplugins\Widgets\Projects\Skins;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Skin_Base as Elementor_Skin_Base;

use Shadhinplugins\Lib;
use Shadhinplugins\CPT\Projects\CPT_Projects;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Style_Mouse_Follow_Floating_Info extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/mh-ele-cpt-projects/mh_general/after_section_end', [ $this, 'register_layout_controls' ] );
	}

	public function get_id() {
		return 'skin-style-mouse-follow-floating-info';
	}


	public function get_title() {
		return __( 'Skin - Mouse Follow Floating Info', 'shadhin-plugins' );
	}


	public function register_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();

		$direction_suffix = is_rtl() ? '.rtl' : '';
		wp_enqueue_style( 'mh-project-skin-mouse-follow-floating-info', SHADHIN_PLUGINS_ASSETS_URI . '/css/cpt/projects/project-skin-mouse-follow-floating-info' . $direction_suffix . '.css' );

		$new_cpt_class = CPT_Projects::Instance();
		$class_instance =  (array) $new_cpt_class;
		$settings['holder_id'] = shadhin_get_isotope_holder_ID('projects');

		$project_image_size_array_new = array();
		if ( $settings['project_image_size_array'] ) :
			foreach (  $settings['project_image_size_array'] as $each_item ) {
				$project_image_size_array_new[$each_item['image_for_project']] = $each_item['image_size'];
			}
		endif;
		$settings['project_image_size_array_new'] = $project_image_size_array_new;

		$this->render_output( $class_instance, $settings );
	}

	public function render_output( $class_instance, $settings ) {
		$new_cpt_class = $class_instance;

		$settings['the_query'] = $this->parent->query_posts($new_cpt_class);

		//classes
		$classes = array();
		if( $settings['add_border_radius'] ) {
			$classes[] = 'border-radius-around-box';
		}
		$classes[] = 'mh-has-mouse-follow-floating-info';
		$settings['classes'] = $classes;

		//button classes
		$settings['btn_classes'] = shadhin_plugins_prepare_button_classes_from_params( $settings );

		//ptTaxKey
		$settings['ptTaxKey'] = $new_cpt_class['ptTaxKey'];

		$settings['settings'] = $settings;

		$html = shadhin_plugins_get_cpt_shortcode_template_part( 'projects', $settings['display_type'], 'projects/tpl', $settings, true );

		echo $html;
	}
}
