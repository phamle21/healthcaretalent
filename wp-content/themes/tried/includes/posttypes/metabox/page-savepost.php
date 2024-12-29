<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
$prod_fields = array(
	'top_banner',
);

if ( !empty( $prod_fields ) ) {
	foreach ( $prod_fields as $prodfield ) {
		if ( array_key_exists( $prodfield, $_POST ) ) {
			update_post_meta( $post->ID, $prodfield, $_POST[$prodfield] );
		}
	}
}