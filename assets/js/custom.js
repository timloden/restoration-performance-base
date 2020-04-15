"use strict";

console.log('custom js');
"use strict";

(function ($) {})(jQuery);
"use strict";

(function ($) {
  $('#dropdown-vehicle').on('click', function () {
    $('#dropdown-vehicle-content').toggleClass('show');
  });
})(jQuery);
"use strict";

(function ($) {
  var home = $('body.home');

  if (home.length === 1) {
    var homeSlider = tns({
      container: '.home-slider',
      items: 1,
      slideBy: 'page',
      autoplay: true,
      controlsPosition: 'bottom',
      navPosition: 'bottom'
    });
  }
})(jQuery);
"use strict";

(function ($) {
  $(document.body).on('added_to_cart', function () {
    console.log($('a.added'));
    setTimeout(function () {
      $('a.added').html('<i class="las la-check-circle"></i> Added to Cart!');
    }, 50);
    setTimeout(function () {
      $('a.added').html('Add to Cart');
      $('a.added').removeClass('added');
    }, 2000);
  });
})(jQuery);