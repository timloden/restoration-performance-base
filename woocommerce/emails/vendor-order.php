<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<?php 
//get term array for order vendors
$term_obj_list = get_the_terms( $order->get_id(), 'vendor' );

// get just the term id from the array 
$termid  = join(', ', wp_list_pluck($term_obj_list, 'term_id'));
$vendor_account_number = get_field( 'account_number', 'vendor_' . $termid ); 
?>
<p style="font-size: 16px;"><strong>Classic Body Parts/Restoration Performance</strong></p>
<p style="font-size: 16px;">Account #: <strong><?php echo $vendor_account_number ?></strong></p>
<br />
<hr>
<p><strong>Please drop ship this order</strong></p>
<p>PO Number: <?php echo esc_html( $order->get_order_number() ); ?></p>

<p>Ship to address:</p>
<p>
    <?php 
echo $order->get_shipping_first_name() . ' ';
echo $order->get_shipping_last_name() . '<br>';

if ($order->get_shipping_company() != '') {
    echo $order->get_shipping_company() . '<br>';
}

echo $order->get_shipping_address_1() . '<br>';

if ($order->get_shipping_address_2() != '') {
    echo $order->get_shipping_address_2() . '<br>';
}

echo $order->get_shipping_city() . ' ';
echo $order->get_shipping_state() . ', ';
echo $order->get_shipping_postcode() . '<br>';

?>
</p>
<p>Phone: <?php echo $order->get_billing_phone(); ?></p>
<table>
    <tr>
        <th style="text-align:left">Qty</th>
        <th style="text-align:left">SKU</th>
        <th style="text-align:left">Product Name</th>
    </tr>
    <?php

// Get and Loop Over Order Items
foreach ( $order->get_items() as $item_id => $item ) {
    $product = $item->get_product();
    echo '<tr>';
    echo '<td>' . $item->get_quantity() . '</td>';
    echo '<td>' . $product->get_sku() . '</td>';
    echo '<td>' . $item->get_name() . '</td>';
    echo '</tr>';
 }

?>
</table>

<p>
    Thank you,<br>
    Please send confirmation to:
</p>

<p>Classic Body Parts<br>
    <a href="orders@classicbodyparts.com">orders@classicbodyparts.com</a>
</p>




<?php

do_action( 'woocommerce_email_footer', $email );