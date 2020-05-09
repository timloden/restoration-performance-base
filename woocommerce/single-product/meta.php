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
?>
<div class="product_meta">

    <?php do_action('woocommerce_product_meta_start'); ?>

    <?php if (wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type('variable') ) ) : ?>

    <p class="sku_wrapper mb-1"><strong><?php esc_html_e('SKU:', 'woocommerce'); ?></strong> <span
            class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span>
    </p>

    <?php endif; ?>

    <?php echo wc_get_product_category_list($product->get_id(), ', ', '<p class="posted_in mb-1">' . _n('<strong>Category:</strong>', '<strong>Categories:</strong>', count($product->get_category_ids()), 'woocommerce') . ' ', '</p>'); ?>

    <?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<p class="tagged_as mb-1">' . _n( '<strong>Tag:</strong>', '<strong>Tags:</strong>', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</p>' ); ?>

    <?php
    $shipping_class = $product->get_shipping_class();
    if (strpos($shipping_class, '-freight')) {
        echo '<p class="mb-1"><i class="las la-shipping-fast"></i> Freight Item</p>';
    }
    ?>
    <p class="mb-1"><strong>Brand:</strong> <?php echo get_brand_name($product->get_id()); ?></p>

    <?php if( have_rows('vehicle_fitment') ): ?>
    <p class="mb-1"><strong>Fitment:</strong></p>
    <ul>

        <?php while( have_rows('vehicle_fitment') ): the_row(); 

            // vars
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