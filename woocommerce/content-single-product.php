<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
    <div class="row pt-md-3">
        <div class="col-12 col-md-6 text-center mt-3 mb-3 mt-md-0">
            <?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>
        </div>
        <div class="col-12 col-md-6">
            <div class="summary entry-summary">
                <?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
				if( have_rows('vehicle_fitment') ): 
					$count = 0;
					?>
                <p class="mb-1"><strong>Vehicle Fitment:</strong></p>
                <ul class="mb-3">
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
					echo '<div class="mb-3"><a class="ml-4" id="show-fitment" href="#">' . $total_count . ' total vehicles, click here to view all</a></div>';
				}
				endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php
			/**
			 * Hook: woocommerce_after_single_product_summary.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
			?>
        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>