<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package restoration-performance-base
 */
$newsletter_form_id = get_field('footer_newsletter_signup_field_id', 'option');
?>

</div><!-- #content -->

<footer class="site-footer border-top">
    <div class="container pt-5 pb-4">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="d-flex">
                    <div class="col-4">
                        <h6>Shop</h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="<?php echo site_url(); ?>/shop">Shop by Vehicle</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-0"
                                    href="<?php echo site_url(); ?>/product-tag/specials">Specials</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="<?php echo site_url(); ?>/about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="<?php echo site_url(); ?>/contact">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <h6>Account</h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="<?php echo site_url(); ?>/my-account">My Account</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="<?php echo site_url(); ?>/tracking">Tracking</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-0"
                                    href="<?php echo site_url(); ?>/frequently-asked-questions">Help</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="<?php echo site_url(); ?>/cart">Cart</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <h6>Resources</h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="<?php echo site_url(); ?>/resources">All Resources</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="<?php echo site_url(); ?>/category/tech-tips/">Tech
                                    Tips</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-0"
                                    href="<?php echo site_url(); ?>/frequently-asked-questions">FAQ's</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ps-0" href="<?php echo site_url(); ?>/shipping">Shipping</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <p mb-0><?php echo get_bloginfo ( 'name' ); ?> is a reseller and dealer of replacement restoration parts
                    relating to the
                    Licensed
                    trademark Chevy, Chevrolet, Ford and Mopar.</p>
                <div class="mb-3">
                    <?php 
                    if ($newsletter_form_id) {
                        echo '<p class="mb-2 fw-bold">Get all the latest product updates, specials and coupons!</p>';
                        echo do_shortcode($newsletter_form_id);
                    }
                     ?>
                </div>

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
                <p style="font-size: 14px; color: #6c757d">
                    <?php echo get_field('footer_disclaimer', 'option'); ?></p>
            </div>

        </div>
    </div>
    <div class="copyright bg-primary">
        <div class="container">
            <p class="text-white m-0 p-2 text-center">&copy;
                <?php echo get_bloginfo ( 'name' ); ?> <?php echo date("Y"); ?></p>

        </div>

    </div>
</footer>
</div><!-- #page -->

<?php 
    if (is_checkout() || is_cart()): 
    $cart_total = WC()->cart->subtotal;
    $shipping_total  = WC()->cart->shipping_total;
?>
<?php if (!is_user_logged_in() && $cart_total > 200 && $shipping_total > 7.5): ?>
<!-- Modal -->
<div class="modal fade" id="five-off-modal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">You have a coupon!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-1"><?php echo esc_attr(get_field('modal_coupon_title', 'option')); ?></p>
                <p class="h3 mb-2 text-primary" style="font-weight: 900;">
                    <?php echo esc_attr(get_field('modal_coupon_code_text', 'option')); ?>
                </p>
                <small
                    class="text-black-50"><?php echo esc_attr(get_field('modal_coupon_disclaimer', 'option')); ?></small>
            </div>
            <div class="modal-footer">
                <button id="five-off-modal-button" type="button" class="btn btn-primary">Apply Your Coupon</button>
            </div>
        </div>
    </div>
</div>
<script>
function getCookie(name) {
    let value = `; ${document.cookie}`;
    let parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

function setModalCookie() {
    document.cookie = "five-off-modal=dismissed; max-age=1209600; path=/";
}

document.addEventListener("DOMContentLoaded", () => {
    document.addEventListener("mouseout", (event) => {
        let modalCookie = getCookie('five-off-modal');
        if (!event.toElement && !event.relatedTarget && modalCookie !== 'dismissed') {
            setTimeout(() => {
                jQuery('#five-off-modal').modal('show');
            }, 250)

        }
    });

    document.addEventListener("touchcancel", (event) => {
        let modalCookie = getCookie('five-off-modal');
        if (!event.toElement && !event.relatedTarget && modalCookie !== 'dismissed') {
            setTimeout(() => {
                jQuery('#five-off-modal').modal('show');
            }, 250)

        }
    });
});

document.getElementById("five-off-modal-button").addEventListener("click", () => {
    setModalCookie();
    window.location.href = '<?php echo get_field('modal_coupon_link', 'option'); ?>';
});

jQuery('#five-off-modal').on('hidden.bs.modal', function(event) {
    setModalCookie();
});
</script>
<?php endif; ?>
<?php endif; ?>

<?php wp_footer(); ?>
<?php the_field('footer_embed', 'option'); ?>
</body>

</html>