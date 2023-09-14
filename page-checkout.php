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
<div class="container">
    <?php
    while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content', 'page' );

    endwhile; // End of the loop.
?>
</div>
<?php
get_footer();