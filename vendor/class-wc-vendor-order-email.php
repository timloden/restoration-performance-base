<?php
/**
 * An email to ask the vendor to check availability of a booking.
 *
 * @extends \WC_Email
 *
 * Code copied from: https://www.skyverge.com/blog/how-to-add-a-custom-woocommerce-email/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
class WC_Vendor_Order_Email extends WC_Email {
/**
 * Set email defaults
 *
 * @since 0.1
 */
public function __construct() {
    // set ID, this simply needs to be a unique name
    $this->id = 'wc_vendor_check_availability';
 
    // this is the title in WooCommerce Email settings
    $this->title = 'Vendor Check Availability';
 
    // this is the description in WooCommerce email settings
    $this->description = 'Send email to the vendor when an order with a booking calendar is received. Vendor will check availability.';
 
    // these are the default heading and subject lines that can be overridden using the settings
    $this->heading = 'Vendor Check Availability';
    $this->subject = '[{site_title}] Order: ({order_number}) - Check Date Availability for {product_title}';

    // Booking information for the product.
    // TODO: Retrieve this info from the order meta.
    //$this->product_name = 'NONE';
    //$this->booking_info = 'NONE';
    

    // these define the locations of the templates that this email should use, we'll just use the new order template since this email is similar
    $this->template_html  = 'emails/vendor-order.php';
    // Don't bother with a plain email - being lazy.
    $this->template_plain  = 'emails/vendor-order.php';
    //$this->template_plain = 'emails/plain/admin-new-order.php';;
 
    // Trigger when a new order is received.
    //add_action( 'woocommerce_order_status_processing', array( $this, 'trigger' ) );
 
    // Call parent constructor to load any other defaults not explicity defined here
    parent::__construct();
 
    // this sets the recipient to the settings defined below in init_form_fields()
    $this->recipient = 'tim@restorationperformance.com';  // TODO: Replace with vendor information.
}
 
/**
 * get_content_html function.
 *
 * @since 0.1
 * @return string
 */
public function get_content_html() {
    return wc_get_template_html( $this->template_html, array(
	    'order'		=> $this->object,
	    'email_heading'	=> $this->get_heading(),
	    'sent_to_admin'	=> true,
	    'plain_text'	=> false,
	    'email'		=> $this,
	    // Send additional info to the email template.
	    //'booking_info'	=> $this->booking_info,
	    //'product_name'	=> $this->product_name,
    ) );
}


function get_heading() {
	return $this->format_string( $this->heading );
} 
 
 
/**
 * get_content_plain function.
 *
 * @since 0.1
 * @return string
 */
public function get_content_plain() {
    return wc_get_template_html( $this->template_plain, array(
	    'order'		=> $this->object,
	    'email_heading'	=> $this->get_heading(),
	    'sent_to_admin'	=> true,
	    'plain_text'	=> false,
	    'email'		=> $this,
	    //'booking_info'	=> $this->booking_info,
	    //'product_name'	=> $this->product_name,
    ) ); 
}


/**
 * Initialize Settings Form Fields
 *
 * @since 0.1
 */
public function init_form_fields() {
 
    $this->form_fields = array(
        'enabled'    => array(
            'title'   => 'Enable/Disable',
            'type'    => 'checkbox',
            'label'   => 'Enable this email notification',
            'default' => 'yes'
        ),
        'recipient'  => array(
            'title'       => 'Recipient(s)',
            'type'        => 'text',
            'description' => sprintf( 'Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', esc_attr( get_option( 'admin_email' ) ) ),
            'placeholder' => '',
            'default'     => ''
        ),
        'subject'    => array(
            'title'       => 'Subject',
            'type'        => 'text',
            'description' => sprintf( 'This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', $this->subject ),
            'placeholder' => '',
            'default'     => ''
        ),
        'heading'    => array(
            'title'       => 'Email Heading',
            'type'        => 'text',
            'description' => sprintf( __( 'This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.' ), $this->heading ),
            'placeholder' => '',
            'default'     => ''
        ),
        'email_type' => array(
            'title'       => 'Email type',
            'type'        => 'select',
            'description' => 'Choose which format of email to send.',
            'default'     => 'html',
            'class'       => 'email_type',
            'options'     => array(
            'plain'     => 'Plain text',
            'html'      => 'HTML', 'woocommerce',
            'multipart' => 'Multipart', 'woocommerce',
            )
        )
    );
}

} // end \WC_Check_Availability_Email class