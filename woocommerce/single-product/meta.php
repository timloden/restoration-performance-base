<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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

if (! defined('ABSPATH') ) {
    exit;
}

global $product;
$brand_name = get_brand_name($product->get_id());
?>
<div class="product_meta">

    <?php if ($brand_name == 'Dynacorn'): ?>
    <div class="alert alert-info">
        <i class="las la-exclamation-circle"></i> Dynacorn parts can take up to an extra 7-10 business days to ship
    </div>
    <?php endif; ?>

    <?php do_action('woocommerce_product_meta_start'); ?>

    <?php if (wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type('variable') ) ) : ?>

    <p class="sku_wrapper mb-1"><strong><?php esc_html_e('SKU:', 'woocommerce'); ?></strong> <span
            class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span>
    </p>

    <?php endif; ?>

    <?php 
     $stock_status = $product->get_stock_status();
    
        if ( $stock_status === 'instock' ) {
        echo '<p class="mb-1"><strong>Stock Status: </strong> In Stock</p>';
        } elseif ( $stock_status === 'onbackorder' ) {
            echo '<p class="mb-1"><strong>Stock Status: </strong> On Backorder</p><p class="text-primary font-weight-bold"><i class="las la-exclamation-circle"></i> Backorder items could take up to 30 days to ship</p>';
        } else {
            echo '<p class="mb-1"><strong>Stock Status: </strong> Out of Stock</p>';
        }

    ?>


    <?php echo wc_get_product_category_list($product->get_id(), ', ', '<p class="posted_in mb-1">' . _n('<strong>Category:</strong>', '<strong>Categories:</strong>', count($product->get_category_ids()), 'woocommerce') . ' ', '</p>'); ?>

    <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<p class="tagged_as mb-1">' . _n( '<strong>Tag:</strong>', '<strong>Tags:</strong>', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</p>' ); ?>

    <?php
    $shipping_class = $product->get_shipping_class();
    if (strpos($shipping_class, '-freight')) {
        echo '<p class="mb-1"><i class="las la-shipping-fast"></i> Freight Item</p>';
    }
    ?>
    <p class="mb-1"><strong>Brand:</strong> <?php echo $brand_name; ?></p>

    <?php if( have_rows('vehicle_fitment') ): ?>
    <p class="mb-1"><strong>Fitment:</strong></p>
    <ul>

        <?php while( have_rows('vehicle_fitment') ): the_row(); 
            $vehicle = get_sub_field('vehicle');
        ?>

        <li>
            <?php echo $vehicle; ?>
        </li>

        <?php endwhile; ?>

    </ul>

    <?php endif; ?>

    <?php do_action('woocommerce_product_meta_end'); ?>
</div>