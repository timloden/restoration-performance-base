<?php

/**
 * Template Name: Home Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package restoration-performance
 */

get_header();
?>

<?php if( have_rows('slider_images') ): ?>
<div class="slider">
    <div class="slide-arrows d-flex justify-content-between position-absolute w-100">
        <a href="#" class="slide-prev text-white pl-2"><i class="las la-angle-left"></i></a>
        <a href="#" class="slide-next text-white pr-2"><i class="las la-angle-right"></i></a>
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
                            <div class="slide-text">
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
<div class="bg-light border-bottom">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-12 col-lg-2">
                <p id="your-vehicle" class="mb-0"><strong>Choose your vehicle:</strong></p>
            </div>
            <div class="col-12 col-lg-10">
                <div class="home-ymm">
                    <?php echo facetwp_display('facet', 'year_make_model'); ?>
                </div>
            </div>
        </div>
        <div class="d-none">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 12,
            
                );
            $loop = new WP_Query( $args );
            
            if ( $loop->have_posts() ) {
                while ( $loop->have_posts() ) : $loop->the_post();
                    wc_get_template_part( 'content', 'product' );
                endwhile;
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>


<div class="container">
    <div class="home-content pt-3 pb-5">
        <?php
		while ( have_posts() ) :
			the_post();
            
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
        ?>
    </div>


    <?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 6,
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
        echo '<h3 class="pb-2">Featured Products</h3>';
        echo '<div class="row products">';
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
        'posts_per_page' => 6,
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
        echo '<h3 class="pb-2">New Products</h3>';
        echo '<div class="row products">';
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