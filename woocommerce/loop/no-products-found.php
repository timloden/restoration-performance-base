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
    <?php if (is_product_tag('special')) :?>
    <h2 class="pb-1 text-center">Sorry, we don&apos;t have any items on special at the moment</h2>
    <p class="mb-5 pb-5 text-center">Be sure to check back regularly as we update our specials often!</p>

    <?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'tax_query' => array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                ),
            ),
        );
    $loop = new WP_Query( $args );
    
    if ( $loop->have_posts() ) {
        echo '<div class="home-featured mb-5">';
        echo '<h3>Featured Products</h3>';
        echo '<p class="pb-3 mb-3 title-border">Here are some products hand picked by our staff</p>';
        echo '<div class="row products">';
        while ( $loop->have_posts() ) : $loop->the_post();
            wc_get_template_part( 'content', 'product-homepage' );
        endwhile;
        echo '</div></div>';
    }
    wp_reset_postdata();
    ?>




    <?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'orderby' =>'date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_tag',
                'field'    => 'name',
                'terms'    => 'new',
            ),
        ),
    );
    $loop = new WP_Query( $args );
    
    if ( $loop->have_posts() ) {
        echo '<div class="home-new">';
        echo '<h3>New Products</h3>';
        echo '<p class="pb-3 mb-3 title-border">Browse the latest products from our high quality manufacturers</p>';
        echo '<div class="row products">';
        while ( $loop->have_posts() ) : $loop->the_post();
            wc_get_template_part( 'content', 'product-homepage' );
        endwhile;
        echo '</div></div>';
    }
    wp_reset_postdata();
    ?>

    <?php else : ?>
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

    <?php endif; ?>
</div>