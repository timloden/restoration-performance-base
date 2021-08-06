<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
$all_shipping_classes = [];
?>

<div class="row">
    <div class="col-12 col-lg-8">
        <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <?php do_action('woocommerce_before_cart_table'); ?>

            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                array_push($all_shipping_classes, get_brand_name($product_id));

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            ?>
            <div
                class="row mb-3 align-items-center border-bottom pb-3 woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                <div class="product-thumbnail col-3 col-lg-2">
                    <?php
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('custom-thumb'), $cart_item, $cart_item_key);
                    $thumbnail = str_replace( 'class="', 'class="img-fluid ', $thumbnail );

                    if (!$product_permalink) {
                        echo $thumbnail; // PHPCS: XSS ok.
                    } else {
                        printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                    }
                    ?>
                </div>
                <div class="col-9 col-lg-6">

                    <div class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                        <p class="mb-2">
                            <?php
                                if (!$product_permalink) {
                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', esc_html( $_product->get_name() ), $cart_item, $cart_item_key ) . '&nbsp;' );
                                } else {
                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), esc_html( $_product->get_name() ) ), $cart_item, $cart_item_key ) );
                                }

                                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                // Meta data.
                                echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                // Backorder notification.
                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                }
                            ?>
                        </p>
                        <p class="mb-2" style="font-size: 12px;">SKU: <?php echo  $_product->get_sku(); ?> <span
                                class="px-2">|</span>
                            Brand:
                            <?php echo get_brand_name($product_id); ?></p>

                        <?php if ($_product->get_stock_status() === 'onbackorder') : ?>
                        <p style="font-size: 12px;" class="text-primary font-weight-bold"><i
                                class="las la-exclamation-circle"></i>
                            Backordered - could take over 30 days to ship</p>
                        <?php endif; ?>

                        <?php if ($_product->get_shipping_class() === 'ground-oversized'): ?>
                        <p style="font-size: 12px;" class="text-primary font-weight-bold"><i class="las la-box"></i> <a
                                data-toggle="tooltip" data-placement="top"
                                title="This product does not qualify for $7.50 shipping">Oversized Ground</a>
                        </p>

                        <?php elseif ($_product->get_shipping_class() === 'dynacorn-freight' || $_product->get_shipping_class() === 'oer-freight'): ?>
                        <p style="font-size: 12px;" class="text-primary font-weight-bold"><i
                                class="las la-shipping-fast"></i> Freight Item</p>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="col-12 col-lg-4">
                    <div class="d-flex align-items-center">
                        <div class="product-quantity col-auto"
                            data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                            <?php
                            if ($_product->is_sold_individually()) {
                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                            } else {
                                $product_quantity = woocommerce_quantity_input(
                                    array(
                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                        'input_value'  => $cart_item['quantity'],
                                        'max_value'    => $_product->get_max_purchase_quantity(),
                                        'min_value'    => '0',
                                        'product_name' => $_product->get_name(),
                                    ),
                                    $_product,
                                    false
                                );
                            }

                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                            ?>
                        </div>
                        <div class="product-price col text-center"
                            data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </div>
                        <div class="product-remove col text-right">
                            <?php
                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                'woocommerce_cart_item_remove_link',
                                sprintf(
                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><small>Remove</small></a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    esc_html__('Remove this item', 'woocommerce'),
                                    esc_attr($product_id),
                                    esc_attr($_product->get_sku())
                                ),
                                $cart_item_key
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
							}
                        }
						?>

            <?php do_action('woocommerce_cart_contents'); ?>

            <div class="row justify-content-between">
                <div class="actions col-auto">

                    <button type="submit" class="btn btn-outline-primary" name="update_cart"
                        value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

                    <?php do_action('woocommerce_cart_actions'); ?>

                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                </div>
                <div colspan="4" class="product-subtotal text-right col col-lg-auto">
                    <?php if (wc_coupons_enabled()) { ?>
                    <label class="sr-only" for="coupon_code"><?php esc_html_e('Coupon code:', 'woocommerce'); ?></label>
                    <div class="coupon input-group">
                        <input type="text" name="coupon_code" class="input-text form-control" id="coupon_code" value=""
                            placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary" name="apply_coupon"
                                value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply', 'woocommerce'); ?></button>
                        </div>
                        <?php do_action('woocommerce_cart_coupon'); ?>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <?php do_action('woocommerce_after_cart_contents'); ?>


            <div class="row">
                <div class="col-12">
                    <?php echo on_action_cart_updated(); ?>
                </div>
            </div>
            <?php 
            if (count(array_unique($all_shipping_classes)) !== 1): ?>
            <div class="row pb-4">
                <div class="col-12">
                    <div class="alert alert-info">
                        <p class="mb-1"><strong>Multiple Manufacturer Shipping</strong></p>
                        <p>It looks like you have selected items from multiple direct ship manufacturers.
                            This may cause you to pay more freight than necessary.</p>
                        <p>We suggest that on truck freight
                            items to stay with only one manufacturer products. Please contact us if that is not possible
                            for you so we can assist: <a
                                href="mailto:sales@classicbodyparts.com">sales@classicbodyparts.com</a></a></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="row pb-4">
                <div class="col-12">
                    <p class="mb-1"><strong>Having trouble with a coupon? Shipping seems off?</strong></p>
                    <p>Please email us at <a href="mailto:sales@classicbodyparts.com">sales@classicbodyparts.com</a> and
                        we will help!</p>
                </div>
            </div>
            <?php do_action('woocommerce_after_cart_table'); ?>
        </form>
    </div>
    <div class="col-12 col-lg-4">
        <?php do_action('woocommerce_before_cart_collaterals'); ?>

        <div class="cart-collaterals">
            <?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display - removed
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action('woocommerce_cart_collaterals');
			?>
        </div>
    </div>
</div>
<div class="row align-items-center">
    <div class="col-6">
        <a href="<?php echo site_url();?>/shop"><i class="las la-arrow-left"></i> Continue shopping</a>
    </div>
    <div class="col-6">

    </div>
</div>
<script>
jQuery(function() {
    jQuery('[data-toggle="tooltip"]').tooltip()
})
</script>
<?php
	do_action('woocommerce_cross_sell_display');
	?>


<?php do_action('woocommerce_after_cart'); ?>