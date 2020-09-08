<?php

// Dynacorn import functions

function dynacorn_pricing( $cost = null, $model = '' ) {

    // Ensure a cost was provided.
    if ( !empty( $cost ) ) {
		
        // Remove unwanted characters from price.
        $cost = preg_replace("/[^0-9,.]/", "", $cost);
	
		if ($cost <= 15) {
			$calculated_price = (round($cost * 1.53)) - 0.05;
		} elseif ($cost > 15 && $cost <= 70) {
			$calculated_price = (round($cost * 1.43)) - 0.05;
		} elseif ($cost > 70 && $cost <= 175) {
			$calculated_price = (round($cost * 1.33)) - 0.05;
		} elseif ($cost > 175 && $cost <= 800) {
			$calculated_price = (round($cost * 1.25)) - 0.05;
		} elseif ($cost > 800) {
			$calculated_price = (round($cost * 1.22)) - 0.05;
		}
		
		if ( $model == 'MUSTANG' ) {
			$calculated_price = (round($calculated_price * 0.98)) - 0.05;
		}
		
        // Return price otherwise.
        return $calculated_price;

    }
}

function dynacorn_stock_status( $ca = null, $pa = null ) {

    if ($ca <= 0 && $pa <= 0) {
        $stock = 'onbackorder';
    } else {
        $stock = 'instock';
    }

    return $stock;
}


// OER import functions

function oer_pricing( $cost = null ) {

    // Ensure a cost was provided.
    if ( !empty( $cost ) ) {
		
        // Remove unwanted characters from price.
        $cost = preg_replace("/[^0-9,.]/", "", $cost);
	
		if ($cost <= 20) {
			$calculated_price = (round($cost * 1.5)) - 0.05;
		} elseif ($cost > 20 && $cost <= 50) {
			$calculated_price = (round($cost * 1.35)) - 0.05;
		} elseif ($cost > 50 && $cost <= 150) {
            $calculated_price = (round($cost * 1.30)) - 0.05;
        } elseif ($cost > 150) {
			$calculated_price = (round($cost * 1.25)) - 0.05;
		}

        // Return price otherwise.
        return $calculated_price;

    }
}

function oer_stock_status( $ca = null ) {

    if ($ca <= 0 ) {
        $stock = 'onbackorder';
    } else {
        $stock = 'instock';
    }

    return $stock;
}

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

function get_rpui_product_by_sku( $sku = '', $brand ) {
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

    // Ensure a cost was provided.
    if ( !empty( $cost ) ) {
		
        // Remove unwanted characters from price.
        $cost = preg_replace("/[^0-9,.]/", "", $cost);
	
		if ($cost <= 20) {
			$calculated_price = (round($cost * 1.57)) - 0.05;
		} elseif ($cost > 20 && $cost <= 60) {
			$calculated_price = (round($cost * 1.52)) - 0.05;
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