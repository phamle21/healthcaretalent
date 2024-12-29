<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-header-content' );
$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$location_menu = 'header-menu';
if ($args['menu_location']) {
	$location_menu = $args['menu_location'];
}
$header_nav_menu = wp_nav_menu( [
	'theme_location' => $location_menu,
	'fallback_cb' => false,
	'echo' => false,
	'container_class' => 'nav-menu'
] );

$custom_logo = get_theme_mod( 'custom_logo' );
$logo = wp_get_attachment_image_src( $custom_logo , 'full' );
?>
<header id="site-header" class="site-header none-shadow" role="content">
	<div class="header-contain">
		<div class="wrapper">
            <div class="logo-block">
                <?php
					if ( $logo ) :
						printf( '
							<a href="%s" class="custom-second-logo" title="%s" rel="home"><img src="%s" alt="%s"></a>',
							esc_url( home_url( '/' ) ),
							esc_attr( 'Home', 'tried' ),
							esc_url( $logo[0] ),
							get_bloginfo( 'name' )
						);
					endif;
				?>
				<p class="tagline"><?php echo get_bloginfo('description'); ?></p>
            </div>
            <div class="nav-block">
                <?php if ( $header_nav_menu ) : ?>
                    <nav class="site-navigation" role="navigation">
                        <div class="site-navigation-wrapper">
                            <?php echo $header_nav_menu; ?>
							<div class="nav-order">
								<div class="nav-action">
									<div class="form-block">
										<?php get_search_form(); ?>
									</div>
								</div>
							</div>
                        </div>
                        <div class="site-navigation-toggle" role="menu">
                            <i aria-hidden="true" class="fal fa-bars icon-nav open"></i>
                            <i aria-hidden="true" class="fas fa-times icon-nav close"></i>
                        </div>
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
</header>
