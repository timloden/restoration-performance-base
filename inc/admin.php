<?php

//Add Search To Admin Bar
function orders_admin_bar_form() {
    global $wp_admin_bar;

    $site_url = get_site_url();
    
    if (current_user_can('administrator') || current_user_can( 'manage_woocommerce' )) {
        $wp_admin_bar->add_menu(array(
            'id' => 'orders_admin_bar_form',
            'parent' => 'top-secondary',
            'title' => '<input type="text" style="min-height: 20px; height: 20px; padding: 2px;" id="order_id">
            <button id="open_order" class="button" style="font-size: 12px; padding: 6px 5px; line-height: 1; min-height: auto; margin-top: 3px;">Open Order</button>
            <script>
              jQuery("#open_order").click(function() {
                  userEntry1 = jQuery("#order_id").val();
                  if (jQuery.isNumeric(userEntry1)) {
                      window.location.href = "' . $site_url . '" + "/wp-admin/post.php?post=" + userEntry1 + "&action=edit";
                  }
              });
              jQuery("#order_id").on("keypress", function (e) {
                if(e.which === 13){
                    userEntry1 = jQuery("#order_id").val();
                    if (jQuery.isNumeric(userEntry1)) {
                        window.location.href = "' . $site_url . '" + "/wp-admin/post.php?post=" + userEntry1 + "&action=edit";
                    }
                }
          });
              
            </script>
            '
        ));
    } 
  }
add_action('admin_bar_menu', 'orders_admin_bar_form');


add_filter('admin_title', 'my_admin_title', 10, 2);

function my_admin_title($admin_title, $title) {
    return get_bloginfo('name').' | '.$title;
}

// Invoice meta box for order

// Adding Meta container admin shop_order pages
add_action( 'add_meta_boxes', 'add_invoice_meta_boxes' );

if ( ! function_exists( 'add_invoice_meta_boxes' ) )
{
    function add_invoice_meta_boxes()
    {
        add_meta_box( 'mv_other_fields', __('Invoice Number','woocommerce'), 'invoice_field', 'shop_order', 'side', 'high' );
    }
}

// Adding Meta field in the meta container admin shop_order pages
if ( ! function_exists( 'invoice_field' ) )
{
    function invoice_field()
    {
        global $post;

        if (get_post_meta( $post->ID, '_oer_invoice_number', true )) {
            $invoice_number_field = get_post_meta( $post->ID, '_oer_invoice_number', true );
        } else {
            $invoice_number_field = get_post_meta( $post->ID, '_invoice_number', true ) ? get_post_meta( $post->ID, '_invoice_number', true ) : '' ;
        }

        $invoice_brand_field = get_post_meta( $post->ID, '_invoice_brand', true ) ? get_post_meta( $post->ID, '_invoice_brand', true ) : '';
        
        $brands = [
            'OER',
            'Dynacorn',
            'Goodmark'
        ];

        echo '<input type="hidden" name="invoice_field_nonce" value="' . wp_create_nonce() . '">
        <p>
            <input type="text" style="width:250px;" name="invoice_number" placeholder="Number" value="' . $invoice_number_field . '"></p>';

        echo '<p style="padding-bottom:5px;">
            <select type="text" style="width:250px;" name="invoice_brand">';

            foreach ($brands as $brand) {
                $selected = $invoice_brand_field == $brand ? 'selected' : '';
                echo '<option value="' . $brand .'" ' . $selected .'>' . $brand . '</option>';
            }
        echo '</select>
        </p>';

    }
}

// Save the data of the Meta field
add_action( 'save_post', 'invoice_number_save', 10, 1 );

if ( ! function_exists( 'invoice_number_save' ) )
{

    function invoice_number_save( $post_id ) {

        // We need to verify this with the proper authorization (security stuff).

        // Check if our nonce is set.
        if ( ! isset( $_POST[ 'invoice_field_nonce' ] ) ) {
            return $post_id;
        }
        $nonce = $_REQUEST[ 'invoice_field_nonce' ];

        //Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce ) ) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'page' == $_POST[ 'post_type' ] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }
        // --- Its safe for us to save the data ! --- //

        // Sanitize user input  and update the meta field in the database.
        if ($_POST[ 'invoice_number' ]) {
            update_post_meta( $post_id, '_invoice_number', $_POST[ 'invoice_number' ] );
        }
        
        if ($_POST[ 'invoice_brand' ]) {
            update_post_meta( $post_id, '_invoice_brand', $_POST[ 'invoice_brand' ] );
        }
        
    }
}

// Display field value on the order edit page (not in custom fields metabox)
add_action( 'woocommerce_admin_order_data_after_billing_address', 'invoice_display_admin_order_meta', 10, 1 );

function invoice_display_admin_order_meta($order){
    $invoice_number = get_post_meta( $order->id, '_invoice_number', true ) ? get_post_meta( $order->id, '_invoice_number', true ) : get_post_meta( $order->id, '_oer_invoice_number', true );
    $invoice_brand = get_post_meta( $order->id, '_invoice_brand', true );
    
    if ( ! empty( $invoice_number) ) {

        if ($invoice_brand == 'OER' || !$invoice_brand) {
            $invoice_url = 'https://www.oerparts.com/controller.cfm?type=order&action=getOrderDetails&invoiceId=' . $invoice_number . '&invoiceStatusId=3&ra=viewOrders';
        } else if ($invoice_brand == 'Dynacorn') {
            $invoice_url = 'http://www.dynacorn.com/ViewInvoiceDetails.aspx?id=' . $invoice_number;
        } else if ($invoice_brand == 'Goodmark') {
            $invoice_url = '#';
        } else {
            $invoice_url = '#';
        }
        
        echo '<p><a class="button" href="' . $invoice_url . '" target="_blank">Open Invoice: ' . $invoice_number . '</a></p>';
    }
}

// Adding a custom column
add_filter( 'manage_edit-shop_order_columns', 'add_example_column' );

function add_example_column($columns) {
    $columns['invoice'] = __('Invoice', 'woocommerce');
    return $columns;
}

// The column content by row
add_action( 'manage_shop_order_posts_custom_column' , 'add_example_column_contents', 10, 2 );

function add_example_column_contents( $column, $post_id ) {
    if ( 'invoice' === $column )
    {
        $order = wc_get_order( $post_id ); // Get the WC_Order instance Object
        $invoice_number = get_post_meta( $order->id, '_invoice_number', true ) ? get_post_meta( $order->id, '_invoice_number', true ) : get_post_meta( $order->id, '_oer_invoice_number', true );
        $invoice_brand = get_post_meta( $order->id, '_invoice_brand', true );

        if ($invoice_number) {
            // check for oer or legacy oer invoices that dont have a brand
            if ($invoice_brand == 'OER' || !$invoice_brand) {
                $invoice_url = 'https://www.oerparts.com/controller.cfm?type=order&action=getOrderDetails&invoiceId=' . $invoice_number . '&invoiceStatusId=3&ra=viewOrders';
            } else if ($invoice_brand == 'Dynacorn') {
                $invoice_url = 'http://www.dynacorn.com/ViewInvoiceDetails.aspx?id=' . $invoice_number;
            } else if ($invoice_brand == 'Goodmark') {
                $invoice_url = '#';
            } else {
                $invoice_url = '#';
            }
            
            echo '<p><a target="_blank" class="button wc-action-button" href="' . $invoice_url . '">' . $invoice_number . '</a></p>';
        
        }

    }
}

// The CSS styling
add_action( 'admin_head', 'add_custom_action_button_css' );

function add_custom_action_button_css() {
    $action_slug = "invoice";

    echo '<style>.wc-action-button-'.$action_slug.'::after { font-family: woocommerce !important; content: "\e029" !important; }</style>';
}

// Woocommerce MPN and GTIN

add_action('woocommerce_product_options_inventory_product_data', function() {
	woocommerce_wp_text_input([
        	'id' => '_rp_mpn',
	        'label' => __('RP MPN', 'restoration-performance-base'),
	]);

    woocommerce_wp_text_input([
        'id' => '_rp_gtin',
        'label' => __('RP GTIN', 'restoration-performance-base'),
    ]);
});

add_action('woocommerce_process_product_meta', function($post_id) {
	$product = wc_get_product($post_id);
	
    $mpn = isset($_POST['_rp_mpn']) ? $_POST['_rp_mpn'] : '';
    $product->update_meta_data('_rp_mpn', sanitize_text_field($mpn));

    $gtin = isset($_POST['_rp_gtin']) ? $_POST['_rp_gtin'] : '';
	$product->update_meta_data('_rp_gtin', sanitize_text_field($gtin));
    
	$product->save();
});