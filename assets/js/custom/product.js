(function ($) {
    $(document.body).on('added_to_cart', function () {
        // change the button text to added
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

    $('#show-fitment').on('click', function (e) {
        console.log('clicked fitment');
        e.preventDefault();
        $('#product-tabs a[href="#tab-fitment_tab"]').tab('show');
        $('body,html').animate(
            {
                scrollTop: $('#product-tabs').offset().top,
            },
            800 //speed
        );
    });
})(jQuery);
