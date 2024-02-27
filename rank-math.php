<?php
add_filter( 'rank_math/snippet/rich_snippet_product_entity', function( $entity ) {
    $gtin = get_post_meta(get_queried_object_id(), '_rp_gtin', true);
    $mpn = get_post_meta(get_queried_object_id(), '_rp_mpn', true);

    if ($gtin) {
        $entity['gtin'] = $gtin;
    }

    if ($mpn) {
        $entity['mpn'] = $mpn;
    }
    
    return $entity;
});