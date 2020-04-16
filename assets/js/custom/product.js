(function ($) {
    $(document.body).on('added_to_cart', function () {
        // change the button text to added
        console.log('EVENT: added_to_cart');
        setTimeout(function () {
            $('a.added').html(
                '<i class="las la-check-circle"></i> Added to Cart!'
            );
        }, 50);

        // remove added class and change text back
        setTimeout(function () {
            $('a.added').html('Add to Cart');
            $('a.added').removeClass('added');
        }, 2000);
    });
})(jQuery);
