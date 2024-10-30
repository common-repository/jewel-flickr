<?php
/**
 * Plugin Name: Jewel Flickr
 * Plugin URI:  https://www.jeweltheme.com
 * Description: Jewel Flickr Plugin is a Simple Flickr Plugin to show Flickr Photos
 * Version:     1.0.5
 * Author:      Jewel Theme
 * Author URI:  https://jeweltheme.com
 * Text Domain: jewel-flickr
 * Domain Path: languages/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package jewel-flickr
 */

/*
 * don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'jewel-flickr' ) );
}

$jlt_flickr_plugin_data = get_file_data(
	__FILE__,
	array(
		'Version'     => 'Version',
		'Plugin Name' => 'Plugin Name',
		'Author'      => 'Author',
		'Description' => 'Description',
		'Plugin URI'  => 'Plugin URI',
	),
	false
);

// Define Constants.
if ( ! defined( 'JLTFLICKR' ) ) {
	define( 'JLTFLICKR', $jlt_flickr_plugin_data['Plugin Name'] );
}

if ( ! defined( 'JLTFLICKR_VER' ) ) {
	define( 'JLTFLICKR_VER', $jlt_flickr_plugin_data['Version'] );
}

if ( ! defined( 'JLTFLICKR_AUTHOR' ) ) {
	define( 'JLTFLICKR_AUTHOR', $jlt_flickr_plugin_data['Author'] );
}

if ( ! defined( 'JLTFLICKR_DESC' ) ) {
	define( 'JLTFLICKR_DESC', $jlt_flickr_plugin_data['Author'] );
}

if ( ! defined( 'JLTFLICKR_URI' ) ) {
	define( 'JLTFLICKR_URI', $jlt_flickr_plugin_data['Plugin URI'] );
}

if ( ! defined( 'JLTFLICKR_DIR' ) ) {
	define( 'JLTFLICKR_DIR', __DIR__ );
}

if ( ! defined( 'JLTFLICKR_FILE' ) ) {
	define( 'JLTFLICKR_FILE', __FILE__ );
}

if ( ! defined( 'JLTFLICKR_SLUG' ) ) {
	define( 'JLTFLICKR_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'JLTFLICKR_BASE' ) ) {
	define( 'JLTFLICKR_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'JLTFLICKR_PATH' ) ) {
	define( 'JLTFLICKR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'JLTFLICKR_URL' ) ) {
	define( 'JLTFLICKR_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

if ( ! defined( 'JLTFLICKR_INC' ) ) {
	define( 'JLTFLICKR_INC', JLTFLICKR_PATH . '/Inc/' );
}

if ( ! defined( 'JLTFLICKR_LIBS' ) ) {
	define( 'JLTFLICKR_LIBS', JLTFLICKR_PATH . 'Libs' );
}

if ( ! defined( 'JLTFLICKR_ASSETS' ) ) {
	define( 'JLTFLICKR_ASSETS', JLTFLICKR_URL . 'assets/' );
}

if ( ! defined( 'JLTFLICKR_IMAGES' ) ) {
	define( 'JLTFLICKR_IMAGES', JLTFLICKR_ASSETS . 'images' );
}

if ( ! class_exists( '\\JLTFLICKR\\JLT_Flickr' ) ) {
	// Autoload Files.
	include_once JLTFLICKR_DIR . '/vendor/autoload.php';
	// Instantiate JLT_Flickr Class.
	include_once JLTFLICKR_DIR . '/class-jewel-flickr.php';
}