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
                <div class="row align-items-center top-bar border-bottom py-2">
                    <div class="col-6">
                        <span class="border-right mr-2 pr-2"><strong>Orders over $99 ship for $4.50!</strong></span>
                        <span>Freight shipping starting at $135</span>
                    </div>
                    <div class="col-6 text-right">
                        <a href="/my-account" class="border-right pr-2 mr-2">My Account</a>
                        <a href="/track-order" class="border-right pr-2 mr-2">Track Order</a>
                        <a href="/help">Help</a>
                    </div>
                </div>
                <div class="row align-items-center py-3">
                    <div class="col-3">
                        <a href="/">Classic Body Parts</a>
                    </div>
                    <div class="col-5">
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
                    <div class="col-4 text-right">
                        <div class="d-flex align-items-center justify-content-end">

                            <div class="dropdown w-100">
                                <a class="dropdown-toggle" role="button" id="dropdown-mini-cart" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="las la-shopping-cart"></i>Cart
                                    <span id="cart-customlocation"
                                        class="badge badge-danger"><?php echo  $woocommerce->cart->cart_contents_count; ?>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-mini-cart">
                                    <?php woocommerce_mini_cart(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    <div class="nav-wrapper bg-primary">
        <div class="container">

            <ul class="d-flex list-unstyled w-100 mb-0 text-center">
                <li class="col">
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
                <li class="col">

                    <div class="dropdown">
                        <a class="nav-link text-white" href="/shop">Search by Vehicle</a>
                    </div>
                </li>
                <li class="col">
                    <a class="nav-link  text-white" href="#">Specials</a>
                </li>
                <li class="col">
                    <a class="nav-link text-white" href="#">About</a>
                </li>
                <li class="col">
                    <a class="nav-link  text-white" href="#">Contact</a>
                </li>
            </ul>


        </div>
    </div>


    </header><!-- #masthead -->

    <div id="content" class="site-content">