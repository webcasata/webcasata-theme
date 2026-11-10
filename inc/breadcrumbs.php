<?php
/**
 * Breadcrumb helper. Rendered only when the breadcrumbs feature is enabled.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output accessible breadcrumb navigation.
 */
function webcasata_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	$items = array();

	$items[] = sprintf(
		'<a href="%1$s">%2$s</a>',
		esc_url( home_url( '/' ) ),
		esc_html__( 'Home', 'webcasata-theme' )
	);

	if ( is_singular() ) {
		$post_type = get_post_type_object( get_post_type() );

		if ( $post_type && $post_type->has_archive ) {
			$items[] = sprintf(
				'<a href="%1$s">%2$s</a>',
				esc_url( get_post_type_archive_link( get_post_type() ) ),
				esc_html( $post_type->labels->name )
			);
		}

		if ( is_singular( 'post' ) ) {
			$categories = get_the_category();
			if ( ! empty( $categories ) ) {
				$items[] = sprintf(
					'<a href="%1$s">%2$s</a>',
					esc_url( get_category_link( $categories[0]->term_id ) ),
					esc_html( $categories[0]->name )
				);
			}
		}

		$items[] = '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$items[] = '<span aria-current="page">' . esc_html( single_term_title( '', false ) ) . '</span>';
	} elseif ( is_search() ) {
		$items[] = '<span aria-current="page">' . esc_html__( 'Search results', 'webcasata-theme' ) . '</span>';
	} elseif ( is_404() ) {
		$items[] = '<span aria-current="page">' . esc_html__( 'Not found', 'webcasata-theme' ) . '</span>';
	} elseif ( is_post_type_archive() ) {
		$items[] = '<span aria-current="page">' . esc_html( post_type_archive_title( '', false ) ) . '</span>';
	} elseif ( is_author() ) {
		$items[] = '<span aria-current="page">' . esc_html( get_the_author() ) . '</span>';
	} elseif ( is_archive() ) {
		$items[] = '<span aria-current="page">' . esc_html( get_the_archive_title() ) . '</span>';
	}

	$separator = '<span class="breadcrumb-separator" aria-hidden="true">/</span>';

	echo '<nav class="wc-breadcrumbs wc-container" aria-label="' . esc_attr__( 'Breadcrumb', 'webcasata-theme' ) . '">';
	echo '<ol>';
	$last = count( $items ) - 1;
	foreach ( $items as $index => $item ) {
		// Items are escaped above; the separator is decorative (aria-hidden).
		echo '<li>' . $item . ( $index < $last ? $separator : '' ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</ol>';
	echo '</nav>';
}
