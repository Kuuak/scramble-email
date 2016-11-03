<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://opusmagnum.ch
 * @since      TODO version
 *
 * @package    Scramble_Email
 * @subpackage Scramble_Email/admin
 */

/* Prevent loading this file directly */
defined( 'ABSPATH' ) || exit;

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Scramble_Email
 * @subpackage Scramble_Email/admin
 * @author     Felipe Paul Martins <fpm@opusmagnum.ch>
 */
if ( !class_exists( 'Scramble_Email_Admin' ) ) {

	/**
	 * Class Scramble_Email_Admin
	 * @since	TODO version
	 */
	class Scramble_Email_Admin {

		/**
		 * The ID of this plugin.
		 *
		 * @since		TODO version
		 * @access	private
		 * @var			string	$plugin_name	The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since		TODO version
		 * @access	private
		 * @var			string	$version	The current version of this plugin.
		 */
		private $version;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since		TODO version
		 * @param		string	$plugin_name	The name of this plugin.
		 * @param		string	$version			The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {
			$this->plugin_name = $plugin_name;
			$this->version = $version;
		}

		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since		TODO version
		 */
		public function enqueue_styles() {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/scem-wpview.css', array(), $this->version, 'all' );
		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since		TODO version
		 */
		public function enqueue_editor_style() {
			global $editor_styles;

			$editor_styles[] = plugin_dir_url( __FILE__ ) .'css/scem-wpview.css';
		}

		/**
		 * Register the TinyMCE plugin
		 *
		 * @since		TODO version
		 */
		public function register_mce_plugin() {

			if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
				return false;
			}

			if ( 'true' == get_user_option('rich_editing') ) {
				add_filter( 'mce_buttons', array($this, 'mce_add_button') );
				add_filter( 'mce_external_plugins', array($this, 'mce_enqueue_js') );
			}
		}

		/**
		 * Add the custom button to the TinyMCE first toolbar
		 *
		 * @since		TODO version
		 *
		 * @param 	array	$buttons	An array of tinyMCE buttons.
		 * @return	array
		 */
		public function mce_add_button( $buttons ) {
			array_push( $buttons, 'scem_mce_button' );
			return $buttons;
		}

		/**
		 * Enqueue the MCE plugin javascript
		 *
		 * @since		TODO version
		 *
		 * @param		array	$plugins	An array of all plugins.
		 * @return	array
		 */
		public function mce_enqueue_js( $plugin_array ) {
			$plugin_array['scem_mce_plugin']		= plugin_dir_url( __FILE__ ) .'js/scem-mce-plugin.js';
			$plugin_array['scem_admin_wpview']	= plugin_dir_url( __FILE__ ) .'js/scem-wpview.js';
			return $plugin_array;
		}
	}
}
