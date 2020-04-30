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
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); 
    global $woocommerce;
    ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <header class="header">
            <div class="container">
                <!-- top bar -->
                <div class="row align-items-center top-bar border-bottom py-2">
                    <div class="col-lg-6 d-none d-lg-block">
                        <span class="border-right mr-2 pr-2"><strong>Orders over $99 ship for $4.50!</strong></span>
                        <span>Freight shipping starting at $135</span>
                    </div>
                    <div class="col-12 col-lg-6 text-center text-lg-right">
                        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"
                            class="border-right pr-2 mr-2">My Account</a>
                        <a href="<?php echo site_url(); ?>/tracking" class="border-right pr-2 mr-2">Track Order</a>
                        <a href="<?php echo site_url(); ?>/help">Help</a>
                    </div>
                </div>
                <!-- main header -->
                <div class="row align-items-center py-3">
                    <div class="col-12 col-lg-3 text-center text-lg-left">
                        <a class="d-block mb-2" href="/"><img
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/classic-body-parts-logo.png"
                                class="img-fluid" alt="Classic Discount Parts Logo"></a>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block">
                        <form action="/" method="get" class="form">
                            <div class="input-group">
                                <input class="form-control" type="search"
                                    placeholder="Search by Vehicle, Part Number..." aria-label="Search" name="s"
                                    id="search" value="<?php the_search_query(); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                                </div>
                            </div>
                            <input type="hidden" name="post_type" value="product" />
                        </form>
                    </div>
                    <div class="col-12 col-lg-4 text-right">
                        <div class="d-flex align-items-center justify-content-end">
                            <a class="d-lg-none mr-3 p-1" data-toggle="collapse" href="#mobile-nav" role="button"
                                aria-expanded="false" aria-controls="mobile-nav">
                                <i class="las la-bars h4 mb-0"></i>
                            </a>
                            <a class="d-lg-none p-1" data-toggle="collapse" href="#mobile-search" role="button"
                                aria-expanded="false" aria-controls="mobile-search">
                                <i class="las la-search h5 mb-0"></i>
                            </a>
                            <div id="cart-dropdown" class="dropdown w-100">
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
                <div class="row d-lg-none pb-3 collapse" id="mobile-search">
                    <div class="col-12">
                        <form action="/" method="get" class="form">
                            <div class="input-group">
                                <input class="form-control" type="search"
                                    placeholder="Search by Vehicle, Part Number..." aria-label="Search" name="s"
                                    id="mobile-search" value="<?php the_search_query(); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">Search</button>
                                </div>
                            </div>
                            <input type="hidden" name="post_type" value="product" />
                        </form>
                    </div>
                </div>
                <!-- mobile nav -->
                <div class="row d-lg-none border-bottom">
                    <div class="col-12">
                        <div class="collapse card mb-2" id="mobile-nav">

                            <div class="accordion" id="mobile-nav-items">

                                <div class="border-bottom" id="mobile-categories-button">

                                    <a class="collapsed d-block py-1 px-2" data-toggle="collapse"
                                        data-target="#mobile-categories" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        Categories
                                    </a>

                                </div>

                                <div id="mobile-categories" class="collapse" aria-labelledby="mobile-categories-button"
                                    data-parent="#mobile-nav-items">
                                    <div class="border-bottom">
                                        <ul class="header-categories list-unstyled mb-0" id="dropdown-categories-list"
                                            aria-labelledby="dropdown-categories">

                                            <?php
                                            $args = array(
                                                'taxonomy'           => 'product_cat',
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
                                        </ul>
                                    </div>
                                </div>


                                <div class="border-bottom">

                                    <a class="d-block py-1 px-2" href="/shop">Search by Vehicle</a>

                                </div>

                                <div class="border-bottom">

                                    <a class="d-block py-1 px-2" href="/specials">Specials</a>

                                </div>

                                <div class="border-bottom">

                                    <a class="d-block py-1 px-2" href="/about">About</a>

                                </div>

                                <div>

                                    <a class="d-block py-1 px-2" href="/contact">Contact</a>

                                </div>

                            </div>



                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    <div class="nav-wrapper bg-primary d-none d-lg-block">
        <div class="container">

            <ul class="nav nav-pills nav-fill justify-content-between">
                <li>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" id="dropdown-categories"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
                        <ul class="dropdown-menu header-categories" id="dropdown-categories-list"
                            aria-labelledby="dropdown-categories">

                            <?php
                                    $args = array(
                                        'taxonomy'           => 'product_cat',
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
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="nav-link text-white" href="/shop">Shop by Vehicle</a>
                </li>
                <li>
                    <a class="nav-link  text-white" href="#">Specials</a>
                </li>
                <li>
                    <a class="nav-link text-white" href="#">About</a>
                </li>
                <li>
                    <a class="nav-link  text-white" href="#">Contact</a>
                </li>
            </ul>


        </div>
    </div>


    </header><!-- #masthead -->

    <div id="content" class="site-content">