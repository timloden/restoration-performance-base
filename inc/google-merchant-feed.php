<?php

// exclude products without images

add_filter( 'woocommerce_gpf_hide_if_no_images_google', '__return_true' );

// remove specific items

function lw_gpf_exclude_product( $excluded, $product_id, $feed_format ) {
    // return TRUE to exclude this product
    // return FALSE to include this product
    $hide_from_feed = false;

    $product = wc_get_product( $product_id );
    $stock_status = $product->get_stock_status();
    $shipping_class = $product->get_shipping_class();
    

    if ($product->get_regular_price() < 35 || $stock_status == 'onbackorder' || $stock_status == 'outofstock' || $shipping_class == 'oer-freight' || $shipping_class == 'windshield') {
        return true;
    } else {
        // return $excluded to keep the standard behavior for this product.
        return $excluded;
    }
}

add_filter( 'woocommerce_gpf_exclude_product', 'lw_gpf_exclude_product', 11, 3 );

// change weight to use lbs

add_filter( 'woocommerce_gpf_shipping_weight_unit', function ( $unit ) {
	return 'lbs';
});


// add vehicle fitments to descriptions

function lw_woocommerce_gpf_feed_item_google( $feed_item, $product ) {
	// Modify $feed_item->description here.
    //$feed_item->description = 'test';
    $product_id = $product->get_id();
    $description = $feed_item->description;
    $list = '';
    
    if( have_rows('vehicle_fitment', $product_id) ):
        $list = '<p>Vehicle Fitment:</p><ul>';
        while ( have_rows('vehicle_fitment', $product_id) ) : the_row();
            $vehicle = '<li>' . get_sub_field('vehicle') . '</li>';
            $list .= $vehicle;
        endwhile;
        $list .= '</ul>';
    else :
        // no rows found
    endif;

    $feed_item->description = $description . $list;
    
    return $feed_item;
}
add_filter( 'woocommerce_gpf_feed_item_google', 'lw_woocommerce_gpf_feed_item_google', 10, 2 );