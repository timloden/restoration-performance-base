<?php

add_filter( 'woocommerce_gpf_shipping_weight_unit', function ( $unit ) {
	return 'lbs';
});