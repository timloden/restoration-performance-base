<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package underscores
 */

?>

</div><!-- #content -->

<footer class="site-footer border-top mt-5">
    <div class="container pt-5 pb-4">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="d-flex">
                    <div class="col-4">
                        <h6>Shop</h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="<?php echo site_url(); ?>/shop">Shop by Vehicle</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-0"
                                    href="<?php echo site_url(); ?>/product-tag/specials">Specials</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="<?php echo site_url(); ?>/about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="<?php echo site_url(); ?>/contact">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <h6>Account</h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="<?php echo site_url(); ?>/my-account">My Account</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="<?php echo site_url(); ?>/tracking">Tracking</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-0"
                                    href="<?php echo site_url(); ?>/frequently-asked-questions">Help</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="<?php echo site_url(); ?>/cart">Cart</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <h6>Resources</h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="<?php echo site_url(); ?>/my-account">All Resources</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="<?php echo site_url(); ?>/tracking">Tech Tips</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-0"
                                    href="<?php echo site_url(); ?>/frequently-asked-questions">FAQ's</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-0" href="<?php echo site_url(); ?>/shipping">Shipping</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <p mb-0>Classic Body Parts is a reseller and dealer of replacement restoration parts relating to the
                    Licensed
                    trademark Chevy, Chevrolet, Ford and Mopar.</p>
                <p class="mb-2 font-weight-bold">Get all the latest product updates, specials and coupons!</p>

                <div class="mb-3" id="mc_embed_signup">
                    <form
                        action="https://classicbodyparts.us8.list-manage.com/subscribe/post?u=7f3a72c126eb4512af40c4195&amp;id=7af00b4ad6"
                        method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate"
                        target="_blank" novalidate>
                        <label for="mce-EMAIL">Email Address <span class="asterisk">*</span>
                        </label>
                        <div class="input-group">

                            <input type="email" value="" name="EMAIL" class="required email form-control"
                                id="mce-EMAIL">
                            <div class="input-group-append">
                                <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"
                                    class="button btn btn-secondary">
                            </div>
                        </div>
                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>
                        </div>
                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text"
                                name="b_7f3a72c126eb4512af40c4195_7af00b4ad6" tabindex="-1" value=""></div>
                    </form>
                </div>
                <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'>
                </script>
                <script type='text/javascript'>
                (function($) {
                    window.fnames = new Array();
                    window.ftypes = new Array();
                    fnames[0] = 'EMAIL';
                    ftypes[0] = 'email';
                }(jQuery));
                var $mcj = jQuery.noConflict(true);
                </script>
                <!--End mc_embed_signup-->

            </div>
        </div>
        <div class="row pt-3">
            <div class="col-12 text-center">
                <img class="img-fluid cc-logos"
                    src="<?php echo get_template_directory_uri(); ?>/assets/images/cc-logos.png"
                    alt="credit card logos">
                <img class="pl-3" src="<?php echo get_template_directory_uri(); ?>/assets/images/paypal-logo.png"
                    alt="PayPal Logo">

                <p class="mt-4" style="font-size: 14px;">
                    <a href="<?php echo site_url(); ?>/policies" class="text-dark">Policies</a> | <a
                        href="<?php echo site_url(); ?>/terms-and-conditions" class="text-dark">Terms and
                        Conditions</a>
                </p>
            </div>

        </div>
    </div>
    <div class="copyright bg-primary">
        <div class="container">
            <p class="text-white m-0 p-2 text-center">&copy; Classic Body Parts <?php echo date("Y"); ?> |
                Classic Body
                Parts is solely owned division of Restoration Performance LLC.</p>

        </div>

    </div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
<?php the_field('footer_embed', 'option'); ?>
</body>

</html>