<?php

// hide state field from shipping calc



// cart custom image size

if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'custom-thumb', 100, 100 ); // 100 wide and 100 high
}

// cart - remove suggestions from cart collateral

remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

// cart - mini cart button classes

remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

function my_woocommerce_widget_shopping_cart_proceed_to_checkout()
{
    echo '<div class="col-4"><a href="' . esc_url(wc_get_cart_url()) . '" class="btn btn-outline-primary d-block">' . esc_html__('View cart', 'woocommerce') . '</a></div>';
    echo '<div class="col-8"><a href="' . esc_url(wc_get_checkout_url()) . '" class="btn btn-success text-white d-block fw-bold">' . esc_html__('Checkout', 'woocommerce') . ' <i class="las la-arrow-right"></i></a></div>';
    
}

add_action('woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

// cart - check for shipping discount

add_action('woocommerce_update_cart_action_cart_updated', 'on_action_cart_updated', 20, 1);

function on_action_cart_updated() {

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
    $has_dynacorn = false;

    // check each cart item for our category
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

        $product = $cart_item['data'];
        $shipping_class_id = $product->get_shipping_class_id();
        $shipping_class_term = get_term($shipping_class_id, 'product_shipping_class');
        $shipping_class_slug = $shipping_class_term->slug;

        if ($shipping_class_slug != 'ground') {
            $has_freight = true;
        }

        if ($shipping_class_slug == 'ground-dynacorn') {
            $has_dynacorn = true;
        }
    }
    
    $current_amount = WC()->cart->cart_contents_total;

    $shipping_state = WC()->customer->get_shipping_state();

    if( $has_freight == true && $shipping_state == 'AK' ) {
        // Display an error message
        echo '<div class="alert alert-danger mt-3" role="alert">Sorry, we do not ship freight items to Alaska at this time.</div>';
        remove_action( 'woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout', 20);
    }

    if( $has_freight == true && $shipping_state == 'HI' ) {
        // Display an error message
        echo '<div class="alert alert-danger mt-3" role="alert">Sorry, we do not ship freight items to Hawaii at this time.</div>';
        remove_action( 'woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout', 20);
    }
    
    // if ($has_freight == false && $shipping_state != 'AK' && $shipping_state != 'HI') {

    //     if ($current_amount < 200) {
    //         $difference = 200 - $current_amount;

    //         echo '<div class="alert alert-info mt-3" role="alert">You&apos;re so close! all you need is <strong>$' . $difference . '</strong> more in your cart to get
    //         <strong>$7.50
    //             shipping</strong>!
    //         </div>';
    //     } elseif ($current_amount >= 200) {
    //         echo '<div class="alert alert-success mt-3" role="alert">
    //             Congratulations your order can be shipped for only <strong>$7.50</strong>!
    //         </div>';
    //     }
    // }

    // if ($has_dynacorn == true && $current_amount >= 200) {
    //     echo '<a data-toggle="dii-tooltip" class="btn btn-text text-primary px-0 mb-3" data-placement="top" title="$7.50 shipping is only offered for OER parts shipped ground">Why does my order not qualify for $7.50 shipping?</a>';
    // }
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
    $message    = sprintf('<div class="d-flex justify-content-between align-items-center"><div class="d-flex align-items-center mb-2 mb-lg-0"><i class="las la-check-circle text-success h4 me-2 mb-0"></i> <strong>%s</strong></div> <a href="%s" class="btn btn-success btn-sm text-white">%s</a></div>', esc_html($added_text), esc_url(wc_get_page_permalink('cart')), esc_html__('View cart', 'woocommerce'));


    return $message;
}
add_filter('wc_add_to_cart_message_html', 'added_to_cart_message_html', 10, 2);

// cart - remove city field from shipping calc
add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_false' );


// adding $10 to drop ship fee fee for Dynacorn
function dynacorn_dropship_fee( $rates, $package ) {    
    if (get_field('enable_dynacorn_ground_drop_ship_fee', 'option')) {
    
        $brand_list = [];

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $product = $cart_item['data'];
            $product_id = $product->get_id();
            array_push($brand_list, get_brand_name($product_id));
        }

        if (in_array("Dynacorn", $brand_list)) {
            //flexible_shipping_fedex:0:GROUND_HOME_DELIVERY
            if ( isset( $rates['flexible_shipping_fedex:0:GROUND_HOME_DELIVERY'] ) ) {
                // get the cost
                $old_cost = $rates['flexible_shipping_fedex:0:GROUND_HOME_DELIVERY']->cost;
                // add the 5 to the old cost
                $new_cost = $old_cost + 5;
                $rates['flexible_shipping_fedex:0:GROUND_HOME_DELIVERY']->cost = $new_cost;
            }
        }

    }

    return $rates;
}

add_filter( 'woocommerce_package_rates', 'dynacorn_dropship_fee', 10, 2 );