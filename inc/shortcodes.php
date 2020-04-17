<?php
function shortcode_handler($atts) {
    $nonce_value = wc_get_var( $_REQUEST['woocommerce-order-tracking-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.

    if ( isset( $_REQUEST['orderid'] ) && wp_verify_nonce( $nonce_value, 'woocommerce-order_tracking' ) ) { // WPCS: input var ok.

        $order_id    = empty( $_REQUEST['orderid'] ) ? 0 : ltrim( wc_clean( wp_unslash( $_REQUEST['orderid'] ) ), '#' ); // WPCS: input var ok.
        $order_email = empty( $_REQUEST['order_email'] ) ? '' : sanitize_email( wp_unslash( $_REQUEST['order_email'] ) ); // WPCS: input var ok.
        
        if ( ! $order_id ) {
            wc_print_notice( __( 'Please enter a valid order ID', 'woocommerce' ), 'error' );
        } elseif ( ! $order_email ) {
            wc_print_notice( __( 'Please enter a valid email address', 'woocommerce' ), 'error' );
        } else {
            //$order_id = trim(explode('-', $order_id)[1]);
            $order_id = trim(substr($order_id, strpos($order_id, '-') + 1));
            $order = wc_get_order( apply_filters( 'woocommerce_shortcode_order_tracking_order_id', $order_id ) );

            if ( $order && $order->get_id() && strtolower( $order->get_billing_email() ) === strtolower( $order_email ) ) {
                do_action( 'woocommerce_track_order', $order->get_id() );
                wc_get_template(
                    'order/tracking.php',
                    array(
                        'order' => $order,
                    )
                );
                return;
            } else {
                wc_print_notice( __( 'Sorry, the order could not be found. Please contact us if you are having difficulty finding your order details.', 'woocommerce' ), 'error' );
            }
        }
    }

    wc_get_template( 'order/form-tracking.php' );
}
add_shortcode('custom_order_tracking','shortcode_handler');