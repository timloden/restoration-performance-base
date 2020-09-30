<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $product;
$brands = wp_get_object_terms( $product->get_id(), 'pwb-brand' );

foreach( $brands as $brand ) {
$image_size = get_option('wc_pwb_admin_tab_brand_logo_size', 'thumbnail');
$brand_logo = get_term_meta( $brand->term_id, 'pwb_brand_image', true );
$brand_logo = wp_get_attachment_image_src( $brand_logo, apply_filters( 'pwb_product_tab_brand_logo_size', $image_size ) );
}
?>
<h1 class="product_title entry-title pt-2 pb-3 text-center text-md-left" style="font-size: 2em;">
    <?php echo esc_html( get_the_title() ); ?>
</h1>
<?php if( !empty($brand_logo) ) :?>
<div class="text-center text-md-left">
    <img style="max-width: 200px;" class="mb-3" src="<?php echo $brand_logo[0]; ?>">
</div>
<?php endif; ?>

<p class="sku_wrapper mb-1 text-center text-md-left"><?php esc_html_e('SKU: ', 'woocommerce'); ?><span
        class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span>
</p>