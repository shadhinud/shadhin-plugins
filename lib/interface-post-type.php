<?php
namespace Shadhinplugins\Lib;

/**
 * interface Shadhin_plugins_Interface_PostType
 * @package Shadhinplugins\Lib;
 */
interface Shadhin_plugins_Interface_PostType {
	/**
	 * Returns PT Key
	 * @return string
	 */
	public function getPTKey();

	/**
	 * It registers custom post type
	 */
	public function register();
}