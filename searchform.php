<?php
/**
 * Search form.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

$webcasata_search_id = wp_unique_id( 'search-form-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $webcasata_search_id ); ?>" class="screen-reader-text">
		<?php esc_html_e( 'Search for:', 'webcasata-theme' ); ?>
	</label>
	<input
		type="search"
		id="<?php echo esc_attr( $webcasata_search_id ); ?>"
		class="search-field"
		placeholder="<?php esc_attr_e( 'Search &hellip;', 'webcasata-theme' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s"
	>
	<button type="submit" class="search-submit">
		<?php esc_html_e( 'Search', 'webcasata-theme' ); ?>
	</button>
</form>
