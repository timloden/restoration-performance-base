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
    // change the button text to added
    setTimeout(function () {
      $('a.added').html('<i class="las la-check-circle"></i> Added to Cart!');
    }, 50); // remove added class and change text back

    setTimeout(function () {
      $('a.added').html('Add to Cart');
      $('a.added').removeClass('added');
    }, 2000);
  });
})(jQuery);
"use strict";

(function ($) {
  $(function () {
    function getUrlParameter(name) {
      name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
      var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
      var results = regex.exec(location.search);
      return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }
    /*
    After FacetWP reloads, store any updates into a cookie
    */


    $(document).on('facetwp-loaded', function () {
      var date = new Date();
      var facets = FWP_HTTP.get.fwp_year_make_model;
      date.setTime(date.getTime() + 24 * 60 * 60 * 1000);

      if (facets) {
        var vehicle = '';
        $('.facetwp-type-hierarchy_select option:selected').each(function () {
          var item = $(this).text() + ' ';
          vehicle += item;
        });
        document.cookie = 'vehicle=' + vehicle + '; expires=' + date.toGMTString() + '; path=/';
        $('.current-vehicle').html(vehicle);
        facets = '?fwp_year_make_model=' + facets;
        document.cookie = 'facetdata=' + facets + '; expires=' + date.toGMTString() + '; path=/';
      }
    });
    /*
    When FacetWP first initializes, look for the "facetdata" cookie
    If it exists, set window.location.search= facetdata
    */

    $(document).on('facetwp-refresh', function () {
      if (!FWP.loaded) {
        var facets = window.location.search;
        var facetdata = readCookie('facetdata');

        if (null != facetdata && '' != facetdata && facets != facetdata) {
          document.cookie = 'facetdata=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
          window.location.search = window.location.search + facetdata;
        }
      }
    });
    $('#reset-all-filters').on('click', function () {
      FWP.reset();
      clearVehicle();
    });
    $('#clear-vehicle').on('click', function () {
      FWP.reset('year_make_model');
      clearVehicle();
    });
    /*
    Cookie handler
    */

    function readCookie(name) {
      var nameEQ = name + '=';
      var ca = document.cookie.split(';');

      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];

        while (c.charAt(0) == ' ') {
          c = c.substring(1, c.length);
        }

        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
      }

      return null;
    }

    function clearVehicle() {
      var currentVehicle = readCookie('vehicle');

      if (currentVehicle) {
        document.cookie = 'vehicle=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
        document.cookie = 'facetdata=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
        $('.current-vehicle-section').html('');
      }

      console.log('cleared');
    }
  });
})(jQuery);