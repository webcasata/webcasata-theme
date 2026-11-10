<?php
/**
 * Security helpers, sanitizers and small hardening.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get a prefixed theme mod with a default.
 *
 * @param string $name    Setting name without the theme prefix.
 * @param mixed  $default Default value.
 * @return mixed
 */
function webcasata_get_option( $name, $default = '' ) {
	return get_theme_mod( 'webcasata_' . $name, $default );
}

/**
 * Sanitize a checkbox value.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function webcasata_sanitize_checkbox( $value ) {
	return ( isset( $value ) && true === (bool) $value );
}

/**
 * Sanitize a select value against the control choices.
 *
 * @param string               $value   Raw value.
 * @param WP_Customize_Setting $setting Setting object.
 * @return string
 */
function webcasata_sanitize_select( $value, $setting ) {
	$value   = sanitize_key( $value );
	$control = $setting->manager->get_control( $setting->id );

	if ( $control && ! empty( $control->choices ) && array_key_exists( $value, $control->choices ) ) {
		return $value;
	}

	return $setting->default;
}

/**
 * Sanitize a positive float.
 *
 * @param mixed $value Raw value.
 * @return float
 */
function webcasata_sanitize_float( $value ) {
	$value = (float) $value;
	return $value > 0 ? $value : 0;
}

/**
 * Sanitize a positive integer, falling back to the default.
 *
 * @param mixed $value Raw value.
 * @return int
 */
function webcasata_sanitize_positive_int( $value ) {
	$value = absint( $value );
	return $value > 0 ? $value : 1;
}

/**
 * Sanitize custom CSS.
 *
 * @param string $value Raw CSS.
 * @return string
 */
function webcasata_sanitize_css( $value ) {
	$value = wp_strip_all_tags( (string) $value );
	$value = str_ireplace( array( '</style', '<style', '<?' ), '', $value );
	return trim( $value );
}

/**
 * Sanitize custom JS. Only users with unfiltered_html may store raw markup.
 *
 * @param string $value Raw JS.
 * @return string
 */
function webcasata_sanitize_js( $value ) {
	$value = (string) $value;
	if ( current_user_can( 'unfiltered_html' ) ) {
		return trim( $value );
	}
	return webcasata_sanitize_css( $value );
}

/**
 * Basic hardening: hide the WordPress generator version.
 */
function webcasata_remove_generator() {
	remove_action( 'wp_head', 'wp_generator' );
	add_filter( 'the_generator', '__return_empty_string' );
}
add_action( 'init', 'webcasata_remove_generator' );
