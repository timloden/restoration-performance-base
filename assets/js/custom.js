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

(function ($) {})(jQuery);
"use strict";

var homeSlider = tns({
  container: '.home-slider',
  items: 1,
  slideBy: 'page',
  autoplay: true,
  controlsPosition: 'bottom',
  navPosition: 'bottom'
});