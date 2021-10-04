<?php
/**
 * Bundle add-to-cart button template
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/add-to-cart/bundle-button.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version 6.11.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

?>
<div class="col-auto mb-3">
    <button style="font-size: 18px;" type="submit" name="add-to-cart"
        value="<?php echo esc_attr( $product->get_id() ); ?>"
        class="single_add_to_cart_button bundle_add_to_cart_button button alt btn btn-primary px-5 font-weight-bold"><i
            class="las la-shopping-cart"></i> <?php echo $product->single_add_to_cart_text(); ?></button>
</div>