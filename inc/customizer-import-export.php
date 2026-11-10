<?php
/**
 * Customizer settings import/export (Appearance > Webcasata Import/Export).
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Keys that may be imported or exported.
 *
 * @return array
 */
function webcasata_importable_keys() {
	$keys = array();

	foreach ( array_keys( webcasata_defaults() ) as $key ) {
		$keys[] = 'webcasata_' . $key;
	}
	foreach ( array_keys( webcasata_features() ) as $key ) {
		$keys[] = 'webcasata_feature_' . $key;
	}

	// WooCommerce settings (exported/imported even if WooCommerce is inactive).
	$keys[] = 'webcasata_woo_columns';
	$keys[] = 'webcasata_woo_products_per_page';

	return apply_filters( 'webcasata_importable_keys', $keys );
}

/**
 * Register the admin page.
 */
function webcasata_register_import_export_page() {
	add_theme_page(
		__( 'Webcasata Import/Export', 'webcasata-theme' ),
		__( 'Webcasata Import/Export', 'webcasata-theme' ),
		'edit_theme_options',
		'webcasata-import-export',
		'webcasata_render_import_export_page'
	);
}
add_action( 'admin_menu', 'webcasata_register_import_export_page' );

/**
 * Collect the current theme settings as JSON.
 *
 * @return string
 */
function webcasata_export_settings() {
	$mods = get_theme_mods();
	$out  = array();

	if ( is_array( $mods ) ) {
		$allowed = webcasata_importable_keys();
		foreach ( $allowed as $key ) {
			if ( array_key_exists( $key, $mods ) ) {
				$out[ $key ] = $mods[ $key ];
			}
		}
	}

	return wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
}

/**
 * Handle an import submission.
 */
function webcasata_handle_import() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to import settings.', 'webcasata-theme' ) );
	}

	check_admin_referer( 'webcasata_import', 'webcasata_import_nonce' );

	// Raw JSON is decoded here and every value is sanitized per key below.
	$raw  = isset( $_POST['webcasata_import_data'] ) ? wp_unslash( $_POST['webcasata_import_data'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$data = json_decode( (string) $raw, true );

	$redirect = add_query_arg( 'page', 'webcasata-import-export', admin_url( 'themes.php' ) );

	if ( ! is_array( $data ) ) {
		wp_safe_redirect( add_query_arg( 'webcasata_notice', 'invalid', $redirect ) );
		exit;
	}

	$allowed = webcasata_importable_keys();

	foreach ( $data as $key => $value ) {
		if ( ! in_array( $key, $allowed, true ) ) {
			continue;
		}

		$value = webcasata_sanitize_import_value( $key, $value );
		if ( null === $value ) {
			continue;
		}

		set_theme_mod( $key, $value );
	}

	wp_safe_redirect( add_query_arg( 'webcasata_notice', 'imported', $redirect ) );
	exit;
}
add_action( 'admin_post_webcasata_import', 'webcasata_handle_import' );

/**
 * Render the admin page.
 */
function webcasata_render_import_export_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$notice = isset( $_GET['webcasata_notice'] ) ? sanitize_key( wp_unslash( $_GET['webcasata_notice'] ) ) : '';
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Webcasata Import / Export', 'webcasata-theme' ); ?></h1>

		<?php if ( 'imported' === $notice ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Settings imported.', 'webcasata-theme' ); ?></p></div>
		<?php elseif ( 'invalid' === $notice ) : ?>
			<div class="notice notice-error is-dismissible"><p><?php esc_html_e( 'The provided JSON was invalid.', 'webcasata-theme' ); ?></p></div>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Export', 'webcasata-theme' ); ?></h2>
		<p><?php esc_html_e( 'Copy these settings and keep them safe, or paste them into another install.', 'webcasata-theme' ); ?></p>
		<textarea readonly class="large-text code" rows="12" onclick="this.select();"><?php echo esc_textarea( webcasata_export_settings() ); ?></textarea>

		<h2><?php esc_html_e( 'Import', 'webcasata-theme' ); ?></h2>
		<p><?php esc_html_e( 'Paste exported settings below and save.', 'webcasata-theme' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="webcasata_import">
			<?php wp_nonce_field( 'webcasata_import', 'webcasata_import_nonce' ); ?>
			<textarea name="webcasata_import_data" class="large-text code" rows="12"></textarea>
			<p>
				<button type="submit" class="button button-primary"><?php esc_html_e( 'Import Settings', 'webcasata-theme' ); ?></button>
			</p>
		</form>
	</div>
	<?php
}
