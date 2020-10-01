<?php


// cart custom image size

if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'custom-thumb', 100, 100 ); // 100 wide and 100 high
}

// cart - remove suggestions from cart collateral

remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

// cart - remove other shipping options if we have $4.50 shipping

add_filter('woocommerce_package_rates', 'custom_shipping_option', 20, 2 );

if (!function_exists('custom_shipping_option')) {
    function custom_shipping_option($rates){

        // unset rates if $4.50 shipping is available or free shipping

        if ( isset( $rates['flexible_shipping_1_2'] ) || isset( $rates['flexible_shipping_1_5']) ) {
            unset( $rates['flexible_shipping_fedex:0:GROUND_HOME_DELIVERY'] );
        }  
        
        // if freight, heavy-freight or free shipping, remove fedex fallback

        if ( isset( $rates['flexible_shipping_1_1'] ) || isset( $rates['flexible_shipping_1_4'] ) || isset( $rates['flexible_shipping_1_5'] ) ) {
            unset( $rates['flexible_shipping_fedex:fallback'] );
        }   

        

        return $rates;
    
    }
}

// cart - mini cart button classes

remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

function my_woocommerce_widget_shopping_cart_button_view_cart()
{
    echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="btn  btn-outline-secondary">' . esc_html__('View cart', 'woocommerce') . '</a>';
}
function my_woocommerce_widget_shopping_cart_proceed_to_checkout()
{
    echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="btn btn-success d-block">' . esc_html__('Checkout', 'woocommerce') . '</a>';
}
//add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_button_view_cart', 10 );
add_action('woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

// cart - check for shipping discount

add_action('woocommerce_update_cart_action_cart_updated', 'on_action_cart_updated', 20, 1);

function on_action_cart_updated()
{
    if( is_cart() || is_checkout() && !is_wc_endpoint_url( 'order-pay' ) ) {

        // HERE Set minimum cart total amount
        $min_total = 15;

        // Total (before taxes and shipping charges)
        $total = WC()->cart->subtotal;

        // Add an error notice is cart total is less than the minimum required
        if( $total < $min_total  ) {
            // Display an error message
            echo '<div class="alert alert-danger mt-3" role="alert">Minimum order subtotal of
            <strong>$15.00 required</strong>.</div>';
            remove_action( 'woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout', 20);
        }
    }

    $has_freight = false;

    // check each cart item for our category
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

        $product = $cart_item['data'];
        $shipping_class_id = $product->get_shipping_class_id();
        $shipping_class_term = get_term($shipping_class_id, 'product_shipping_class');
        $shipping_class_slug = $shipping_class_term->slug;

        if ($shipping_class_slug != 'ground') {
            $has_freight = true;
        }
    }

    if ($has_freight == false) {
        $current_amount = WC()->cart->cart_contents_total;

        if ($current_amount < 150) {
            $difference = 150 - $current_amount;

            echo '<div class="alert alert-info mt-3" role="alert">You&apos;re so close! all you need is <strong>$' . $difference . '</strong> more in your cart to get
    <strong>$7.50
        shipping</strong>!
    </div>';
        } elseif ($current_amount >= 150) {
            echo '<div class="alert alert-success mt-3" role="alert">
        Congratulations your order can be shipped for only <strong>$7.50</strong>!
    </div>';
        }
    }
}

// cart - notices 

function added_to_cart_message_html($message, $products)
{

    $count = 0;
    $titles = array();
    foreach ($products as $product_id => $qty) {
        $titles[] = ($qty > 1 ? absint($qty) . ' &times; ' : '') . sprintf(_x('%s', 'Item name in quotes', 'woocommerce'), strip_tags(get_the_title($product_id)));
        $count += $qty;
    }

    $titles     = array_filter($titles);
    $added_text = sprintf(_n(
        '%s is added to your cart.', // Singular
        '%s are added to your cart.', // Plural
        $count, // Number of products added
        'woocommerce' // Textdomain
    ), wc_format_list_of_items($titles));
    $message    = sprintf('<div class="d-flex justify-content-between"><div class="d-flex"><i class="las la-check-circle text-success h4 mb-0 mr-2"></i> <strong>%s</strong></div> <a href="%s" class="btn btn-success btn-sm">%s</a></div>', esc_html($added_text), esc_url(wc_get_page_permalink('cart')), esc_html__('View cart', 'woocommerce'));


    return $message;
}
add_filter('wc_add_to_cart_message_html', 'added_to_cart_message_html', 10, 2);

// cart - remove city field from shipping calc
add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_false' );