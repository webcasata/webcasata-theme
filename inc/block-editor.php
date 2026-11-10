<?php
/**
 * Block styles and block patterns.
 *
 * The CSS for every block style lives in assets/css/components/_block-styles.scss
 * and is compiled into theme.css, which is also loaded as the editor style.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register custom block styles.
 */
function webcasata_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	$styles = array(
		'core/group'     => array(
			'name'  => 'webcasata-card',
			'label' => __( 'Card', 'webcasata-theme' ),
		),
		'core/image'     => array(
			'name'  => 'webcasata-shadow',
			'label' => __( 'Rounded with shadow', 'webcasata-theme' ),
		),
		'core/list'      => array(
			'name'  => 'webcasata-checklist',
			'label' => __( 'Checklist', 'webcasata-theme' ),
		),
		'core/quote'     => array(
			'name'  => 'webcasata-accent',
			'label' => __( 'Accent border', 'webcasata-theme' ),
		),
		'core/separator' => array(
			'name'  => 'webcasata-short',
			'label' => __( 'Short accent', 'webcasata-theme' ),
		),
	);

	foreach ( $styles as $block => $style ) {
		register_block_style( $block, $style );
	}
}
add_action( 'init', 'webcasata_register_block_styles' );

/**
 * Register the theme pattern category and block patterns.
 */
function webcasata_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'webcasata-theme',
			array( 'label' => __( 'Webcasata', 'webcasata-theme' ) )
		);
	}

	register_block_pattern(
		'webcasata-theme/call-to-action',
		array(
			'title'       => __( 'Call to action', 'webcasata-theme' ),
			'description' => __( 'A centered heading, short text and a button on a tinted background.', 'webcasata-theme' ),
			'categories'  => array( 'webcasata-theme', 'call-to-action' ),
			'content'     => '<!-- wp:group {"align":"full","backgroundColor":"secondary","textColor":"background","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}}} -->
<div class="wp-block-group alignfull has-background-color has-secondary-background-color has-text-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Ready to get started?', 'webcasata-theme' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">' . esc_html__( 'Tell visitors what you offer in one or two short sentences, then point them to the next step.', 'webcasata-theme' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"tertiary","textColor":"secondary"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-secondary-color has-tertiary-background-color has-text-color has-background wp-element-button">' . esc_html__( 'Contact us', 'webcasata-theme' ) . '</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
		)
	);

	$column = static function ( $title, $text ) {
		return '<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-webcasata-card","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-webcasata-card"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">' . esc_html( $title ) . '</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html( $text ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->';
	};

	register_block_pattern(
		'webcasata-theme/three-features',
		array(
			'title'       => __( 'Three feature cards', 'webcasata-theme' ),
			'description' => __( 'Three columns of short feature descriptions in card style.', 'webcasata-theme' ),
			'categories'  => array( 'webcasata-theme', 'columns' ),
			'content'     => '<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Why choose us', 'webcasata-theme' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">' .
				$column( __( 'Fast', 'webcasata-theme' ), __( 'A lightweight theme with no bundled frameworks keeps pages quick to load.', 'webcasata-theme' ) ) . "\n\n" .
				$column( __( 'Flexible', 'webcasata-theme' ), __( 'Set colors, fonts, buttons and layout globally from the Customizer.', 'webcasata-theme' ) ) . "\n\n" .
				$column( __( 'Secure', 'webcasata-theme' ), __( 'Every setting is sanitized and every output is escaped.', 'webcasata-theme' ) ) .
				'</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'webcasata_register_block_patterns' );
