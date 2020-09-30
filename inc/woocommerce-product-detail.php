<?php


remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25);


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
    unset( $tabs['reviews'] ); 
    return $tabs;
}

// add vehicle fitment tab

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );

function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
	if(have_rows('vehicle_fitment')) {

        $tabs['fitment_tab'] = array(
		'title' 	=> __( 'Vehicle Fitment', 'woocommerce' ),
		'priority' 	=> 10,
		'callback' 	=> 'vehicle_fitment'
        );
    }
        

	return $tabs;

}

function vehicle_fitment() {
    
    echo '<p class="mb-1"><strong>Fitment:</strong></p>';
    echo '<ul>';
    
    while( have_rows('vehicle_fitment') ): the_row(); 
                $vehicle = get_sub_field('vehicle');
    
            echo '<li>' . $vehicle . '</li>';
    
    endwhile;
    
    echo '</ul>';

}