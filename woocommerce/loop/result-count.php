<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="container d-none d-lg-block">
    <div class="row py-3">
        <div class="col-6">
            <?php if (is_search() || is_product_category()) : ?>
            <a href="<?php echo site_url(); ?>/shop"><i class="las la-arrow-left"></i> Back to all products</a>
            <?php else : ?>
            <p id="your-vehicle" class="mb-0"></p>
            <?php endif; ?>
        </div>