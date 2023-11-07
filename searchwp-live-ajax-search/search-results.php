<?php
/**
 * Search results are contained within a div.searchwp-live-search-results
 * which you can style accordingly as you would any other element on your site
 *
 * Some base styles are output in wp_footer that do nothing but position the
 * results container and apply a default transition, you can disable that by
 * adding the following to your theme's functions.php:
 *
 * add_filter( 'searchwp_live_search_base_styles', '__return_false' );
 *
 * There is a separate stylesheet that is also enqueued that applies the default
 * results theme (the visual styles) but you can disable that too by adding
 * the following to your theme's functions.php:
 *
 * wp_dequeue_style( 'searchwp-live-search' );
 *
 * You can use ~/searchwp-live-search/assets/styles/style.css as a guide to customize
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); 

$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
$product = wc_get_product( get_the_ID() );
$stock_status = $product->get_stock_status();
if ( 'instock' == $stock_status) {
	$stock = 'In Stock';
} else {
	$stock = 'Backordered';
}
?>
<?php $post_type = get_post_type_object( get_post_type() ); ?>
<div class="searchwp-live-search-result" role="option" id="" aria-selected="false">
    <a href="<?php echo esc_url( get_permalink() ); ?>" style="white-space: initial; text-overflow: initial;">
        <div class="row align-items-center p-2 border-bottom">
            <div class="col-auto">
                <img src="<?php echo $featured_img_url; ?>" style="width: 75px;">
            </div>
            <div class="col px-0">
                <p class="mb-1 p-0" style="border-bottom: none;">
                    <?php the_title(); ?>
                </p>
                <p class="mb-0 p-0" style="font-size: 12px; border-bottom: none;">SKU:
                    <?php echo $product->get_sku(); ?> |
                    <?php echo $stock; ?></p>
            </div>
        </div>
    </a>
</div>
<?php endwhile; ?>
<?php else : ?>
<p class="searchwp-live-search-no-results" role="option">
    <em><?php esc_html_e( 'No results found.', 'searchwp-live-ajax-search' ); ?></em>
</p>
<?php endif; ?>