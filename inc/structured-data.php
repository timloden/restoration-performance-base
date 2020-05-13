<?php

function article_structured_data($id) {
    $post = get_post( $id );
    $featured_img_url = get_the_post_thumbnail_url($id, 'full');
    $permalink = get_the_permalink($id);
    $logo = get_field('logo', 'option');

    $output = [
    "@context" => "https://schema.org",
      "@type" => "NewsArticle",
      "mainEntityOfPage" => [
        "@type" => "WebPage",
        "@id" => $permalink
      ],
      "headline" => $post->post_title,
      "image" => [
        $featured_img_url
       ],
      "datePublished" => get_the_date('c'),
      "dateModified" => get_the_modified_date('c'),
      "author" => [
        "@type" => "Organization",
        "name" => "Classic Body Parts"
      ],
       "publisher" => [
        "@type" => "Organization",
        "name" => "Classic Body Parts",
        "logo" => [
          "@type" => "ImageObject",
          "url" => $logo['url']
        ]
       ]
        ];
    echo '<script type="application/ld+json">';
    echo json_encode($output);
    echo '</script>';
}

function product_structured_data($id) {
    $product = wc_get_product( $id );
    $featured_img_url = get_the_post_thumbnail_url($id, 'full');
    $permalink = get_the_permalink($id);
    $stock = $product->get_stock_status();
    $stock_output = 'https://schema.org/OutOfStock';

    if ($stock == 'instock') {
        $stock_output = 'https://schema.org/InStock';
    }

    $brands = wp_get_object_terms( $product->get_id(), 'pwb-brand' );
    foreach( $brands as $brand ) {
        $brand_name = $brand->name;
    }

    $output = [
        "@context" => "https://schema.org/",
        "@type" => "Product",
        "name" => $product->get_name(),
        "image" => [
            $featured_img_url 
         ],
        "description" => $product->get_description(),
        "sku" => $product->get_sku(),
        "mpn" => $product->get_sku(),
        "brand" => [
          "@type"  => "Organization",
          "name"  => $brand_name
        ],
        "aggregateRating" => [
          "@type" => "AggregateRating",
          "ratingValue" => $product->get_average_rating(),
          "reviewCount" => $product->get_review_count()
        ],
        "offers" => [
          "@type" => "Offer",
          "url" => $permalink,
          "priceCurrency" => "USD",
          "price" => $product->get_price(),
          "itemCondition" => "https://schema.org/NewCondition",
          "availability" => $stock_output,
          "seller" => [
            "@type" => "Organization",
            "name" => "Classic Body Parts"
          ]
        ]
        ];
    echo '<script type="application/ld+json">';
    echo json_encode($output);
    echo '</script>';
}