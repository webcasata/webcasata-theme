<?php
/**
 * Theme setup: supports, menus, image sizes, content width.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme features.
 */
function webcasata_setup() {
	load_theme_textdomain( 'webcasata', WEBCASATA_DIR . 'languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/theme.css' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'webcasata' ),
			'footer'  => __( 'Footer Menu', 'webcasata' ),
			'top'     => __( 'Top Bar Menu', 'webcasata' ),
		)
	);

	add_image_size( 'webcasata-card', 600, 400, true );

	$GLOBALS['content_width'] = absint( webcasata_get_option( 'container_width', 1200 ) );

	set_post_thumbnail_size( 1200, 675, true );
}
add_action( 'after_setup_theme', 'webcasata_setup' );

/**
 * Add a boxed or full-width body class based on the Customizer setting.
 *
 * @param array $classes Existing body classes.
 * @return array
 */
function webcasata_container_body_class( $classes ) {
	$type      = webcasata_get_option( 'container_type', 'boxed' );
	$classes[] = 'full' === $type ? 'wc-container-full' : 'wc-container-boxed';
	return $classes;
}
add_filter( 'body_class', 'webcasata_container_body_class' );

/**
 * Add a pingback header when singular.
 */
function webcasata_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'webcasata_pingback_header' );
