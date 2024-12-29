<?php
// Template: Template Eldoms

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$post_id = false;
if ( isset( $_GET['post'] ) ) {
    $post_id = $_GET['post'];
}
if ( isset( $args['post_id'] ) ) {
	$post_id = $args['post_id'];
}
