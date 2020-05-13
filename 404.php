<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package underscores
 */

get_header();
?>
<div class="container">


    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <section class="error-404 not-found">
                <header class="page-header pt-3">
                    <h1 class="page-title">
                        <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'underscores' ); ?>
                    </h1>
                </header><!-- .page-header -->

                <div class="page-content">
                    <?php
			$args = array(
				'posts_per_page' => 3, // How many items to display
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
					echo '<div class="row">';
					while ( $loop->have_posts() ) : $loop->the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
					echo '</div>';
					echo '<a href="' . site_url() . '\category/' . $cat->slug . '">Browse all ' . $cat->name . ' articles</a>';
				}
				wp_reset_postdata();
				}
			?>
                </div><!-- .page-content -->
            </section><!-- .error-404 -->

        </main><!-- #main -->
    </div><!-- #primary -->
</div>
<?php
get_footer();