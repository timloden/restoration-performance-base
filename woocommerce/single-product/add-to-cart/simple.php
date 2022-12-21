<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
$upsells = $product->get_upsells();

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form
    action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
    method="post" enctype='multipart/form-data' class="border-top mt-3 mt-md-0 pt-3 pt-lg-3 pb-4">

    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <div class="row g-3 align-items-center justify-content-center justify-content-md-start">

        <div class="col-auto" style="font-size: 18px;">
            <?php
        do_action( 'woocommerce_before_add_to_cart_quantity' );

        woocommerce_quantity_input(
            array(
                'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
            )
        );

        do_action( 'woocommerce_after_add_to_cart_quantity' );
        ?>
        </div>
        <div class="col-auto">
            <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"
                class="single_add_to_cart_button btn btn-primary px-5 fw-bold" style="font-size: 18px;"><i
                    class="las la-shopping-cart"></i>
                <?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
        </div>
        <div class="col-auto">
            <?php echo do_shortcode('[ti_wishlists_addtowishlist]'); ?>
        </div>
    </div>
    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php  
    if ( $upsells ) {
            echo '<p class="text-center text-md-start mb-4"><a class="text-primary fw-bold" href="#upsells"><i class="las la-exclamation-circle"></i> Check out our related items that might be helpful!</a></p>';
    }
    ?>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>