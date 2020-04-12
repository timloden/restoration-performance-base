(function ($) {
    var home = $('body.home');

    if (home.length === 1) {
        const homeSlider = tns({
            container: '.home-slider',
            items: 1,
            slideBy: 'page',
            autoplay: true,
            controlsPosition: 'bottom',
            navPosition: 'bottom',
        });
    }
})(jQuery);
