<?php
/**
 * Product Bundle add-to-cart buttons wrapper template
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/add-to-cart/bundle-add-to-cart.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version 6.4.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="cart bundle_data bundle_data_<?php echo $product_id; ?>"
    data-bundle_form_data="<?php echo esc_attr( json_encode( $bundle_form_data ) ); ?>"
    data-bundle_id="<?php echo $product_id; ?>"><?php

	if ( $is_purchasable ) {

		/**
		 * 'woocommerce_before_add_to_cart_button' action.
		 */
		do_action( 'woocommerce_before_add_to_cart_button' );

		?>
    <div class="bundle_wrap">
        <div class="bundle_price h4" style="font-size: 1.75em;"></div>
        <div class="bundle_error" style="display:none">
            <div class="woocommerce-info">
                <ul class="msg"></ul>
            </div>
        </div>
        <div class="bundle_availability">test<?php
				
				// Availability html.
				echo $availability_html;

			?></div>

        <div class="bundle_button row align-items-center justify-content-center justify-content-md-start">
            <?php

				/**
				 * woocommerce_bundles_add_to_cart_button hook.
				 *
				 * @hooked wc_pb_template_add_to_cart_button - 10
				 */
				do_action( 'woocommerce_bundles_add_to_cart_button', $product );

			?></div>
        <input type="hidden" name="add-to-cart" value="<?php echo $product_id; ?>" />

    </div><?php

		/** WC Core action. */
		do_action( 'woocommerce_after_add_to_cart_button' );

	} else {

		?><div class="bundle_unavailable woocommerce-info"><?php
			echo $purchasable_notice;
		?></div><?php
	}

?>
</div>