<?php
namespace JLTFLICKR;

use JLTFLICKR\Libs\Assets;
use JLTFLICKR\Libs\Helper;
use JLTFLICKR\Libs\Featured;
use JLTFLICKR\Inc\Classes\Recommended_Plugins;
use JLTFLICKR\Inc\Classes\Notifications\Notifications;
use JLTFLICKR\Inc\Classes\Pro_Upgrade;
use JLTFLICKR\Inc\Classes\Row_Links;
use JLTFLICKR\Inc\Classes\Upgrade_Plugin;
use JLTFLICKR\Inc\Classes\Feedback;
use JLTFLICKR\Inc\Classes\Flickr_Widget;

/**
 * Main Class
 *
 * @jewel-flickr
 * Jewel Theme <support@jeweltheme.com>
 * @version     1.0.5
 */

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JLT_Flickr Class
 */
if ( ! class_exists( '\JLTFLICKR\JLT_Flickr' ) ) {

	/**
	 * Class: JLT_Flickr
	 */
	final class JLT_Flickr {

		const VERSION            = JLTFLICKR_VER;
		private static $instance = null;

		/**
		 * what we collect construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'jlt_flickr_plugins_loaded' ), 999 );
			// Body Class.
			add_filter( 'admin_body_class', array( $this, 'jlt_flickr_body_class' ) );
			// This should run earlier .
			// add_action( 'plugins_loaded', [ $this, 'jlt_flickr_maybe_run_upgrades' ], -100 ); .
			add_action( 'widgets_init', array( $this, 'jlt_flickr_register' ) );
			add_action('admin_init', array( $this, 'jlt_flickr_ignore' ) );
		}


		/**
		 * plugins_loaded method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_flickr_plugins_loaded() {
			$this->jlt_flickr_activate();
		}

		/**
		 * Version Key
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function plugin_version_key() {
			return Helper::jlt_flickr_slug_cleanup() . '_version';
		}

		/**
		 * Activation Hook
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function jlt_flickr_activate() {
			$current_jlt_flickr_version = get_option( self::plugin_version_key(), null );

			if ( get_option( 'jlt_flickr_activation_time' ) === false ) {
				update_option( 'jlt_flickr_activation_time', strtotime( 'now' ) );
			}

			if ( is_null( $current_jlt_flickr_version ) ) {
				update_option( self::plugin_version_key(), self::VERSION );
			}

			$allowed = get_option( Helper::jlt_flickr_slug_cleanup() . '_allow_tracking', 'no' );

			// if it wasn't allowed before, do nothing .
			if ( 'yes' !== $allowed ) {
				return;
			}
			// re-schedule and delete the last sent time so we could force send again .
			$hook_name = Helper::jlt_flickr_slug_cleanup() . '_tracker_send_event';
			if ( ! wp_next_scheduled( $hook_name ) ) {
				wp_schedule_event( time(), 'weekly', $hook_name );
			}
		}


		/**
		 * Add Body Class
		 *
		 * @param [type] $classes .
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_flickr_body_class( $classes ) {
			$classes .= ' jewel-flickr ';
			return $classes;
		}

		/**
		 * Run Upgrader Class
		 *
		 * @return void
		 */
		public function jlt_flickr_maybe_run_upgrades() {
			if ( ! is_admin() && ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Run Upgrader .
			$upgrade = new Upgrade_Plugin();

			// Need to work on Upgrade Class .
			if ( $upgrade->if_updates_available() ) {
				$upgrade->run_updates();
			}
		}

		/**
		 * Include methods
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {
			new Assets();
			new Recommended_Plugins();
			new Row_Links();
			new Pro_Upgrade();
			new Notifications();
			new Featured();
			new Feedback();
		}


		/**
		 * Initialization
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_flickr_init() {
			$this->jlt_flickr_load_textdomain();
		}


		/**
		 * Text Domain
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jlt_flickr_load_textdomain() {
			$domain = 'jewel-flickr';
			$locale = apply_filters( 'jlt_flickr_plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( JLTFLICKR_BASE ) . '/languages/' );
		}
		

		/**
		 * Register Flickr Ignore
		 */		
		public function jlt_flickr_ignore(){
			global $current_user;
		    $user_id = $current_user->ID;
		    if ( isset($_GET['jewel_flickr_ignore']) && '0' == $_GET['jewel_flickr_ignore'] ) {
		         add_user_meta($user_id, 'example_ignore_notice', 'true', true);
			}
		}


		/**
		 * Register Flickr Widget
		 */		
		public function jlt_flickr_register(){
			$register_widget = new Flickr_Widget();
			register_widget( $register_widget );	
		}

		/**
		 * Returns the singleton instance of the class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof JLT_Flickr ) ) {
				self::$instance = new JLT_Flickr();
				self::$instance->jlt_flickr_init();
			}

			return self::$instance;
		}
	}

	// Get Instant of JLT_Flickr Class .
	JLT_Flickr::get_instance();
}