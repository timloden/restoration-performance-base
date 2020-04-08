<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package restoration-performance
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



	<div class="container">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'underscores' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'underscores' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

</div><!-- #post-<?php the_ID(); ?> -->
