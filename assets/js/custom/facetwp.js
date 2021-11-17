(function ($) {
    
        /*
        After FacetWP reloads, store any updates into a cookie
        */

        var facetCookie = readCookie('facetdata');

         /*
        When FacetWP first initializes, look for the "facetdata" cookie
        If it exists, set window.location.search= facetdata
        */

        $(document).on('facetwp-refresh', function() {
            
            if (FWP.loaded) {
                showFacetLoading();
            }

            if (! FWP.loaded) {
                showFacetLoading();
                if (facetCookie) {
                    FWP.facets['year_make_model'] = facetCookie.split(',');
                    FWP.fetchData();
                }
            }

            
        });

        $(document).on('facetwp-loaded', function() {
            
            // scroll to content if facets loaded
            if (FWP.loaded) {
                $('html, body').animate(
                    {
                        scrollTop: $('#content').offset().top,
                    },
                    500
                );
            }

            var date = new Date();
            date.setTime(date.getTime()+(24*60*60*1000));

            var facets = FWP.facets.year_make_model;

            if (facets.length === 3) { 
                document.cookie = "facetdata=" + facets + "; expires=" + date.toGMTString() + "; path=/";

                var fullVehicle = [...facets].pop();
                var ymmArray = fullVehicle.split('-').reverse();
                var selectedVehicle = uppercase(ymmArray.join(' '));

                document.cookie = "vehicle=" + selectedVehicle + "; expires=" + date.toGMTString() + "; path=/";
            } else {
                $('.facetwp-template .is-loading').remove();
            }

            if (window.location.href.indexOf('s=') && FWP.settings.pager.total_rows === 0) {
                console.log('on search and has no results');
                $('#ymm-bar').addClass('d-none');
                $('.orderby').addClass('d-none');
                $('#search-terms').addClass('d-none');
                $('#products-container').removeClass('row-cols-md-2 row-cols-lg-3');
            }

           // shown on search page
            $('#remove-vehicle').on('click', function () {
                console.log('clicked remove vehicle');
                clearVehicle();
                $('#ymm-bar').addClass('d-none');
                $('#no-results-vehicle').remove();
                $(this).html('<i class="las la-check"></i> Cleared!');
            });

        });

       

        function showFacetLoading() {
            var vehicleCookie = readCookie('vehicle');

            var vehicle = vehicleCookie ? ' for <br>' + vehicleCookie : '';
            $('.facetwp-template').prepend(
                '<div class="is-loading position-absolute w-100 h-100"> <div class="d-flex w-100 h-100 justify-content-center mt-5"><div class="d-block text-center mt-5 text-primary"><p class="fw-bold">Loading parts' + vehicle + '</p><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div></div></div>'
            );
        }


        // shown in YMM bar
        $('.clear-vehicle').on('click', function () {
            clearVehicle();
            FWP.reset('year_make_model');
        });

        
        function clearVehicle() {
            var currentVehicle = readCookie('facetdata');

            if (currentVehicle) {
                document.cookie =
                    'vehicle=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
                document.cookie =
                    'facetdata=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
            }
            console.log('cleared');
        }

        /*
        Cookie handler
        */
        function readCookie(name) {
            var nameEQ = name + '=';
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0)
                    return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

       

        function uppercase(str) {
        var array1 = str.split(' ');
        var newarray1 = [];
            
        for(var x = 0; x < array1.length; x++){
            newarray1.push(array1[x].charAt(0).toUpperCase()+array1[x].slice(1));
        }
        return newarray1.join(' ');
        }

})(jQuery);
