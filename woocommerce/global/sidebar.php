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

?>


<div class="row py-2 d-md-none">
    <div class="col-4 col-lg-12">
        <a class="btn btn-outline-primary d-block" data-bs-toggle="collapse" href="#brand-collapse" role="button"
            aria-expanded="false" aria-controls="brand-collapse">Brands</a>
    </div>
    <div class="col-4 col-lg-12">
        <a class="btn btn-outline-primary d-block" data-bs-toggle="collapse" href="#stock-collapse" role="button"
            aria-expanded="false" aria-controls="stock-collapse">Stock Status</a>
    </div>
    <div class="col-4 col-lg-12">
        <a class="btn btn-outline-primary d-block" data-bs-toggle="collapse" href="#category-collapse" role="button"
            aria-expanded="false" aria-controls="category-collapse">Categories</a>
    </div>
</div>

<?php if (facetwp_display('facet', 'brands')) : ?>
<section id="brand-collapse" class="widget_text widget widget_custom_html collapse">

    <div class="d-flex justify-content-between align-items-center my-2">
        <p class="h6 mb-0">Brands</p>
        <button type="button" class="btn-close text-reset d-md-none" data-bs-toggle="collapse" href="#brand-collapse"
            aria-expanded="false" aria-controls="brand-collapse"></button>
    </div>


    <div class="textwidget custom-html-widget">
        <?php echo facetwp_display('facet', 'brands'); ?>
    </div>
</section>
<?php endif; ?>

<?php if (facetwp_display('facet', 'stock_status')) : ?>
<section id="stock-collapse" class="widget_text widget widget_custom_html collapse">

    <div class="d-flex justify-content-between align-items-center my-2">
        <p class="h6 mb-0">Stock Status</p>
        <button type="button" class="btn-close text-reset d-md-none" data-bs-toggle="collapse" href="#stock-collapse"
            aria-expanded="false" aria-controls="stock-collapse"></button>
    </div>


    <div class="textwidget custom-html-widget">
        <?php echo facetwp_display('facet', 'stock_status'); ?>
    </div>
</section>
<?php endif; ?>

<?php if (facetwp_display('facet', 'categories')) : ?>
<section id="category-collapse" class="widget_text widget widget_custom_html collapse">
    <div class="d-flex justify-content-between align-items-center my-2">
        <p class="h6 mb-0">Categories</p>
        <button type="button" class="btn-close text-reset d-md-none" data-bs-toggle="collapse" href="#category-collapse"
            aria-expanded="false" aria-controls="category-collapse"></button>
    </div>
    <div class="textwidget custom-html-widget">
        <?php echo facetwp_display('facet', 'categories'); ?>
    </div>
</section>
<?php endif; ?>