<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package restoration-performance
 */


 // loop product title
 
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'loop_product_title', 10 );

function loop_product_title() {
    echo '<h3 class="text-dark ' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '"><strong>' . get_the_title() . '</strong></h3>';
}

// loop product image

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'loop_product_image', 10 );

function loop_product_image() {
    echo woocommerce_get_product_thumbnail(); // WPCS: XSS ok.
}

// YMM to show on product page

/**
 * YMM to show on product page
 *
 * @see get_object_taxonomies()
 */
function ymm_fitment_product_page() {
    // Get post by post ID.
    if ( ! $post = get_post() ) {
        return '';
    }

    $walker = new WPQuestions_Walker;
    
    $args = array(
    'taxonomy'     => 'ymm',
    'orderby'      => 'name',
    'show_count'   =>  false,
    'pad_counts'   => false,
    'hierarchical' => true,
    'use_desc_for_title' => 0,
    'hide_title_if_empty' => true,
    'title_li' => 'Vehicle Fitment: ',
    'style' => 'list',
    'walker' => $walker,
    );

    return wp_list_categories( $args );
}

// cart - remove suggestions from cart collateral

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


// cart - remove country list

//add_filter( 'woocommerce_shipping_calculator_enable_country', '__return_false' );

// cart - remove city list

//add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_false' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function woocommerce_active_body_class( $classes )
{
    $classes[] = 'woocommerce-active';

    return $classes;
}
add_filter('body_class', 'woocommerce_active_body_class');

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function woocommerce_products_per_page()
{
    return 12;
}
add_filter('loop_shop_per_page', 'woocommerce_products_per_page');

/**
 * Product gallery thumbnail columns.
 *
 * @return integer number of columns.
 */
function woocommerce_thumbnail_columns()
{
    return 4;
}
add_filter('woocommerce_product_thumbnails_columns', 'woocommerce_thumbnail_columns');

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function woocommerce_loop_columns()
{
    return 3;
}
add_filter('loop_shop_columns', 'woocommerce_loop_columns');

/**
 * Related Products Args.
 *
 * @param  array $args related products args.
 * @return array $args related products args.
 */
function woocommerce_related_products_args( $args )
{
    $defaults = array(
    'posts_per_page' => 3,
    'columns'        => 3,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'woocommerce_related_products_args');


/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
    <?php
        if ( function_exists( 'woocommerce_header_cart' ) ) {
            woocommerce_header_cart();
        }
    ?>
*/

if (! function_exists('woocommerce_cart_link_fragment') ) {
/**
* Cart Fragments.
*
* Ensure cart contents update when products are added to the cart via AJAX.
*
* @param array $fragments Fragments to refresh via AJAX.
* @return array Fragments to refresh via AJAX.
*/
function woocommerce_cart_link_fragment( $fragments )
{
ob_start();
woocommerce_cart_link();
$fragments['a.cart-contents'] = ob_get_clean();

return $fragments;
}
}
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_cart_link_fragment');

if (! function_exists('woocommerce_cart_link') ) {
/**
* Cart Link.
*
* Displayed a link to the cart including the number of items present and the cart total.
*
* @return void
*/
function woocommerce_cart_link()
{
?>
<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>"
    title="<?php esc_attr_e('View your shopping cart', 'underscores'); ?>">
    <?php
        $item_count_text = sprintf(
            /* translators: number of items in the mini cart. */
            _n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'underscores'),
            WC()->cart->get_cart_contents_count()
        );
        ?>
    <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span
        class="count"><?php echo esc_html($item_count_text); ?></span>
</a>
<?php
    }
}

if (! function_exists('woocommerce_header_cart') ) {
    /**
     * Display Header Cart.
     *
     * @return void
     */
    function woocommerce_header_cart()
    {
        if (is_cart() ) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
<ul id="site-header-cart" class="site-header-cart">
    <li class="<?php echo esc_attr($class); ?>">
        <?php woocommerce_cart_link(); ?>
    </li>
    <li>
        <?php
        $instance = array(
        'title' => '',
        );

        the_widget('WC_Widget_Cart', $instance);
        ?>
    </li>
</ul>
<?php
    }
}