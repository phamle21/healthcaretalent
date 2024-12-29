<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'EIPost_Content_Database', false ) ) {
    class EIPost_Content_Database {
        public $table_name;

        public function __construct() {
            global $wpdb;

            $this->table_name = $wpdb->prefix . 'eipostcontent_post';
            $this->create_table();
        }

        public function create_table() {
            global $wpdb;

            if ( $wpdb->get_var( "SHOW TABLES LIKE '$this->table_name'" ) != $this->table_name ) {
                $charset_collate = $wpdb->get_charset_collate();
                $sql = "CREATE TABLE IF NOT EXISTS `$this->table_name` (
                    `post_id` bigint(20) NOT NULL,
                    `post_content` text NULL,
                    `time_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`post_id`),
                    FOREIGN KEY (`post_id`) REFERENCES wp_posts(`ID`)
                ) ENGINE = MyISAM DEFAULT CHARSET = utf8;";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
                $is_error = empty( $wpdb->last_error );
                return $is_error;
            }
        }

        public function insert( $args = array() ) {
            global $wpdb;
            $wpdb->insert( $this->table_name, $args );
            $is_error = !empty( $wpdb->insert_id );
            return $is_error;
        }

        public function select( $post_id = null ) {
            global $wpdb;
            $where = '';
            if ( $post_id ) {
                $where = "WHERE `post_id` = {$post_id} ORDER BY `post_id` DESC limit 1";
            }
            $results = $wpdb->get_results( "SELECT * FROM {$this->table_name} {$where}", OBJECT );
            return ( $post_id )?$results[0]:$results;
        }

        public function exist( $post_id ) {
            global $wpdb;
            $results = $wpdb->get_results( "SELECT * FROM {$this->table_name} WHERE `post_id` = {$post_id}", OBJECT );
            return $results;
        }

        public function update( $post_id, $args = array() ) {
            global $wpdb;
            $wpdb->update( $this->table_name, $args, array(
                    'post_id' => $post_id
                )
            );
            $is_error = empty( $wpdb->last_error );
            return $is_error;
        }

        public function delete( $post_id ) {
            global $wpdb;
            $wpdb->delete( $this->table_name, array(
                    'post_id' => $post_id
                )
            );
            $is_error = empty( $wpdb->last_error );
            return $is_error;
        }
    }

    return new EIPost_Content_Database();
}
