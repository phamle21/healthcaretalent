<?php

defined('ABSPATH') || exit;

if ( !class_exists( 'Tried_Theme', false ) ) {
    include_once get_template_directory() . '/includes/class-tried.php';
}

if ( !function_exists( 'extentions_init' )) {
    include_once get_template_directory() . '/extentions/init.php';
}
