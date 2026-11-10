<?php
/**
 * Footer widget columns.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

$webcasata_columns = absint( webcasata_get_option( 'footer_columns', 3 ) );
if ( $webcasata_columns < 1 || $webcasata_columns > 4 ) {
	$webcasata_columns = 3;
}
?>
<div class="footer-widgets">
	<div class="wc-container footer-widgets-inner columns-<?php echo esc_attr( $webcasata_columns ); ?>">
		<?php dynamic_sidebar( 'webcasata-footer-widgets' ); ?>
	</div>
</div>
