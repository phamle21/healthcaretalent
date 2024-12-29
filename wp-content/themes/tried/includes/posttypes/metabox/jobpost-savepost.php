<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
$prod_fields = array(
	'editor_applicant',
	'editor_offer',
	'min_salary',
	'max_salary',
	'job_expired',
	'job_currency',
	'job_unit'
);
if ( !empty( $prod_fields ) ) {
	foreach ( $prod_fields as $prodfield ) {
		if ( array_key_exists( $prodfield, $_POST ) ) {
			update_post_meta( $post->ID, $prodfield, $_POST[$prodfield] );
		}
	}
}