<?php

/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package restoration-performance
 */

 //order number

add_filter( 'woocommerce_order_number', 'change_woocommerce_order_number' );

function change_woocommerce_order_number( $order_id ) {
    $prefix = 'CBP-';
    $new_order_id = $prefix . $order_id;
    return $new_order_id;
}

 // header - cart item count update

 add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

 function woocommerce_header_add_to_cart_fragment( $fragments ) {

    ob_start();
    echo '<div id="cart-dropdown" class="dropdown w-100">';
    echo '<a class="dropdown-toggle h4" role="button" id="dropdown-mini-cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">';
    echo '<i class="las la-shopping-cart "></i>Cart <span id="cart-customlocation" class="badge badge-danger animated swing">' . WC()->cart->get_cart_contents_count() . '</span></a>';

    echo '<div id="custom-mini-cart" class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-mini-cart">';
    woocommerce_mini_cart(); 
    echo '</div>';
    echo '</div>';
    
    $fragments['div#cart-dropdown'] = ob_get_clean();
    
    return $fragments;

 }

// loop - remove breadcrumbs from shop page

add_action('template_redirect', 'remove_shop_breadcrumbs' );

function remove_shop_breadcrumbs(){
 
    if (!is_product())
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
 
}


// loop - product title

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'loop_product_title', 10);

function loop_product_title()
{
    echo '<a class="mt-2" href="' . get_the_permalink()  . '"><p class="h5 text-dark ' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '"><strong>' . get_the_title() . '</strong></p></a>';
}

// loop / brand - get brand name

function get_brand_name($product_id) {
    $brand = wp_get_object_terms( $product_id, 'pwb-brand' );
    echo $brand[0]->name;
}

// loop - remove link

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 10);


// loop - product image

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'loop_product_image', 10);

function loop_product_image()
{
    global $post, $woocommerce;
    if ( has_post_thumbnail() ) {
        echo woocommerce_get_product_thumbnail();
    } else {
        echo '<img class="img-fluid" src="' . get_template_directory_uri() . '/assets/images/woocommerce-placeholder.png">';
    }
}

// product - remove related products

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


// product - image modification

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

add_action( 'woocommerce_before_single_product_summary', 'custom_show_product_images', 20);

function custom_show_product_images() {
    global $product;
    $attachment_ids = $product->get_gallery_image_ids();
    $image_id = $product->get_image_id();
    if ($image_id) {
        echo wp_get_attachment_image( $image_id, 'full', "", array( "class" => "img-fluid" ) );
    } else {
        echo '<img class="img-fluid" src="' . get_template_directory_uri() . '/assets/images/woocommerce-placeholder.png">';
    }
    
} 

// product - remove additional information tab

add_filter( 'woocommerce_product_tabs', 'remove_product_tabs', 9999 );
  
function remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] ); 
    return $tabs;
}

// cart - remove suggestions from cart collateral

remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

// cart - remove other shipping options if we have $4.50 shipping

add_filter('woocommerce_package_rates', 'custom_shipping_option', 20, 2 );

function custom_shipping_option($rates){

    // Only unset rates if $4.50 shipping is available

    if ( isset( $rates['flexible_shipping_1_2'] ) ) {
        unset( $rates['flexible_shipping_fedex:0:GROUND_HOME_DELIVERY'] );
    }     
        
    return $rates;
 
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

        if ($current_amount < 100) {
            $difference = 100 - $current_amount;

            echo '<div class="alert alert-info mt-3" role="alert">You&apos;re so close! all you need is <strong>$' . $difference . '</strong> more in your cart to get
    <strong>$4.50
        shipping</strong>!
    </div>';
        } elseif ($current_amount > 100) {
            echo '<div class="alert alert-success mt-3" role="alert">
        Congratulations your order can be shipped for only <strong>$4.50</strong>!
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

// checkout - custom fields

function custom_woocommerce_form_field($key, $args, $value = null)
{
    $defaults = array(
        'type' => 'text',
        'label' => '',
        'description' => '',
        'placeholder' => '',
        'maxlength' => false,
        'required' => false,
        'autocomplete' => false,
        'id' => $key,
        'class' => array(),
        'label_class' => array(),
        'input_class' => array(),
        'return' => false,
        'options' => array(),
        'custom_attributes' => array(),
        'validate' => array(),
        'default' => '',
        'autofocus' => '',
        'priority' => '',
    );

    $args = wp_parse_args($args, $defaults);
    $args = apply_filters('woocommerce_form_field_args', $args, $key, $value);

    if ($args['required']) {
        $args['class'][] = 'validate-required';
        $required = ' <abbr class="required" title="' . esc_attr__('required', 'woocommerce') . '">*</abbr>';
    } else {
        $required = '';
    }

    if (is_string($args['label_class'])) {
        $args['label_class'] = array($args['label_class']);
    }

    if (is_null($value)) {
        $value = $args['default'];
    }

    // Custom attribute handling
    $custom_attributes = array();
    $args['custom_attributes'] = array_filter((array) $args['custom_attributes']);

    if ($args['maxlength']) {
        $args['custom_attributes']['maxlength'] = absint($args['maxlength']);
    }

    if (!empty($args['autocomplete'])) {
        $args['custom_attributes']['autocomplete'] = $args['autocomplete'];
    }

    if (true === $args['autofocus']) {
        $args['custom_attributes']['autofocus'] = 'autofocus';
    }

    if (!empty($args['custom_attributes']) && is_array($args['custom_attributes'])) {
        foreach ($args['custom_attributes'] as $attribute => $attribute_value) {
            $custom_attributes[] = esc_attr($attribute) . '="' . esc_attr($attribute_value) . '"';
        }
    }

    if (!empty($args['validate'])) {
        foreach ($args['validate'] as $validate) {
            $args['class'][] = 'validate-' . $validate;
        }
    }

    $field = '';
    $label_id = $args['id'];
    $sort = $args['priority'] ? $args['priority'] : '';
    $field_container = '<div class="form-group %1$s" id="%2$s" data-priority="' . esc_attr($sort) . '">%3$s</div>';

    switch ($args['type']) {
        case 'country':

            $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() :
                WC()->countries->get_allowed_countries();

            if (1 === sizeof($countries)) {

                $field .= '<strong>' . current(array_values($countries)) . '</strong>';

                $field .= '<input type="hidden" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '"
    value="' . current(array_keys($countries)) . '" ' . implode(' ', $custom_attributes) . '
    class="country_to_state" />';
            } else {

                $field = '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '"
    class="country_to_state country_select ' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . '>'
                    . '<option value="">' . esc_html__('Select a country…', 'woocommerce') . '</option>';

                foreach ($countries as $ckey => $cvalue) {
                    $field .= '<option value="' . esc_attr($ckey) . '" ' . selected($value, $ckey, false) . '>' . $cvalue . '</option>';
                }

                $field .= '</select>';

                $field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals"
        value="' . esc_attr__('Update country', 'woocommerce') . '" /></noscript>';
            }

            break;
        case 'state':

            /**
             * Get Country
             */
            $country_key = 'billing_state' === $key ? 'billing_country' : 'shipping_country';
            $current_cc = WC()->checkout->get_value($country_key);
            $states = WC()->countries->get_states($current_cc);

            if (is_array($states) && empty($states)) {

                $field_container = '<div class="form-group %1$s" id="%2$s" style="display: none">%3$s</div>';

                $field .= '<input type="hidden" class="hidden" name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '"
    value="" ' . implode(' ', $custom_attributes) . ' placeholder="' . esc_attr($args['placeholder']) . '" />';
            } elseif (!is_null($current_cc) && is_array($states)) {

                $field .= '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '"
    class="state_select form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . '
    data-placeholder="' . esc_attr($args['placeholder']) . '">
    <option value="">' . esc_html__('Select a state…', 'woocommerce') . '</option>';

                foreach ($states as $ckey => $cvalue) {
                    $field .= '<option value="' . esc_attr($ckey) . '" ' . selected($value, $ckey, false) . '>' . $cvalue . '</option>';
                }

                $field .= '
</select>';
            } else {

                $field .= '<input type="text" class="input-text form-control ' . esc_attr(implode(' ', $args['input_class'])) . '"
    value="' . esc_attr($value) . '" placeholder="' . esc_attr($args['placeholder']) . '" name="' . esc_attr($key) . '"
    id="' . esc_attr($args['id']) . '" ' . implode(' ', $custom_attributes) . ' />';
            }

            break;
        case 'textarea':

            $field .= '<textarea name="' . esc_attr($key) . '"
    class="input-text form-control ' . esc_attr(implode(' ', $args['input_class'])) . '"
    id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . (empty($args['
    custom_attributes']['rows']) ? ' rows="2"' : '') . (empty($args['custom_attributes']['cols']) ? ' cols="5"' : '')
                . implode(' ', $custom_attributes) . '>' . esc_textarea($value) . '</textarea>';

            break;
        case 'checkbox':

            $field = '<label class="checkbox ' . implode(' ', $args['label_class']) . '" ' . implode(' ', $custom_attributes) . '>
    <input type="' . esc_attr($args['type']) . '"
        class="input-checkbox ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '"
        id="' . esc_attr($args['id']) . '" value="1" ' . checked($value, 1, false) . ' /> '
                . $args['label'] . $required . '</label>';

            break;
        case 'password':
        case 'text':
        case 'email':
        case 'tel':
        case 'number':

            $field .= '<input type="' . esc_attr($args['type']) . '"
    class="input-text form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '"
    id="' . esc_attr($args['id']) . '" placeholder="' . esc_attr($args['placeholder']) . '"
    value="' . esc_attr($value) . '" ' . implode(' ', $custom_attributes) . ' />';

            break;
        case 'select':

            $options = $field = '';

            if (!empty($args['options'])) {
                foreach ($args['options'] as $option_key => $option_text) {
                    if ('' === $option_key) {
                        // If we have a blank option, select2 needs a placeholder
                        if (empty($args['placeholder'])) {
                            $args['placeholder'] = $option_text ? $option_text : __('Choose an option', 'woocommerce');
                        }
                        $custom_attributes[] = 'data-allow_clear="true"';
                    }
                    $options .= '<option value="' . esc_attr($option_key) . '" ' . selected($value, $option_key, false) . '>' .
                        esc_attr($option_text) . '</option>';
                }

                $field .= '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '"
    class="select form-control ' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . '
    data-placeholder="' . esc_attr($args['placeholder']) . '">
    ' . $options . '
</select>';
            }

            break;
        case 'radio':

            $label_id = current(array_keys($args['options']));

            if (!empty($args['options'])) {
                foreach ($args['options'] as $option_key => $option_text) {
                    $field .= '<input type="radio" class="input-radio ' . esc_attr(implode(' ', $args['input_class'])) . '"
    value="' . esc_attr($option_key) . '" name="' . esc_attr($key) . '"
    id="' . esc_attr($args['id']) . '_' . esc_attr($option_key) . '"' . checked($value, $option_key, false) . ' />';
                    $field .= '<label for="' . esc_attr($args['id']) . '_' . esc_attr($option_key) . '"
    class="radio ' . implode(' ', $args['label_class']) . '">' . $option_text . '</label>';
                }
            }

            break;
    }

    if (!empty($field)) {
        $field_html = '';

        if ($args['label'] && 'checkbox' != $args['type']) {
            $field_html .= '<label for="' . esc_attr($label_id) . '" class="' . esc_attr(implode(' ', $args['label_class'])) . '">'
                . $args['label'] . $required . '</label>';
        }

        $field_html .= $field;

        if ($args['description']) {
            $field_html .= '<small class="form-text text-muted">' . esc_html($args['description']) . '</small>';
        }

        $container_class = esc_attr(implode(' ', $args['class']));
        $container_id = esc_attr($args['id']) . '_field';
        $field = sprintf($field_container, $container_class, $container_id, $field_html);
    }

    $field = apply_filters('woocommerce_form_field_' . $args['type'], $field, $key, $args, $value);

    if ($args['return']) {
        return $field;
    } else {
        echo $field;
    }
}

// checkout - place order button text

add_filter('woocommerce_order_button_text', 'checkout_place_order_button_text');

function checkout_place_order_button_text($order_button_text)
{
    return 'Securely Place Order'; // new text is here
}

// checkout - remove coupon form before checkout hook

//remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

//add_action('woocommerce_checkout_after_customer_details', 'woocommerce_checkout_coupon_form', 10);

// my account - remove downloads from my account 

add_filter( 'woocommerce_account_menu_items', 'custom_remove_downloads_my_account', 999 );
 
function custom_remove_downloads_my_account( $items ) {
unset($items['downloads']);
return $items;
}

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function woocommerce_active_body_class($classes)
{
    $classes[] = 'woocommerce-active';

    return $classes;
}
add_filter('body_class', 'woocommerce_active_body_class');

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function woocommerce_products_per_page()
{
    return 12;
}
add_filter('loop_shop_per_page', 'woocommerce_products_per_page');

/**
 * Product gallery thumbnail columns.
 *
 * @return integer number of columns.
 */
function woocommerce_thumbnail_columns()
{
    return 4;
}
add_filter('woocommerce_product_thumbnails_columns', 'woocommerce_thumbnail_columns');

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function woocommerce_loop_columns()
{
    return 3;
}
add_filter('loop_shop_columns', 'woocommerce_loop_columns');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function woocommerce_related_products_args($args)
{
    $defaults = array(
        'posts_per_page' => 3,
        'columns' => 3,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'woocommerce_related_products_args');