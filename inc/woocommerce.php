<?php
/**
 * WooCommerce integration. This file is required only when WooCommerce is
 * active (see functions.php), so brochure-only sites load none of it.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare WooCommerce support.
 */
function webcasata_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 400,
			'single_image_width'    => 700,
			'product_grid'          => array(
				'default_columns' => absint( webcasata_get_option( 'woo_columns', 3 ) ),
				'min_columns'     => 2,
				'max_columns'     => 4,
			),
		)
	);

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'webcasata_woocommerce_setup' );

/**
 * Shop loop columns from the Customizer.
 *
 * @return int
 */
function webcasata_woo_loop_columns() {
	return absint( webcasata_get_option( 'woo_columns', 3 ) );
}
add_filter( 'loop_shop_columns', 'webcasata_woo_loop_columns' );

/**
 * Products per page from the Customizer.
 *
 * @return int
 */
function webcasata_woo_products_per_page() {
	return absint( webcasata_get_option( 'woo_products_per_page', 12 ) );
}
add_filter( 'loop_shop_per_page', 'webcasata_woo_products_per_page', 20 );

/**
 * Keep WooCommerce wrappers consistent with the theme markup.
 */
function webcasata_woocommerce_wrappers() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

	add_action( 'woocommerce_before_main_content', 'webcasata_woocommerce_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'webcasata_woocommerce_wrapper_end', 10 );
}
add_action( 'after_setup_theme', 'webcasata_woocommerce_wrappers' );

/**
 * Open the WooCommerce content wrapper.
 */
function webcasata_woocommerce_wrapper_start() {
	echo '<main id="primary" class="site-main woocommerce-main">';
}

/**
 * Close the WooCommerce content wrapper.
 */
function webcasata_woocommerce_wrapper_end() {
	echo '</main>';
}

/**
 * Register a WooCommerce Customizer section (only when Woo is active).
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function webcasata_woocommerce_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'webcasata_woocommerce',
		array(
			'title' => __( 'WooCommerce', 'webcasata-theme' ),
			'panel' => 'webcasata_global',
		)
	);

	$wp_customize->add_setting(
		'webcasata_woo_columns',
		array(
			'default'           => 3,
			'transport'         => 'refresh',
			'sanitize_callback' => 'webcasata_sanitize_positive_int',
		)
	);
	$wp_customize->add_control(
		'webcasata_woo_columns',
		array(
			'label'       => __( 'Shop Columns', 'webcasata-theme' ),
			'section'     => 'webcasata_woocommerce',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 2,
				'max'  => 4,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'webcasata_woo_products_per_page',
		array(
			'default'           => 12,
			'transport'         => 'refresh',
			'sanitize_callback' => 'webcasata_sanitize_positive_int',
		)
	);
	$wp_customize->add_control(
		'webcasata_woo_products_per_page',
		array(
			'label'       => __( 'Products Per Page', 'webcasata-theme' ),
			'section'     => 'webcasata_woocommerce',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 4,
				'max'  => 48,
				'step' => 4,
			),
		)
	);
}
add_action( 'customize_register', 'webcasata_woocommerce_customize_register' );
