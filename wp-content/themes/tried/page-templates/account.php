<?php 
/* Template Name: Acoount */
defined('ABSPATH') || exit;

if ( !is_user_logged_in() ) {
    wp_enqueue_style( 'tried-login_register-page' );
}

$root = 'account';

$current_block =  'profile';
if ( isset( $_GET['block'] ) ) {
    $current_block = $_GET['block'];
}
$message_form = array();

$titlepage = __( 'My account', 'tried' );
if ( $current_block == 'savejob' ) {
    $titlepage = __( 'Saved Jobs', 'tried' );
} elseif ( $current_block == 'profile-detail' ) {
    $titlepage = __( 'Personal Details', 'tried' );
} elseif ( $current_block == 'change-password' ) {
    $titlepage = __( 'Account Settings', 'tried' );
} elseif ( $current_block == 'submit-resume' ) {
    $titlepage = __( 'Submit Your Resume', 'tried' );
}
?>
<?php get_header(); ?>
<main <?php post_class( 'site-main' ); ?> role="account">
    <div class="main-contain <?php echo is_user_logged_in()?'account':'login-register'; ?>">
        <?php if ( is_user_logged_in() ) {?>
        <div class="banner-account">
            <div class="wrapper">
                <?php
                    if ( !isset( $_GET['block'] ) || ( isset( $_GET['block'] ) && $_GET['block'] != 'dashboard' ) ) {
                        printf(
                            '<a class="back-to-dashboard" href="%s" title="%s"><span>%s</span></a>',
                            esc_url( add_query_arg( 'block', 'dashboard', home_url( 'account' ) ) ),
                            __( 'My account', 'tried' ),
                            __( 'My account', 'tried' )
                        );
                    }
                ?>
                <h3 class="banner-titlepage"><?php echo $titlepage; ?></h3>
            </div>
        </div>
        <?php } ?>
        <div class="wrapper">
            <?php
                if ( is_user_logged_in() ) {
                    if ( isset( $_GET['block'] ) ) {
                        if ( $_GET['block'] == 'profile-detail' ) {
                            get_template_part( 'page-templates/account/profile', 'detail', false );
                        } elseif ( $_GET['block'] == 'savejob' ) {
                            get_template_part( 'page-templates/account/savejob', null, false );
                        } elseif ( $_GET['block'] == 'change-password' ) {
                            get_template_part( 'page-templates/account/change', 'password', false );
                        } elseif ( $_GET['block'] == 'submit-resume' ) {
                            get_template_part( 'page-templates/account/submit', 'resume', false );
                        } else {
                            get_template_part( 'page-templates/account/dashboard', null, false );
                        }
                    } else {
                        get_template_part( 'page-templates/account/dashboard', null, false );
                    }
                } else {
                    $shortcodeForm = '[tried_login_form]';
                    if (isset($_GET['form']) && $_GET['form'] == 'register') {
                        $shortcodeForm = '[tried_register_form]';
                    }
                    printf( '<div class="form-login_register">%s</div>', do_shortcode( $shortcodeForm ) );
                }
            ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>