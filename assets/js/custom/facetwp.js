(function ($) {
    $(function () {
        /*
        After FacetWP reloads, store any updates into a cookie
        */

        $(document).on('facetwp-loaded', function () {
            var date = new Date();
            var facets = window.location.search;
            date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
            document.cookie =
                'facetdata=' +
                facets +
                '; expires=' +
                date.toGMTString() +
                '; path=/';
        });

        /*
        When FacetWP first initializes, look for the "facetdata" cookie
        If it exists, set window.location.search= facetdata
        */

        $(document).on('facetwp-refresh', function () {
            if (!FWP.loaded) {
                var facets = window.location.search;
                var facetdata = readCookie('facetdata');
                if (
                    null != facetdata &&
                    '' != facetdata &&
                    facets != facetdata
                ) {
                    document.cookie =
                        'facetdata=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
                    window.location.search = facetdata;
                }
            }
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
    });
})(jQuery);
