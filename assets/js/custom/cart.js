(function ($) {
    // set country to US
    var country_input = $('.woocommerce-shipping-calculator').find(
        '#calc_shipping_country'
    );

    if (country_input) {
        country_input.val('US');
        country_input.hide();
    }

})(jQuery);