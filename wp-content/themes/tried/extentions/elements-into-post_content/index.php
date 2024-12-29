<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$_eipc = '/elements-into-post_content/';

if ( !defined( 'TREXT_EIPOSTCONTENT_PATH' ) ) {
    define( 'TREXT_EIPOSTCONTENT_PATH', TRIED_EXTENTION_PATH . $_eipc );
}

if ( !defined( 'TREXT_EIPOSTCONTENT_URL' ) ) {
    define( 'TREXT_EIPOSTCONTENT_URL', TRIED_EXTENTION_URL . $_eipc );
}

if ( !defined( 'TREXT_EIPOSTCONTENT_ROOT' ) ) {
    define( 'TREXT_EIPOSTCONTENT_ROOT', TRIED_EXTENTION_ROOT . $_eipc );
}

include_once TREXT_EIPOSTCONTENT_PATH . '/includes/class-eipostcontent.php';
