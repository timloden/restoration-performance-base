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
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>

<div class="row">
    <div class="col-12 col-lg-8">
        <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <?php do_action('woocommerce_before_cart_table'); ?>
            <div class="table-responsive-sm">
                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents table"
                    cellspacing="0">
                    <thead>
                        <tr>

                            <th class="product-thumbnail" scope="col">&nbsp;</th>
                            <th class="product-name" scope="col"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                            <th class="product-price" scope="col"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                            <th class="product-quantity" scope="col"><?php esc_html_e('Qty', 'woocommerce'); ?></th>
                            <th class="product-remove" scope="col">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php do_action('woocommerce_before_cart_contents'); ?>

                        <?php
						foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
							$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
							$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

							if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
								$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
						?>
                        <tr
                            class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">



                            <td class="product-thumbnail">
                                <?php
										$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

										if (!$product_permalink) {
											echo $thumbnail; // PHPCS: XSS ok.
										} else {
											printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
										}
										?>
                            </td>

                            <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                <p class="mb-1">
                                    <?php
										if (!$product_permalink) {
											echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
										} else {
											echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
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
                                <span style="font-size: 12px;">SKU: <?php echo  $_product->get_sku(); ?></span>
                                <?php if ($_product->get_stock_status() === 'onbackorder') : ?>
                                <p style="font-size: 12px;" class="text-primary font-weight-bold"><i
                                        class="las la-exclamation-circle"></i>
                                    Backordered - could take up to 30 days to ship</p>
                                <?php endif; ?>
                                <?php if ($_product->get_shipping_class() === 'ground-oversized'): ?>
                                <p style="font-size: 12px;" class="text-primary font-weight-bold"><i
                                        class="las la-box"></i> <a data-toggle="tooltip" data-placement="top"
                                        title="This product does not qualify for $7.50 shipping">Oversized Ground</a>
                                </p>
                                <?php elseif ($_product->get_shipping_class() === 'dynacorn-freight' || $_product->get_shipping_class() === 'oer-freight'): ?>
                                <p style="font-size: 12px;" class="text-primary font-weight-bold"><i
                                        class="las la-shipping-fast"></i> Freight Item</p>
                                <?php endif; ?>
                            </td>

                            <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                <?php
										echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
										?>
                            </td>

                            <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
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
                            </td>
                            <td class="product-remove">
                                <?php
										echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											'woocommerce_cart_item_remove_link',
											sprintf(
												'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">Remove</a>',
												esc_url(wc_get_cart_remove_url($cart_item_key)),
												esc_html__('Remove this item', 'woocommerce'),
												esc_attr($product_id),
												esc_attr($_product->get_sku())
											),
											$cart_item_key
										);
										?>
                            </td>
                        </tr>
                        <?php
							}
						}
						?>

                        <?php do_action('woocommerce_cart_contents'); ?>

                        <tr>
                            <td colspan="2" class="actions">

                                <button type="submit" class="btn btn-sm btn-outline-secondary" name="update_cart"
                                    value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

                                <?php do_action('woocommerce_cart_actions'); ?>

                                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                            </td>
                            <td colspan="4" class="product-subtotal text-right">
                                <?php if (wc_coupons_enabled()) { ?>
                                <label class="sr-only"
                                    for="coupon_code"><?php esc_html_e('Coupon code:', 'woocommerce'); ?></label>
                                <div class="coupon input-group">
                                    <input type="text" name="coupon_code" class="input-text form-control"
                                        id="coupon_code" value=""
                                        placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary" name="apply_coupon"
                                            value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></button>
                                    </div>
                                    <?php do_action('woocommerce_cart_coupon'); ?>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>

                        <?php do_action('woocommerce_after_cart_contents'); ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php echo on_action_cart_updated(); ?>
                </div>
            </div>
            <div class="row pb-4">
                <div class="col-12">
                    <p class="mb-1"><strong>Having trouble with a coupon? Shipping seems off?</strong></p>
                    <p>Please email us at <a href="mailto:sales@classicbodyparts.com">sales@classicbodyparts.com</a> and
                        we will help!</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-6">
                    <a href="<?php echo site_url();?>/shop"><i class="las la-arrow-left"></i> Continue shopping</a>
                </div>
                <div class="col-6">

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
<script>
jQuery(function() {
    jQuery('[data-toggle="tooltip"]').tooltip()
})
</script>
<?php
	do_action('woocommerce_cross_sell_display');
	?>


<?php do_action('woocommerce_after_cart'); ?>