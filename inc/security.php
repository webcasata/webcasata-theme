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
	// CSS never needs a "<" character; removing it rules out any closing
	// </style> or other markup surviving into the inline style tag.
	$value = str_replace( '<', '', $value );
	return trim( $value );
}

/**
 * Sanitize custom JS.
 *
 * Only users with the unfiltered_html capability (administrators on single
 * site, super admins on multisite) may store JavaScript. For anyone else the
 * previously saved value is kept unchanged, so they cannot inject scripts.
 *
 * @param string                    $value   Raw JS.
 * @param WP_Customize_Setting|null $setting Setting object, when called by the Customizer.
 * @return string
 */
function webcasata_sanitize_js( $value, $setting = null ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		return trim( (string) $value );
	}
	return (string) webcasata_get_option( 'custom_js', '' );
}

/**
 * Sanitize a single imported theme mod using the same rules the Customizer
 * applies, so imported JSON can never bypass sanitization.
 *
 * @param string $key   Full theme mod name (with webcasata_ prefix).
 * @param mixed  $value Raw imported value.
 * @return mixed|null Sanitized value, or null to skip the key.
 */
function webcasata_sanitize_import_value( $key, $value ) {
	if ( ! is_scalar( $value ) ) {
		return null;
	}

	if ( 0 === strpos( $key, 'webcasata_feature_' ) ) {
		return webcasata_sanitize_checkbox( $value );
	}

	$name = substr( $key, strlen( 'webcasata_' ) );

	if ( 0 === strpos( $name, 'color_' ) ) {
		$color = sanitize_hex_color( $value );
		return $color ? $color : null;
	}

	$choices = array(
		'container_type' => array( 'boxed', 'full' ),
		'header_layout'  => array( 'logo-left', 'logo-center' ),
		'heading_weight' => array( '400', '500', '600', '700', '800' ),
		'font_body'      => array_keys( webcasata_font_choices() ),
		'font_heading'   => array_keys( webcasata_font_choices() ),
	);
	if ( isset( $choices[ $name ] ) ) {
		$value = sanitize_key( $value );
		return in_array( $value, $choices[ $name ], true ) ? $value : null;
	}

	switch ( $name ) {
		case 'btn_radius':
			return absint( $value );
		case 'line_height':
			return webcasata_sanitize_float( $value );
		case 'footer_text':
			return wp_kses_post( $value );
		case 'custom_css':
			return webcasata_sanitize_css( $value );
		case 'custom_js':
			return current_user_can( 'unfiltered_html' ) ? trim( (string) $value ) : null;
		case 'login_logo':
			return esc_url_raw( $value );
		default:
			return webcasata_sanitize_positive_int( $value );
	}
}
