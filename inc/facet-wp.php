<?php

// add bootstrap class to selects

add_filter(
    'facetwp_facet_html',
    function ($output, $params) {
        if ('hierarchy_select' == $params['facet']['type']) {
            $output = str_replace('facetwp-hierarchy_select', 'facetwp-hierarchy_select form-control mb-2', $output);
        }
        return $output;
    },
    10,
    2
);

// remove counts from drop downs

add_filter(
    'facetwp_facet_dropdown_show_counts',
    function ($return, $params) {
        if ('year_make_model' == $params['facet']['name']) {
            $return = false;
        }
        return $return;
    },
    10,
    2
);

// if we have vehicle cookie add it to search filter