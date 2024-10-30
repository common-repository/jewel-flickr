<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version       1.0.0
 * @package       JLT_Flickr
 * @license       Copyright JLT_Flickr
 */

if ( ! function_exists( 'jlt_flickr_option' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param string $section default section name jlt_flickr_general .
	 * @param string $key .
	 * @param string $default .
	 *
	 * @return string
	 */
	function jlt_flickr_option( $section = 'jlt_flickr_general', $key = '', $default = '' ) {
		$settings = get_option( $section );

		return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'jlt_flickr_exclude_pages' ) ) {
	/**
	 * Get exclude pages setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jlt_flickr_exclude_pages() {
		return jlt_flickr_option( 'jlt_flickr_triggers', 'exclude_pages', array() );
	}
}

if ( ! function_exists( 'jlt_flickr_exclude_pages' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jlt_flickr_exclude_pages_except() {
		return jlt_flickr_option( 'jlt_flickr_triggers', 'exclude_pages_except', array() );
	}
}