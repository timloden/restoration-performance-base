<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

<section class="up-sells upsells products" id="upsells">

    <h3 class="mb-3"><?php esc_html_e( 'You may also like:', 'woocommerce' ); ?></h3>

    <div class="row products row-cols-1 row-cols-md-3 row-cols-lg-4 position-relative">

        <?php foreach ( $upsells as $upsell ) : ?>

        <?php
				$post_object = get_post( $upsell->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object );

				wc_get_template_part( 'content', 'product' );
				?>

        <?php endforeach; ?>

    </div>

</section>

<?php
endif;

wp_reset_postdata();