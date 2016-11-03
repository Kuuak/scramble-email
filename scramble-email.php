<?php
/**
 * Plugin Name:		Scramble Email
 * Description: 	Protect your email addresses from being harvested by automatic bots. Simply replace the emails in your post or page content by an unique shortcode.
 * Author: 				Felipe Paul Martins - Opus Magnum
 * Version: 			0.1
 * Author URI:		https://opusmagnum.ch
 * License:				GPL-2.0+
 * License URI:		http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Scramble Email is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * Scramble Email is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package		Scramble_Email
 * @author		Felipe Paul Martins <fpm@opusmagnum.ch>
 * @license		GPL-2.0+
 * @link			https://opusmagnum.ch
 */

/* Prevent loading this file directly */
defined( 'ABSPATH' ) || exit;

/**
 * Add default options on plugin activation.
 * @since 1.1
 */
function scramble_email_activate() {

	add_option( 'scem_zone', array('normal') );
	add_option( 'scem_posttype', array('post', 'page') );
}
register_activation_hook( __FILE__, 'scramble_email_activate' );


if ( !class_exists( 'Scramble_Email' ) ) {

	/**
	 * Class Scramble_Email
	 * @since TODO version
	 */
	class Scramble_Email {

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since		TODO version
		 * @access	protected
		 * @var			string	$plugin_name	The string used to uniquely identify this plugin.
		 */
		protected $plugin_name;

		/**
		 * The current version of the plugin.
		 *
		 * @since		TODO version
		 * @access	protected
		 * @var			string	$version	The current version of the plugin.
		 */
		protected $version;

		/**
		 * The directory path of the plugin.
		 *
		 * @since		TODO version
		 * @access	protected
		 * @var			string	$dir_path	The directory path of the plugin.
		 */
		protected $dir_path;

		/**
		 * The directory URI of the plugin.
		 *
		 * @since		TODO version
		 * @access	protected
		 * @var			string	$dir_uri	The directory URI of the plugin.
		 */
		protected $dir_uri;

		/**
		 * Class Constructor.
		 *
		 * @since		TODO version
		 */
		public function __construct() {

			$this->version			= '0.1';
			$this->plugin_name	= 'scramble-email';
			$this->dir_path			= trailingslashit( plugin_dir_path( __FILE__ ) );
			$this->dir_uri			= trailingslashit( plugin_dir_url(  __FILE__ ) );

			$this->load_dependencies();
			$this->register_public_hooks();
		}

		/**
		 * Init the plugin functions
		 *
		 * @since		TODO version
		 */
		private function load_dependencies() {

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once $this->dir_path .'admin/class-scramble-email-admin.php';
		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since		TODO version
		 */
		private function register_public_hooks() {

			add_action( 'init', array($this, 'add_shortcodes') );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since		TODO version
		 */

		}

		/**
		 * Register the shortcode
		 *
		 * @since		TODO version
		 */
		public function add_shortcodes() {

			add_shortcode( 'scem', array($this, 'render_shortcode') );
		}

		/**
		 * Transform the shortcode into javascript function call.
		 *
		 * @since		TODO version
		 *
		 * @param		array		$atts		Shortcode attributes.
		 * @return	string					Rendered HTML.
		 */
		public function render_shortcode( $atts ) {
			// Attributes
			extract( shortcode_atts(
				array(
					'email'			=> null,
					'title'			=> "Email",
					'classes'		=> null,
					'subject'		=> null,
				), $atts )
			);

			$email = base64_encode($email);
			$title = base64_encode($title);

			return "<script>scem_unscramble( '$email' , '$title'". ( (!empty($classes) || !empty($subject)) ? ', '. (!empty($subject) ? "'$classes'" : "'null'") . (!empty($subject) ? ", '$subject'" : '') : '' ) .');</script>';
		}

		/**
		 * Enqueuing js/css files
		 *
		 * @since		TODO version
		 */
		public function enqueue_scripts( ) {

			wp_enqueue_script( 'scem_js', $this->dir_uri . 'js/scem.js', NULL, $this->version );
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since		TODO version
		 * @return	string	The name of the plugin.
		 */
		public function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since		TODO version
		 * @return	string	The version number of the plugin.
		 */
		public function get_version() {
			return $this->version;
		}
	}
}

new Scramble_Email();
