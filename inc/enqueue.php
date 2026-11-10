<?php
/**
 * Front-end asset loading.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Resolve an asset version, preferring the file modification time.
 *
 * @param string $relative Relative path inside the theme.
 * @return string
 */
function webcasata_asset_version( $relative ) {
	$file = WEBCASATA_DIR . $relative;
	return file_exists( $file ) ? (string) filemtime( $file ) : WEBCASATA_VERSION;
}

/**
 * Enqueue front-end styles and scripts.
 */
function webcasata_enqueue_assets() {
	$min     = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$css_rel = 'assets/css/theme' . $min . '.css';

	if ( ! file_exists( WEBCASATA_DIR . $css_rel ) ) {
		$css_rel = 'assets/css/theme.css';
	}

	wp_enqueue_style( 'webcasata-style', WEBCASATA_URI . $css_rel, array(), webcasata_asset_version( $css_rel ) );

	$js_rel = 'assets/js/theme.js';
	wp_enqueue_script( 'webcasata-theme', WEBCASATA_URI . $js_rel, array(), webcasata_asset_version( $js_rel ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	webcasata_enqueue_fonts();
	webcasata_enqueue_woocommerce_assets();
}
add_action( 'wp_enqueue_scripts', 'webcasata_enqueue_assets' );

/**
 * Enqueue Google Fonts only when a non-system font is selected.
 */
function webcasata_enqueue_fonts() {
	$choices  = webcasata_font_choices();
	$families = array();

	foreach ( array( 'font_body', 'font_heading' ) as $key ) {
		$choice = webcasata_get_option( $key, webcasata_default( $key ) );
		if ( isset( $choices[ $choice ]['google'] ) && $choices[ $choice ]['google'] ) {
			$families[] = $choices[ $choice ]['google'];
		}
	}

	$families = array_values( array_unique( $families ) );
	if ( empty( $families ) ) {
		return;
	}

	$url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $families ) . '&display=swap';
	wp_enqueue_style( 'webcasata-fonts', $url, array(), null );
}
add_filter(
	'wp_resource_hints',
	static function ( $hints, $relation_type ) {
		if ( 'preconnect' === $relation_type ) {
			$hints[] = array(
				'href'        => 'https://fonts.gstatic.com',
				'crossorigin' => 'anonymous',
			);
		}
		return $hints;
	},
	10,
	2
);

/**
 * Enqueue WooCommerce styles only when the plugin is active.
 */
function webcasata_enqueue_woocommerce_assets() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$rel = 'assets/css/woocommerce' . $min . '.css';

	if ( ! file_exists( WEBCASATA_DIR . $rel ) ) {
		$rel = 'assets/css/woocommerce.css';
	}

	if ( file_exists( WEBCASATA_DIR . $rel ) ) {
		wp_enqueue_style( 'webcasata-woocommerce', WEBCASATA_URI . $rel, array( 'webcasata-style' ), webcasata_asset_version( $rel ) );
	}
}

/**
 * Defer the theme script.
 *
 * @param string $tag    Script tag.
 * @param string $handle Script handle.
 * @param string $src    Script source.
 * @return string
 */
function webcasata_defer_script( $tag, $handle, $src ) {
	if ( 'webcasata-theme' !== $handle ) {
		return $tag;
	}

	return sprintf(
		'<script src="%s" defer id="%s-js"></script>',
		esc_url( $src ),
		esc_attr( $handle )
	);
}
add_filter( 'script_loader_tag', 'webcasata_defer_script', 10, 3 );
