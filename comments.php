<?php
/**
 * Comments template.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$count = get_comments_number();
			printf(
				/* translators: %s: comment count. */
				esc_html( _n( '%s response', '%s responses', $count, 'webcasata' ) ),
				esc_html( number_format_i18n( $count ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar'     => array(
						'width'  => 48,
						'height' => 48,
					),
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation();

		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'webcasata' ); ?></p>
			<?php
		endif;
	endif;

	comment_form();
	?>
</div>
