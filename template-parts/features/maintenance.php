<?php
/**
 * Maintenance page. Served with a 503 status while maintenance mode is on.
 *
 * @package Webcasata
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'webcasata-maintenance' ); ?>>
<?php wp_body_open(); ?>
	<div class="maintenance-wrap">
		<h1 class="maintenance-title"><?php bloginfo( 'name' ); ?></h1>
		<p class="maintenance-message">
			<?php esc_html_e( 'We are performing scheduled maintenance. Please check back soon.', 'webcasata-theme' ); ?>
		</p>
	</div>
	<?php wp_footer(); ?>
</body>
</html>
