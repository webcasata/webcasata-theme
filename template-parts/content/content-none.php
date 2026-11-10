<?php
/**
 * "Nothing found" content.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing here', 'webcasata' ); ?></h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php
				printf(
					/* translators: %s: new post URL. */
					wp_kses_post( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'webcasata' ) ),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>
		<?php elseif ( is_search() ) : ?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again.', 'webcasata' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can not find what you are looking for. Perhaps searching will help.', 'webcasata' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
