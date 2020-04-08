<?php
/**
 * Register widget area
 */
function widgets_init()
{
    register_sidebar(
        array(
        'name'          => esc_html__('Sidebar', 'restoration-performance'),
        'id'            => 'sidebar',
        'description'   => esc_html__('Add widgets here.', 'restoration-performance'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
        ) 
    );

    register_sidebar(
        array(
        'name'          => esc_html__('Shop', 'restoration-performance'),
        'id'            => 'shop',
        'description'   => esc_html__('Add widgets here.', 'restoration-performance'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
        ) 
    );
}
add_action('widgets_init', 'widgets_init');