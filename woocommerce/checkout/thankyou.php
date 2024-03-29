<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 8.1.0
 */

defined('ABSPATH') || exit;
?>
<div class="container">
    <div class="woocommerce-order pt-3">

        <?php
	if ($order) :

		do_action('woocommerce_before_thankyou', $order->get_id());
	?>

        <?php if ($order->has_status('failed')) : ?>
        <div class="alert alert-danger">
            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed mb-0">
                <?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?>
            </p>
        </div>

        <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
            <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>"
                class="btn btn-success"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
            <?php if (is_user_logged_in()) : ?>
            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
                class="btn btn-secondary"><?php esc_html_e('My account', 'woocommerce'); ?></a>
            <?php endif; ?>
        </p>

        <?php else : ?>
        <div class="alert alert-success">
            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received mb-0"><i
                    class="las la-check-circle"></i> <?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), $order); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																											?></p>
        </div>

        <p style="font-size: 1.1rem;">All order and tracking details will be emailed from
            <strong>sales@<?php echo $_SERVER['HTTP_HOST']; ?></strong>. <strong>Please make sure this our email address
                is
                flagged/added
                to your contacts so they don't go to spam!</strong>
        </p>

        <div class="row">
            <div class="col-12 col-lg-4">
                <p>Your account login and password have been emailed to:
                    <strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                </p>
                <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

                    <li class="woocommerce-order-overview__order order pb-2">
                        <?php esc_html_e('Order Invoice Number:', 'woocommerce'); ?>
                        <strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?></strong>
                    </li>

                    <li class="woocommerce-order-overview__date date pb-2">
                        <?php esc_html_e('Date:', 'woocommerce'); ?>
                        <strong><?php echo wc_format_datetime($order->get_date_created()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?></strong>
                    </li>

                    <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                    <li class="woocommerce-order-overview__email email pb-2">
                        <?php esc_html_e('Email:', 'woocommerce'); ?>
                        <strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
										?></strong>
                    </li>
                    <?php endif; ?>

                    <li class="woocommerce-order-overview__total total pb-2">
                        <?php esc_html_e('Total:', 'woocommerce'); ?>
                        <strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?></strong>
                    </li>

                    <?php if ($order->get_payment_method_title()) : ?>
                    <li class="woocommerce-order-overview__payment-method method pb-2">
                        <?php esc_html_e('Payment method:', 'woocommerce'); ?>
                        <strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                    </li>
                    <?php endif; ?>

                </ul>
            </div>

            <?php endif; ?>
            <div class="col-12 col-lg-8">
                <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
                <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
            </div>
        </div>
        <?php if (get_field('enable_google_reviews', 'option')) : 
                $date = strtotime("+7 day");    
            ?>

        <script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>

        <script>
        window.renderOptIn = function() {
            window.gapi.load('surveyoptin', function() {
                window.gapi.surveyoptin.render({
                    // REQUIRED FIELDS
                    "merchant_id": <?php echo get_field('google_merchant_id', 'option'); ?>,
                    "order_id": "<?php echo $order->get_order_number(); ?>",
                    "email": "<?php echo $order->get_billing_email(); ?>",
                    "delivery_country": "US",
                    "estimated_delivery_date": "<?php echo date('Y-m-d', $date); ?>",
                });
            });
        }
        </script>
        <?php endif; ?>

        <?php else : ?>
        <div class="alert alert-success">
            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
                <?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), null); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div> ?></p>

        <?php endif; ?>

    </div>

</div>