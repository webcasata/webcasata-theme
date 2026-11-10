<?php
/**
 * Footer credits and footer menu.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

$webcasata_footer_text = webcasata_get_option( 'footer_text', '' );
?>
<div class="site-info">
	<div class="wc-container site-info-inner">
		<div class="footer-copyright">
			<?php
			if ( $webcasata_footer_text ) {
				echo wp_kses_post( $webcasata_footer_text );
			} else {
				printf(
					'&copy; %1$s %2$s',
					esc_html( date_i18n( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
			}
			?>
		</div>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer menu', 'webcasata-theme' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
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
