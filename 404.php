<?php
/**
 * 404 template.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="site-main">

	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can not be found.', 'webcasata-theme' ); ?></h1>
		</header>

		<div class="page-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Try a search.', 'webcasata-theme' ); ?></p>

			<?php get_search_form(); ?>

			<?php
			wp_list_pages(
				array(
					'title_li' => esc_html__( 'Pages:', 'webcasata-theme' ),
					'depth'    => 1,
				)
			);
			?>
		</div>
	</section>

</main>
<?php
get_footer();
