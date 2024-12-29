<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Tried_User', false )) {
	class Tried_User {
    function __construct() {
      $this->load_hooks();
    }

    function load_hooks() {
        // add new role user
        add_action( 'init', array( $this, 'tried_new_role_user' ) );
        add_filter( 'register_post_type_args', array( $this, 'tried_modify_cpt_registry' ) , 10, 2 );
    }

    function tried_new_role_user() {
        global $wp_roles;
  
        if ( !class_exists( 'WP_Roles' ) ) return;
  
        if ( !isset( $wp_roles ) ) $wp_roles = new WP_Roles();

        $argsRoles = array();

        if ( $argsRoles ) {
          foreach ( $argsRoles as $role ) {
            $wp_roles->add_role( $role['id'], $role['name'], array( 'read' => true ) );
          }
        }
  
        $posttypeCap = $this->tried_set_posttype_caps();
        foreach ( $posttypeCap as $capGroup ) {
          foreach ( $capGroup as $cap ) {
            $wp_roles->add_cap( 'administrator', $cap );
          }
        }
        
        $wp_roles->add_cap( 'administrator', 'tried_dashboard' );
    }

    function tried_set_posttype_caps() {
        $capabilities = array();
        $capability_types = array();
  
        foreach ( $capability_types as $capability_type ) {
          $capabilities[ $capability_type ] = array(
            // Post type
            "edit_{$capability_type}",
            "read_{$capability_type}",
            "delete_{$capability_type}",
            "edit_{$capability_type}s",
            "edit_others_{$capability_type}s",
            "publish_{$capability_type}s",
            "read_private_{$capability_type}s",
            "delete_{$capability_type}s",
            "delete_private_{$capability_type}s",
            "delete_published_{$capability_type}s",
            "delete_others_{$capability_type}s",
            "edit_private_{$capability_type}s",
            "edit_published_{$capability_type}s",
  
            // Terms
            "manage_{$capability_type}_status",
            "edit_{$capability_type}_status",
            "delete_{$capability_type}_status",
            "assign_{$capability_type}_status",
          );
        }
  
        return $capabilities;
      }

      function tried_modify_cpt_registry( $args, $post_type ){
        if( current_user_can('subscriber') ) {
          $args['capabilities']['create_posts'] = false;
        }
        return $args;
      }
  }

  return new Tried_User();
}