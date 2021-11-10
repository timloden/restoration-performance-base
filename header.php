<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package restoration-performance
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <?php the_field('header_embed', 'option'); ?>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php 
    if (is_single() && !is_product()) {
        article_structured_data($post->ID);
    }
    ?>
    <?php wp_head(); 
    global $woocommerce;
    
    $logo = get_field('logo', 'option');
    $commercial_freight = get_field('commercial_freight_starting_at', 'option');

    if (!$commercial_freight) {
        $commercial_freight = '159';
    }

    if(isset($_COOKIE['facetdata'])) {
        $facetdata = create_facet_url_query($_COOKIE['facetdata']);
    }
    ?>
</head>

<body <?php body_class(); ?>>
    <!-- mini cart offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="off-canvas-mini-cart"
        aria-labelledby="off-canvas-mini-cart-label">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <!-- mobile nav offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="off-canvas-mobile-nav"
        aria-labelledby="off-canvas-mobile-nav-label">
        <div class="offcanvas-header p-2">
            <h5 class="offcanvas-title" id="off-canvas-mini-cart-label"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action" href="<?php echo site_url(); ?>/shop">
                Shop by Vehicle</a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="offcanvas" href="#off-canvas-mini-cart"
                role="button" aria-controls="off-canvas-mini-cart">Cart</a>
            <a class="list-group-item list-group-item-action" href="<?php echo site_url(); ?>/checkout">Checkout</a>
            <div class="list-group-item px-0">
                <div class="accordion accordion-flush" id="accordion-account">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-account-headingOne">
                            <button class="accordion-button collapsed p-0 pb-1 px-3" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-account" aria-expanded="false"
                                aria-controls="flush-account">
                                Account
                            </button>
                        </h2>
                        <div id="flush-account" class="accordion-collapse collapse"
                            aria-labelledby="flush-account-headingOne" data-bs-parent="#accordion-account">
                            <div class="accordion-body p-0">
                                <ul class="header-categories list-unstyled mb-0" id="dropdown-resources-list"
                                    aria-labelledby="dropdown-resources">
                                    <li class="cat-item">
                                        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"
                                            class="dropdown-item"><?php echo (is_user_logged_in() ? 'My Account' : 'Login / Create Account'); ?></a>
                                    </li>
                                    <li class="cat-item">
                                        <a href="<?php echo site_url(); ?>/tracking" class="dropdown-item">Track your
                                            order</a>
                                    </li>
                                    <?php 
                                    if ( shortcode_exists( 'ti_wishlist_products_counter' ) ) {
                                        echo '<li class="cat-item"><a href="' . site_url() . '/buildlist" class="dropdown-item">Buildlist</a></li>';
                                    
                                    }
                                    ?>
                                    <li class="cat-item">
                                        <a href="<?php echo site_url(); ?>/frequently-asked-questions"
                                            class="dropdown-item">Help</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="list-group-item" href="<?php echo site_url(); ?>/product-tag/special/">Specials</a>
            <div class="list-group-item px-0">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed p-0 pb-1 px-3" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                Resources
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body p-0">
                                <ul class="header-categories list-unstyled mb-0" id="dropdown-resources-list"
                                    aria-labelledby="dropdown-resources">

                                    <?php
                                            $args = array(
                                                'taxonomy'           => 'category',
                                                'hide_empty'         => true,
                                                'orderby'            => 'name',
                                                'order'              => 'ASC',
                                                'title_li'           => false,
                                                'style'              => 'list',
                                                'depth'              => 1,
                                                'separator'              => '',
                                                'echo'               => false,
                                                'walker'       => new Walker_Category_Bootstrap(),
                                            );
                                            $categories = wp_list_categories($args);

                                            if ($categories) {
                                                printf('%s', $categories);
                                            }
                                            ?>
                                    <li class="cat-item">
                                        <a href="<?php echo site_url(); ?>/resources" class="dropdown-item">All
                                            Resources</a>
                                    </li>
                                    <li class="cat-item">
                                        <a href="<?php echo site_url(); ?>/frequently-asked-questions"
                                            class="dropdown-item">FAQs</a>
                                    </li>
                                    <li class="cat-item">
                                        <a href="<?php echo site_url(); ?>/shipping" class="dropdown-item">Shipping</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a class="list-group-item list-group-item-action" href="<?php echo site_url(); ?>/about">About</a>

            <a class="list-group-item list-group-item-action" href="<?php echo site_url(); ?>/contact">Contact</a>

        </div>
    </div>

    <?php wp_body_open(); ?>

    <div id="page" class="site">
        <header class="header">
            <!-- top bar -->
            <div class=" top-bar border-bottom">
                <div class="container">
                    <div class="row align-items-center py-2">
                        <div class="col-lg-6 text-center text-lg-start">
                            <span
                                class="border-end me-2 pe-2"><strong><?php echo esc_attr( get_field('ground_shipping_discount', 'option') ); ?></strong></span>
                            <span>Freight shipping starting at $<?php echo esc_attr($commercial_freight); ?></span>
                        </div>
                        <div class="col-12 col-lg-6 text-center text-lg-end d-none d-lg-block">
                            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"
                                class="border-end pe-2 me-2"><?php echo (is_user_logged_in() ? 'My Account' : 'Login / Create Account'); ?></a>
                            <a href="<?php echo site_url(); ?>/tracking" class="border-end pe-2 me-2">Track
                                Order</a>
                            <a href="<?php echo site_url(); ?>/frequently-asked-questions"
                                class="border-end pe-2 me-2">Help</a>

                            <?php 
                            if ( shortcode_exists( 'ti_wishlist_products_counter' ) ) {
                                echo do_shortcode('[ti_wishlist_products_counter]'); 
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <!-- main header -->
                <div class="row align-items-center py-2 py-lg-3">
                    <div class="col-7 col-lg-3 text-center text-lg-left">
                        <a class="d-block mb-lg-2" href="<?php echo site_url(); ?>">
                            <?php if ($logo) : ?>
                            <img src="<?php echo $logo['url'] ?>" class="img-fluid"
                                alt="<?php echo $logo['alt'] ?>"></a>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block">
                        <form action="/" method="get" class="form">
                            <div class="input-group">
                                <input class="form-control" type="search"
                                    placeholder="Search by Keyword, Part Number..." aria-label="Search" name="s"
                                    id="search" data-swplive="true" value="<?php the_search_query(); ?>">

                                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>

                            </div>
                            <input type="hidden" name="post_type" value="product" />

                        </form>
                    </div>
                    <div class="col-5 col-lg-4 text-end">
                        <div class="d-flex align-items-center justify-content-end">

                            <a class="position-relative btn d-inline-flex p-0" role="button" id="mini-cart-link"
                                data-bs-toggle="offcanvas" href="#off-canvas-mini-cart" role="button"
                                aria-controls="off-canvas-mini-cart">
                                <i class="las la-shopping-cart h5 position-relative"></i>
                                <span style="font-size: 12px;" id="cart-customlocation"
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo  $woocommerce->cart->cart_contents_count; ?>
                            </a>


                            <a style="color: #212529;" class="d-lg-none btn p-0 px-2 ms-2" id="mobile-nav-link"
                                data-bs-toggle="offcanvas" href="#off-canvas-mobile-nav" role="button"
                                aria-controls="off-canvas-mobile-nav">
                                <i class="las la-bars mb-0"></i>
                            </a>
                        </div>
                    </div>
                </div>


        </header>
        <div class="bg-light d-lg-none border-bottom border-top">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="/" method="get" class="form py-2">
                            <div class="input-group">
                                <input class="form-control" type="search"
                                    placeholder="Search by Keyword, Part Number..." aria-label="Search" name="s"
                                    id="mobile-search" data-swplive="true" value="<?php the_search_query(); ?>">
                                <button class="btn btn-secondary" type="submit">Search</button>
                            </div>
                            <input type="hidden" name="post_type" value="product" />

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Desktop nav -->
    <div class="nav-wrapper bg-primary d-none d-lg-block border-top">
        <div class="container">

            <ul class="nav nav-fill justify-content-between">
                <li>
                    <a class="bg-dark-25 nav-link text-white font-weight-bold px-lg-4 px-xl-5"
                        href="<?php echo site_url(); ?>/shop"><i class="las la-car" style="font-size: 20px;"></i>
                        Shop
                        by Vehicle</a>
                </li>
                <li>
                    <a class="nav-link text-white px-lg-4 px-xl-5"
                        href="<?php echo site_url(); ?>/product-tag/special/">Specials</a>
                </li>
                <li>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white px-lg-4 px-xl-5" href="#" role="button"
                            id="dropdown-resources" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Resources</a>
                        <ul class="dropdown-menu header-resources" id="dropdown-resources-list"
                            aria-labelledby="dropdown-categories">
                            <?php
                                    $args = array(
                                        'taxonomy'           => 'category',
                                        'hide_empty'         => true,
                                        'orderby'            => 'name',
                                        'order'              => 'ASC',
                                        'title_li'           => false,
                                        'style'              => 'list',
                                        'separator'              => '',
                                        'echo'               => false,
                                        'walker'       => new Walker_Category_Bootstrap(),
                                    );
                                    $categories = wp_list_categories($args);

                                    if ($categories) {
                                        printf('%s', $categories);
                                    }
                                    ?>
                            <li class="cat-item">
                                <a href="<?php echo site_url(); ?>/resources" class="dropdown-item">All
                                    Resources</a>
                            </li>
                            <li class="cat-item">
                                <a href="<?php echo site_url(); ?>/frequently-asked-questions"
                                    class="dropdown-item">FAQs</a>
                            </li>
                            <li class="cat-item">
                                <a href="<?php echo site_url(); ?>/shipping" class="dropdown-item">Shipping</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="nav-link text-white px-lg-4 px-xl-5" href="<?php echo site_url(); ?>/about">About</a>
                </li>
                <li>
                    <a class="nav-link  text-white px-lg-4 px-xl-5" href="<?php echo site_url(); ?>/contact">Contact</a>
                </li>
            </ul>


        </div>
    </div>

    </header><!-- #masthead -->

    <div id="content" class="site-content">