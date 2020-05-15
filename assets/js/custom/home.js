(function ($) {
    var home = $('body.home');

    if (home.length === 1) {
        const homeSlider = tns({
            container: '.home-slider',
            items: 1,
            slideBy: 'page',
            autoplay: true,
            controlsContainer: '.slide-arrows',
            nav: false,
            prevButton: '.slide-prev',
            nextButton: '.slide-next',
            autoplayButtonOutput: false,
            lazyload: true,
        });
    }
})(jQuery);
