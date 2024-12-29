<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp, $wp_query;
if ( is_archive() ) {
	the_post();
	$archive_args = array();
	$archive_slug = 'post';
	if (get_post_type() != 'post' ) {
		$archive_slug = get_post_type();
	}
	if ( get_queried_object() != null ) {
		if ( isset( get_queried_object()->taxonomy ) ) {
			$taxonomy = get_queried_object()->taxonomy;
			if ( str_contains( $taxonomy, '_cat' ) ) {
				$posttype = substr_replace( $taxonomy, '', -4 );
				$archive_slug = $posttype;
				$archive_args['posttype'] = $posttype;
			}
			if ( str_contains( $taxonomy, 'jobpost' ) ) {
				$archive_slug = 'jobpost';
				$archive_args['posttype'] = 'jobpost';
				$archive_args['taxonomy'] = array(
					'term_id' => get_queried_object()->term_id,
					'name' => get_queried_object()->name,
					'slug' => get_queried_object()->slug,
					'term' => get_queried_object(),
					'tax' => $taxonomy
				);
			}
		}
	}
	get_template_part( 'template-parts/archive/archive', $archive_slug, $archive_args );
}