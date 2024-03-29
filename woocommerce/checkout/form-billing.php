<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-billing-fields">
    <?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

    <h4><?php esc_html_e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h4>

    <?php else : ?>

    <h4><?php esc_html_e( 'Contact Information', 'woocommerce' ); ?></h4>
    <?php if ( !is_user_logged_in() ) : ?>
    <p>Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
            Click here to login
        </a></p>
    <?php endif; ?>

    <?php endif; ?>

    <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

    <div class="woocommerce-billing-fields__field-wrapper">
        <?php
		$fields = $checkout->get_checkout_fields( 'billing' );

		foreach ( $fields as $key => $field ) {
			custom_woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		?>
    </div>
    <div class="d-flex justify-content-between flex-wrap pb-4">
        <div class="col-12">
            <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
        </div>
    </div>
    <?php  
    
    $has_freight = false;
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $product = $cart_item['data'];
        $shipping_class = $product->get_shipping_class();

        if (str_contains($shipping_class, 'freight') || str_contains($shipping_class, 'bundle') || str_contains($shipping_class, 'windshield')) {
            $has_freight = true;
        }
    }

    if ($has_freight) :
    ?>
    <div class="row pb-3">
        <div class="col-12">
            <div class="alert alert-warning">
                <p class="mb-0"><strong>Freight Orders</strong></p>
                <p class="mb-0">Due to the rising cost of fuel and labor shortages truck freight
                    charges are subject to change if we cannot ship as is and immediately. If this is the case we
                    will contact you for approval to proceed.</p>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
<div class="woocommerce-account-fields">
    <?php if ( ! $checkout->is_registration_required() ) : ?>

    <p class="form-row form-row-wide create-account">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount"
                <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?>
                type="checkbox" name="createaccount" value="1" />
            <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
        </label>
    </p>

    <?php endif; ?>

    <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

    <?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

    <div class="create-account">
        <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
        <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
        <?php endforeach; ?>
        <div class="clear"></div>
    </div>

    <?php endif; ?>

    <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

</div>
<?php endif; ?>