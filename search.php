<?php
/**
 * Search results template.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title">
				<?php
				printf(
					/* translators: %s: search query. */
					esc_html__( 'Search results for: %s', 'webcasata' ),
					'<span>' . esc_html( get_search_query() ) . '</span>'
				);
				?>
			</h1>
		</header>

		<div class="posts-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/card/post-card' );
			endwhile;
			?>
		</div>

		<?php webcasata_pagination(); ?>

	<?php else : ?>
		<?php get_template_part( 'template-parts/content/content-none' ); ?>
	<?php endif; ?>

</main>
<?php
get_footer();
