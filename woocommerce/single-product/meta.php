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
$dynacorn_message = get_field('dynacorn_shipping_notice', 'option');
?>
<div class="product_meta border-top pt-3">

    <?php if ($brand_name == 'Dynacorn' && $dynacorn_message): ?>
    <div class="alert alert-info">
        <i class="las la-exclamation-circle"></i> <?php echo $dynacorn_message; ?>
    </div>
    <?php endif; ?>

    <?php do_action('woocommerce_product_meta_start'); ?>

    <?php echo wc_get_product_category_list($product->get_id(), ', ', '<p class="posted_in mb-3">' . _n('', '', count($product->get_category_ids()), 'woocommerce') . ' ', '</p>'); ?>

    <?php if( have_rows('vehicle_fitment') ): 
        $count = 0;
        ?>
    <p class="mb-1"><strong>Vehicle Fitment:</strong></p>
    <ul class="mb-1">
        <?php while( have_rows('vehicle_fitment') && $count < 5 ): the_row(); 
            $vehicle = get_sub_field('vehicle');
            $total_count = count(get_field('vehicle_fitment'));
        ?>

        <li>
            <?php echo $vehicle; ?>
        </li>

        <?php 
        $count++;
        endwhile; 
        ?>
    </ul>

    <?php 
    if ($total_count > 5) {
        echo '<a class="ml-4" id="show-fitment" href="#">' . $total_count . ' total vehicles, click here to view all</a>';
    }
    endif; ?>

    <?php do_action('woocommerce_product_meta_end'); ?>
</div>