<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

while ( have_posts() ) :
	the_post();
	$single_args = array();
	$single_slug = 'default';
	if ( is_front_page() || is_home() ) {
		$single_slug = 'frontpage';
	}
	if ( is_single() ) {
		$single_slug = 'post';
		if ( get_post_type() != 'post' ) {
			$single_slug = get_post_type();
		}
	}
	get_template_part( 'template-parts/single/single', $single_slug, $single_args );
endwhile;