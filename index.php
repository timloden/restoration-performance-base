<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package underscores
 */

get_header();
?>
<div class="bg-light border-bottom">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <header class="page-header">
                    <h1 class="page-title text-center">Classic Body Parts Resources</h1>
                    <div class="archive-description text-center"></div>
                </header><!-- .page-header -->
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php
			$args = array(
				'posts_per_page' => 6, // How many items to display
				'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
			);
			$cats = get_terms( array(
				'taxonomy' => 'category',
				'hide_empty' => true,
			) );

			$cats_ids = array();  
			foreach( $cats as $cat ) {

				$args['category__in'] = $cat;
				$loop = new WP_Query( $args );
			
				if ( $loop->have_posts() ) {
					echo '<h3 class="py-3">' . $cat->name . '</h3>';
					echo '<div class="row pb-3">';
					while ( $loop->have_posts() ) : $loop->the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
					echo '</div>';
					echo '<a class="text-right d-block" href="' . site_url() . '\category/' . $cat->slug . '">Browse all ' . $cat->name . ' articles <i class="las la-arrow-right"></i></a>';
				}
				wp_reset_postdata();
				}
			?>

        </main><!-- #main -->
    </div><!-- #primary -->
</div>


<?php
get_footer();