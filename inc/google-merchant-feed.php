<?php

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