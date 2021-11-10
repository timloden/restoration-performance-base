<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

$vehicle = isset($_COOKIE['vehicle']) ? $_COOKIE['vehicle'] : '';

?>

<div id="ymm-bar"
    class="bg-light border-bottom border-top <?php if (is_search() || is_product_tag( 'special' )) { echo 'd-none'; } ?>">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-12 col-lg-2">
                <div class="d-flex justify-content-between justify-content-lg-end align-items-center mb-2 mb-md-0">
                    <p class="mb-0 text-primary fw-bold">Your Vehicle:</p>
                    <button class="btn fw-bold btn-sm d-md-none clear-vehicle">Clear Vehicle</button>
                </div>

            </div>
            <div class="col-12 col-lg-10">
                <div class="d-flex align-items-center">
                    <div class="home-ymm w-100 col">
                        <?php echo facetwp_display('facet', 'year_make_model'); ?>
                    </div>
                    <div class="d-none d-md-block">
                        <button class="btn fw-bold btn-sm clear-vehicle">Clear Vehicle</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="product-content">
    <?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>



    <?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	?>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3">
                <?php
			/**
			 * Hook: woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
			?>
            </div>
            <div class="col-12 col-md-9">
                <?php

					//woocommerce_product_loop_start();

					if (is_search() && $vehicle) {
						echo '<h3 id="search-terms" class="mb-3">Search results for "' . get_search_query() . '" for ' . $vehicle . '</h3>';
					} elseif(is_search()) {
						echo '<h3 id="search-terms" class="mb-3">Search results for "' . get_search_query() . '"</h3>';
					}
	
					echo '<div id="products-container" class="row products row-cols-1 row-cols-md-2 row-cols-lg-3 position-relative">';
					
					if ( wc_get_loop_prop( 'total' ) ) {
						
						
						while ( have_posts() ) {
							the_post();

							/**
							 * Hook: woocommerce_shop_loop.
							 */
							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
					}

					//woocommerce_product_loop_end();

					echo '</div>';

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					//do_action( 'woocommerce_after_shop_loop' );
					echo facetwp_display('facet', 'pagination');
					} else {

						/**
						 * Hook: woocommerce_no_products_found.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );

					}

					/**
					 * Hook: woocommerce_after_main_content.
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
					
					?>
            </div>

        </div>
    </div>
</div>

<?php
get_footer( 'shop' );