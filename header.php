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
    ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <header class="header">
            <!-- top bar -->
            <div class="top-bar border-bottom">
                <div class="container">
                    <div class="row align-items-center py-2">
                        <div class="col-lg-6 d-none d-lg-block">
                            <span class="border-right mr-2 pr-2"><strong>Orders over $150 ship for
                                    $7.50!</strong></span>
                            <span>Freight shipping starting at $135</span>
                        </div>
                        <div class="col-12 col-lg-6 text-center text-lg-right">
                            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"
                                class="border-right pr-2 mr-2"><?php echo (is_user_logged_in() ? 'My Account' : 'Login / Create Account'); ?></a>
                            <a href="<?php echo site_url(); ?>/tracking" class="border-right pr-2 mr-2">Track Order</a>
                            <a href="<?php echo site_url(); ?>/frequently-asked-questions"
                                class="border-right pr-2 mr-2">Help</a>

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
                <div class="row align-items-center py-3">
                    <div class="col-12 col-lg-3 text-center text-lg-left">
                        <a class="d-block mb-2" href="<?php echo site_url(); ?>">
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
                                <div class="input-group-append">
                                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                                </div>
                            </div>
                            <input type="hidden" name="post_type" value="product" />
                        </form>
                    </div>
                    <div class="col-12 col-lg-4 text-right">
                        <div class="d-flex align-items-center justify-content-end">
                            <a class="d-lg-none p-1" data-toggle="collapse" href="#mobile-nav" role="button"
                                aria-expanded="false" aria-controls="mobile-nav">
                                <i class="las la-bars h4 mb-0"></i>
                            </a>
                            <a class="d-lg-none p-1 w-100" href="<?php echo site_url(); ?>/shop">
                                <i class="las la-car h5 mb-0"></i> Shop
                                by Vehicle</a>
                            </a>
                            <div id="cart-dropdown" class="dropdown w-50">
                                <a class="dropdown-toggle" role="button" id="dropdown-mini-cart" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="las la-shopping-cart h5"></i>Cart
                                    <span id="cart-customlocation"
                                        class="badge badge-danger"><?php echo  $woocommerce->cart->cart_contents_count; ?>
                                </a>

                                <div id="custom-mini-cart" class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="dropdown-mini-cart">
                                    <?php woocommerce_mini_cart(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- mobile search -->
                <div class="row d-lg-none pb-3" id="mobile-search">
                    <div class="col-12">
                        <form action="/" method="get" class="form">
                            <div class="input-group">
                                <input class="form-control" type="search"
                                    placeholder="Search by Keyword, Part Number..." aria-label="Search" name="s"
                                    id="mobile-search" data-swplive="true" value="<?php the_search_query(); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">Search</button>
                                </div>
                            </div>
                            <input type="hidden" name="post_type" value="product" />
                        </form>
                    </div>
                </div>
                <!-- mobile nav -->
                <div class="row d-lg-none">
                    <div class="col-12">
                        <div class="collapse card mb-2" id="mobile-nav">

                            <div class="accordion" id="mobile-nav-items">

                                <div class="border-bottom">

                                    <a class="d-block py-1 px-2"
                                        href="<?php echo site_url(); ?>/product-tag/special/">Specials</a>

                                </div>

                                <div class="border-bottom" id="mobile-categories-button">

                                    <a class="collapsed d-block py-1 px-2" data-toggle="collapse"
                                        data-target="#mobile-resources" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Resources
                                    </a>

                                </div>

                                <div id="mobile-resources" class="collapse" aria-labelledby="mobile-resources-button"
                                    data-parent="#mobile-nav-items">
                                    <div class="border-bottom">
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
                                                <a href="<?php echo site_url(); ?>/shipping"
                                                    class="dropdown-item">Shipping</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="border-bottom">

                                    <a class="d-block py-1 px-2" href="<?php echo site_url(); ?>/about">About</a>

                                </div>

                                <div>

                                    <a class="d-block py-1 px-2" href="<?php echo site_url(); ?>/contact">Contact</a>

                                </div>

                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>
    <!-- Desktop nav -->
    <div class="nav-wrapper bg-primary d-none d-lg-block border-top">
        <div class="container">

            <ul class="nav nav-fill justify-content-between">
                <li>
                    <a class="bg-dark-25 nav-link text-white font-weight-bold px-lg-4 px-xl-5"
                        href="<?php echo site_url(); ?>/shop"><i class="las la-car" style="font-size: 20px;"></i> Shop
                        by Vehicle</a>
                </li>
                <li>
                    <a class="nav-link text-white px-lg-4 px-xl-5"
                        href="<?php echo site_url(); ?>/product-tag/special/">Specials</a>
                </li>
                <li>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white px-lg-4 px-xl-5" href="#" role="button"
                            id="dropdown-resources" data-toggle="dropdown" aria-haspopup="true"
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
                                <a href="<?php echo site_url(); ?>/resources" class="dropdown-item">All Resources</a>
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