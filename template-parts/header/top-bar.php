<?php
/**
 * Header top bar. Output only when the top_bar feature is enabled.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="top-bar">
	<div class="wc-container top-bar-inner">
		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<nav class="top-bar-navigation" aria-label="<?php esc_attr_e( 'Top bar menu', 'webcasata-theme' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'top',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>
		<?php endif; ?>
	</div>
</div>
