<?php

//Add Search To Admin Bar
function orders_admin_bar_form() {
    global $wp_admin_bar;

    $site_url = get_site_url();
    
    if (current_user_can('administrator') || current_user_can( 'manage_woocommerce' )) {
        $wp_admin_bar->add_menu(array(
            'id' => 'orders_admin_bar_form',
            'parent' => 'top-secondary',
            'title' => '<input type="text" style="min-height: 20px; height: 20px; padding: 2px;" id="order_id">
            <button id="open_order" class="button" style="font-size: 12px; padding: 6px 5px; line-height: 1; min-height: auto; margin-top: 3px;">Open Order</button>
            <script>
              jQuery("#open_order").click(function() {
                  userEntry1 = jQuery("#order_id").val();
                  if (jQuery.isNumeric(userEntry1)) {
                      window.location.href = "' . $site_url . '" + "/wp-admin/post.php?post=" + userEntry1 + "&action=edit";
                  }
              });
            </script>
            '
        ));
    } 
  }
  add_action('admin_bar_menu', 'orders_admin_bar_form');