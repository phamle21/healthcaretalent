<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('Tried_Extentions', false )) {
	class Tried_Extentions {
        private $root = '/extentions/';
        public $includes = array(
            // '/extentions/elements-into-post_content/index.php',
            // '/extentions/thu-cu-doi-moi/index.php'
        );

		function __construct() {
            $this->load_hooks();
            $this->load_includes();
		}

        function load_hooks() {
            if ( !defined( 'TRIED_EXTENTION_PATH' ) ) {
                define( 'TRIED_EXTENTION_PATH', get_stylesheet_directory( __FILE__ ) . $this->root );
            }
            
            if ( !defined( 'TRIED_EXTENTION_URL' ) ) {
                define( 'TRIED_EXTENTION_URL', get_stylesheet_directory_uri( __FILE__ ) . $this->root );
            }

            if ( !defined( 'TRIED_EXTENTION_ROOT' ) ) {
                define( 'TRIED_EXTENTION_ROOT', $this->root );
            }
        }

        function load_includes() {
            if ( !empty( $this->includes ) ) {
                foreach ( $this->includes as $include ) {
                    include_once get_template_directory() . $include;
                }
            }
        }
    }
    
    return new Tried_Extentions();
}
