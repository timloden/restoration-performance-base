<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>

<div class="col-12 col-lg-6">
    <div class="border rounded p-2">
        <div class="woocommerce-form-coupon-toggle">
            <p class="mb-0">Have a coupon? <a href="#" class="showcoupon">Click here to enter your code</a></p>
        </div>

        <form class="checkout_coupon woocommerce-form-coupon pt-2" method="post" style="display:none">

            <div class="coupon input-group">
                <input type="text" name="coupon_code" class="input-text form-control"
                    placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary" name="apply_coupon"
                        value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
                </div>
                <?php do_action( 'woocommerce_cart_coupon' ); ?>
            </div>

        </form>
    </div>
</div>