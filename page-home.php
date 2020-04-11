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
<div style="height: 300px;">
    <div class="home-slider">
        <div>
            <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/images/firebird.jpg">
        </div>
        <div>
            <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/images/hot-rod.jpg">
        </div>
        <div>
            <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/images/charger.jpg">
        </div>
    </div>
</div>
<div class="container">

</div><!-- #primary -->

<?php
get_sidebar();
get_footer();