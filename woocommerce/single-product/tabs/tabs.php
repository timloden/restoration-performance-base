<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>
<div class="woocommerce-tabs wc-tabs-wrapper">
    <ul class="nav nav-tabs" id="product-tab" role="tablist">
        <?php 
			$count = 0;
			foreach ( $product_tabs as $key => $product_tab ) : $count++; ?>
        <li class="nav-item" role="presentation">

            <button class="nav-link <?php if ($count == 1) { echo 'active'; } ?>"
                id="product-<?php echo esc_attr( $key ); ?>-tab" data-bs-toggle="tab"
                data-bs-target="#product-<?php echo esc_attr( $key ); ?>" type="button" role="tab"
                aria-controls="product-<?php echo esc_attr( $key ); ?>" aria-selected="true">
                <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
            </button>

        </li>
        <?php endforeach; ?>
    </ul>
    <div class="tab-content" id="product-tabContent">
        <?php 
			$count = 0;
			foreach ( $product_tabs as $key => $product_tab ) : $count++; 
        ?>
        <div class="tab-pane p-3 fade <?php if ($count == 1) { echo 'show active'; } ?>"
            id="product-<?php echo esc_attr( $key ); ?>" role="tabpanel"
            aria-labelledby="product-<?php echo esc_attr( $key ); ?>-tab">

            <?php
            if ( isset( $product_tab['callback'] ) ) {
                call_user_func( $product_tab['callback'], $key, $product_tab );
            }
            ?>

        </div>
        <?php endforeach; ?>
    </div>
    <?php do_action( 'woocommerce_product_after_tabs' ); ?>
</div>

<?php endif; ?>