<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$footer_args = array( 'menu_location' => 'footer-menu' );
$footer_slug = 'primary';
// if ( is_front_page() || is_home() ) {
// 	$footer_slug = 'primary';
// } else {
	// $footer_slug = 'primary';
	// if ( is_single() && get_post_type() == 'post' ) {
	// 	$footer_slug = 'content';
	// }
// }
get_template_part( 'template-parts/footer/footer', $footer_slug, $footer_args );

if ( is_front_page() || is_home() ) {
	$popuphomepage = get_option( 'add_setting_popuphomepage', '' );
	$popuphomepage_link = get_option( 'add_setting_popuphomepage_link', '' );
	if ( !empty( $popuphomepage ) ) {
		printf(
			'<div id="popup-homepage" style="display: none;">
                <div class="popup-overlay"></div>
                <div class="popup-wrapper">
                    <div class="popup-main">
                        <a href="%s" title="">
                            <img src="%s" alt="">
                        </a>
                        <a class="popup-main_close" href="javascript:void(0)" title=""></a>
                    </div>
                </div>
			</div>',
			$popuphomepage_link,
			$popuphomepage
		);
	}
}
?>
<button id="scroll-top" data-target="html"></button>