<?php

function get_oer_product_by_sku( $sku = '' ) {
    // Add OER to SKU
    $sku .= "-OER";
    
    // Match by our files SKU and ignore slashes in the database.
    //$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' LIMIT 1", $sku ) );

    $product_id = wc_get_product_id_by_sku($sku);

    // If a match was found return its ID.
    if ( $product_id ) return $product_id;

    return null;
}


// RPUI import functions

function get_rpui_product_by_sku( $sku = '', $brand = '' ) {
    // Append brand to SKU
    
    if ($brand == 'Trim Parts') {
        $sku .= "-TP";
    } else if ($brand == 'PUI') {
        $sku .= "-PUI";
    } else if ($brand == 'TRSD') {
        $sku .= "-RSD";
    } else if ($brand == 'Soffseal') {
        $sku .= "-SS";
    }

    $product_id = wc_get_product_id_by_sku($sku);

    // If a match was found return its ID.
    if ( $product_id ) return $product_id;

    return null;
}

function pui_pricing( $cost = null ) {

    // Ensure a cost was provided.
    if ( !empty( $cost ) ) {
		
        // Remove unwanted characters from price.
        $cost = preg_replace("/[^0-9,.]/", "", $cost);
	
		$calculated_price = (round($cost * 1.4)) - 0.05;

        // Return price otherwise.
        return $calculated_price;

    }
}


// Goodmark import functions

function goodmark_pricing( $cost = null ) {
    $global_price_modifier = 0.03;

    // Ensure a cost was provided.
    if ( !empty( $cost ) ) {
		
        // Remove unwanted characters from price.
        $cost = preg_replace("/[^0-9,.]/", "", $cost);
	
		if ($cost <= 20) {
			$calculated_price = (round($cost * (1.52 + $global_price_modifier))) - 0.05;
		} elseif ($cost > 20 && $cost <= 60) {
			$calculated_price = (round($cost * (1.47 + $global_price_modifier))) - 0.05;
		} elseif ($cost > 60 && $cost <= 130) {
			$calculated_price = (round($cost * (1.37 + $global_price_modifier))) - 0.05;
		} elseif ($cost > 130 && $cost <= 200) {
			$calculated_price = (round($cost * (1.32 + $global_price_modifier))) - 0.05;
		} elseif ($cost > 200 && $cost <= 600) {
			$calculated_price = (round($cost * (1.27 + $global_price_modifier))) - 0.05;
		} elseif ($cost > 600) {
			$calculated_price = (round($cost * (1.22 + $global_price_modifier))) - 0.05;
		}
		
        // Return price otherwise.
        return $calculated_price;

    }
}

// Sherman import functions

function get_sherman_product_by_sku( $sku = '' ) {
    // Add OER to SKU
    $sku .= "-SHE";
    
    // Match by our files SKU and ignore slashes in the database.
    //$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' LIMIT 1", $sku ) );

    $product_id = wc_get_product_id_by_sku($sku);

    // If a match was found return its ID.
    if ( $product_id ) return $product_id;

    return null;
}

function sherman_pricing( $cost = null ) {

    // Ensure a cost was provided.
    if ( !empty( $cost ) ) {
		
        // Remove unwanted characters from price.
        $cost = preg_replace("/[^0-9,.]/", "", $cost);
	
		if ($cost <= 20) {
			$calculated_price = (round($cost * 1.62)) - 0.05;
		} elseif ($cost > 20 && $cost <= 60) {
			$calculated_price = (round($cost * 1.57)) - 0.05;
		} elseif ($cost > 60 && $cost <= 130) {
			$calculated_price = (round($cost * 1.42)) - 0.05;
		} elseif ($cost > 130 && $cost <= 200) {
			$calculated_price = (round($cost * 1.37)) - 0.05;
		} elseif ($cost > 200 && $cost <= 600) {
			$calculated_price = (round($cost * 1.32)) - 0.05;
		} elseif ($cost > 600) {
			$calculated_price = (round($cost * 1.27)) - 0.05;
		}
		
        // Return price otherwise.
        return $calculated_price;

    }
}

// orders - get order subtotal

function get_subtotal($value) {
    $order = wc_get_order( $value );
    $subtotal = $order->get_subtotal();
    return $subtotal;
}

// orders - get order discounts

function get_discount_total($value) {
    $order = wc_get_order( $value );
    $discount = $order->get_discount_total();
    return $discount;
}


// create csv for new instock products

function before_xml_import( $import_id ) {

    $dynacorn_import_id = get_field('dynacorn_import_id', 'option');
    $oer_import_id = get_field('oer_import_id', 'option');
    $goodmark_import_id = get_field('goodmark_import_id', 'option');

    if ($import_id == $dynacorn_import_id || $import_id == $oer_import_id || $import_id == $goodmark_import_id) { 

        $uploads = wp_upload_dir();        
        $todays_date = date('m-d-Y');

        if ($import_id == $dynacorn_import_id) {
            $file = $uploads['basedir'] . '/vendors/dynacorn/instock-items-' . $todays_date . '.csv';
        } elseif ($import_id == $oer_import_id) {
            $file = $uploads['basedir'] . '/vendors/oer/instock-items-' . $todays_date . '.csv';
        } elseif ($import_id == $goodmark_import_id) {
            $file = $uploads['basedir'] . '/vendors/goodmark/instock-items-' . $todays_date . '.csv';
        }

        if(!is_file($file)){  
            $handle = fopen($file, "a");
            $line = [
                "ID",
                "Product Name",
                "SKU",
                "Price",
            ];
            fputcsv($handle, $line);
            fclose($handle);
        }

    }

}
add_action('pmxi_before_xml_import', 'before_xml_import', 10, 1);

// added items that have been updated form onbackorder to instock

function only_update_if_stock_status_changed ( $continue_import, $post_id, $data, $import_id ) {
    
    $dynacorn_import_id = get_field('dynacorn_import_id', 'option');
    $oer_import_id = get_field('oer_import_id', 'option');
    $goodmark_import_id = get_field('goodmark_import_id', 'option');

    if ($import_id == $dynacorn_import_id || $import_id == $oer_import_id || $import_id == $goodmark_import_id) { 

        $uploads = wp_upload_dir();        
        $todays_date = date('m-d-Y');

        // get our file
        if ($import_id == $dynacorn_import_id) {
            $file = $uploads['basedir'] . '/vendors/dynacorn/instock-items-' . $todays_date . '.csv';
        } elseif ($import_id == $oer_import_id) {
            $file = $uploads['basedir'] . '/vendors/oer/instock-items-' . $todays_date . '.csv';
        } elseif ($import_id == $goodmark_import_id) {
            $file = $uploads['basedir'] . '/vendors/goodmark/instock-items-' . $todays_date . '.csv';
        }

        // get the import stock status
        if ($import_id == $dynacorn_import_id) {
            $import_stock_status = $data["stockstatus"];
        } elseif ($import_id == $oer_import_id) {
            $import_stock_status = $data["availableqty"];
        } elseif ($import_id == $goodmark_import_id) {
            $import_stock_status = $data["quantityavailable"];
        }

        $handle = fopen($file, "a");

        // Retrieve product's current stock status.
        $woo_stock_status = get_post_meta($post_id, "_stock_status", true);

        if ($woo_stock_status == 'onbackorder' && $import_stock_status == 'instock') {

            $product_sku = get_post_meta($post_id, "_sku", true);
            $product_title = get_the_title($post_id);
            //$product_price = get_post_meta($post_id, "_regular_price", true);

            if ($import_id == $dynacorn_import_id) {
                $line = [
                    $post_id,
                    $product_title,
                    $product_sku,
                    $data["saleprice"],
                ];
            } else {
                $line = [
                    $post_id,
                    $product_title,
                    $product_sku,
                    $data["price"],
                ];
            }

            if(is_file($file)){
                fputcsv($handle, $line);
                fclose($handle);
            }
        }

        return true;

    }

    // Do nothing if it's not our target import.
    return $continue_import;

}

add_filter( 'wp_all_import_is_post_to_update', 'only_update_if_stock_status_changed', 10, 4 );

// email out the csv

function send_instock_email($import_id) {

    $dynacorn_import_id = get_field('dynacorn_import_id', 'option');
    $oer_import_id = get_field('oer_import_id', 'option');
    $goodmark_import_id = get_field('goodmark_import_id', 'option');

    if ($import_id == $dynacorn_import_id || $import_id == $oer_import_id || $import_id == $goodmark_import_id) { 
    
        $uploads = wp_upload_dir();  
        $todays_date = date('m-d-Y');
    
        // get our file
        if ($import_id == $dynacorn_import_id) {
            $file = $uploads['basedir'] . '/vendors/dynacorn/instock-items-' . $todays_date . '.csv';
            $brand = 'Dynacorn';
        } elseif ($import_id == $oer_import_id) {
            $file = $uploads['basedir'] . '/vendors/oer/instock-items-' . $todays_date . '.csv';
            $brand = 'OER';
        } elseif ($import_id == $goodmark_import_id) {
            $file = $uploads['basedir'] . '/vendors/goodmark/instock-items-' . $todays_date . '.csv';
            $brand = 'Goodmark';
        }

        // Destination email address.
        $to = 'orders@restorationperformance.com';

        // Email subject.
        $subject = $brand . ' Products changed from on backorder to in stock on: ' . $todays_date;

        // Email message.
        $body = 'CSV Attached';

        // Send the email as HTML.
        $headers = array('Content-Type: text/html; charset=UTF-8');
    
        // Send via WordPress email.
        wp_mail( $to, $subject, $body, $headers, $file );

    }
}

add_action('pmxi_after_xml_import', 'send_instock_email', 10, 1);