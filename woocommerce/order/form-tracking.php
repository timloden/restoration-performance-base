<?php
/**
 * Order tracking form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/form-tracking.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.5.0
 */

defined( 'ABSPATH' ) || exit;

global $post;
?>

<div class="row justify-content-center">
    <div class="col-12 col-lg-6">

        <p class="pt-3">
            <?php esc_html_e( 'To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.', 'woocommerce' ); ?>
        </p>

        <form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post"
            class="woocommerce-form woocommerce-form-track-order track_order border rounded p-3">
            <?php 
            /**
             * Hook: woocommerce_order_tracking_form_start.
             * @since 6.5.0
             */
            do_action( 'woocommerce_order_tracking_form_start' ); 
            ?>

            <label class="form-label" for="orderid"><?php esc_html_e( 'Order ID', 'woocommerce' ); ?></label>
            <input class="form-control mb-2" type="text" name="orderid" id="orderid"
                value="<?php echo isset( $_REQUEST['orderid'] ) ? esc_attr( wp_unslash( $_REQUEST['orderid'] ) ) : ''; ?>"
                placeholder="<?php esc_attr_e( 'Found in your order confirmation email.', 'woocommerce' ); ?>" />
            <label class="form-label" for="order_email"><?php esc_html_e( 'Billing email', 'woocommerce' ); ?></label>
            <input class="form-control mb-3" type="text" name="order_email" id="order_email"
                value="<?php echo isset( $_REQUEST['order_email'] ) ? esc_attr( wp_unslash( $_REQUEST['order_email'] ) ) : ''; ?>"
                placeholder="<?php esc_attr_e( 'Email you used during checkout.', 'woocommerce' ); ?>" />

            <?php 
            /**
             * Hook: woocommerce_order_tracking_form.
             * @since 6.5.0
             */
            do_action( 'woocommerce_order_tracking_form' ); 
            ?>
            <button type="submit" class="btn btn-primary w-100" name="track"
                value="<?php esc_attr_e( 'Track', 'woocommerce' ); ?>"><?php esc_html_e( 'Track', 'woocommerce' ); ?></button>
            <?php wp_nonce_field( 'woocommerce-order_tracking', 'woocommerce-order-tracking-nonce' ); ?>

            <?php 
            /**
             * Hook: woocommerce_order_tracking_form_end.
             * @since 6.5.0
             */
            do_action( 'woocommerce_order_tracking_form_end' ); 
            ?>
        </form>
    </div>



</div>

</div>