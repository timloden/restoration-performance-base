<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$stock_status = $product->get_stock_status();
if ( 'instock' == $stock_status) {
	$stock = 'In Stock';
} else {
	$stock = 'Backordered';
}
?>
<p class="mb-2">Brand: <?php echo get_brand_name($product->get_id()); ?></p>
<div class="d-flex mb-2">
    <div class="col border-right">
        <?php if ( $price_html = $product->get_price_html() ) : ?>
        <p class="price text-center mb-0"><?php echo $price_html; ?></p>
        <?php endif; ?>
    </div>
    <div class="col">
        <p class="text-center mb-0"><?php echo $stock; ?></p>
    </div>
</div>
<p>SKU: <?php echo $product->get_sku(); ?></p>