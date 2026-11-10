<?php
/**
 * Reusable template helpers.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output the featured image when the feature is enabled.
 *
 * @param string $size Image size.
 */
function webcasata_post_thumbnail( $size = 'webcasata-card' ) {
	if ( ! webcasata_is_feature_enabled( 'featured_image' ) ) {
		return;
	}
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) {
		echo '<figure class="post-thumbnail">';
		the_post_thumbnail( 'post-thumbnail', array( 'class' => 'attachment-post-thumbnail' ) );
		echo '</figure>';
		return;
	}

	printf(
		'<a class="post-thumbnail" href="%1$s" aria-hidden="true" tabindex="-1">%2$s</a>',
		esc_url( get_permalink() ),
		get_the_post_thumbnail( null, $size, array( 'loading' => 'lazy' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * Output the published date.
 */
function webcasata_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);

	printf(
		'<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
		esc_url( get_permalink() ),
		$time_string // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * Output the author link.
 */
function webcasata_posted_by() {
	printf(
		'<span class="byline"><span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
}

/**
 * Output entry meta (date and author).
 */
function webcasata_entry_meta() {
	echo '<div class="entry-meta">';
	webcasata_posted_on();
	webcasata_posted_by();
	echo '</div>';
}

/**
 * Output the entry footer (categories, tags, edit link).
 */
function webcasata_entry_footer() {
	if ( 'post' === get_post_type() ) {
		$categories = get_the_category_list( ', ' );
		$tags        = get_the_tag_list( '', ', ' );

		if ( $categories ) {
			printf( '<span class="cat-links">%s</span>', wp_kses_post( $categories ) );
		}
		if ( $tags ) {
			printf( '<span class="tags-links">%s</span>', wp_kses_post( $tags ) );
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: post title. */
			esc_html__( 'Edit %s', 'webcasata-theme' ),
			'<span class="screen-reader-text">' . wp_kses_post( get_the_title() ) . '</span>'
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Numeric posts pagination.
 */
function webcasata_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => esc_html__( 'Previous', 'webcasata-theme' ),
			'next_text' => esc_html__( 'Next', 'webcasata-theme' ),
			'class'     => 'pagination',
		)
	);
}

/**
 * Get the main container CSS class.
 *
 * @return string
 */
function webcasata_container_class() {
	return 'wc-container';
}

/**
 * Render the site logo or site title.
 */
function webcasata_site_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}
	?>
	<div class="site-branding-text">
		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>
		<?php
		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) :
			?>
			<p class="site-description"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Read more link for excerpts.
 */
function webcasata_read_more_link() {
	if ( ! webcasata_is_feature_enabled( 'blog_excerpt' ) ) {
		return;
	}
	printf(
		'<a class="more-link" href="%1$s">%2$s</a>',
		esc_url( get_permalink() ),
		esc_html__( 'Read more', 'webcasata-theme' )
	);
}
