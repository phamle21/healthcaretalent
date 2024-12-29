<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('Tried_API', false )) {
	class Tried_API {
        public $api_namespace = 'tried/v1';
        
        public $includes = array(
            '/includes/apis/api-dashboard.php'
        );

		function __construct() {
            $this->load_includes();
        }

        function load_includes() {
            if (!empty($this->includes)) {
                foreach ($this->includes as $include) {
                    include_once get_template_directory() . $include;
                }
            }
        }
    }

	return new Tried_API();
}