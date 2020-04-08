<?php
/**
 * underscores functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package underscores
 */

if (! function_exists('theme_setup') ) :

    function theme_setup()
    {

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
            'html5', array(
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

    }
endif;

add_action('after_setup_theme', 'theme_setup');

/**
 * Load includes
 */

function includes_autoload()
{
    $function_path = pathinfo(__FILE__);

    foreach ( glob($function_path['dirname'] . '/inc/*.php') as $file ) {
        include_once $file;
    }
}

add_action('after_setup_theme', 'includes_autoload');
