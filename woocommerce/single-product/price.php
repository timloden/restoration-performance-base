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
$product_id = $product->get_id();
$stock_status = $product->get_stock_status();
$shipping_class = $product->get_shipping_class();

$brand = wp_get_object_terms( $product_id, 'pwb-brand' );
$shipping_time = '';

if($brand) {
    $term = 'term_' . $brand[0]->term_id;
    
    if (strpos($shipping_class, 'ground') !== false && get_field('ground_notice', $term) && $stock_status == 'instock') {
        $shipping_time = ' (' . get_field('ground_notice', $term) . ')';
    }
    
    if (strpos($shipping_class, '-freight') !== false && get_field('freight_notice', $term) && $stock_status == 'instock') {
        $shipping_time = ' (' . get_field('freight_notice', $term) . ')';
    }

    if (strpos($shipping_class, 'windshield') !== false && get_field('freight_notice', $term) && $stock_status == 'instock') {
        $shipping_time = ' (' . get_field('freight_notice', $term) . ')';
    }
    
}

$current_brand = get_brand_name($product->get_id());

if ($stock_status == 'instock') {
    $stock = 'In Stock';
} elseif ($stock_status == 'onbackorder') {
    $stock = 'Backordered <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="Backordered items could take up to or over 30 days to ship."><i class="las la-exclamation-circle text-primary"></i></a>';
} else {
    $stock = 'Out of Stock';
}

if ($shipping_class == 'bundle' || $shipping_class == 'heavy-freight') {
    $shipping = 'Heavy Freight';
} elseif (strpos($shipping_class, '-freight') || $shipping_class == 'windshield') {
    $shipping = 'Freight';
} elseif ($shipping_class == 'free-shipping' || $shipping_class == 'right-stuff') {
    $shipping = 'FREE SHIPPING';
} elseif ($shipping_class == 'ground-oversized' || $shipping_class == 'ground-oversized-dynacorn') {
    $shipping = 'Ground - Oversized';
} else {
    $shipping = 'Ground';
}
?>
<div class="d-flex align-items-center py-3 flex-wrap">
    <div class="col-6 col-md-auto text-center text-md-left product-price-wrapper">
        <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?> h4 mb-0 pe-md-3 product-price"
            style="font-size: 1.75em;">
            <?php echo $product->get_price_html(); ?></p>
    </div>
    <div class="col-6 col-md-auto product-stock-wrapper text-center text-md-start">
        <div class="ps-md-3">
            <p class="mb-0 product-stock fw-bold" style="font-size: 1.75em; line-height: 1;">
                <?php echo $stock; ?></p>
        </div>
    </div>
    <div class="col-12 mt-2 text-center text-md-start">
        <span class="" style="font-size: 12px;">Shipping:</span>
        <p class="mb-0 product-shipping" style="font-size: 1em; line-height: 1;">
            <span class="fw-bold"><?php echo $shipping; ?></span><?php echo $shipping_time; ?>
        </p>
    </div>
</div>