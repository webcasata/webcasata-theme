<?php
/**
 * Header template.
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

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'webcasata' ); ?></a>

	<?php do_action( 'webcasata_before_header' ); ?>

	<header id="masthead" class="site-header">
		<div class="wc-container site-header-inner">
			<?php get_template_part( 'template-parts/header/site-branding' ); ?>

			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'webcasata' ); ?>">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="menu-toggle-box" aria-hidden="true"></span>
						<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'webcasata' ); ?></span>
					</button>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
			<?php endif; ?>
		</div>

		<?php if ( webcasata_has_widgets( 'header-widgets' ) ) : ?>
			<div class="header-widgets wc-container">
				<?php dynamic_sidebar( 'webcasata-header-widgets' ); ?>
			</div>
		<?php endif; ?>
	</header>

	<?php do_action( 'webcasata_after_header' ); ?>

	<div id="content" class="site-content wc-container">
		<?php if ( webcasata_has_widgets( 'content-widgets' ) ) : ?>
			<div class="content-widgets">
				<?php dynamic_sidebar( 'webcasata-content-widgets' ); ?>
			</div>
		<?php endif; ?>
