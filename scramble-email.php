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
 * @package		scramble-email
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


if ( !class_exists( 'Scramble_email' ) ) {

	/**
	 * Class Scramble_email
	 * @since TODO version
	 */
	class Scramble_email {

		/**
		 * Class Constructor.
		 * @since  TODO version
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'scem_setup' ), 1 );
			add_action( 'plugins_loaded', array( $this, 'scem_init' ), 10 );
		}

		/**
		 * Setup ID, Version, Directory path, and URI
		 * @since  TODO version
		 */
		public function scem_setup() {
			$this->id							= 'scem';
			$this->version				= '0.1';
			$this->directory_path	= trailingslashit( plugin_dir_path( __FILE__ ) );
			$this->directory_uri	= trailingslashit( plugin_dir_url(  __FILE__ ) );
		}

		/**
		 * Init the plugin functions
		 * @since	TODO version
		 */
		public function scem_init() {

			add_action( 'init', array($this, 'register_shortcodes') );
			add_action('wp_enqueue_scripts', array( $this, 'scem_enqueue_files') );
		}

		function register_shortcodes() {

			add_shortcode( 'scem-email', array($this, 'render_shortcode') );
		}

		function render_shortcode( $atts ) {
			// Attributes
			extract( shortcode_atts(
				array(
					'email'		=> null,
					'class'		=> null,
					'subject'	=> null,
					'title'		=> "Email",
				), $atts )
			);

			$email = base64_encode($email);
			$title = base64_encode($title);

			return "<script>scem_unscramble( '$email' , '$title'". ( (!empty($class) || !empty($subject)) ? ', '. (!empty($subject) ? "'$class'" : "'null'") . (!empty($subject) ? ", '$subject'" : '') : '' ) .');</script>';
		}

		/**
		 * Enqueuing js/css files
		 * @since	TODO version
		 */
		public function scem_enqueue_files( ) {

			wp_enqueue_script( 'scem_js', $this->directory_uri . 'js/scem.js', NULL, $this->version );
			// wp_enqueue_style( 'scem_css', $this->directory_uri . 'css/scem.css', false, $this->version );

			// if ( is_array($zones = get_option('scem_zone')) ) {
			// 	wp_localize_script( 'scem_js', 'scem', array_flip($zones) );
			// }
		}
	}
}

new Scramble_email();
