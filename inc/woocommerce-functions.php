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

if (!function_exists('change_woocommerce_order_number')) {
    function change_woocommerce_order_number( $order_id ) {
        $prefix = 'CBP-';
        $new_order_id = $prefix . $order_id;
        return $new_order_id;
    }
}

// Order status - https://www.wpblog.com/woocommerce-custom-order-status/

// register the status
function wpblog_wc_register_post_statuses() {
    register_post_status( 'wc-ready-shipping', array(
    'label' => _x( 'Ready for shipping', 'WooCommerce Order status', 'text_domain' ),
    'public' => true,
    'exclude_from_search' => false,
    'show_in_admin_all_list' => true,
    'show_in_admin_status_list' => true,
    'label_count' => _n_noop( 'Ready for shipping (%s)', 'Ready for shipping (%s)', 'text_domain' )
    ) );
    }
add_filter( 'init', 'wpblog_wc_register_post_statuses' );

// add status to list
function wpblog_wc_add_order_statuses( $order_statuses ) {
    $order_statuses['wc-ready-shipping'] = _x( 'Ready for shipping', 'WooCommerce Order status', 'text_domain' );
    return $order_statuses;
    }
add_filter( 'wc_order_statuses', 'wpblog_wc_add_order_statuses' );

// add custom color for status
add_action('admin_head', 'styling_admin_order_list' );
function styling_admin_order_list() {
    global $pagenow, $post;

    if( $pagenow != 'edit.php') return; // Exit
    //if( get_post_type($post->ID) != 'shop_order' ) return; // Exit

    // HERE we set your custom status
    $order_status = 'ready-shipping'; // <==== HERE
    ?>
<style>
.order-status.status-<?php echo sanitize_title($order_status);

?> {
    background: #d7f8a7;
    color: #0c942b;
}
</style>
<?php
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
    if($brand) {
        return $brand[0]->name;
    }
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
        echo '<a href="' . get_the_permalink() . '">' .  woocommerce_get_product_thumbnail() . '</a>';
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


// my account - remove downloads

add_filter( 'woocommerce_account_menu_items', 'custom_remove_downloads_my_account', 999 );
 
function custom_remove_downloads_my_account( $items ) {
unset($items['downloads']);
return $items;
}

// my account - rename orders

add_filter ( 'woocommerce_account_menu_items', 'account_rename_orders' );
 
function account_rename_orders( $menu_links ){
 
	// $menu_links['TAB ID HERE'] = 'NEW TAB NAME HERE';
	$menu_links['orders'] = 'My Orders';
 
	return $menu_links;
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

// order detail 

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'order_address_classification' );

function order_address_classification( $order ){

    $classification = get_post_meta( $order->get_id(), '_wc_address_validation_classification', true );

    if ( $classification ) {
        echo '<div class="address-classification">Address Type: <strong>' . $classification . '</strong></div>';
    }
    

}