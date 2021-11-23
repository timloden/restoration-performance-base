(function ($) {
    // set country to US
    var country_input = $('.woocommerce-shipping-calculator').find(
        '#calc_shipping_country'
    );

    if (country_input) {
        country_input.val('US');
        country_input.hide();
    }
    
    $('.woocommerce').on('change', 'input.qty', function() {
        var timeout;
        if (timeout !== undefined) {
            clearTimeout(timeout);
        }

        timeout = setTimeout(function() {
            $("[name='update_cart']").trigger("click");
        }, 500); // 1 second delay, half a second (500) seems comfortable too

    });

})(jQuery);
