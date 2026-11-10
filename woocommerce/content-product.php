<?php
/**
 * Product card, overridden from WooCommerce.
 *
 * This template can be overridden by copying it to
 * yourtheme/woocommerce/content-product.php.
 *
 * @package Webcasata
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'wc-product-card', $product ); ?>>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="wc-product-card-inner">
		<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
			<?php
			do_action( 'woocommerce_before_shop_loop_item_title' );
			do_action( 'woocommerce_shop_loop_item_title' );
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
		</a>

		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
</li>
