<?php

use Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController;

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

function add_invoice_meta_boxes() {
    $screen = wc_get_container()->get( CustomOrdersTableController::class )->custom_orders_table_usage_is_enabled()
		? wc_get_page_screen_id( 'shop-order' )
		: 'shop_order';

    add_meta_box(
        'order_invoice_field',
        __( 'Invoice Number', 'restoration-performance-base' ),
        'render_invoice_field',
        $screen,
        'side',
        'high'
    );

    add_meta_box(
        'order_invoice_totals',
        __( 'Order Invoice Totals', 'restoration-performance-base' ),
        'render_invoice_totals',
        $screen,
        'side',
        'high'
    );
}

function render_invoice_totals( $order_object ) {

    $order = ( $order_object instanceof WP_Post ) ? wc_get_order( $order_object->id ) : $order_object;

    if ( ! $order ) {
        return;
    }
    
    $order_id = $order->get_id();

    if ($order->get_meta( 'invoice_cogs', true )) {
        $invoice_cogs = $order->get_meta( 'invoice_cogs', true );
    } elseif ($order->get_meta( '_invoice_cogs', true ) && !preg_match('/^field_*/', $order->get_meta( '_invoice_cogs', true ))) {
        $invoice_cogs = $order->get_meta( '_invoice_cogs', true );
    } else {
        $invoice_cogs = '';
    }

    if ($order->get_meta( 'invoice_shipping', true )) {
        $invoice_shipping = $order->get_meta( 'invoice_shipping', true );
    } elseif ($order->get_meta( '_invoice_shipping', true ) && !preg_match('/^field_*/', $order->get_meta( '_invoice_shipping', true )))  {
        $invoice_shipping = $order->get_meta( '_invoice_shipping', true );
    } else {
        $invoice_shipping = '';
    }

    echo '<label>Invoice COGS</label>';
    echo '<p><input type="text" style="width:250px;" name="invoice_cogs" placeholder="" value="' . $invoice_cogs . '"></p>';
    echo '<label>Invoice Shipping</label>';
    echo '<p><input type="text" style="width:250px;" name="invoice_shipping" placeholder="" value="' . $invoice_shipping . '"></p>';

}

function render_invoice_field( $order_object ) {

    $order = ( $order_object instanceof WP_Post ) ? wc_get_order( $order_object->id ) : $order_object;

    if ( ! $order ) {
        return;
    }
    
    $order_id = $order->get_id();

    if ($order->get_meta( $order_id, '_oer_invoice_number', true )) {
        $invoice_number_field = $order->get_meta( '_oer_invoice_number', true );
    } else {
        $invoice_number_field = $order->get_meta( '_invoice_number', true ) ? $order->get_meta( '_invoice_number', true ) : '' ;
    }

    $invoice_brand_field = $order->get_meta( '_invoice_brand', true ) ? $order->get_meta( '_invoice_brand', true ) : '';
    
    $brands = [
        'OER',
        'Dynacorn',
        'Goodmark'
    ];

    echo '<p>
        <input type="text" style="width:250px;" name="invoice_number" placeholder="" value="' . $invoice_number_field . '"></p>';

    echo '<p style="padding-bottom:5px;">
        <select type="text" style="width:250px;" name="invoice_brand">';

        foreach ($brands as $brand) {
            $selected = $invoice_brand_field == $brand ? 'selected' : '';
            echo '<option value="' . $brand .'" ' . $selected .'>' . $brand . '</option>';
        }
    echo '</select>
    </p>';

}


// Save the data of the Meta field

add_action( 'woocommerce_process_shop_order_meta', 'invoice_number_save' );

function invoice_number_save( $order_id ) {

    $order = wc_get_order( $order_id );

    if (isset($_POST['invoice_number'])) {
        $order->update_meta_data( '_invoice_number', $_POST['invoice_number'] );
    }

    if (isset($_POST[ 'invoice_brand' ])) {
        $order->update_meta_data( '_invoice_brand', $_POST[ 'invoice_brand' ] );
    }

    if (isset($_POST[ 'invoice_cogs' ])) {
        if ($order->get_meta('_invoice_cogs', true)) {
            $order->update_meta_data( '_invoice_cogs', $_POST[ 'invoice_cogs' ] );
        } else {
            $order->add_meta_data( '_invoice_cogs', $_POST[ 'invoice_cogs' ] );
        }
    }

    if (isset($_POST[ 'invoice_shipping' ])) {
        if ($order->get_meta('_invoice_shipping', true)) {
            $order->update_meta_data( '_invoice_shipping', $_POST[ 'invoice_shipping' ] );
        } else {
            $order->add_meta_data( '_invoice_shipping', $_POST[ 'invoice_cogs' ] );
        }
    }

    $order->save_meta_data();
    
}


// Display field value on the order edit page (not in custom fields metabox)
add_action( 'woocommerce_admin_order_data_after_billing_address', 'invoice_display_admin_order_meta', 10, 1 );

function invoice_display_admin_order_meta($order) {
    $order_id = $order->get_ID();

    $invoice_number = $order->get_meta( '_invoice_number', true ) ? $order->get_meta( '_invoice_number', true ) : $order->get_meta( '_oer_invoice_number', true );
    $invoice_brand = $order->get_meta( '_invoice_brand', true );
    
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
    
    $order = wc_get_order( $post_id ); // Get the WC_Order instance Object
    $order_id = $order->get_ID();

    if ( 'invoice' === $column ) {
        
        $invoice_number = $order->get_meta( 'invoice_number', true ) ? $order->get_meta( 'invoice_number', true ) : $order->get_meta( 'oer_invoice_number', true );
        $invoice_brand = $order->get_meta( 'invoice_brand', true );

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