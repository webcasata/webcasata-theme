<?php
/**
 * Main index template.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">

	<?php if ( have_posts() ) : ?>

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="page-header">
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>

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
