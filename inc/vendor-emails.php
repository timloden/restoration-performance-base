<?php
// email - add send vendor order email to order actions

function add_vendor_email_order_meta_box_action( $actions ) {
    global $theorder;

    // bail if the order has been paid for or this action has been run
    if ( get_post_meta( $theorder->get_id(), '_wc_order_marked_printed_for_packaging', true ) ) {
        return $actions;
    }

    // add "mark printed" custom action
    $actions['wc_vendor_email_action'] = __( 'Send vendor order email', 'my-textdomain' );
    return $actions;
}
add_action( 'woocommerce_order_actions', 'add_vendor_email_order_meta_box_action' );


// email - add note that vendor email was sent

function vendor_email_order_note( $order ) {
    // add the order note
    // translators: Placeholders: %s is a user's display name

    $message = sprintf( __( 'Vendor order email sent by %s.', 'my-textdomain' ), wp_get_current_user()->display_name );
    $order->add_order_note( $message );
    
    // add the flag
    //update_post_meta( $order->id, '_wc_order_marked_printed_for_packaging', 'yes' );
}
add_action( 'woocommerce_order_action_wc_vendor_email_action', 'vendor_email_order_note' );


// email - send dropship email
  
function bbloomer_status_custom_notification( $order ) {

    //get term array for order vendors
    $term_obj_list = get_the_terms( $order->get_id(), 'vendor' );

    // get just the term id from the array 
    $termid  = join(', ', wp_list_pluck($term_obj_list, 'term_id'));
  
    // get the acf field for the email from that term
    $vendor_email = get_field( 'contact_email', 'vendor_' . $termid ); 
    
    // MMR01
    $vendor_account_number = get_field( 'account_number', 'vendor_' . $termid ); 

    // check if we have a vendor
    if ($vendor_email != '') {
        $recipient = $vendor_email;
    } else {
        $recipient = wp_get_current_user()->user_email;
    }

    // load the mailer class
    $mailer = WC()->mailer();

    $subject = 'Classic Body Parts/Restoration Performance Order #' . esc_html( $order->get_order_number() );
    $content = iconic_get_processing_notification_content( $order, $mailer , $subject );
    $headers = "Content-Type: text/html\r\n";
 
    $mailer->send( $recipient, $subject, $content, $headers );
      
}

add_action( 'woocommerce_order_action_wc_vendor_email_action', 'bbloomer_status_custom_notification', 20, 2 );

function iconic_get_processing_notification_content( $order, $mailer, $heading = false ) {
 
    $template = 'emails/vendor-order.php';
 
    return wc_get_template_html( $template, array(
        'order'         => $order,
        'email_heading' => $heading,
        'sent_to_admin' => true,
        'plain_text'    => false,
        'email'         => $mailer
    ) );
}