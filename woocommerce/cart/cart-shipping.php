<?php

/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.3.0
 */

defined('ABSPATH') || exit;

$formatted_destination    = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping  = !empty($has_calculated_shipping);
$show_shipping_calculator = !empty($show_shipping_calculator);
$calculator_text          = '';

// flexible_shipping_fedex:0:GROUND_HOME_DELIVERY

$shipping_method = WC()->session->get( 'chosen_shipping_methods' )[0];

// Freight - Residential Address
$residential_freight = 'flexible_shipping_single:5';

// Freight - Commercial Address
$commercial_freight = 'flexible_shipping_single:6';

// Heavy Freight - Commercial Only
$heavy_freight = 'flexible_shipping_single:7';

// Flat Rate 
$flat_rate = 'flexible_shipping_single:8';

// Free Shipping
$free_rate = 'flexible_shipping_single:9';

?>
<tr>
    <th colspan="2"><?php echo wp_kses_post($package_name); ?></th>
</tr>
<tr class="woocommerce-shipping-totals shipping">

    <td style="border-top: none;" colspan="2" data-title="<?php echo esc_attr($package_name); ?>">
        <?php if ($available_methods) : ?>
        <ul id="shipping_method" class="woocommerce-shipping-methods list-unstyled my-2">
            <?php foreach ($available_methods as $method) : ?>
            <li class="mb-1">
                <div class="form-check">
                    <?php
                    printf('<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method form-check-input" %4$s />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id), checked($method->id, $chosen_method, false)); // WPCS: XSS ok.
                    
                    printf('<label class="form-check-label d-flex justify-content-between" for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr(sanitize_title($method->id)), wc_cart_totals_shipping_method_label($method)); // WPCS: XSS ok.
                
                    do_action('woocommerce_after_shipping_rate', $method, $index);
                    ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php if (is_cart()) : ?>
        <p class="woocommerce-shipping-destination mb-0">
            <?php
            if ($formatted_destination) {
                // Translators: $s shipping destination.
                printf(esc_html__('Shipping to %s.', 'woocommerce') . ' ', '<strong><br>' . esc_html($formatted_destination) . '</strong>');
                $calculator_text = esc_html__('Change address', 'woocommerce');
            } else {
                echo wp_kses_post(apply_filters('woocommerce_shipping_estimate_html', __('Shipping options will be updated during checkout.', 'woocommerce')));
            }
            ?>
        </p>
        <?php endif; ?>
        <?php
		elseif (!$has_calculated_shipping || !$formatted_destination) :
			if (is_cart() && 'no' === get_option('woocommerce_enable_shipping_calc')) {
				echo wp_kses_post(apply_filters('woocommerce_shipping_not_enabled_on_cart_html', __('Shipping costs are calculated during checkout.', 'woocommerce')));
			} else {
				echo wp_kses_post(apply_filters('woocommerce_shipping_may_be_available_html', __('Enter your address to view shipping options.', 'woocommerce')));
			} elseif (!is_cart()) :
			echo wp_kses_post(apply_filters('woocommerce_no_shipping_available_html', __('There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce')));
		else :
			// Translators: $s shipping destination.
            echo wp_kses_post(
				/**
				 * Provides a means of overriding the default 'no shipping available' HTML string.
				 *
				 * @since 3.0.0
				 *
				 * @param string $html                  HTML message.
				 * @param string $formatted_destination The formatted shipping destination.
				 */
				apply_filters(
					'woocommerce_cart_no_shipping_available_html',
					// Translators: $s shipping destination.
					sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ),
					$formatted_destination
				)
			);
			$calculator_text = esc_html__('Enter a different address', 'woocommerce');
		endif;
		?>

        <?php if ($show_package_details) : ?>
        <?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html($package_details) . '</small></p>'; ?>
        <?php endif; ?>

        <?php if ($show_shipping_calculator) : ?>
        <?php woocommerce_shipping_calculator($calculator_text); ?>
        <?php endif; ?>
    </td>
</tr>
<!-- are we commercial freight?     -->
<?php if ($shipping_method === $commercial_freight) : ?>
<tr>
    <td class="p-0" colspan="2">
        <div class="d-block p-2">
            <p class="d-block mb-1 text-center" style="font-size: 16px;"><strong>PRICING TO A VERIFIED COMMERCIAL
                    ADDRESS</strong></p>
            <p class="mb-0 text-center" style="font-size: 14px;">Shipping to a residential address will result in
                additional fees, our staff will contact you</p>
        </div>
    </td>
</tr>
<!-- are we heavy freight?     -->
<?php elseif ($shipping_method === $heavy_freight) : ?>
<tr>
    <td class="p-0" colspan="2">
        <div class="d-block p-2">
            <p class="d-block mb-1 text-center"><strong>PRICING IS TO A COMMERCIAL
                    ADDRESS</strong></p>
            <p class="text-center mb-0" style="font-size: 12px;"><a target="_blank"
                    href="mailto:sales@classicbodyparts.com">Email us
                    for
                    residential shipping quote</a></p>
        </div>
    </td>
</tr>

<?php endif; ?>