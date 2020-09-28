<?php


// product - remove related products

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


// product - image modification

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

add_action( 'woocommerce_before_single_product_summary', 'custom_show_product_images', 20);

function custom_show_product_images() {
    global $product;
    $attachment_ids = $product->get_gallery_image_ids();
    $image_id = $product->get_image_id();
    if ($image_id) {
        echo wp_get_attachment_image( $image_id, 'full', "", array( "class" => "img-fluid" ) );
    } else {
        echo '<img class="img-fluid" src="' . get_template_directory_uri() . '/assets/images/woocommerce-placeholder.png">';
    }
    
} 

// product - remove additional information tab

add_filter( 'woocommerce_product_tabs', 'remove_product_tabs', 9999 );
  
function remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] ); 
    return $tabs;
}