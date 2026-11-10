<?php
/**
 * Widget areas. Exactly three by default: Header, Footer and Content.
 *
 * To remove an area before going live, unset it from the array via the
 * `webcasata_widget_areas` filter, for example:
 *
 *     add_filter( 'webcasata_widget_areas', function ( $areas ) {
 *         unset( $areas['content-widgets'] );
 *         return $areas;
 *     } );
 *
 * To add another area, add a new entry to `webcasata_widget_areas()`.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Define the widget areas to register.
 *
 * @return array
 */
function webcasata_widget_areas() {
	$areas = array(
		'header-widgets'  => array(
			'name'        => __( 'Header Widgets', 'webcasata' ),
			'description' => __( 'Optional widgets shown inside the header.', 'webcasata' ),
		),
		'footer-widgets'  => array(
			'name'        => __( 'Footer Widgets', 'webcasata' ),
			'description' => __( 'Widget columns shown above the footer credits.', 'webcasata' ),
		),
		'content-widgets' => array(
			'name'        => __( 'Content Widgets', 'webcasata' ),
			'description' => __( 'Widgets shown above the content area.', 'webcasata' ),
		),
	);

	return apply_filters( 'webcasata_widget_areas', $areas );
}

/**
 * Register a single widget area with sensible defaults.
 *
 * @param string $id   Area id without prefix.
 * @param string $name Area name.
 * @param array  $args Optional overrides.
 */
function webcasata_register_widget_area( $id, $name, $args = array() ) {
	$defaults = array(
		'id'            => 'webcasata-' . sanitize_key( $id ),
		'name'          => $name,
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar( wp_parse_args( $args, $defaults ) );
}

/**
 * Register all widget areas.
 */
function webcasata_register_widget_areas() {
	foreach ( webcasata_widget_areas() as $id => $area ) {
		$args = isset( $area['args'] ) ? $area['args'] : array();
		webcasata_register_widget_area( $id, $area['name'], $args );
	}
}
add_action( 'widgets_init', 'webcasata_register_widget_areas' );

/**
 * Check whether a theme widget area has widgets.
 *
 * @param string $id Area id without prefix.
 * @return bool
 */
function webcasata_has_widgets( $id ) {
	return is_active_sidebar( 'webcasata-' . sanitize_key( $id ) );
}
