<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
$prod_fields = array(
	'video',
	'location',
	'publish',
	'agenda_calevent',
	'picture_calevent',
	'sponsor_calevent'
);

if ( !empty( $prod_fields ) ) {
	foreach ( $prod_fields as $prodfield ) {
		if ( array_key_exists( $prodfield, $_POST ) ) {
			update_post_meta( $post->ID, $prodfield, $_POST[$prodfield] );
		}
	}
}