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

?>
<div id="ymm-bar" class="bg-light border-bottom">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-12 col-lg-2">
                <p class="mb-0"><strong>Choose your vehicle:</strong></p>
            </div>
            <div class="col-12 col-lg-10">
                <div class="home-ymm">
                    <?php echo facetwp_display('facet', 'year_make_model'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="selected-vehicle" class="bg-light border-bottom d-none mb-3 mb-lg-0">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <p class="mb-0"><strong>Your Vehicle:</strong><span id="your-vehicle" class="pl-2"></span></p>
                    <button id="clear-vehicle" class="btn btn-outline-secondary btn-sm">Clear Vehicle</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <header class="woocommerce-products-header">
	<div class="container">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
	</div>
</header> -->

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
    <?php if (is_product_tag( 'specials' )) : ?>
    <h1>Classic Body Parts Specials</h1>
    <p>All parts in specials are heavily discounted and limited stock so make sure to check back regularly!</p>
    <?php endif; ?>
    <div class="row">
        <div class="col-12 col-md-6 col-lg-3">
            <?php
			/**
			 * Hook: woocommerce_sidebar.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
			?>
        </div>
        <div class="col-12 col-md-6 col-lg-9">
            <div class="row">

                <?php

					woocommerce_product_loop_start();

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

					woocommerce_product_loop_end();

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					//do_action( 'woocommerce_after_shop_loop' );
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
					echo facetwp_display('facet', 'pagination');
					?>

            </div>
        </div>

    </div>
</div>


<?php
get_footer( 'shop' );