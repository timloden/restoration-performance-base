<?php
/**
 * underscores functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package underscores
 */

if (! function_exists('theme_setup') ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function theme_setup()
    {

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
            'menu-1' => esc_html__('Primary', 'underscores'),
            ) 
        );

        /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
        add_theme_support(
            'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            ) 
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background', apply_filters(
                'underscores_custom_background_args', array(
                'default-color' => 'ffffff',
                'default-image' => '',
                ) 
            ) 
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
            ) 
        );
    }
endif;

add_action('after_setup_theme', 'theme_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function underscores_widgets_init()
{
    register_sidebar(
        array(
        'name'          => esc_html__('Sidebar', 'underscores'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'underscores'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
        ) 
    );
}
add_action('widgets_init', 'underscores_widgets_init');

function includes_autoload()
{
    $function_path = pathinfo(__FILE__);

    foreach ( glob($function_path['dirname'] . '/inc/*.php') as $file ) {
        include_once $file;
    }
}

add_action('after_setup_theme', 'includes_autoload');