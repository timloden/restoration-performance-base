<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>


<?php endif; ?>



<div class="row justify-content-center">
    <div class="col-12 col-lg-6">
        <p class="pt-3">Please login to view your account information</p>
        <div class="border rounded p-3 mt-3">

            <form class="woocommerce-form woocommerce-form-login login" method="post">

                <?php do_action( 'woocommerce_login_form_start' ); ?>

                <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                    <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span
                            class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control"
                        name="username" id="username" autocomplete="username"
                        value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </div>
                <div class="woocommerce-form-row woocommerce-form-row--wide form-group">
                    <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span
                            class="required">*</span></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="password"
                        name="password" id="password" autocomplete="current-password" />
                </div>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <div class="row">
                    <div class="col">
                        <div class="form-check">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox form-check-input"
                                name="rememberme" type="checkbox" id="rememberme" value="forever" />
                            <label
                                class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme form-check-label">

                                <?php esc_html_e( 'Remember me', 'woocommerce' ); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col text-right">
                        <button type="submit"
                            class="woocommerce-button button woocommerce-form-login__submit btn btn-primary"
                            name="login"
                            value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
                    </div>
                </div>


                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>


                <a
                    href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>


                <?php do_action( 'woocommerce_login_form_end' ); ?>

            </form>
        </div>
    </div>

    <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

    <div class="col-12 col-lg-6">

        <p class="pt-3">Dont have a login? Create your account here:</p>
        <div class="border rounded p-3 mt-3">

            <form method="post" class="woocommerce-form woocommerce-form-register register"
                <?php do_action( 'woocommerce_register_form_tag' ); ?>>

                <?php do_action( 'woocommerce_register_form_start' ); ?>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
                    <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span
                            class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control"
                        name="username" id="reg_username" autocomplete="username"
                        value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </div>

                <?php endif; ?>

                <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
                    <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span
                            class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control"
                        name="email" id="reg_email" autocomplete="email"
                        value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </div>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-group">
                    <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span
                            class="required">*</span></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text form-control"
                        name="password" id="reg_password" autocomplete="new-password" />
                </div>

                <?php else : ?>

                <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

                <?php endif; ?>

                <?php do_action( 'woocommerce_register_form' ); ?>

                <div class="woocommerce-form-row form-row">
                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                    <button type="submit"
                        class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit  btn btn-primary"
                        name="register"
                        value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
                </div>

                <?php do_action( 'woocommerce_register_form_end' ); ?>

            </form>
        </div>
    </div>


    <?php endif; ?>

</div>





<?php do_action( 'woocommerce_after_customer_login_form' ); ?>