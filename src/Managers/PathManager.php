<?php

namespace Objectiv\BoosterSeat\Managers;

/**
 * Manages plugin related path information.
 *
 * This class is mainly used in the template manager and other classes related to plugin setup and file management
 *
 * @link objectiv.co
 * @since 0.0.1
 * @package Objectiv\Plugins\BulkCodes\Managers
 * @author Brandon Tassone <brandontassone@gmail.com>
 */

class PathManager {
	/**
	 * @since 0.0.1
	 * @access private
	 * @var string The base path to the plugin
	 */
	private $base;

	/**
	 * @since 0.0.1
	 * @access private
	 * @var string The url base path to the plugin
	 */
	private $url_base;

	/**
	 * @since 0.0.1
	 * @access private
	 * @var string The assets path
	 */
	private $assets;

	/**
	 * @since 0.0.1
	 * @access private
	 * @var string The plugin template path
	 */
	private $plugin_template;

	/**
	 * @since 0.0.1
	 * @access private
	 * @var string The theme template path
	 */
	private $theme_template;

	/**
	 * @since 0.0.1
	 * @access private
	 * @var string The main file name that initiates the plugin
	 */
	private $main_file;

	/**
	 * @since 0.0.1
	 * @access private
	 * @var string The raw file name
	 */
	private $raw_file;

	/**
	 * PathManager constructor.
	 *
	 * @since 0.0.1
	 * @access public
	 * @param string $base The plugin base path
	 * @param string $url_base The plugin url base path
	 * @param string $main_file The main plugin file
	 */
	public function __construct($base, $url_base, $main_file) {
		$this->base = $base;
		$this->url_base = $url_base;
		$this->main_file = basename($main_file); // TODO: Rename main_file to main_file_basename
		$this->raw_file = $main_file;

		$this->plugin_template = $this->base . "templates";
		$this->assets = $this->url_base . "assets";
		$this->theme_template = get_stylesheet_directory() . "/checkout-wc";
	}

	/**
	 * Get raw file
	 *
	 * @since 0.0.1
	 * @return string
	 */
	public function get_raw_file() {
		return $this->raw_file;
	}

	/**
	 * Set raw file
	 *
	 * @since 0.0.1
	 * @param string $raw_file
	 */
	public function set_raw_file( $raw_file ) {
		$this->raw_file = $raw_file;
	}

	/**
	 * Get the path to the assets folder
	 *
	 * @since 0.0.1
	 * @access public
	 * @return string
	 */
	public function get_assets_path() {
		return $this->assets;
	}

	/**
	 * Return the base plugin path
	 *
	 * @since 0.0.1
	 * @access public
	 * @return string
	 */
	public function get_base() {
		return $this->base;
	}

	/**
	 * Return the main file name
	 *
	 * @since 0.0.1
	 * @access public
	 * @return string
	 */
	public function get_main_file() {
		return $this->main_file;
	}

	/**
	 * Returns the concatenated folder name with the main file name in one strong
	 *
	 * @since 0.0.1
	 * @access public
	 * @return string Returns the concatenated folder name with the main file name in one strong
	 */
	public function get_path_main_file() {
		return $this->base . "/" . $this->main_file;
	}

	/**
	 * @since 0.0.1
	 * @access public
	 * @return string The plugin template path
	 */
	public function get_plugin_template() {
		return $this->plugin_template;
	}

	/**
	 * Returns the value of the theme_template variable
	 *
	 * @since 0.0.1
	 * @access public
	 * @return string The theme template path
	 */
	public function get_theme_template() {
		return $this->theme_template;
	}

	/**
	 * Returns the value of variable url_base
	 *
	 * @since 0.0.1
	 * @access public
	 * @return string The url base path
	 */
	public function get_url_base() {
		return $this->url_base;
	}

	/**
	 * Determines where each sub folder file is actually located. Theme template files take precedence over plugin
	 * template files returned in the array.
	 *
	 * @since 0.0.1
	 * @access public
	 * @param array $sub_folders List of folder names within the template directories to look for template files.
	 * @return array
	 */
	public function get_template_information($sub_folders, $file_name = 'template.php') {
		$template_information = array();

		foreach($sub_folders as $sub_folder) {

			// Set up the possible paths
			$plugin_template_path = $this->plugin_template . "/" . $sub_folder . "/{$file_name}";
			$theme_template_path = $this->theme_template . "/" . $sub_folder . "/{$file_name}";

			// Get the template path we want (user overloaded, or base)
			$template_path = file_exists($theme_template_path) ? $theme_template_path : $plugin_template_path;

			// Add the appropriate paths to the template information array.
			$template_information[$sub_folder] = $template_path;
		}
		return $template_information;
	}
}