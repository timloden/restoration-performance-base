<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
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

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Details', 'woocommerce' ) );
global $product;
$brands = wp_get_object_terms( $product->get_id(), 'pwb-brand' );

foreach( $brands as $brand ) {
$image_size = get_option('wc_pwb_admin_tab_brand_logo_size', 'thumbnail');
$brand_logo = get_term_meta( $brand->term_id, 'pwb_brand_image', true );
$brand_logo = wp_get_attachment_image_src( $brand_logo, apply_filters( 'pwb_product_tab_brand_logo_size', $image_size ) );
}
	
?>



<?php the_content(); ?>


<div class="row">
    <div class="col-12 col-lg-8 order-2 order-lg-1">
        <?php if( !empty($brand->description) ) echo do_shortcode($brand->description);?>
    </div>
    <div class="col-12 col-lg-4 order-1 order-lg-2">
        <?php if( !empty($brand_logo) ) :?>
        <img class="img-fluid" src="<?php echo $brand_logo[0]; ?>">
        <?php endif; ?>
    </div>
</div>