<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-header-primary' );

global $current_user;
wp_get_current_user();

$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$location_menu = 'header-menu';
if ( isset( $args['menu_location'] ) ) {
	$location_menu = $args['menu_location'];
}
$location_menu_mobile = 'header_mobile-menu';
if ( isset( $args['menu_mobile_location'] ) ) {
	$location_menu_mobile = $args['menu_mobile_location'];
}
$header_nav_menu = wp_nav_menu( [
	'theme_location' => $location_menu,
	'fallback_cb' => false,
	'echo' => false,
	'container_class' => 'nav-menu'
] );
$header_mobile_nav_menu = wp_nav_menu( [
	'theme_location' => $location_menu_mobile,
	'fallback_cb' => false,
	'echo' => false,
	'container_class' => 'nav-menu'
] );
$header_phone = get_option( 'add_header_phone_banner', '' );

$custom_logo = get_theme_mod( 'custom_logo' );
$logo = ( $custom_logo )?wp_get_attachment_image_src( $custom_logo , 'full' )[0]:'';
?>
<header id="site-header" class="site-header none-shadow" role="primary">
    <div class="header-info">
        <div class="wrapper mwidth-main margin-auto">
            <?php dynamic_sidebar('header_banner_info'); ?>
        </div>
    </div>

    <div class="header-contain">
        <div class="wrapper mwidth-main margin-auto">
            <div class="logo-block">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-second-logo"
                    title="<?php echo esc_attr( 'Home', 'tried' ); ?>" rel="home">
                    <?php
						if ( $logo != '' ) {
							printf( '<img src="%s" alt="%s">',
								$logo,
								get_bloginfo( 'name' )
							);
						} else {
							_e( 'Logo', 'tried' );
						}
					?>
                    <p class="tagline"><?php echo get_bloginfo('description'); ?></p>
                </a>
            </div>
            <div class="nav-block">
                <?php if ( $header_nav_menu ) : ?>
                <nav class="site-navigation" role="navigation">
                    <div class="site-navigation-wrapper">
                        <div class="nav-desktop">
                            <?php echo $header_nav_menu; ?>
                        </div>
                        <div class="nav-mobile">
                            <div class="nav-act_icon">
                                <div class="findjob-act_icon">
                                    <a href="<?php echo esc_url( home_url( 'job-seekers' ) ); ?>"
                                        title="<?php _e( 'Job search', 'tried' ); ?>"><span><?php _e('Job search', 'tried'); ?></span></a>
                                </div>
                                <div class="savejob-act_icon">
                                    <a href="<?php echo esc_url( home_url( 'account/?block=savejob' ) ); ?>"
                                        title="<?php _e('Saved jobs', 'tried'); ?>"><span><?php _e('Saved jobs', 'tried'); ?></span></a>
                                </div>
                                <?php 
                                    $titleAccount = __( 'Sign in', 'tried' );
                                    if ( is_user_logged_in() ) $titleAccount = $current_user->user_login;
                                ?>
                                <div class="account-act_icon <?php echo is_user_logged_in()?'logged':''; ?>">
                                    <a href="<?php echo esc_url( home_url( 'account' ) ); ?>"
                                        title="<?php _e('Account', 'tried'); ?>"><span><?php echo $titleAccount; ?></span></a>
                                </div>
                            </div>
                            <?php echo $header_mobile_nav_menu; ?>
                        </div>
                        <div class="nav-order">
                            <div class="nav-action">
                                <?php if ( false ) : ?>
                                <div class="search-block">
                                    <?php get_search_form(); ?>
                                </div>
                                <?php endif; ?>
                                <?php if ( false ) : ?>
                                <div class="salary-block">
                                    <a href="javascript:void(0)">
                                        <i class="fas fa-donate"></i><?php _e( 'Hướng dẫn về lương', 'tried' ); ?></a>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php if ( false ) : ?>
                                <div class="cart-block">
                                    <a class="cart-toggle" href="javascript:void(0)"><i aria-hidden="true"
                                            class="fas fa-shopping-cart"></i></a>
                                    <div class="cart-wrapper">
                                        <?php woocommerce_mini_cart(); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($header_phone)) : ?>
                            <div class="call-number">
                                <a href="<?php echo $header_phone; ?>" class="support">
                                    <p><?php _e('Contact Us', 'tried'); ?></p>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="site-navigation-toggle" role="menu">
                        <i aria-hidden="true" class="fal fa-bars icon-nav open"></i>
                        <i aria-hidden="true" class="fas fa-times icon-nav close"></i>
                    </div>
                    <?php if ( false ) : ?>
                    <div class="site-cart-toggle" role="cart">
                        <i aria-hidden="true" class="fas fa-shopping-cart icon-nav open"></i>
                        <i aria-hidden="true" class="fas fa-times icon-nav close"></i>
                    </div>
                    <?php endif; ?>
                    <?php if ( false ) : ?>
                    <div class="call-number">
                        <a href="<?php echo $header_phone; ?>" class="support">
                            <i class="far fa-calendar-alt"></i>
                            <p><?php _e('Contact Us', ''); ?></p>
                        </a>
                    </div>
                    <?php endif; ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="header-contain sticky">
        <div class="wrapper mwidth-main margin-auto">
            <div class="logo-block">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-second-logo"
                    title="<?php echo esc_attr( 'Home', 'tried' ); ?>" rel="home">
                    <?php
						if ( $logo != '' ) {
							printf( '<img src="%s" alt="%s">',
								$logo,
								get_bloginfo( 'name' )
							);
						} else {
							_e( 'Logo', 'tried' );
						}
					?>
                    <p class="tagline"><?php echo get_bloginfo('description'); ?></p>
                </a>
            </div>
            <div class="nav-block">
                <?php if ( $header_nav_menu ) : ?>
                <nav class="site-navigation" role="navigation">
                    <div class="site-navigation-wrapper">
                        <?php echo $header_nav_menu; ?>
                        <div class="nav-order">
                            <div class="nav-action">
                                <?php if ( false ) : ?>
                                <div class="search-block">
                                    <div class="search-action-block" role="dropdown">
                                        <a class="searchform-action" href="javascript:void(0)" data-status="false"></a>
                                        <div class="searchform-wrapper">
                                            <?php get_search_form(); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if ( false ) : ?>
                                <div class="salary-block">
                                    <a href="javascript:void(0)">
                                        <i class="fas fa-donate"></i>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php if ( false ) : ?>
                                <div class="cart-block">
                                    <a class="cart-toggle" href="javascript:void(0)"><i aria-hidden="true"
                                            class="fas fa-shopping-cart"></i></a>
                                    <div class="cart-wrapper">
                                        <?php woocommerce_mini_cart(); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($header_phone)) : ?>
                            <div class="call-number">
                                <a href="<?php echo $header_phone; ?>" class="support">
                                    <p><?php _e('Contact Us', ''); ?></p>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="site-navigation-toggle" role="menu">
                        <i aria-hidden="true" class="fal fa-bars icon-nav open"></i>
                        <i aria-hidden="true" class="fas fa-times icon-nav close"></i>
                    </div>
                    <?php if ( false ) : ?>
                    <div class="site-cart-toggle" role="cart">
                        <i aria-hidden="true" class="fas fa-shopping-cart icon-nav open"></i>
                        <i aria-hidden="true" class="fas fa-times icon-nav close"></i>
                    </div>
                    <?php endif; ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="header-outfit">
        <div class="wrapper mwidth-main margin-auto">
            <?php dynamic_sidebar('header_banner_outfit'); ?>
        </div>
    </div>
</header>

<div id="site-searchjob" class="site-searchjob" style="display: none;">
    <div class="wrapper">
        <?php echo do_shortcode( '[tried_filter_head]' ); ?>
    </div>
</div>

<?php if ( !is_front_page() && false ) { ?>
<div class="site-breadcrumbs">
    <div class="wrapper"><?php tried_the_breadcrumbs(); ?></div>
</div>
<?php
}