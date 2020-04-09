<?php
/**
 * WP YMM Walker
 * https://wpquestions.com/wp_list_categories_unlink_or_style_empty/8622
 */

// Check if Class Exists.
if (! class_exists('WPQuestions_Walker') ) {
    class WPQuestions_Walker extends Walker_Category
    {

        function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 )
        {
        
            extract($args); 
        
        
        
            $cat_name = esc_attr($category->name);
        
            $cat_name = apply_filters('list_cats', $cat_name, $category);
        
        
        
            // ---
        
            $termchildren = get_term_children($category->term_id, $category->taxonomy);
        
            if($category->count >0 ) {
        
                $aclass = ' class="cat_has_posts" ';
        
            }
            else
            $aclass = ' class="cat_has_no_posts" ';
        
        
        
            $link = '<span '. $aclass;
        
            // ---
        
        
        
            if ($use_desc_for_title == 0 || empty($category->description) )
        
            $link .= 'title="' . esc_attr(sprintf(__('View all posts filed under %s'), $cat_name)) . '"';
        
            else
        
            $link .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
        
            $link .= '>';
        
            $link .= $cat_name . '</span>';
        
        
        
            if (!empty($show_count) )
        
            $link .= ' (' . intval($category->count) . ')';
        
        
        
            if ('list' == $args['style'] ) {
        
                $output .= "\t<li";
        
                $class = 'cat-item cat-item-' . $category->term_id;
        
        
        
                if (!empty($current_category) ) {
        
                    $_current_category = get_term($current_category, $category->taxonomy);
        
                    if ($category->term_id == $current_category )
        
                    $class .= ' current-cat';
        
                    elseif ($category->term_id == $_current_category->parent )
        
                    $class .= ' current-cat-parent';
        
                }
        
                $output .= ' class="' . $class . '"';
        
                $output .= ">$link\n";
        
            } elseif ('div' == $args['style'] ) {
                

            } else {
        
                $output .= "\t$link<br />\n";
        
            }
        
        }
        
    }
    
}