<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Tried_DB__ProdAttributeCategory', false ) ) {
    class Tried_DB__ProdAttributeCategory {
        public $table_name = 'tried_prodattribute_category';
            
        public function __construct() {
            $this->create(
                "CREATE TABLE IF NOT EXISTS `$this->table_name` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `title` VARCHAR(30) NOT NULL,
                    `status` INT(2) DEFAULT 0,
                    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
            );
        }

        public function create($sql) {
            global $wpdb;
            if ( $wpdb->get_var( "SHOW TABLES LIKE '$this->table_name'" ) != $this->table_name ) {
                $charset_collate = $wpdb->get_charset_collate();
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
                $is_error = empty( $wpdb->last_error );
                return $is_error;
            }
        }

        public function clear() {
            global $wpdb;
            $wpdb->query( "DELETE FROM " . $this->table_name );
        }

        public function all() {
            global $wpdb;
            $results = $wpdb->get_results( "SELECT * FROM `$this->table_name` ORDER BY created_at DESC" );
            return $results;
        }
        
        public function delete( $id ) {
            global $wpdb;
            $result = $wpdb->delete( $this->table_name, array( 'id' => $id ) );
            return $result;
        }

        public function query($sql) {
            global $wpdb;
            $results = $wpdb->get_results( $sql );
            return $results;
        }

        public function insert($args = array()) {
            global $wpdb;
            $wpdb->insert( $this->table_name, $args );
            return $this->get_by_ID( $wpdb->insert_id );
        }
        
        public function get_by_ID( $id ) {
            global $wpdb;
            $results = $wpdb->get_row( "SELECT * FROM `$this->table_name` WHERE id = $id" );
            return $results;
        }

        public function update( $id, $args = array() ) {
            global $wpdb;
            $result = $wpdb->update( $this->table_name, $args, array( 'id' => $id ) );
            return $result;
        }
    }

    return new Tried_DB__ProdAttributeCategory();
}