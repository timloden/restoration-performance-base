<?php

/**
 * Template Name: FAQ Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package restoration-performance
 */

get_header();
?>
<div class="container">
    <h1 class="py-3 mb-3 title-border"><?php the_title(); ?></h1>
    <div class="row">
        <div class="col-12">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <a class="h5 d-block mb-0" type="button" data-toggle="collapse" data-target="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                                Sales tax information
                            </a>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            <p>We collect state sales tax on purchases as dictated by state legislation. For certain
                                states, Restoration Performance is not currently obligated to, and does not, collect
                                state sales tax on your purchase. For those states, your purchase is subject to tax
                                unless it is specifically exempt from taxation. Placing your order on the internet or by
                                any other remote means does NOT exempt your purchase from tax. Certain states may
                                require us to provide an annual notice to you of your purchases and to notify your state
                                tax department of your annual purchases. Details for reporting your untaxed purchases,
                                filing a tax return and paying any tax may be found on the tax department website for
                                your state of residence.</p>
                            <p>Shipping and Return policies can be found at: <a
                                    href="<?php echo site_url(); ?>/shipping/">Shipping Page</a></p>
                            <p>If you need Tracking information it can be found at: <a
                                    href="<?php echo site_url(); ?>/tracking">Track Order
                                    page</a></p>
                            <p>Store Policies and important information: <a
                                    href="<?php echo site_url(); ?>/policies/">Policies Page</a></p>
                            <p>Tech tips - Discover ways to make your restoration experience easier: <a
                                    href="<?php echo site_url(); ?>/category/tech-tips/">Browse all our Tech tips</a>
                            </p>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <a class="h5 d-block mb-0 collapsed" type="button" data-toggle="collapse"
                                data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Price Match Guarantee
                            </a>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <p><strong>If you find a product for less, we will match the price!</strong></p>
                            <p>Restoration Performance will match any competitor’s current advertised retail price for
                                an identical product and manufacture. Simply send us a copy of the competitors’ current
                                advertised price from a catalog, advertisement or website (with URL) and we’ll match the
                                price. The price match guarantee is available at the time the order is placed and
                                available for in-stock merchandise only. Price matching will be determined by a
                                competitor’s most current retail-published price and is limited to competitors selling
                                to the retail public.</p>
                            <p>If we match a price from a competitor, additional discounts on that product or products
                                may not apply. We reserve the right to modify or revoke this offer at any time without
                                notice. Sale items, kits, discount exempt products, special orders, promotional items,
                                engines, tires, and all performance parts are exempt from the Price Matching policy. We
                                reserve the right to decline price matching if the competitors’ pricing is deemed to be
                                a special offer, a sale, closeout price, promotional offer or an out-of-date price. We
                                will contact competitors to confirm that the published price is current due to market
                                changes, demand or availability.</p>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <a class="h5 d-block mb-0 collapsed" type="button" data-toggle="collapse"
                                data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Sheet Metal Body Parts
                            </a>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            <p>The sheet metal you receive may have scratches, dings, small dents and other minor
                                imperfections which are considered normal sheet metal characteristics due to the nature
                                of the product. These minor imperfections will be easily corrected during the filling,
                                priming and sanding phase of your sheet metal installation. We does not consider dings,
                                scratches, minor dents or other imperfections on the sheet metal to be defects in the
                                panel nor are they considered damaged. All sheet metal panels will require some sort of
                                preparation and manipulation during installation. Every panel that we sell is inspected
                                and then carefully packaged to protect against damage that may occur during transit.</p>
                            <p>We recommend test fitting all sheet metal panels prior to final paint and installation.
                                Minor modifications including elongating mounting holes, adding additional shims, etc.
                                are normal and may be necessary when installing sheet metal. It is important to note
                                that hard driving conditions, like racing, can twist bodies and frames out of original
                                tolerances. Poor bodywork from previous collisions can cause problems with the body
                                structure that the panels are attached to. Some vehicles were manufactured with a
                                unitized body causing even the most minor accident to twist the body creating a
                                situation that would cause sheet metal panel mis-alignments. Take into consideration
                                that tolerances on classic vehicles are not as exact as they are on modern vehicles.
                                This is primarily due to the hand fitting of panels at the factory on most antique and
                                classic cars as opposed to the robotics used in today’s modern factories. All of these
                                factors will affect the way your new reproduction sheet metal will install and fit on
                                the car. There is really no such thing as a direct fit body panel when it comes to older
                                vehicles.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h2 class="mb-0">
                            <a class="h5 d-block mb-0 collapsed" type="button" data-toggle="collapse"
                                data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Classic Car Make / Model Identification Guide
                            </a>
                        </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            <p>During the 1960’s and 1970’s, the automakers used letter codes to designate which car
                                platform the models were built off of. Unlike today, there were basically small, midsize
                                and large cars with perhaps a special model of each available. Following is a chart
                                which you can use to determine which model and platform your car was build off of, and
                                that will help you identify which parts will fit your particular application.
                            </p>
                            <h6>Mopar "A"-Body</h6>
                            <ul>
                                <li>1963-76 Dodge Dart</li>
                                <li>1971-72 Dodge Demon</li>
                                <li>1973-76 Dodge Dart Sport</li>
                                <li>1963-76 Plymouth Valiant</li>
                                <li>1964-69 Plymouth Barracuda</li>
                                <li>1970-76 Plymouth Duster</li>
                            </ul>

                            <h6>Mopar "B"-Body</h6>
                            <ul>
                                <li>1962 Dodge Dart</li>
                                <li>1963-64 Dodge 330 / 440 / Polara</li>
                                <li>1965-74 Dodge Coronet / Super Bee / R/T</li>
                                <li>1975-78 Dodge Monaco</li>
                                <li>1966-79 Dodge Charger / R/T / Daytona Magnum XE</li>
                                <li>1962 Plymouth Savory / Fury</li>
                                <li>1965-74 Plymouth Belvedere / Satellite / Roadrunner / GTX</li>
                                <li>1975-77 Plymouth Grand Fury</li>
                            </ul>

                            <h6>Mopar "C"-Body</h6>
                            <ul>
                                <li>1965-74 Dodge Polara / Monaco</li>
                                <li>1975-77 Dodge Royal Monaco</li>
                                <li>1965-74 Plymouth Fury/ Sport Fury</li>
                                <li>1975-77 Plymouth Grand Fury</li>
                            </ul>

                            <h6>Mopar "E"-Body</h6>
                            <ul>
                                <li>1970-1974 Dodge Challenger</li>
                                <li>1970-74 Plymouth Barracuda</li>
                            </ul>

                            <h6>GM "X"-Body</h6>
                            <ul>
                                <li>1962-79 Chevrolet Chevy II / Nova</li>
                                <li>1971-79 Pontiac Ventura II / Ventura / Phoenix</li>
                                <li>1973-79 Oldsmobile Omega</li>
                                <li>1973-79 Buick Apollo / Skylark</li>
                            </ul>

                            <h6>GM "F"-Body</h6>
                            <ul>
                                <li>1967-92 Chevrolet Camaro</li>
                                <li>1967-92 Pontiac Firebird</li>
                            </ul>

                            <h6>GM "A"-Body</h6>
                            <ul>
                                <li>1964-87 Chevrolet Chevelle / Malibu / El Camino</li>
                                <li>1964-86 Pontiac Tempest / LeMans / GTO / Bonneville Model G</li>
                                <li>1964-86 Oldsmobile F-85 / Cutlass / 4-4-2 / Hurst/Olds / Supreme 4-d</li>
                                <li>1964-84 Buick Special / Skylark / Gran Sport / GS / Century / Regal 4d</li>
                                <li>1971-87 GMC Sprint / Caballero</li>

                            </ul>

                            <h6>GM "A-Special or G"-Body</h6>
                            <ul>
                                <li>1970-88 Chevrolet Monte Carlo</li>
                                <li>1969-87 Pontiac Grand Prix</li>
                                <li>1970-88 Oldsmobile Cutlass Supreme 2d / Salon / Calais</li>
                                <li>1973-87 Buick Regal 2d</li>
                            </ul>

                            <h6>GM "B"-Body</h6>
                            <ul>
                                <li>1955-57 Chevrolet 150 / 210 / Bel Air / Nomad Wagon</li>
                                <li>1958-76 Chevrolet Delray / Biscayne / Impala / SS / Caprice</li>
                                <li>1955-58 Pontiac Chieftain / Star Chief / Super Chief</li>
                                <li>1959-76 Pontiac Catalina / Star Chief / Bonneville/ Grandville</li>
                                <li>1962-68 Pontiac Grand Prix</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
get_footer();