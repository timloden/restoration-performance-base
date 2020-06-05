<?php

// Dynacorn import functions

function dynacorn_pricing( $cost = null, $model = '' ) {

    // Ensure a cost was provided.
    if ( !empty( $cost ) ) {
		
        // Remove unwanted characters from price.
        $cost = preg_replace("/[^0-9,.]/", "", $cost);
	
		if ($cost <= 15) {
			$calculated_price = (round($cost * 1.5)) - 0.05;
		} elseif ($cost > 15 && $cost <= 70) {
			$calculated_price = (round($cost * 1.4)) - 0.05;
		} elseif ($cost > 70 && $cost <= 175) {
			$calculated_price = (round($cost * 1.3)) - 0.05;
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
			$calculated_price = (round($cost * 1.45)) - 0.05;
		} elseif ($cost > 20 && $cost <= 50) {
			$calculated_price = (round($cost * 1.35)) - 0.05;
		} elseif ($cost > 50) {
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