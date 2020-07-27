<?php

add_filter( 'facetwp_is_main_query', function( $is_main_query, $query ) {
    // if ( 'product_query' != $query->get( 'wc_query') ) {
    //     $is_main_query = false;
    // }

    if ('product-tag/special' == FWP()->helper->get_uri()) {
        $is_main_query = false;
    }


    //echo FWP()->helper->get_uri();
   
    return $is_main_query;
}, 10, 2 );


// product bundles

add_filter( 'facetwp_is_main_query', function( $is_main_query, $query ) {
    if ( 'product' == $query->get( 'post_type' ) && 'product_query' != $query->get( 'wc_query' ) ) {
        $is_main_query = false;
    }
    return $is_main_query;
}, 10, 2 );

// add bootstrap class to selects

add_filter(
    'facetwp_facet_html',
    function ($output, $params) {
        if ('hierarchy_select' == $params['facet']['type']) {
            $output = str_replace('facetwp-hierarchy_select', 'facetwp-hierarchy_select form-control mb-2', $output);
        }
        return $output;
    },
    10,
    2
);

// remove counts from drop downs

add_filter(
    'facetwp_facet_dropdown_show_counts',
    function ($return, $params) {
        if ('year_make_model' == $params['facet']['name']) {
            $return = false;
        }
        return $return;
    },
    10,
    2
);

// staging site protection bypass

add_filter( 'http_request_args', function( $args, $url ) {
    if ( 0 === strpos( $url, get_site_url() ) ) {
        $args['headers'] = array(
            'Authorization' => 'Basic ' . base64_encode( 'staging_xnixx2:ruGfCjccDcJS' )
        );
    }
    return $args;
}, 10, 2 );