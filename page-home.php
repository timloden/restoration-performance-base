<?php

/**
 * Template Name: Home Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package restoration-performance
 */

get_header();
$commercial_freight = get_field('commercial_freight_starting_at', 'option');

if (!$commercial_freight) {
    $commercial_freight = '159';
}
?>

<?php if( have_rows('slider_images') ): ?>
<div class="slider position-relative">
    <div class="slide-arrows d-flex justify-content-between position-absolute w-100">
        <a class="slide-prev text-white pl-3"><i class="las la-angle-left"></i></a>
        <a class="slide-next text-white pr-3"><i class="las la-angle-right"></i></a>
    </div>
    <div class="home-slider">

        <?php while( have_rows('slider_images') ): the_row(); 

    // vars
    $image = get_sub_field('image');
    $text = get_sub_field('text');
    $button_text = get_sub_field('button_text');
    $button_link = get_sub_field('button_link');

    ?>

        <div class="slide">
            <div class="slide-content d-flex align-items-center"
                style="background-image: url(<?php echo $image['url']; ?>);">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="slide-text text-center text-lg-left">
                                <?php echo $text; ?>
                                <a class="btn btn-primary"
                                    href="<?php echo $button_link; ?>"><?php echo $button_text; ?></a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<?php endif; ?>
<div id="choose-your-vehicle" class="bg-light border-bottom">
    <div class="container py-3">
        <div class="row align-items-center">
            <!-- <div class="col-12 col-lg-2">
                <p class="mb-0 text-primary fw-bolder">Start here:</p>
            </div> -->
            <div class="col-12">
                <div class="home-ymm">
                    <?php //echo facetwp_display('facet', 'year_make_model'); ?>
                    <p class="mb-0 text-center"><a class="btn-lg btn btn-primary"
                            href="<?php echo site_url(); ?>/shop#ymm-bar">Choose your Vehicle</a></p>
                </div>
            </div>
        </div>
        <div class="d-none">
            <?php
            // $args = array(
            //     'post_type' => 'product',
            //     'posts_per_page' => 12,
            //     'facetwp' => true,
            //     );
            // $loop = new WP_Query( $args );
            
            // if ( $loop->have_posts() ) {
            //     while ( $loop->have_posts() ) : $loop->the_post();
            //         wc_get_template_part( 'content', 'product' );
            //     endwhile;
            // }
            // wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

<div class="bg-white py-lg-5">
    <div class="container py-5">
        <div class="row home-benefits">
            <div class="col-12 pb-5">
                <h1 class="text-center h2 pb-3">Classic car and restoration auto parts location at
                    everyday low
                    prices.</h1>
                <p class="text-center pb-4">Classic Body Parts is the best choice for Auto Restoration and Performance
                    car
                    parts because of our
                    respective associations as a dealer from over 50 aftermarket and restoration parts manufacturers to
                    meet all your vehicle's needs. </p>
            </div>
            <div class="col-12 col-lg-4 text-center">
                <i class="las la-shipping-fast text-primary"></i>
                <h5 class="my-2 fw-bold">Easy Shipping Price</h5>
                <p class="mb-2">See accurate shipping in your cart with just a state and zipcode</p>
            </div>
            <div class="col-12 col-lg-4 text-center">
                <i class="las la-check-circle text-primary"></i>
                <h5 class="my-2 fw-bold">High Quality Parts</h5>
                <p>Over 20,000 restoration parts sourced from high quality manufacturers</p>
            </div>
            <div class="col-12 col-lg-4 text-center">
                <i class="las la-headset text-primary"></i>
                <h5 class="my-2 fw-bold">Expert Advice</h5>
                <p>Our experts are here to help you with your restoration project</p>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-12 text-center">
                <a href="<?php echo site_url(); ?>/shop#ymm-bar" class="btn btn-primary">Get your project started</a>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row align-items-center py-5">
        <div class=" col-12 col-lg-6 order-2 order-lg-1">
            <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/images/shelby-cobra.jpg">

        </div>
        <div class="col-12 col-lg-6 order-1 order-lg-2 mb-5 mb-lg-5">
            <div class="px-3">
                <h2 class="pb-3 mb-3 title-border">Why we should be your first choice for restoration &amp; muscle car
                    parts
                </h2>
                <p>We have a history as one of the largest dealers for Dynacorn International. Dynacorn has been
                    supplying
                    the classic muscle car enthusiast quality sheet metal, bright trim and molding since 1984.
                </p>
                <p>
                    We strive to meet all your classic car and truck vehicles needs. Don&#39;t be fooled by other
                    companies
                    that
                    offer monthly or weekend sells offering discounts at 15 - 25% off RETAIL price! We have the lowest
                    prices every month all year long! Just try us and you will see.</p>

                <a href="<?php echo site_url(); ?>/shop#ymm-bar" class="btn btn-primary">Browse parts for your
                    vehicle</a>
            </div>

        </div>
    </div>
</div>

<?php if( have_rows('brands') ): ?>
<div class="border-bottom border-top py-5">
    <div class="container">
        <h2 class="text-center pt-3 h3">Our featured brands</h2>
        <p class="text-center pb-3">Classic Body Parts carries a wide range of brands for all stages of car
            restoration.</p>
        <div class="row align-items-center justify-content-around">
            <?php while( have_rows('brands') ): the_row(); 

            $brand_id = get_sub_field('brand');
            $term = get_term_by('id', $brand_id, 'pwb-brand');
            $term_link = get_term_link( $term );

            $image_size = get_option('wc_pwb_admin_tab_brand_logo_size', 'thumbnail');
            $brand_image_id = get_term_meta( $term->term_id, 'pwb_brand_image', true );
            $brand_logo = wp_get_attachment_image_src( $brand_image_id, apply_filters( 'pwb_product_tab_brand_logo_size', $image_size ) );
        ?>
            <div class="col-6 col-md-4 text-center pb-3">
                <a href="<?php echo $term_link; ?>"><img class="img-fluid" src="<?php echo esc_url($brand_logo[0]); ?>"
                        alt="<?php echo $term->name; ?>"></a>
                <h3 class="h4 mt-3"><a class="text-black" href="<?php echo $term_link; ?>"><?php echo $term->name; ?>
                        Parts</a></h3>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center pt-5 pt-lg-3">
            <a href="<?php echo site_url(); ?>/shop#ymm-bar" class="btn btn-primary">Select your vehicle to get
                started</a>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="border-bottom pb-5">
    <div class="container py-5">
        <h2 class="text-center pt-3 h3">Need help with your project?</h2>
        <p class="text-center pb-5">The Classic Body Parts resource center is here to help answer all of your
            restoration questions.</p>
        <div class="row">
            <div class="col-12 col-lg-6 mb-5 mb-lg-0">
                <div class="card home-resource py-5"
                    style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/classic-car-is-in-a-workshop.jpg);">
                    <div class="card-body position-relative">
                        <h4 class="text-white text-center h2">Tech Tips</h4>
                        <p class="text-white text-center">Helpful hints for your restoration project</p>
                        <a class="text-white text-center d-block mt-5"
                            href="<?php echo site_url(); ?>/category/tech-tips/">Browse
                            all Tech Tips</a>
                    </div>
                    <div class="hero-overlay"></div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card home-resource py-5"
                    style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/firebird.jpg);">
                    <div class="card-body position-relative">
                        <h4 class="text-white text-center h2">Frequently Asked Questions</h4>
                        <p class="text-white text-center">Common questions we get about ordering</p>
                        <a class="text-white text-center d-block mt-5"
                            href="<?php echo site_url(); ?>/frequently-asked-questions/">Browse Frequently
                            Asked Questions</a>
                    </div>
                    <div class="hero-overlay"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="home-content pt-3 pb-5">
        <?php
		while ( have_posts() ) :
			the_post();
			//get_template_part( 'template-parts/content', 'page' );
		endwhile; // End of the loop.
        ?>
    </div>


    <?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'tax_query' => array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                ),
            ),
        );
    $loop = new WP_Query( $args );
    
    if ( $loop->have_posts() ) {
        echo '<div class="home-featured mb-5">';
        echo '<h3>Featured Products</h3>';
        echo '<p class="pb-3 mb-3 title-border">Here are some products hand picked by our staff</p>';
        echo '<div class="row products row-cols-1 row-cols-md-2 row-cols-lg-4">';
        while ( $loop->have_posts() ) : $loop->the_post();
            wc_get_template_part( 'content', 'product' );
        endwhile;
        echo '</div></div>';
    }
    wp_reset_postdata();
    ?>




    <?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'orderby' =>'date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_tag',
                'field'    => 'name',
                'terms'    => 'new',
            ),
        ),
    );
    $loop = new WP_Query( $args );
    
    if ( $loop->have_posts() ) {
        echo '<div class="home-new">';
        echo '<h3>New Products</h3>';
        echo '<p class="pb-3 mb-3 title-border">Browse the latest products from our high quality manufacturers</p>';
        echo '<div class="row products row-cols-1 row-cols-md-2 row-cols-lg-4">';
        while ( $loop->have_posts() ) : $loop->the_post();
            wc_get_template_part( 'content', 'product' );
        endwhile;
        echo '</div></div>';
    }
    wp_reset_postdata();
    ?>

</div>

<?php
//get_sidebar();
get_footer();