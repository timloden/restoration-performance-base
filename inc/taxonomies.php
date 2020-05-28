<?php

/**
 * Registers the `ymm` taxonomy,
 * for use with 'product'.
 */
function ymm_init()
{
    register_taxonomy(
        'ymm', array( 'product' ), array(
        'hierarchical'      => true,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => true,
        'capabilities'      => array(
        'manage_terms'  => 'edit_posts',
        'edit_terms'    => 'edit_posts',
        'delete_terms'  => 'edit_posts',
        'assign_terms'  => 'edit_posts',
        ),
        'labels'            => array(
        'name'                       => __('Year / Make / Model', 'YOUR-TEXTDOMAIN'),
        'singular_name'              => _x('Year / Make / Model', 'taxonomy general name', 'YOUR-TEXTDOMAIN'),
        'search_items'               => __('Search YMM', 'YOUR-TEXTDOMAIN'),
        'popular_items'              => __('Popular YMM', 'YOUR-TEXTDOMAIN'),
        'all_items'                  => __('All', 'YOUR-TEXTDOMAIN'),
        'parent_item'                => __('Parent', 'YOUR-TEXTDOMAIN'),
        'parent_item_colon'          => __('Parent:', 'YOUR-TEXTDOMAIN'),
        'edit_item'                  => __('Edit YMM', 'YOUR-TEXTDOMAIN'),
        'update_item'                => __('Update YMM', 'YOUR-TEXTDOMAIN'),
        'view_item'                  => __('View YMM', 'YOUR-TEXTDOMAIN'),
        'add_new_item'               => __('Add New', 'YOUR-TEXTDOMAIN'),
        'new_item_name'              => __('New YMM', 'YOUR-TEXTDOMAIN'),
        'separate_items_with_commas' => __('Separate ymms with commas', 'YOUR-TEXTDOMAIN'),
        'add_or_remove_items'        => __('Add or remove ymms', 'YOUR-TEXTDOMAIN'),
        'choose_from_most_used'      => __('Choose from the most used ymms', 'YOUR-TEXTDOMAIN'),
        'not_found'                  => __('No ymms found.', 'YOUR-TEXTDOMAIN'),
        'no_terms'                   => __('No ymms', 'YOUR-TEXTDOMAIN'),
        'menu_name'                  => __('Year / Make / Model', 'YOUR-TEXTDOMAIN'),
        'items_list_navigation'      => __('Ymms list navigation', 'YOUR-TEXTDOMAIN'),
        'items_list'                 => __('Ymms list', 'YOUR-TEXTDOMAIN'),
        'most_used'                  => _x('Most Used', 'ymm', 'YOUR-TEXTDOMAIN'),
        'back_to_items'              => __('&larr; Back to Ymms', 'YOUR-TEXTDOMAIN'),
        ),
        'show_in_rest'      => true,
        'rest_base'         => 'ymm',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
        ) 
    );

}
add_action('init', 'ymm_init');

/**
 * Sets the post updated messages for the `ymm` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `ymm` taxonomy.
 */
function ymm_updated_messages( $messages )
{

    $messages['ymm'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => __('Ymm added.', 'YOUR-TEXTDOMAIN'),
    2 => __('Ymm deleted.', 'YOUR-TEXTDOMAIN'),
    3 => __('Ymm updated.', 'YOUR-TEXTDOMAIN'),
    4 => __('Ymm not added.', 'YOUR-TEXTDOMAIN'),
    5 => __('Ymm not updated.', 'YOUR-TEXTDOMAIN'),
    6 => __('Ymms deleted.', 'YOUR-TEXTDOMAIN'),
    );

    return $messages;
}
add_filter('term_updated_messages', 'ymm_updated_messages');


/**
 * Registers the `vendor` taxonomy,
 * for use with 'product'.
 */
function vendor_init()
{
    register_taxonomy(
        'vendor', array( 'product', 'shop_order' ), array(
        'hierarchical'      => false,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => true,
        'capabilities'      => array(
        'manage_terms'  => 'edit_posts',
        'edit_terms'    => 'edit_posts',
        'delete_terms'  => 'edit_posts',
        'assign_terms'  => 'edit_posts',
        ),
        'labels'            => array(
        'name'                       => __('Vendor', 'YOUR-TEXTDOMAIN'),
        'singular_name'              => _x('Vendor', 'taxonomy general name', 'YOUR-TEXTDOMAIN'),
        'search_items'               => __('Search Vendors', 'YOUR-TEXTDOMAIN'),
        'popular_items'              => __('Popular Vendors', 'YOUR-TEXTDOMAIN'),
        'all_items'                  => __('All', 'YOUR-TEXTDOMAIN'),
        'parent_item'                => __('Parent', 'YOUR-TEXTDOMAIN'),
        'parent_item_colon'          => __('Parent:', 'YOUR-TEXTDOMAIN'),
        'edit_item'                  => __('Edit Vendor', 'YOUR-TEXTDOMAIN'),
        'update_item'                => __('Update Vendor', 'YOUR-TEXTDOMAIN'),
        'view_item'                  => __('View Vendor', 'YOUR-TEXTDOMAIN'),
        'add_new_item'               => __('Add New', 'YOUR-TEXTDOMAIN'),
        'new_item_name'              => __('New Vendor', 'YOUR-TEXTDOMAIN'),
        'separate_items_with_commas' => __('Separate Vendors with commas', 'YOUR-TEXTDOMAIN'),
        'add_or_remove_items'        => __('Add or remove Vendors', 'YOUR-TEXTDOMAIN'),
        'choose_from_most_used'      => __('Choose from the most used Vendors', 'YOUR-TEXTDOMAIN'),
        'not_found'                  => __('No Vendors found.', 'YOUR-TEXTDOMAIN'),
        'no_terms'                   => __('No Vendors', 'YOUR-TEXTDOMAIN'),
        'menu_name'                  => __('Vendors', 'YOUR-TEXTDOMAIN'),
        'items_list_navigation'      => __('Vendor list navigation', 'YOUR-TEXTDOMAIN'),
        'items_list'                 => __('Vendor list', 'YOUR-TEXTDOMAIN'),
        'most_used'                  => _x('Most Used', 'ymm', 'YOUR-TEXTDOMAIN'),
        'back_to_items'              => __('&larr; Back to Vendors', 'YOUR-TEXTDOMAIN'),
        ),
        'show_in_rest'      => true,
        'rest_base'         => 'vendor',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
        ) 
    );

}
add_action('init', 'vendor_init');

/**
 * Sets the post updated messages for the `ymm` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `ymm` taxonomy.
 */
function vendor_updated_messages( $messages )
{

    $messages['ymm'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => __('Vendor added.', 'YOUR-TEXTDOMAIN'),
    2 => __('Vendor deleted.', 'YOUR-TEXTDOMAIN'),
    3 => __('Vendor updated.', 'YOUR-TEXTDOMAIN'),
    4 => __('Vendor not added.', 'YOUR-TEXTDOMAIN'),
    5 => __('Vendor not updated.', 'YOUR-TEXTDOMAIN'),
    6 => __('Vendors deleted.', 'YOUR-TEXTDOMAIN'),
    );

    return $messages;
}
add_filter('term_updated_messages', 'vendor_updated_messages');