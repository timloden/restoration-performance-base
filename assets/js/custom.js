"use strict";

console.log('custom js');
"use strict";

(function ($) {
  // set country to US
  var country_input = $('.woocommerce-shipping-calculator').find('#calc_shipping_country');

  if (country_input) {
    country_input.val('US');
    country_input.hide();
  }
})(jQuery);
"use strict";

(function ($) {
  $(function () {
    /*
    After FacetWP reloads, store any updates into a cookie
    */
    $(document).on('facetwp-loaded', function () {
      var home = $('body.home'); // scroll to content if facets loaded

      if (FWP.loaded && home.length != 1) {
        $('html, body').animate({
          scrollTop: $('#content').offset().top
        }, 500);
      }

      var date = new Date();
      var facets = FWP_HTTP.get._year_make_model;
      date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
      var vehicle = ''; //var facetdata = readCookie('facetdata');

      if (facets) {
        var vehicleCookie = readCookie('vehicle');

        if (!vehicleCookie) {
          // get vehicle form selected ymm facets
          $('.facetwp-type-hierarchy_select option:selected').each(function () {
            var item = $(this).text() + ' ';
            vehicle += item;
          }); // set cookie for vehicle

          if (FWP.facets.year_make_model.length === 3) {
            document.cookie = 'vehicle=' + vehicle + '; expires=' + date.toGMTString() + '; path=/';
          }
        } else {
          vehicle = vehicleCookie;
        } // update the your vehicle with facet selection


        $('#your-vehicle').html(vehicle); // set ymm facet with proper query string

        facets = '?_year_make_model=' + facets; // set ymm facet cookie

        document.cookie = 'facetdata=' + facets + '; expires=' + date.toGMTString() + '; path=/';
      } // remove loader


      $('.facetwp-template .is-loading').remove(); // check if have a facet cookie

      var facetdata = readCookie('facetdata'); // if on a search page, have facets but are missing facet in the url, add it

      if (window.location.href.indexOf('s=') && facetdata && !facets) {
        facetdata = facetdata.replace('?', '&');
        window.location.search = window.location.search + facetdata;
      }
    });
    /*
    When FacetWP first initializes, look for the "facetdata" cookie
    If it exists, set window.location.search= facetdata
    */

    $(document).on('facetwp-refresh', function () {
      // add loading screen
      $('.facetwp-template').prepend('<div class="is-loading position-absolute w-100 h-100"> <div class="d-flex w-100 h-100 justify-content-center align-items-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div></div>');

      if (!FWP.loaded) {
        var facets = FWP_HTTP.get._year_make_model;
        var facetdata = readCookie('facetdata');

        if (null != facetdata && '' != facetdata && facets != facetdata) {
          // if we are on a search page, change the ? to a &
          if (!window.location.href.indexOf('s=') !== 1 && !facets) {
            facetdata = facetdata.replace('?', '&');
            window.location.search = window.location.search + facetdata;
          } else if (!window.location.search) {
            window.location.search = window.location.search + facetdata;
          }
        }
      }

      var home = $('body.home'); // if home, redirect us to shop after selecting ymm

      if (home.length === 1 && FWP.facets.year_make_model.length === 3) {
        if (!facetdata) {
          window.location.href = window.location.hostname + '/shop';
        }
      } // un hide categories and buttons if we have facets


      if (FWP.facets.year_make_model) {
        if (FWP.facets.year_make_model.length === 3) {
          $('#selected-vehicle').removeClass('d-none');
          $('#ymm-bar').addClass('d-none');
        }
      }
    }); // shown in YMM bar

    $('#clear-vehicle').on('click', function () {
      clearVehicle();
      FWP.reset('year_make_model');
    }); // shown on search page

    $('#remove-vehicle').on('click', function () {
      clearVehicle();
      $('#ymm-bar').addClass('d-none');
      $(this).html('<i class="las la-check"></i> Cleared!');
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
      var currentVehicle = readCookie('facetdata');

      if (currentVehicle) {
        document.cookie = 'vehicle=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
        document.cookie = 'facetdata=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/'; //$('#clear-vehicle').addClass('d-none');

        $('#your-vehicle').html('');
        $('#selected-vehicle').addClass('d-none');
        $('#ymm-bar').removeClass('d-none');
      }

      console.log('cleared');
    }
  });
})(jQuery);
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
      controlsContainer: '.slide-arrows',
      nav: false,
      prevButton: '.slide-prev',
      nextButton: '.slide-next',
      autoplayButtonOutput: false,
      lazyload: true
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
  $('#show-fitment').on('click', function (e) {
    console.log('clicked fitment');
    e.preventDefault();
    $('#product-tab #product-fitment_tab-tab').tab('show');
    $('body,html').animate({
      scrollTop: $('#product-tab').offset().top
    }, 800 //speed
    );
  });
})(jQuery);
//ScrollReveal().reveal('.title-border');
"use strict";