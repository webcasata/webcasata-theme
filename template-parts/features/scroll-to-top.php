<?php
/**
 * Scroll to top button. Output only when the scroll_to_top feature is enabled.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;
?>
<button type="button" id="webcasata-scroll-top" class="scroll-top" aria-label="<?php esc_attr_e( 'Scroll to top', 'webcasata-theme' ); ?>" hidden>
	<span aria-hidden="true">&uarr;</span>
</button>
