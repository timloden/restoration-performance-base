<?php

/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package restoration-performance
 */

 //order number

//add_filter( 'woocommerce_order_number', 'change_woocommerce_order_number' );

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
    'label' => _x( 'Awaiting Shipping', 'WooCommerce Order status', 'text_domain' ),
    'public' => true,
    'exclude_from_search' => false,
    'show_in_admin_all_list' => true,
    'show_in_admin_status_list' => true,
    'label_count' => _n_noop( 'Ready for shipping (%s)', 'Ready for shipping (%s)', 'text_domain' )
    ) );

    register_post_status( 'wc-on-backorder', array(
        'label' => _x( 'On Backorder', 'WooCommerce Order status', 'text_domain' ),
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop( 'On Backorder (%s)', 'On Backorder (%s)', 'text_domain' )
        ) );
    }
add_filter( 'init', 'wpblog_wc_register_post_statuses' );

// add status to list
function wpblog_wc_add_order_statuses( $order_statuses ) {
    $order_statuses['wc-ready-shipping'] = _x( 'Awaiting Shipping', 'WooCommerce Order status', 'text_domain' );
    $order_statuses['wc-on-backorder'] = _x( 'On Backorder', 'WooCommerce Order status', 'text_domain' );
    return $order_statuses;
    }
add_filter( 'wc_order_statuses', 'wpblog_wc_add_order_statuses' );

// add custom color for status
add_action('admin_head', 'styling_admin_order_list' );

function styling_admin_order_list() {
    ?>
<style>
.order-status.status-ready-shipping {
    background: #d7f8a7;
    color: #0c942b;
}

.order-status.status-on-backorder {
    background: #d1ecf1;
    color: #0c5460;
}
</style>
<?php
}

 // header - cart item count update

 add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

 function woocommerce_header_add_to_cart_fragment( $fragments ) {

    ob_start();
    echo '<a class="position-relative btn d-inline-flex p-0" role="button" id="mini-cart-link" data-bs-toggle="offcanvas" href="#off-canvas-mini-cart" role="button"
    aria-controls="off-canvas-mini-cart">';
    echo '<i class="las la-shopping-cart position-relative"></i><span style="font-size: 12px;" id="cart-customlocation" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">' . WC()->cart->get_cart_contents_count() . '</span></a>';
    
    $fragments['a#mini-cart-link'] = ob_get_clean();
    return $fragments;

 }

// mini cart update

 add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_mini_cart_fragment'); 
 
 function woocommerce_mini_cart_fragment( $fragments ) {

    ob_start();
    ?>

<div id="mini-cart-content" class="d-flex flex-column h-100">
    <?php woocommerce_mini_cart(); ?>
</div>
<?php 
    $fragments['div#mini-cart-content'] = ob_get_clean();

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
    echo '<a class="mt-2 d-block text-center" href="' . get_the_permalink()  . '"><p class="text-dark ' . esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')) . '"><strong>' . get_the_title() . '</strong></p></a>';
}

// loop / brand - get brand name

function get_brand_name($product_id) {
    $brand = wp_get_object_terms( $product_id, 'pwb-brand' );
    $brand_name = '';
    
    if($brand) {
        $brand_name = $brand[0]->name;
    }

    if ($brand_name == 'OER Authorized') {
        $brand_name = 'OER';
    }

    return $brand_name;
}

function get_brand_notice($product_id) {
    $brand = wp_get_object_terms( $product_id, 'pwb-brand' );
    if($brand) {
        $term = 'term_' . $brand[0]->term_id;
        $notice = get_field('freight_notice', $term);
        echo $notice;
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
        echo '<a class="pe-2 pe-md-0 d-block" href="' . get_the_permalink() . '">' .  woocommerce_get_product_thumbnail() . '</a>';
    } else {
        echo '<img class="img-fluid" src="' . get_template_directory_uri() . '/assets/images/woocommerce-placeholder.png">';
    }
}


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
    
    if (isset($menu_links['tinv_wishlist'])) {
        $menu_links['tinv_wishlist'] = 'My Buildlist';
    }
 
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

add_filter( 'woocommerce_states', 'custom_us_states', 10, 1 );

function custom_us_states( $states ) {
    $non_allowed_us_states = array( 'AA', 'AE', 'AP'); 

    // Loop through your non allowed us states and remove them
    foreach( $non_allowed_us_states as $state_code ) {
        if( isset($states['US'][$state_code]) )
            unset( $states['US'][$state_code] );
    }
    return $states;
}