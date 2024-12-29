<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
// Product
$prod_fields = array(
	'prod_warranty',
	'prod_refund',
	'prod_cusrefund',
);
if ( !empty( $prod_fields ) ) {
	foreach ( $prod_fields as $prodfield ) {
		if ( array_key_exists( $prodfield, $_POST ) ) {
			update_post_meta( $post->ID, $prodfield, $_POST[$prodfield] );
		}
	}
}

// Product Attribute
$prodattr_fields = array(
	'prodattr_category',
	'prodattr_cluster'
);
if ( !empty( $prodattr_fields ) ) {
	foreach ( $prodattr_fields as $prodfield ) {
		if ( array_key_exists( $prodfield, $_POST ) ) {
			update_post_meta( $post->ID, $prodfield, $_POST[$prodfield] );
		}
	}
}
// Product
// Client
//   if ( array_key_exists( 'info_status', $_POST ) ) {
//     update_post_meta( $post_id, 'info_status', $_POST['info_status'] );
//     if ( $_POST['info_status'] == '1' || $_POST['info_status'] == 1 ) {
//       after_change_status_baohanh( $post_id );
//     }
//   }