<?php
/**
 * Footer template.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;
?>
	</div><!-- #content -->

	<?php do_action( 'webcasata_before_footer' ); ?>

	<footer id="colophon" class="site-footer">
		<?php if ( webcasata_has_widgets( 'footer-widgets' ) ) : ?>
			<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/footer/site-info' ); ?>
	</footer>

	<?php do_action( 'webcasata_after_footer' ); ?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
