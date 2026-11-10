<?php
/**
 * Webcasata Theme functions and definitions.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

define( 'WEBCASATA_VERSION', '1.0.0' );
define( 'WEBCASATA_DIR', trailingslashit( get_template_directory() ) );
define( 'WEBCASATA_URI', trailingslashit( get_template_directory_uri() ) );

require_once WEBCASATA_DIR . 'inc/security.php';
require_once WEBCASATA_DIR . 'inc/features.php';
require_once WEBCASATA_DIR . 'inc/setup.php';
require_once WEBCASATA_DIR . 'inc/widgets.php';
require_once WEBCASATA_DIR . 'inc/template-tags.php';
require_once WEBCASATA_DIR . 'inc/breadcrumbs.php';
require_once WEBCASATA_DIR . 'inc/customizer.php';
require_once WEBCASATA_DIR . 'inc/customizer-import-export.php';
require_once WEBCASATA_DIR . 'inc/enqueue.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once WEBCASATA_DIR . 'inc/woocommerce.php';
}
