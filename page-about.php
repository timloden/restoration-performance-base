<?php

/**
 * Template Name: About Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package restoration-performance
 */

get_header();
?>
<div class="container">
    <?php echo dynacorn_stock_status(1000, 100); ?>
    <h1 class="py-3 mb-3 title-border"><?php the_title(); ?></h1>
    <div class="row">
        <div class="col-12 col-lg-8">
            <?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>
        </div>
        <div class="col-12 col-lg-4">

            <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/images/warehouse-2.jpg">
        </div>
    </div>
</div>




<?php
get_footer();