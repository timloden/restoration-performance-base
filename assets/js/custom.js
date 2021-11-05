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
  /*
  After FacetWP reloads, store any updates into a cookie
  */
  var facetCookie = readCookie('facetdata');
  $(document).on('facetwp-loaded', function () {
    var date = new Date();
    date.setTime(date.getTime() + 24 * 60 * 60 * 1000);

    if (FWP.facets.year_make_model.length === 3 && !facetCookie) {
      var facets = FWP.facets.year_make_model;
      document.cookie = "facetdata=" + facets + "; expires=" + date.toGMTString() + "; path=/";
    }

    $('.facetwp-template .is-loading').remove();
  });
  /*
  When FacetWP first initializes, look for the "facetdata" cookie
  If it exists, set window.location.search= facetdata
  */

  $(document).on('facetwp-refresh', function () {
    showFacetLoading();

    if (!FWP.loaded) {
      if (facetCookie) {
        FWP.facets['year_make_model'] = facetCookie.split(',');
        FWP.fetchData();
      }
    }
  });

  function showFacetLoading() {
    $('.facetwp-template').prepend('<div class="is-loading position-absolute w-100 h-100"> <div class="d-flex w-100 h-100 justify-content-center mt-5"><div class="d-block text-center mt-5 text-primary"><p class="fw-bold">Loading parts</p><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div></div></div>');
  } // shown in YMM bar


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