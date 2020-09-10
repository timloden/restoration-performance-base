<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}



// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>
<div class="row py-3">
    <?php do_action('woocommerce_before_checkout_form', $checkout); ?>
</div>
<form name="checkout" method="post" class="checkout woocommerce-checkout"
    action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12 col-lg-7">
            <?php if ($checkout->get_checkout_fields()) : ?>

            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

            <div class="row" id="customer_details">
                <div class="col-12">
                    <?php do_action('woocommerce_checkout_billing'); ?>
                </div>

                <div class="col-12">
                    <?php do_action('woocommerce_checkout_shipping'); ?>
                </div>
            </div>

            <?php do_action('woocommerce_checkout_after_customer_details'); ?>

            <?php endif; ?>
        </div>
        <div class="col-12 col-lg-5">
            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>


            <?php do_action('woocommerce_checkout_before_order_review'); ?>

            <div id="order_review" class="woocommerce-checkout-review-order border rounded px-3 pb-3">
                <?php do_action('woocommerce_checkout_order_review'); ?>
            </div>

            <?php do_action('woocommerce_checkout_after_order_review'); ?>

        </div>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Residential Shipping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please fill out the form below and a sales associate will get you an accurate residential shipping
                    quote for the items in your cart.</p>
                <?php
                        $items = WC()->cart->get_cart();
                        $cart_contents = '';

                        foreach($items as $item => $values) { 
                            $_product =  wc_get_product( $values['data']->get_id()); 
                            $sku = get_post_meta($values['product_id'] , '_sku', true);
                            $cart_contact_item = $_product->get_title() . ' (' . $sku . ')' . ' x '.$values['quantity'] . '\n'; 
                            $cart_contents .= $cart_contact_item;
                        } 
                        $shortcode = '[gravityform id="3" title="false" description="false" ajax="true" field_values="residential_request_cart=' . $cart_contents . '"]';
                        echo do_shortcode($shortcode);
                ?>

            </div>
        </div>
    </div>
</div>
<?php

do_action('woocommerce_after_checkout_form', $checkout);
?>