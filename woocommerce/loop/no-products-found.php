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
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

if(isset($_COOKIE['vehicle'])){
    $vehicle = $_COOKIE['vehicle'];
}
?>
<div class="container py-5">
    <h2 class="pb-3">Sorry, no results were found for "<?php echo get_search_query(); ?>"</h2>
    <div class="row">
        <div class="col-12 col-lg-8">
            <?php if (isset($vehicle)) : ?>
            <div class="pb-3">
                No "<span class="font-weight-bold"><?php echo get_search_query(); ?></span>" parts were found for a
                "<span class="font-weight-bold"><?php echo $vehicle ?></span>"
                <button id="remove-vehicle" class="btn btn-outline-secondary btn-sm">Clear Vehicle</button>

            </div>
            <?php endif; ?>
            <div>
                <p>Try clearing your vehicle and searching again</p>
                <form action="/" method="get" class="form">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search by Vehicle, Part Number..."
                            aria-label="Search" name="s" id="search" value="">
                        <div class="input-group-append">
                            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </div>
                    <input type="hidden" name="post_type" value="product" />
                </form>
            </div>

        </div>
        <div class="col-12 col-lg-4">
            <p class="font-weight-bold">Search Tips</p>
            <ul>
                <li>Check for typos or spelling errors</li>
                <li>Simplify your search - try using fewer words</li>
                <li>Try looking up by part number</li>
                <li>Still cant find what your looking for? <a href="/contact">Contact us for more help</a></li>
            </ul>
        </div>
    </div>
</div>