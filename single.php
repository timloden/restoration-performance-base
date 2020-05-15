<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package underscores
 */

get_header();
$post_date = get_the_date( 'F j, Y' );
$categories = get_the_category();
?>

<div id="primary" class="content-area article-single">
    <main id="main" class="site-main">
        <div class="jumbotron jumbotron-fluid"
            style="background-image: url(<?php the_post_thumbnail_url('full'); ?>); background-position: center center; background-size: cover; position: relative">

            <div class="container">
                <h1 class="display-4 text-white font-weight-bold"><?php the_title(); ?></h1>
                <p class="lead text-light">Posted on: <?php echo $post_date ?> in
                    <?php echo esc_html( $categories[0]->name ); ?>
                </p>
            </div>
            <div class="hero-overlay"></div>
        </div>

        <div class="container">
            <?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content-single', get_post_type() );

		endwhile; // End of the loop.
		?>

            <?php
			$args = array(
				'posts_per_page' => 4, // How many items to display
				'post__not_in'   => array( get_the_ID() ), // Exclude current post
				'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
			);
			$cats = wp_get_post_terms( get_the_ID(), 'category' ); 
			$cats_ids = array();  
			foreach( $cats as $related_cat ) {
				$cats_ids[] = $related_cat->term_id; 
			}
			if ( ! empty( $cats_ids ) ) {
				$args['category__in'] = $cats_ids;
			}
			$loop = new WP_Query( $args );
			
			if ( $loop->have_posts() ) {
				echo '<h3 class="py-3">Related Articles:</h3>';
				echo '<div class="row">';
				while ( $loop->have_posts() ) : $loop->the_post();
					get_template_part( 'template-parts/content', get_post_type() );
				endwhile;
				echo '</div>';
			}
			wp_reset_postdata();
			?>

        </div>



    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();