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

// OER invoice meta box for order

// Adding Meta container admin shop_order pages
add_action( 'add_meta_boxes', 'add_OER_meta_boxes' );

if ( ! function_exists( 'add_OER_meta_boxes' ) )
{
    function add_OER_meta_boxes()
    {
        add_meta_box( 'mv_other_fields', __('OER Invoice Number','woocommerce'), 'oer_invoice_field', 'shop_order', 'side', 'high' );
    }
}

// Adding Meta field in the meta container admin shop_order pages
if ( ! function_exists( 'oer_invoice_field' ) )
{
    function oer_invoice_field()
    {
        global $post;

        $meta_field_data = get_post_meta( $post->ID, '_oer_invoice_number', true ) ? get_post_meta( $post->ID, '_oer_invoice_number', true ) : '';

        echo '<input type="hidden" name="oer_invoice_field_nonce" value="' . wp_create_nonce() . '">
        <p style="border-bottom:solid 1px #eee;padding-bottom:13px;">
            <input type="text" style="width:250px;" name="oer_invoice_number" placeholder="' . $meta_field_data . '" value="' . $meta_field_data . '"></p>';

    }
}

// Save the data of the Meta field
add_action( 'save_post', 'oer_invoice_number_save', 10, 1 );

if ( ! function_exists( 'oer_invoice_number_save' ) )
{

    function oer_invoice_number_save( $post_id ) {

        // We need to verify this with the proper authorization (security stuff).

        // Check if our nonce is set.
        if ( ! isset( $_POST[ 'oer_invoice_field_nonce' ] ) ) {
            return $post_id;
        }
        $nonce = $_REQUEST[ 'oer_invoice_field_nonce' ];

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
        update_post_meta( $post_id, '_oer_invoice_number', $_POST[ 'oer_invoice_number' ] );
    }
}

// Display field value on the order edit page (not in custom fields metabox)
add_action( 'woocommerce_admin_order_data_after_billing_address', 'oer_invoice_display_admin_order_meta', 10, 1 );

function oer_invoice_display_admin_order_meta($order){
    $oer_invoice_number = get_post_meta( $order->id, '_oer_invoice_number', true );
    if ( ! empty( $oer_invoice_number) ) {
        echo '<p><a class="button" href="https://www.oerparts.com/controller.cfm?type=order&action=getOrderDetails&invoiceId=' . $oer_invoice_number . '&invoiceStatusId=3&ra=viewOrders" target="_blank">Open OER Invoice: ' . $oer_invoice_number . '</a></p>';
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
        $oer_invoice_number = get_post_meta( $order->id, '_oer_invoice_number', true );

        if ($oer_invoice_number) {
        echo '<p><a target="_blank" class="button wc-action-button" href="https://www.oerparts.com/controller.cfm?type=order&action=getOrderDetails&invoiceId=' . $oer_invoice_number . '&invoiceStatusId=3&ra=viewOrders">' . $oer_invoice_number . '</a></p>';
        }

    }
}

// The CSS styling
add_action( 'admin_head', 'add_custom_action_button_css' );

function add_custom_action_button_css() {
    $action_slug = "invoice";

    echo '<style>.wc-action-button-'.$action_slug.'::after { font-family: woocommerce !important; content: "\e029" !important; }</style>';
}