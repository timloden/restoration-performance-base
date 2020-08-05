<?php

add_filter( 'facetwp_is_main_query', function( $is_main_query, $query ) {
    
    //echo FWP()->helper->get_uri();
    
    $front_page_id = get_option( 'page_on_front' );

    // dont show on specials page
    if ('product-tag/special' == FWP()->helper->get_uri()) {
        $is_main_query = false;
    }

    // product bundles fix
    if ( 'product' == $query->get( 'post_type' ) && 'product_query' != $query->get( 'wc_query' )) {
        $is_main_query = false;
    }

    return $is_main_query;
}, 10, 2 );

// universal products

// add_filter( 'facetwp_facet_render_args', function( $args ) {
//     if ( 'year_make_model' == $args['facet']['name'] ) {
//         $args['selected_values'] = array( 'universal' );
//     }
//     return $args;
// });

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