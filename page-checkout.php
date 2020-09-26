<?php

/**
 * Template Name: Checkout Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package restoration-performance
 */

get_header();
?>

<?php
    while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content', 'page' );

    endwhile; // End of the loop.
?>

<?php
get_footer();