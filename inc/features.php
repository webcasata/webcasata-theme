<?php
/**
 * Feature registry. Every optional feature is toggle-gated: a disabled feature
 * never attaches its hooks, so its markup and inline assets are not loaded.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the theme feature registry.
 *
 * @return array
 */
function webcasata_features() {
	$features = array(
		'top_bar'          => array(
			'label'       => __( 'Header Top Bar', 'webcasata' ),
			'description' => __( 'Show a slim top bar above the header.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_boot_top_bar',
		),
		'sticky_header'    => array(
			'label'       => __( 'Sticky Header', 'webcasata' ),
			'description' => __( 'Keep the header visible while scrolling.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_boot_sticky_header',
		),
		'scroll_to_top'    => array(
			'label'       => __( 'Scroll To Top Button', 'webcasata' ),
			'description' => __( 'Show an accessible back-to-top button.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_boot_scroll_to_top',
		),
		'breadcrumbs'      => array(
			'label'       => __( 'Breadcrumbs', 'webcasata' ),
			'description' => __( 'Show breadcrumb navigation on inner pages.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_boot_breadcrumbs',
		),
		'featured_image'   => array(
			'label'       => __( 'Featured Images', 'webcasata' ),
			'description' => __( 'Display featured images on posts and cards.', 'webcasata' ),
			'default'     => true,
			'boot'        => '',
		),
		'blog_excerpt'     => array(
			'label'       => __( 'Post Excerpts', 'webcasata' ),
			'description' => __( 'Use trimmed excerpts with a read more link on archives.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_boot_blog_excerpt',
		),
		'custom_css'       => array(
			'label'       => __( 'Custom CSS', 'webcasata' ),
			'description' => __( 'Print your own CSS in the document head.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_boot_custom_css',
		),
		'custom_js'        => array(
			'label'       => __( 'Custom JavaScript', 'webcasata' ),
			'description' => __( 'Print your own JavaScript before the closing body tag.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_boot_custom_js',
		),
		'login_branding'   => array(
			'label'       => __( 'Login Screen Branding', 'webcasata' ),
			'description' => __( 'Brand the WordPress login screen with your logo and colors.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_boot_login_branding',
		),
		'maintenance_mode' => array(
			'label'       => __( 'Maintenance Mode', 'webcasata' ),
			'description' => __( 'Show a maintenance page to logged out visitors.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_boot_maintenance',
		),
		'block_editor'     => array(
			'label'       => __( 'Block Editor (Gutenberg)', 'webcasata' ),
			'description' => __( 'Edit posts and pages with the block editor. Turn off to use the classic editor.', 'webcasata' ),
			'default'     => true,
			'boot'        => '',
			'boot_off'    => 'webcasata_feature_disable_block_editor',
		),
		'modern_widgets'   => array(
			'label'       => __( 'Block-based Widgets (Modern Layout)', 'webcasata' ),
			'description' => __( 'Use the modern block-based Widgets screen. Leave off to keep the classic (previous) widget layout.', 'webcasata' ),
			'default'     => false,
			'boot'        => 'webcasata_feature_enable_widgets_block_editor',
			'boot_off'    => 'webcasata_feature_disable_widgets_block_editor',
		),
	);

	return apply_filters( 'webcasata_features', $features );
}

/**
 * Check whether a feature toggle is enabled.
 *
 * @param string $key Feature key.
 * @return bool
 */
function webcasata_is_feature_enabled( $key ) {
	$features = webcasata_features();

	if ( ! isset( $features[ $key ] ) ) {
		return false;
	}

	$default = ! empty( $features[ $key ]['default'] );

	return (bool) get_theme_mod( 'webcasata_feature_' . $key, $default );
}

/**
 * Boot features. A feature's `boot` runs when enabled; its optional `boot_off`
 * runs when disabled. This lets a toggle both add and remove core behavior
 * (for example disabling the block editor).
 */
function webcasata_boot_features() {
	foreach ( webcasata_features() as $key => $feature ) {
		$enabled  = webcasata_is_feature_enabled( $key );
		$callback = $enabled ? 'boot' : 'boot_off';

		if ( empty( $feature[ $callback ] ) || ! is_callable( $feature[ $callback ] ) ) {
			continue;
		}

		call_user_func( $feature[ $callback ] );
	}
}
add_action( 'after_setup_theme', 'webcasata_boot_features', 20 );

/**
 * Toggle OFF: fall back to the classic editor, disabling the block editor for
 * posts and pages (core and the Gutenberg plugin filters are both covered).
 */
function webcasata_feature_disable_block_editor() {
	add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
	add_filter( 'use_block_editor_for_post', '__return_false', 100 );
	add_filter( 'gutenberg_can_edit_post_type', '__return_false', 100 );
	add_filter( 'gutenberg_can_edit_post', '__return_false', 100 );
}

/**
 * Toggle ON: use the modern block-based Widgets editor.
 */
function webcasata_feature_enable_widgets_block_editor() {
	add_filter( 'use_widgets_block_editor', '__return_true', 100 );
	add_filter( 'gutenberg_use_widgets_block_editor', '__return_true', 100 );
}

/**
 * Toggle OFF: keep the classic (previous) widget layout.
 */
function webcasata_feature_disable_widgets_block_editor() {
	remove_theme_support( 'widgets-block-editor' );
	add_filter( 'use_widgets_block_editor', '__return_false', 100 );
	add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );
}

/**
 * Boot: header top bar.
 */
function webcasata_feature_boot_top_bar() {
	add_action( 'webcasata_before_header', 'webcasata_render_top_bar' );
}

/**
 * Boot: sticky header body class.
 */
function webcasata_feature_boot_sticky_header() {
	add_filter(
		'body_class',
		static function ( $classes ) {
			$classes[] = 'has-sticky-header';
			return $classes;
		}
	);
}

/**
 * Boot: scroll to top button.
 */
function webcasata_feature_boot_scroll_to_top() {
	add_action( 'webcasata_after_footer', 'webcasata_render_scroll_to_top' );
}

/**
 * Boot: breadcrumbs.
 */
function webcasata_feature_boot_breadcrumbs() {
	add_action( 'webcasata_after_header', 'webcasata_render_breadcrumbs' );
}

/**
 * Boot: blog excerpt filters.
 */
function webcasata_feature_boot_blog_excerpt() {
	add_filter( 'excerpt_length', 'webcasata_excerpt_length', 999 );
	add_filter( 'excerpt_more', 'webcasata_excerpt_more' );
}

/**
 * Excerpt length from the Customizer.
 *
 * @param int $length Default length.
 * @return int
 */
function webcasata_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return absint( webcasata_get_option( 'excerpt_length', 30 ) );
}

/**
 * Excerpt "read more" string.
 *
 * @param string $more Default more string.
 * @return string
 */
function webcasata_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	return '&hellip;';
}

/**
 * Boot: custom CSS output.
 */
function webcasata_feature_boot_custom_css() {
	add_action( 'wp_head', 'webcasata_output_custom_css', 99 );
}

/**
 * Print user CSS only when the feature is enabled.
 */
function webcasata_output_custom_css() {
	$css = webcasata_get_option( 'custom_css', '' );

	$css = webcasata_sanitize_css( $css );

	if ( empty( $css ) ) {
		return;
	}

	echo '<style id="webcasata-custom-css">' . $css . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Boot: custom JS output.
 */
function webcasata_feature_boot_custom_js() {
	add_action( 'wp_footer', 'webcasata_output_custom_js', 99 );
}

/**
 * Print user JS only when the feature is enabled.
 */
function webcasata_output_custom_js() {
	$js = webcasata_get_option( 'custom_js', '' );

	if ( empty( $js ) ) {
		return;
	}

	wp_print_inline_script_tag( $js, array( 'id' => 'webcasata-custom-js' ) );
}

/**
 * Boot: login screen branding.
 */
function webcasata_feature_boot_login_branding() {
	add_action( 'login_enqueue_scripts', 'webcasata_login_assets' );
	add_filter( 'login_headerurl', 'webcasata_login_header_url' );
}

/**
 * Enqueue login screen assets and dynamic styles.
 */
function webcasata_login_assets() {
	$login_css = WEBCASATA_URI . 'assets/css/admin/login.css';
	wp_enqueue_style( 'webcasata-login', $login_css, array(), WEBCASATA_VERSION );

	$primary = sanitize_hex_color( webcasata_get_option( 'color_primary', '#2563eb' ) );
	$logo    = esc_url_raw( webcasata_get_option( 'login_logo', '' ) );

	$css = '';
	if ( $primary ) {
		$css .= '.login .button-primary{background:' . $primary . ';border-color:' . $primary . ';}';
		$css .= 'a{color:' . $primary . ';}';
	}
	if ( $logo ) {
		$css .= '.login h1 a{background-image:url("' . $logo . '");background-size:contain;background-position:center;width:100%;height:80px;}';
	}

	if ( $css ) {
		wp_add_inline_style( 'webcasata-login', $css );
	}
}

/**
 * Point the login logo link to the site home.
 *
 * @return string
 */
function webcasata_login_header_url() {
	return esc_url( home_url( '/' ) );
}

/**
 * Boot: maintenance mode.
 */
function webcasata_feature_boot_maintenance() {
	add_action( 'template_redirect', 'webcasata_maintenance_redirect' );
}

/**
 * Serve the maintenance page to logged out visitors.
 */
function webcasata_maintenance_redirect() {
	if ( is_admin() || is_customize_preview() || wp_doing_ajax() ) {
		return;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}
	if ( isset( $GLOBALS['pagenow'] ) && 'wp-login.php' === $GLOBALS['pagenow'] ) {
		return;
	}
	if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	status_header( 503 );
	header( 'Retry-After: 3600' );
	nocache_headers();

	include WEBCASATA_DIR . 'template-parts/features/maintenance.php';
	exit;
}

/**
 * Render the header top bar part.
 */
function webcasata_render_top_bar() {
	get_template_part( 'template-parts/header/top-bar' );
}

/**
 * Render the scroll to top part.
 */
function webcasata_render_scroll_to_top() {
	get_template_part( 'template-parts/features/scroll-to-top' );
}

/**
 * Render breadcrumbs.
 */
function webcasata_render_breadcrumbs() {
	webcasata_breadcrumbs();
}
