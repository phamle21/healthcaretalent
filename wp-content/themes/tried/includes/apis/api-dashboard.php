<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Tried_API_Dashboard', false ) ) {
	class Tried_API_Dashboard {
        public $api_namespace = 'tried/v1';

		function __construct() {
            $this->load_hooks();
        }

        function load_hooks() {
            add_action( 'rest_api_init', array( $this, 'api_register_route' ) );
        }

        function api_register_route() {
            register_rest_route( $this->api_namespace, 'shop', array(
                'methods' => 'GET',
                'callback' => array( $this, 'getInit'),
            ) );
        }

        function getInit( WP_REST_Request $request ) {
            $result = array();
            return rest_ensure_response( array(
                'result' => $result
            ) );
        }
    }

	return new Tried_API_Dashboard();
}