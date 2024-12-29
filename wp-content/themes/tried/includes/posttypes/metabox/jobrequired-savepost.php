<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
$prod_fields = array(
	'cus_fullname',
	'cus_telephone',
	'cus_email',
	'cus_company',
	'job_title',
	'job_location',
	'job_sector',
	'job_tag',
	'job_sector',
	// 'job_media_cv',
    // 'job_url_cv'
);
if ( !empty( $prod_fields ) ) {
	foreach ( $prod_fields as $prodfield ) {
		if ( array_key_exists( $prodfield, $_POST ) ) {
            if ( $prodfield == 'job_url_cv' || $prodfield == 'job_media_cv' ) {
                update_post_meta( $post->ID, 'job_cv', $_POST[$prodfield] );
            } else {
                update_post_meta( $post->ID, $prodfield, $_POST[$prodfield] );
            }
		}
	}
}