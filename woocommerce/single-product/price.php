<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$stock_status = $product->get_stock_status();

if ($stock_status == 'instock') {
    $stock = 'In Stock';
} elseif ($stock_status == 'onbackorder') {
    $stock = 'Backordered';
} else {
    $stock = 'Out of Stock';
}

$shipping_class = $product->get_shipping_class();

if (strpos($shipping_class, '-freight')) {
    $shipping = 'Freight';
} elseif ($shipping_class == 'bundle' || $shipping_class == 'heavy-freight') {
    $shipping = 'Heavy Freight';
} elseif ($shipping_class == 'free-shipping' || $shipping_class == 'right-stuff') {
    $shipping = 'FREE SHIPPING';
} elseif ($shipping_class == 'ground-oversized') {
    $shipping = 'Ground (Oversized)';
} else {
    $shipping = 'Ground';
}
?>
<div class="d-flex align-items-center py-3 flex-wrap">
    <div class="col-12 col-lg-auto text-center text-md-left px-0 pr-md-2 pb-3 pb-lg-0">
        <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?> h4 mb-0 pr-3 product-price"
            style="font-size: 1.75em;">
            <?php echo $product->get_price_html(); ?></p>
    </div>
    <div class="col-6 col-md-auto pl-0 pl-md-2 border-end product-stock-wrapper text-center text-md-left">
        <div class="d-flex w-100 justify-content-center">
            <div>
                <span class="pl-md-3" style="font-size: 12px;">Stock:</span>
                <p class="mb-0 px-3 product-stock font-weight-bold" style="font-size: 1em; line-height: 1;">
                    <?php echo $stock; ?></p>
            </div>
        </div>

    </div>
    <div class="col-6 col-md-auto pr-0 pr-md-2 text-center text-md-left">
        <span class="pl-md-3" style="font-size: 12px;">Shipping:</span>
        <p class="mb-0 pl-md-3 product-shipping font-weight-bold" style="font-size: 1em; line-height: 1;">
            <?php echo $shipping; ?>
        </p>
    </div>
</div>
<?php  
if ( $stock_status === 'onbackorder' ) {
        echo '<p class="text-primary font-weight-bold"><i class="las la-exclamation-circle"></i> Backordered items could take over 30 days to ship</p>';
    }
?>