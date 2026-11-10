<?php
/**
 * Customizer: global settings, output as CSS custom properties.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default values for all global settings (single source of truth).
 *
 * @return array
 */
function webcasata_defaults() {
	return array(
		'container_type'    => 'boxed',
		'container_width'   => 1200,
		'color_primary'     => '#2563eb',
		'color_secondary'   => '#1e293b',
		'color_tertiary'    => '#f59e0b',
		'color_text'        => '#334155',
		'color_link'        => '#2563eb',
		'color_bg'          => '#ffffff',
		'color_header_bg'   => '#ffffff',
		'color_footer_bg'   => '#0f172a',
		'color_footer_text' => '#cbd5e1',
		'font_body'         => 'system',
		'font_heading'      => 'system',
		'font_size_base'    => 16,
		'line_height'       => 1.6,
		'heading_weight'    => '600',
		'header_layout'     => 'logo-left',
		'btn_radius'        => 4,
		'btn_padding_x'     => 20,
		'btn_padding_y'     => 10,
		'footer_text'       => '',
		'footer_columns'    => 3,
		'excerpt_length'    => 30,
		'custom_css'        => '',
		'custom_js'         => '',
		'login_logo'        => '',
	);
}

/**
 * Get a default value.
 *
 * @param string $key Default key.
 * @return mixed
 */
function webcasata_default( $key ) {
	$defaults = webcasata_defaults();
	return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
}

/**
 * Available font choices.
 *
 * @return array
 */
function webcasata_font_choices() {
	return array(
		'system'          => array(
			'label'  => __( 'System Default', 'webcasata-theme' ),
			'stack'  => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
			'google' => '',
		),
		'inter'           => array(
			'label'  => 'Inter',
			'stack'  => '"Inter", sans-serif',
			'google' => 'Inter:wght@400;500;600;700',
		),
		'poppins'         => array(
			'label'  => 'Poppins',
			'stack'  => '"Poppins", sans-serif',
			'google' => 'Poppins:wght@400;500;600;700',
		),
		'roboto'          => array(
			'label'  => 'Roboto',
			'stack'  => '"Roboto", sans-serif',
			'google' => 'Roboto:wght@400;500;700',
		),
		'open-sans'       => array(
			'label'  => 'Open Sans',
			'stack'  => '"Open Sans", sans-serif',
			'google' => 'Open+Sans:wght@400;600;700',
		),
		'lato'            => array(
			'label'  => 'Lato',
			'stack'  => '"Lato", sans-serif',
			'google' => 'Lato:wght@400;700',
		),
		'nunito'          => array(
			'label'  => 'Nunito',
			'stack'  => '"Nunito", sans-serif',
			'google' => 'Nunito:wght@400;600;700',
		),
		'montserrat'      => array(
			'label'  => 'Montserrat',
			'stack'  => '"Montserrat", sans-serif',
			'google' => 'Montserrat:wght@400;600;700',
		),
		'merriweather'    => array(
			'label'  => 'Merriweather',
			'stack'  => '"Merriweather", Georgia, serif',
			'google' => 'Merriweather:wght@400;700',
		),
		'lora'            => array(
			'label'  => 'Lora',
			'stack'  => '"Lora", Georgia, serif',
			'google' => 'Lora:wght@400;600;700',
		),
		'playfair'        => array(
			'label'  => 'Playfair Display',
			'stack'  => '"Playfair Display", Georgia, serif',
			'google' => 'Playfair+Display:wght@400;600;700',
		),
	);
}

/**
 * Return a font stack by key.
 *
 * @param string $key Font key.
 * @return string
 */
function webcasata_font_stack( $key ) {
	$choices = webcasata_font_choices();
	return isset( $choices[ $key ] ) ? $choices[ $key ]['stack'] : $choices['system']['stack'];
}

/**
 * Build the CSS custom properties string.
 *
 * @return string
 */
function webcasata_customizer_css() {
	$d = webcasata_defaults();

	$color = static function ( $key ) use ( $d ) {
		$value = webcasata_get_option( $key, $d[ $key ] );
		$valid = sanitize_hex_color( $value );
		return $valid ? $valid : $d[ $key ];
	};

	$vars = array(
		'--wc-container-width'   => absint( webcasata_get_option( 'container_width', $d['container_width'] ) ) . 'px',
		'--wc-color-primary'     => $color( 'color_primary' ),
		'--wc-color-secondary'   => $color( 'color_secondary' ),
		'--wc-color-tertiary'    => $color( 'color_tertiary' ),
		'--wc-color-text'        => $color( 'color_text' ),
		'--wc-color-link'        => $color( 'color_link' ),
		'--wc-color-bg'          => $color( 'color_bg' ),
		'--wc-color-header-bg'   => $color( 'color_header_bg' ),
		'--wc-color-footer-bg'   => $color( 'color_footer_bg' ),
		'--wc-color-footer-text' => $color( 'color_footer_text' ),
		'--wc-font-body'         => webcasata_font_stack( webcasata_get_option( 'font_body', $d['font_body'] ) ),
		'--wc-font-heading'      => webcasata_font_stack( webcasata_get_option( 'font_heading', $d['font_heading'] ) ),
		'--wc-font-size-base'    => absint( webcasata_get_option( 'font_size_base', $d['font_size_base'] ) ) . 'px',
		'--wc-line-height'       => (float) webcasata_get_option( 'line_height', $d['line_height'] ),
		'--wc-heading-weight'    => sanitize_key( webcasata_get_option( 'heading_weight', $d['heading_weight'] ) ),
		'--wc-btn-radius'        => absint( webcasata_get_option( 'btn_radius', $d['btn_radius'] ) ) . 'px',
		'--wc-btn-padding-x'     => absint( webcasata_get_option( 'btn_padding_x', $d['btn_padding_x'] ) ) . 'px',
		'--wc-btn-padding-y'     => absint( webcasata_get_option( 'btn_padding_y', $d['btn_padding_y'] ) ) . 'px',
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$vars['--wc-shop-columns'] = absint( webcasata_get_option( 'woo_columns', 3 ) );
	}

	$css = ':root{';
	foreach ( $vars as $name => $value ) {
		$css .= $name . ':' . $value . ';';
	}
	$css .= '}';

	return apply_filters( 'webcasata_customizer_css', $css );
}

/**
 * Print the CSS variables in the document head.
 */
function webcasata_print_customizer_css() {
	echo '<style id="webcasata-vars">' . webcasata_customizer_css() . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'webcasata_print_customizer_css', 20 );

/**
 * Body class for the header layout.
 *
 * @param array $classes Body classes.
 * @return array
 */
function webcasata_header_layout_body_class( $classes ) {
	$layout    = webcasata_get_option( 'header_layout', 'logo-left' );
	$classes[] = 'header-' . sanitize_html_class( $layout );
	return $classes;
}
add_filter( 'body_class', 'webcasata_header_layout_body_class' );

/**
 * Register Customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function webcasata_customize_register( $wp_customize ) {
	$d = webcasata_defaults();

	$wp_customize->add_panel(
		'webcasata_global',
		array(
			'title'       => __( 'Webcasata Global Settings', 'webcasata-theme' ),
			'description' => __( 'Global layout, colors, typography and feature options.', 'webcasata-theme' ),
			'priority'    => 10,
		)
	);

	/*
	 * Helper: register a setting plus its control. A sanitize callback is
	 * mandatory; settings without one are not registered at all.
	 */
	$add = static function ( $id, $args ) use ( $wp_customize ) {
		if ( empty( $args['setting']['sanitize_callback'] ) ) {
			_doing_it_wrong( __FUNCTION__, esc_html( $id . ': a sanitize_callback is required.' ), '1.0.1' );
			return;
		}

		$wp_customize->add_setting(
			$id,
			array(
				'default'           => isset( $args['setting']['default'] ) ? $args['setting']['default'] : '',
				'transport'         => isset( $args['setting']['transport'] ) ? $args['setting']['transport'] : 'refresh',
				'sanitize_callback' => $args['setting']['sanitize_callback'],
			)
		);

		$args['control']['settings'] = $id;
		$wp_customize->add_control( $id, $args['control'] );
	};

	/* Layout -------------------------------------------------------------- */
	$wp_customize->add_section(
		'webcasata_layout',
		array(
			'title' => __( 'Layout', 'webcasata-theme' ),
			'panel' => 'webcasata_global',
		)
	);

	$add(
		'webcasata_container_type',
		array(
			'setting' => array(
				'default'           => $d['container_type'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'webcasata_sanitize_select',
			),
			'control' => array(
				'label'   => __( 'Container Type', 'webcasata-theme' ),
				'section' => 'webcasata_layout',
				'type'    => 'select',
				'choices' => array(
					'boxed' => __( 'Boxed', 'webcasata-theme' ),
					'full'  => __( 'Full Width', 'webcasata-theme' ),
				),
			),
		)
	);

	$add(
		'webcasata_container_width',
		array(
			'setting' => array(
				'default'           => $d['container_width'],
				'transport'         => 'postMessage',
				'sanitize_callback' => 'webcasata_sanitize_positive_int',
			),
			'control' => array(
				'label'       => __( 'Container Width (px)', 'webcasata-theme' ),
				'section'     => 'webcasata_layout',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => 960,
					'max'  => 1920,
					'step' => 10,
				),
			),
		)
	);

	/* Colors -------------------------------------------------------------- */
	$wp_customize->add_section(
		'webcasata_colors',
		array(
			'title' => __( 'Colors', 'webcasata-theme' ),
			'panel' => 'webcasata_global',
		)
	);

	$colors = array(
		'color_primary'     => __( 'Primary Color', 'webcasata-theme' ),
		'color_secondary'   => __( 'Secondary Color', 'webcasata-theme' ),
		'color_tertiary'    => __( 'Tertiary Color', 'webcasata-theme' ),
		'color_text'        => __( 'Body Text', 'webcasata-theme' ),
		'color_link'        => __( 'Link Color', 'webcasata-theme' ),
		'color_bg'          => __( 'Site Background', 'webcasata-theme' ),
		'color_header_bg'   => __( 'Header Background', 'webcasata-theme' ),
		'color_footer_bg'   => __( 'Footer Background', 'webcasata-theme' ),
		'color_footer_text' => __( 'Footer Text', 'webcasata-theme' ),
	);

	foreach ( $colors as $key => $label ) {
		$wp_customize->add_setting(
			'webcasata_' . $key,
			array(
				'default'           => $d[ $key ],
				'transport'         => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'webcasata_' . $key,
				array(
					'label'   => $label,
					'section' => 'webcasata_colors',
				)
			)
		);
	}

	/* Typography ---------------------------------------------------------- */
	$wp_customize->add_section(
		'webcasata_typography',
		array(
			'title' => __( 'Typography', 'webcasata-theme' ),
			'panel' => 'webcasata_global',
		)
	);

	$font_labels = array();
	foreach ( webcasata_font_choices() as $key => $font ) {
		$font_labels[ $key ] = $font['label'];
	}

	foreach ( array(
		'font_body'    => __( 'Body Font Family', 'webcasata-theme' ),
		'font_heading' => __( 'Heading Font Family', 'webcasata-theme' ),
	) as $key => $label ) {
		$add(
			'webcasata_' . $key,
			array(
				'setting' => array(
					'default'           => $d[ $key ],
					'transport'         => 'refresh',
					'sanitize_callback' => 'webcasata_sanitize_select',
				),
				'control' => array(
					'label'   => $label,
					'section' => 'webcasata_typography',
					'type'    => 'select',
					'choices' => $font_labels,
				),
			)
		);
	}

	$add(
		'webcasata_font_size_base',
		array(
			'setting' => array(
				'default'           => $d['font_size_base'],
				'transport'         => 'postMessage',
				'sanitize_callback' => 'webcasata_sanitize_positive_int',
			),
			'control' => array(
				'label'       => __( 'Base Font Size (px)', 'webcasata-theme' ),
				'section'     => 'webcasata_typography',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => 12,
					'max'  => 24,
					'step' => 1,
				),
			),
		)
	);

	$add(
		'webcasata_line_height',
		array(
			'setting' => array(
				'default'           => $d['line_height'],
				'transport'         => 'postMessage',
				'sanitize_callback' => 'webcasata_sanitize_float',
			),
			'control' => array(
				'label'       => __( 'Line Height', 'webcasata-theme' ),
				'section'     => 'webcasata_typography',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 2.5,
					'step' => 0.1,
				),
			),
		)
	);

	$add(
		'webcasata_heading_weight',
		array(
			'setting' => array(
				'default'           => $d['heading_weight'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'webcasata_sanitize_select',
			),
			'control' => array(
				'label'   => __( 'Heading Weight', 'webcasata-theme' ),
				'section' => 'webcasata_typography',
				'type'    => 'select',
				'choices' => array(
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
				),
			),
		)
	);

	/* Header -------------------------------------------------------------- */
	$wp_customize->add_section(
		'webcasata_header',
		array(
			'title' => __( 'Header', 'webcasata-theme' ),
			'panel' => 'webcasata_global',
		)
	);

	$add(
		'webcasata_header_layout',
		array(
			'setting' => array(
				'default'           => $d['header_layout'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'webcasata_sanitize_select',
			),
			'control' => array(
				'label'   => __( 'Header Layout', 'webcasata-theme' ),
				'section' => 'webcasata_header',
				'type'    => 'select',
				'choices' => array(
					'logo-left'   => __( 'Logo Left', 'webcasata-theme' ),
					'logo-center' => __( 'Logo Center', 'webcasata-theme' ),
				),
			),
		)
	);

	/* Buttons ------------------------------------------------------------- */
	$wp_customize->add_section(
		'webcasata_buttons',
		array(
			'title' => __( 'Buttons', 'webcasata-theme' ),
			'panel' => 'webcasata_global',
		)
	);

	$buttons = array(
		// Radius may be 0 (square buttons), so it uses absint instead of positive int.
		'btn_radius'    => array( __( 'Button Radius (px)', 'webcasata-theme' ), 0, 50, 1, 'absint' ),
		'btn_padding_x' => array( __( 'Horizontal Padding (px)', 'webcasata-theme' ), 4, 60, 1, 'webcasata_sanitize_positive_int' ),
		'btn_padding_y' => array( __( 'Vertical Padding (px)', 'webcasata-theme' ), 2, 40, 1, 'webcasata_sanitize_positive_int' ),
	);
	foreach ( $buttons as $key => $meta ) {
		$add(
			'webcasata_' . $key,
			array(
				'setting' => array(
					'default'           => $d[ $key ],
					'transport'         => 'postMessage',
					'sanitize_callback' => $meta[4],
				),
				'control' => array(
					'label'       => $meta[0],
					'section'     => 'webcasata_buttons',
					'type'        => 'number',
					'input_attrs' => array(
						'min'  => $meta[1],
						'max'  => $meta[2],
						'step' => $meta[3],
					),
				),
			)
		);
	}

	/* Footer -------------------------------------------------------------- */
	$wp_customize->add_section(
		'webcasata_footer',
		array(
			'title' => __( 'Footer', 'webcasata-theme' ),
			'panel' => 'webcasata_global',
		)
	);

	$add(
		'webcasata_footer_columns',
		array(
			'setting' => array(
				'default'           => $d['footer_columns'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'webcasata_sanitize_positive_int',
			),
			'control' => array(
				'label'       => __( 'Footer Widget Columns', 'webcasata-theme' ),
				'section'     => 'webcasata_footer',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 4,
					'step' => 1,
				),
			),
		)
	);

	$add(
		'webcasata_footer_text',
		array(
			'setting' => array(
				'default'           => $d['footer_text'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'wp_kses_post',
			),
			'control' => array(
				'label'   => __( 'Copyright Text', 'webcasata-theme' ),
				'section' => 'webcasata_footer',
				'type'    => 'textarea',
			),
		)
	);

	/* Features ------------------------------------------------------------ */
	$wp_customize->add_section(
		'webcasata_features',
		array(
			'title'       => __( 'Features', 'webcasata-theme' ),
			'description' => __( 'Enable only what you need. Disabled features load no code.', 'webcasata-theme' ),
			'panel'       => 'webcasata_global',
		)
	);

	foreach ( webcasata_features() as $key => $feature ) {
		$wp_customize->add_setting(
			'webcasata_feature_' . $key,
			array(
				'default'           => ! empty( $feature['default'] ),
				'transport'         => 'refresh',
				'sanitize_callback' => 'webcasata_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			'webcasata_feature_' . $key,
			array(
				'label'       => $feature['label'],
				'description' => isset( $feature['description'] ) ? $feature['description'] : '',
				'section'     => 'webcasata_features',
				'type'        => 'checkbox',
			)
		);
	}

	$add(
		'webcasata_excerpt_length',
		array(
			'setting' => array(
				'default'           => $d['excerpt_length'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'webcasata_sanitize_positive_int',
			),
			'control' => array(
				'label'           => __( 'Excerpt Length (words)', 'webcasata-theme' ),
				'section'         => 'webcasata_features',
				'type'            => 'number',
				'active_callback' => static function () {
					return webcasata_is_feature_enabled( 'blog_excerpt' );
				},
				'input_attrs'     => array(
					'min'  => 5,
					'max'  => 100,
					'step' => 5,
				),
			),
		)
	);

	$add(
		'webcasata_custom_css',
		array(
			'setting' => array(
				'default'           => $d['custom_css'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'webcasata_sanitize_css',
			),
			'control' => array(
				'label'           => __( 'Custom CSS', 'webcasata-theme' ),
				'section'         => 'webcasata_features',
				'type'            => 'textarea',
				'active_callback' => static function () {
					return webcasata_is_feature_enabled( 'custom_css' );
				},
				'input_attrs'     => array( 'rows' => 8 ),
			),
		)
	);

	$add(
		'webcasata_custom_js',
		array(
			'setting' => array(
				'default'           => $d['custom_js'],
				'transport'         => 'refresh',
				'sanitize_callback' => 'webcasata_sanitize_js',
			),
			'control' => array(
				'label'           => __( 'Custom JavaScript', 'webcasata-theme' ),
				'section'         => 'webcasata_features',
				'type'            => 'textarea',
				'active_callback' => static function () {
					return webcasata_is_feature_enabled( 'custom_js' );
				},
				'input_attrs'     => array( 'rows' => 8 ),
			),
		)
	);

	/* Login branding ------------------------------------------------------ */
	$wp_customize->add_section(
		'webcasata_login',
		array(
			'title'           => __( 'Login Screen', 'webcasata-theme' ),
			'panel'           => 'webcasata_global',
			'active_callback' => static function () {
				return webcasata_is_feature_enabled( 'login_branding' );
			},
		)
	);

	$wp_customize->add_setting(
		'webcasata_login_logo',
		array(
			'default'           => $d['login_logo'],
			'transport'         => 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'webcasata_login_logo',
			array(
				'label'   => __( 'Login Logo', 'webcasata-theme' ),
				'section' => 'webcasata_login',
			)
		)
	);
}
add_action( 'customize_register', 'webcasata_customize_register' );

/**
 * Live preview script for postMessage settings.
 */
function webcasata_customize_preview_js() {
	wp_enqueue_script(
		'webcasata-customizer',
		WEBCASATA_URI . 'assets/js/customizer.js',
		array( 'customize-preview' ),
		WEBCASATA_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'webcasata_customize_preview_js' );

/**
 * Give the block editor the same CSS custom properties as the front end, so
 * Customizer colors, fonts and sizes are reflected while editing.
 *
 * @param array $settings Block editor settings.
 * @return array
 */
function webcasata_block_editor_vars( $settings ) {
	if ( ! isset( $settings['styles'] ) || ! is_array( $settings['styles'] ) ) {
		$settings['styles'] = array();
	}

	$settings['styles'][] = array( 'css' => webcasata_customizer_css() );

	return $settings;
}
add_filter( 'block_editor_settings_all', 'webcasata_block_editor_vars' );
