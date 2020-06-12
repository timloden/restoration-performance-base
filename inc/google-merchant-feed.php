<?php

// change weight to use lbs

add_filter( 'woocommerce_gpf_shipping_weight_unit', function ( $unit ) {
	return 'lbs';
});


// add vehicle fitments to descriptions

function lw_woocommerce_gpf_feed_item_google( $feed_item, $product ) {
	// Modify $feed_item->description here.
    //$feed_item->description = 'test';
    
    
    
    return $feed_item;
}
add_filter( 'woocommerce_gpf_feed_item_google', 'lw_woocommerce_gpf_feed_item_google', 10, 2 );