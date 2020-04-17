(function ($) {
    $(function () {
        /*
        After FacetWP reloads, store any updates into a cookie
        */

        $(document).on('facetwp-loaded', function () {
            var date = new Date();
            var facets = FWP_HTTP.get.fwp_year_make_model;
            date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
            var facetCookie = readCookie('facetdata');

            if (facets) {
                //console.log(facetCookie);

                var vehicle = '';

                $('.facetwp-type-hierarchy_select option:selected').each(
                    function () {
                        var item = $(this).text() + ' ';
                        vehicle += item;
                    }
                );

                document.cookie =
                    'vehicle=' +
                    vehicle +
                    '; expires=' +
                    date.toGMTString() +
                    '; path=/';

                $('#clear-vehicle').toggle();

                facets = '?fwp_year_make_model=' + facets;

                document.cookie =
                    'facetdata=' +
                    facets +
                    '; expires=' +
                    date.toGMTString() +
                    '; path=/';
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
                console.log(facetdata);
                if (
                    null != facetdata &&
                    '' != facetdata &&
                    facets != facetdata
                ) {
                    document.cookie =
                        'facetdata=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
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
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0)
                    return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        function clearVehicle() {
            var currentVehicle = readCookie('vehicle');

            if (currentVehicle) {
                document.cookie =
                    'vehicle=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
                document.cookie =
                    'facetdata=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';

                $('#clear-vehicle').toggle();
            }

            console.log('cleared');
        }
    });
})(jQuery);
