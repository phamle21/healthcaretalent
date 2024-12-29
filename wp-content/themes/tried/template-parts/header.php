<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$header_args = array(
	'menu_mobile_location' => 'header_mobile-menu'
);
// $header_mobile_args = array( 'menu_location' => 'header_mobile-menu' );
$header_slug = 'primary';
// if ( is_front_page() || is_home() ) {
// 	$header_slug = 'primary';
// } else {
	// $header_slug = 'primary';
	// if ( is_single() && get_post_type() == 'post' ) {
	// 	$header_slug = 'content';
	// }
// }
get_template_part( 'template-parts/header/header', $header_slug, $header_args );