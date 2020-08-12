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

add_filter( 'facetwp_filtered_post_ids', function( $post_ids, $class ) {
    
    // get products from the universal ymm taxonomy
    $universal_args = array(
        'fields' => 'ids',
        'facetwp' => false,
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'ymm',
                'field' => 'slug',
                'terms' => array( 'universal' )
    
            ),
        ),
    );

    $universal_query = new WP_Query( $universal_args );
    $universal_ids = $universal_query->posts;

    // if facet selected add universal products to results
    if ( isset( FWP()->facet->facets['year_make_model'] ) ) {
        $post_ids = array_merge( $post_ids, $universal_ids );
    }

    return $post_ids;
}, 15, 2 );

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