<?php
// search by sku
// add_filter( "wpo_custom_product_search", function($results,$query_args,$term) {
//     global $wpdb;
//     $term = esc_sql($wpdb->esc_like($term));
//     $results = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_type='product' AND post_status='publish' AND post_title LIKE '%{$term}%'  
//                               OR ID IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value LIKE '%{$term}%' )
//                               ORDER BY post_title LIMIT 25");
//     return $results;
//    },10,3);