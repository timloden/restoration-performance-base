<?php

// move email field up
add_filter( 'woocommerce_checkout_fields', 'misha_email_first' );
 
function misha_email_first( $checkout_fields ) {
    $checkout_fields['billing']['billing_email']['priority'] = 4;
	return $checkout_fields;
}

// add email validation - https://www.businessbloomer.com/woocommerce-add-confirm-email-address-field-checkout/

add_filter( 'woocommerce_checkout_fields' , 'bbloomer_add_email_verification_field_checkout' );
   
function bbloomer_add_email_verification_field_checkout( $fields ) {
  
if (is_user_logged_in()) {
    return $fields;
}

$fields['billing']['billing_email']['class'] = array( 'form-row-first' );
  
$fields['billing']['billing_em_ver'] = array(
    'label' => 'Confirm Email',
    'required' => true,
    'class' => array( 'mb-4' ),
    'clear' => true,
    'priority' => 5,
);
  
return $fields;
}

add_action('woocommerce_checkout_process', 'bbloomer_matching_email_addresses');
  
function bbloomer_matching_email_addresses() { 
    $email1 = $_POST['billing_email'];
    $email2 = $_POST['billing_em_ver'];
    if ( $email2 !== $email1 && !is_user_logged_in() ) {
        wc_add_notice( 'Your email addresses do not match', 'error' );
    }
}



add_action( 'woocommerce_form_field_text','reigel_custom_heading', 10, 2 );

function reigel_custom_heading( $field, $key ){
    // will only execute if the field is billing_company and we are on the checkout page...
    if ( is_checkout() && ( $key == 'billing_company') ) {
        $field .= '<h4 class="mt-4">' . __('Billing Address') . '</h4>';
    }
    return $field;
}

// redirect if cart min is not met

add_action( 'template_redirect', 'redirect_to_cart_if_checkout' );

function redirect_to_cart_if_checkout() {

    if ( !is_checkout() ) return;
    global $woocommerce;

    if( is_checkout() && WC()->cart->subtotal < 15 && !is_wc_endpoint_url( 'order-pay' ) &&  !is_wc_endpoint_url( 'order-received' )) {
        wp_redirect( wc_get_cart_url() ); 
    } 

}

add_action('woocommerce_review_order_after_cart_contents', 'checkout_payment_heading');

function checkout_payment_heading() {
    //echo '<h4>Payment</h4>';
}

// add terms full content to checkout

add_action('woocommerce_review_order_after_submit', 'full_terms_window');

function full_terms_window() {
    $page = get_page_by_title('Terms and Conditions'); 
    $content = apply_filters('the_content', $page->post_content);

    echo '<div class="overflow-auto mt-4 mb-2 p-2 bg-white border" style="height: 100px; font-size: 12px;">' . $content . '</div>';
}


// place order button text

add_filter('woocommerce_order_button_text', 'checkout_place_order_button_text');

function checkout_place_order_button_text($order_button_text)
{
    return 'Securely Place Order'; // new text is here
}

// add payment section title before payment options

add_action( 'woocommerce_review_order_before_payment', 'wc_privacy_message_below_checkout_button' );
 
function wc_privacy_message_below_checkout_button() {
   echo '<p><a class="font-weight-bold" href="#" data-toggle="modal" data-target="#couponModal">
   Have a coupon code?</a></p><h4>Payment</h4>';
}


// Remove CSS and/or JS for Select2 used by WooCommerce, see https://gist.github.com/Willem-Siebe/c6d798ccba249d5bf080.
 
add_action( 'wp_enqueue_scripts', 'wsis_dequeue_stylesandscripts_select2', 100 );

function wsis_dequeue_stylesandscripts_select2() {
    if ( class_exists( 'woocommerce' ) ) {
        wp_dequeue_style( 'selectWoo' );
        wp_deregister_style( 'selectWoo' );
    
        wp_dequeue_script( 'selectWoo');
        wp_deregister_script('selectWoo');
    } 
} 


// checkout custom fields

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
            } elseif (is_user_logged_in()) {

                // if logged in, use the country on account

                $field = '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '"
    class="country_to_state country_select d-none ' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . '>'
                    . '<option value="">' . esc_html__('Select a country…', 'woocommerce') . '</option>';

                foreach ($countries as $ckey => $cvalue) {
                    $field .= '<option value="' . esc_attr($ckey) . '" ' . selected($value, $ckey, false) . '>' . $cvalue . '</option>';
                }

                $field .= '</select>';

                $field .= '<noscript><input type="submit" name="woocommerce_checkout_update_totals"
        value="' . esc_attr__('Update country', 'woocommerce') . '" /></noscript>';
                
            } else {

                // if not logged in default to US as country 
            
                $field = '<select name="' . esc_attr($key) . '" id="' . esc_attr($args['id']) . '"
    class="country_to_state country_select d-none ' . esc_attr(implode(' ', $args['input_class'])) . '" ' . implode(' ', $custom_attributes) . '>'
                    . '<option value="US" selected="selected">United States</option>';

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