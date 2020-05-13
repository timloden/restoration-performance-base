<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package restoration-performance
 */

?>
<div class="col-12 col-lg-4">
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="card">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'title' => 'Feature image']);
 ?>
            </a>
            <div class="card-body">
                <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
            </div>
        </div>


    </div><!-- #post-<?php the_ID(); ?> -->
</div>