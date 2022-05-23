<?php

/**
 *  functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package restoration-performance
 */

require 'plugin-update-checker/plugin-update-checker.php';

$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/timloden/restoration-performance-base/',
    __FILE__,
    'restoration-performance-base'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();

//Optional: If you're using a private repository, specify the access token like this:
//$myUpdateChecker->setAuthentication('your-token-here');

//Optional: Set the branch that contains the stable release.
//$myUpdateChecker->setBranch('stable-branch-name');


if (!function_exists('theme_setup')) :

    function theme_setup()
    {

        // title tag
        add_theme_support( 'title-tag' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'header-primary' => esc_html__('Header Primary', 'restoration-performance'),
            )
        );

        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // bootstrap - custom nav walker
        include_once get_template_directory() . '/vendor/class-wp-bootstrap-navwalker.php';

        // ymm - taxonomy walker
        include_once get_template_directory() . '/vendor/class-wp-ymm-walker.php';

        // bootstrap - category walker
        include_once get_template_directory() . '/vendor/class-wp-category-walker.php';

         // custom tracking shortcode
         //include_once get_template_directory() . '/vendor/class-wp-custom-order-tracking.php';

        // woocommerce support
        add_theme_support('woocommerce');
        //add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        // remove emojis 
        remove_action( 'wp_head',  'print_emoji_detection_script',     7    );
        
    }
endif;

add_action('after_setup_theme', 'theme_setup');

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Site Options',
		'menu_title'	=> 'Site Options',
		'menu_slug' 	=> 'site-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	
}

// disable comments for posts 

function my_prefix_comments_open( $open, $post_id ) {
    $post_type = get_post_type( $post_id );
    // allow comments for built-in "post" post type
    if ( $post_type == 'post' || $post_type == 'page' ) {
        return false;
    }
    // disable comments for any other post types
    return true;
}
add_filter( 'comments_open', 'my_prefix_comments_open', 10 , 2 );


// remove edit link on pages
function wpse_remove_edit_post_link( $link ) {
    return '';
}

add_filter('edit_post_link', 'wpse_remove_edit_post_link');

// decrease number of action scheduler logs
add_filter( 'action_scheduler_retention_period', function() { return DAY_IN_SECONDS * 7; } );

/**
 * Load includes
 */

function includes_autoload()
{
    $function_path = pathinfo(__FILE__);

    foreach (glob($function_path['dirname'] . '/inc/*.php') as $file) {
        include_once $file;
    }
}

add_action('after_setup_theme', 'includes_autoload');