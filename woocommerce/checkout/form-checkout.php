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

global $woocommerce;

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
$has_backorder = false;

$items = $woocommerce->cart->get_cart();

foreach($items as $item => $values) { 
    $_product =  wc_get_product( $values['data']->get_id()); 
    $product_stock = $_product->get_stock_status();
    if ($product_stock == 'onbackorder') {
        $has_backorder = true;
    }
}
?>
<?php do_action('woocommerce_before_checkout_form', $checkout); ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
    action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
    <div class="container">

        <div class="row">
            <div class="col-12 col-md-7 py-5 pr-md-5 border-right">
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
            <div class="col-12 col-md-5 py-5 px-md-3 px-lg-4 checkout-cart border-right">
                <?php //do_action('woocommerce_checkout_before_order_review_heading'); ?>
                <h4>Your Order</h4>
                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>
                <?php //do_action('woocommerce_checkout_after_order_review'); ?>
            </div>
        </div>
    </div>
</form>
<script>
jQuery(document).on('updated_checkout', function() {
    jQuery("#place_order").html("Securely Place Order");
});
</script>

<?php
do_action('woocommerce_after_checkout_form', $checkout);

if ($has_backorder) :

?>

<script type="text/javascript">
jQuery(window).on('load', function() {
    jQuery('#exampleModal').modal('show');
});
</script>
<div class="modal fade" id="exampleModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Backordered Items</h5>
            </div>
            <div class="modal-body">
                <strong>Notice:</strong> Some of the items in your cart are currently on backorder and could take over
                30 days to ship. If there is no ETA, we will refund the cost of the part.
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">I Understand</button>
            </div>
        </div>
    </div>
</div>

<?php endif;