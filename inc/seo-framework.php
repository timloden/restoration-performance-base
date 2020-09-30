<?php

// add sku to title
add_filter( 'the_seo_framework_title_from_custom_field', function( $title, $args ) {

    if ( is_product() ){
        $product_id = get_the_id();
        $product = wc_get_product( $product_id );

        $brand = get_brand_name($product_id);

        $name = $product->get_name();
        $sku = $product->get_sku();

        $title = $brand . ' ' . $name . ' &#x2d; ' . $sku;

        return $title;
    }

}, 10, 2 );