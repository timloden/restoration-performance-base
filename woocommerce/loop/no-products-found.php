<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

$vehicle = isset($_COOKIE['vehicle']) ? $_COOKIE['vehicle'] : '';
if (wc_get_loop_prop( 'total' ) === 0) {
    echo '<style>#ymm-bar {display: none;}</style>';
    echo '<div class="container py-3 py-lg-5">';
}
?>
<?php if (is_product_tag('special')) :?>

<h2 class="pb-1 text-center">Sorry, we don&apos;t have any items on special at the moment</h2>

<p class="mb-5 pb-5 text-center">Be sure to check back regularly as we update our specials often!</p>

<?php else : ?>
<h3 class="pb-3">Sorry, no results were found for
    "<?php echo get_search_query(); ?>"<?php if ($vehicle) { echo ' in a ' . $vehicle; } ?></h3>
<div class="row">
    <div class="col-12 col-lg-8 mb-3">
        <div>
            <?php if ($vehicle) : ?>
            <p><a class="fw-bold" href="http://classicbodyparts.local/shop">Browse
                    all products for your vehicle</a> or try clearing your vehicle and searching again:</p>
            <p><span id="no-results-vehicle" class="fw-bold"><?php echo $vehicle; ?></span> <button id="remove-vehicle"
                    class="btn btn-sm btn-outline-primary ms-1">Clear Vehicle</button></p>
            <?php endif; ?>
            <form action="/" method="get" class="form">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Search by Vehicle, Part Number..."
                        aria-label="Search" name="s" id="search" value="<?php the_search_query(); ?>">

                    <button class="btn btn-secondary" type="submit">Search</button>
                </div>
                <input type="hidden" name="post_type" value="product" />
            </form>
        </div>

    </div>
    <div class="col-12 col-lg-4">
        <p class="fw-bold">Search Tips</p>
        <ul>
            <li>Check for typos or spelling errors</li>
            <li>Simplify your search - try using fewer words</li>
            <li>Try looking up by part number</li>
            <li>Still cant find what your looking for? <a href="/contact">Contact us for more help</a></li>
        </ul>
    </div>
</div>

<?php 
if (wc_get_loop_prop( 'total' ) === 0) {
    echo '</div>';
}
endif; ?>