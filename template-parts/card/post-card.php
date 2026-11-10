<?php
/**
 * Post card used in archives, search and blog listings.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card entry' ); ?>>
	<?php webcasata_post_thumbnail(); ?>

	<div class="post-card-body">
		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<?php webcasata_entry_meta(); ?>
		</header>

		<div class="entry-summary">
			<?php
			if ( webcasata_is_feature_enabled( 'blog_excerpt' ) ) {
				the_excerpt();
				webcasata_read_more_link();
			} else {
				the_content(
					sprintf(
						/* translators: %s: post title. */
						esc_html__( 'Continue reading %s', 'webcasata-theme' ),
						'<span class="screen-reader-text">' . wp_kses_post( get_the_title() ) . '</span>'
					)
				);
			}
			?>
		</div>
	</div>
</article>
