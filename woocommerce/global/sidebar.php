<?php

/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
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

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//get_sidebar( 'shop' );
//dynamic_sidebar('shop');
?>


<section class="current-vehicle-section">
    <p class="h5">Current Vehicle</p>
    <p class="current-vehicle text-bold"></p>
    <button id="clear-vehicle" class="btn btn-outline-secondary btn-sm">Clear Vehicle</button>
</section>

<section class="widget_text widget widget_custom_html">
    <p class=" h5">Filter by Vehicle</p>
    <div class="textwidget custom-html-widget">
        <?php echo facetwp_display('facet', 'year_make_model'); ?>
    </div>
</section>

<section class="widget_text widget widget_custom_html">
    <p class="h5">Filter by Category</p>
    <div class="textwidget custom-html-widget">
        <?php echo facetwp_display('facet', 'categories'); ?>
    </div>
</section>


<button id="reset-all-filters" class="btn btn-outline-secondary">Reset All Filters</button>