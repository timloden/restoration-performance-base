<?php

// waitlist - Enable for products on backorder

add_filter( 'wcwl_enable_waitlist_for_backorder_products', 'wcwl_force_backorder_waitlist_true' );

function wcwl_force_backorder_waitlist_true( $product_id ) {
    return true;
}

// waitlist - dont send out email when on backorder

add_filter( 'wcwl_automatic_mailouts_are_disabled', '__return_true' );

// waitlist - Update message 

add_filter( 'wcwl_join_waitlist_message_text', 'change_waitlist_message_text' );

function change_waitlist_message_text( $text ) {
    return __( '<strong>This item is currently on backorder</strong><br>Enter your email below to be notified when it is back in stock!' );
}

add_action( 'woocommerce_product_set_stock_status', 'wcwl_perform_custom_mailout', 10, 2 );

add_action( 'woocommerce_variation_set_stock_status', 'wcwl_perform_custom_mailout', 10, 2 );

function wcwl_perform_custom_mailout( $product_id, $stock_status ) {
  $product = wc_get_product( $product_id );
  if ( ! $product || 'publish' !== get_post_status( $product->get_id() ) ) {
    return;
  }
  if ( $product->is_type( 'variation' ) && 'publish' !== get_post_status( $product->get_parent_id() ) ) {
    return;
  }
  // Check product has a status of "instock"
  if ( 'instock' === $stock_status ) {
    $product->waitlist = new Pie_WCWL_Waitlist( $product );
    global $woocommerce;
    $woocommerce->mailer();
    foreach ( $product->waitlist->waitlist as $user => $date_added ) {
      if ( ! is_email( $user ) ) {
        $user_object = get_user_by( 'id', $user );
        if ( $user_object ) {
          $user = $user_object->user_email;
        }
      }
      if ( get_transient( 'wcwl_done_mailout_' . $user . '_' . $product_id ) ) {
        continue;
      }
      $timeout = apply_filters( 'wcwl_notification_limit_time', 10 );
      set_transient( 'wcwl_done_mailout_' . $user . '_' . $product_id, 'yes', $timeout );
      require_once WP_PLUGIN_DIR . '/woocommerce-waitlist/classes/class-pie-wcwl-waitlist-mailout.php';
      $mailer = new Pie_WCWL_Waitlist_Mailout();
      $mailer->trigger( $user, $product_id );
      $product->waitlist->unregister_user( $user );
    }
  }
}

add_action( 'wcwl_after_add_email_to_waitlist', 'add_waitlist_to_newsletter', 30, 2);

function add_waitlist_to_newsletter( $product_id, $email ) {
	
	$apiKey = 'api-key: ' . get_field('sendinblue_api_key', 'option');
	$listId = (int)get_field('sendinblue_list_id', 'option');
	
	$payload = json_encode(array(
		'listIds' => array(
			$listId
	), 
	'updateEnabled' => false,
	'email' => $email
	));
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,            "https://api.sendinblue.com/v3/contacts" );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt($ch, CURLOPT_POST,           1 );
	curl_setopt($ch, CURLOPT_POSTFIELDS,     $payload ); 
	curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json', $apiKey)); 

	$result = curl_exec ($ch);
}