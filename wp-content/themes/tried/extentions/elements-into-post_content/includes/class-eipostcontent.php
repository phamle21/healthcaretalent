<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'EIPost_Content', false ) ) {
	class EIPost_Content {
        public $includes = array(
            'includes/class-eipostcontent-template.php',
            'includes/class-eipostcontent-database.php'
        );

        function __construct() {
            $this->includes();
            $this->load_hooks();
        }

        function load_hooks() {
          add_action( 'admin_enqueue_scripts', array( $this, 'eipostcontent_admin_enqueue_scripts' ), 10 );
          add_action( 'wp_enqueue_scripts', array( $this, 'eipostcontent_enqueue_scripts' ) );
        }

        function eipostcontent_admin_enqueue_scripts() {
            global $pagenow, $typenow;
            if ( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && $typenow == 'post' ) {
              wp_enqueue_style( 'eipostcontent-admin', TREXT_EIPOSTCONTENT_URL . 'assets/css/admin-style.css', '', "1.0.0" );
              wp_enqueue_script( 'eipostcontent-admin', TREXT_EIPOSTCONTENT_URL . 'assets/js/admin-script.js', null, "1.0.0", true );

              wp_enqueue_style( 'trumbowyg' );
              wp_enqueue_script( 'trumbowyg' );
              wp_enqueue_style( 'trumbowyg-color' );
              wp_enqueue_script( 'trumbowyg-color' );
              wp_enqueue_style( 'trumbowyg-table' );
              wp_enqueue_script( 'trumbowyg-table' );
                
              wp_enqueue_style( 'font-awesome-4.7.0' );
              
              wp_enqueue_style( 'eipostcontent', TREXT_EIPOSTCONTENT_URL . 'assets/css/style.css', '', "1.0.0" );
            }
        }

        function eipostcontent_enqueue_scripts() {
            wp_enqueue_style( 'eipostcontent', TREXT_EIPOSTCONTENT_URL . 'assets/css/style.css', '', "1.0.0" );
        }

        function includes() {
            if ( !empty( $this->includes ) ) {
                foreach ( $this->includes as $include ) {
                    include_once TREXT_EIPOSTCONTENT_PATH . $include;
                }
            }
        }
	}

  return new EIPost_Content();
}
