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
				'posts_per_page' => 4, // How many items to display
				//'post__not_in'   => array( get_the_ID() ), // Exclude current post
				//'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
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
					echo '<div class="row">';
					while ( $loop->have_posts() ) : $loop->the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
					echo '</div>';
				}
				wp_reset_postdata();
				}



			// if ( ! empty( $cats_ids ) ) {
			// 	$args['category__in'] = $cats_ids;
			// }
			// $loop = new WP_Query( $args );
			
			// if ( $loop->have_posts() ) {
			// 	echo '<h3 class="py-3">Related Articles:</h3>';
			// 	echo '<div class="row">';
			// 	while ( $loop->have_posts() ) : $loop->the_post();
			// 		get_template_part( 'template-parts/content', get_post_type() );
			// 	endwhile;
			// 	echo '</div>';
			// }
			// wp_reset_postdata();
			?>


            <?php
		// if ( have_posts() ) :

		// 	/* Start the Loop */
		// 	while ( have_posts() ) :
		// 		the_post();

		// 		/*
		// 		 * Include the Post-Type-specific template for the content.
		// 		 * If you want to override this in a child theme, then include a file
		// 		 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
		// 		 */
		// 		get_template_part( 'template-parts/content', get_post_type() );

		// 	endwhile;

		// 	the_posts_navigation();

		// else :

		// 	get_template_part( 'template-parts/content', 'none' );

		// endif;
		?>

        </main><!-- #main -->
    </div><!-- #primary -->
</div>


<?php
get_footer();