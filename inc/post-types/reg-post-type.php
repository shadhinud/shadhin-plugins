<?php
namespace Shadhinplugins\CPT;

use Shadhinplugins\Lib;

/**
 * class Reg_Post_Type
 * @package Shadhinplugins\CPT;
 */
class Reg_Post_Type {
	/**
	 * @var Singleton The reference to *Singleton* instance of this class
	 */
	private static $instance;

	/**
	 * @var array
	 */
	private $allPostTypes = array();

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Singleton The *Singleton* instance.
	 */
	public static function get_instance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct()
	{
	}

	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone()
	{
	}

	/**
	 * Private unserialize method to prevent unserializing of the *Singleton*
	 * instance.
	 *
	 * @return void
	 */
	public function __wakeup()
	{
	}


	/**
	 * Adds new post type to post types array
	 */
	private function add_new_post_type(Lib\Shadhin_plugins_Interface_PostType $newPostType) {
		if(!array_key_exists($newPostType->getPTKey(), $this->allPostTypes)) {
			$this->allPostTypes[$newPostType->getPTKey()] = $newPostType;
		}
	}

	/**
	 * List of all post types to register
	 */
	private function all_post_types_to_reg() {
		$this->add_new_post_type(HeaderTop\CPT_HeaderTop::Instance());
		$this->add_new_post_type(Footer\CPT_Footer::Instance());
		$this->add_new_post_type(PageTitle\CPT_PageTitle::Instance());
		$this->add_new_post_type(MegaMenu\CPT_MegaMenu::Instance());
		$this->add_new_post_type(SidePushPanel\CPT_SidePushPanel::Instance());
		//$this->add_new_post_type(Portfolio\CPT_Portfolio::Instance());
		$this->add_new_post_type(Projects\CPT_Projects::Instance());
		if ( class_exists( 'WPCF\Crowdfunding' ) ) {
			$this->add_new_post_type(WPCF\CPT_WPCFTemplate::Instance());
		}
	}


	/**
	 * Calls all_post_types_to_reg method, loops through each post type in array and calls register method
	 */
	public function register() {
		$this->all_post_types_to_reg();

		foreach ($this->allPostTypes as $eachPostType) {
			$eachPostType->register();
		}
	}
}


/**
 * enable elementor for each custom post types
 */
function tm_enable_elementor_for_all_cpt(){
    add_post_type_support( 'header-top', 'elementor' );
    add_post_type_support( 'megamenu', 'elementor' );
    add_post_type_support( 'page-title', 'elementor' );
    add_post_type_support( 'footer', 'elementor' );
    add_post_type_support( 'side-push-panel', 'elementor' );
    //add_post_type_support( 'portfolio-items', 'elementor' );
    add_post_type_support( 'projects', 'elementor' );
}
add_action('elementor/init','Shadhinplugins\CPT\tm_enable_elementor_for_all_cpt');