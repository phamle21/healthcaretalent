<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (!class_exists('Tried_Posttype', false )) {
	class Tried_Posttype {
    public $posttypes = array();

    public $includes = array();

    function __construct() {
      $this->load_vars();
      $this->load_hooks();
      $this->load_includes();
    }

    function load_hooks() {
      add_action( 'admin_menu', array( $this, 'tried_posttype_admin_submenu' ) );
      add_action( 'init', array( $this, 'tried_posttype_init' ) );
      
      add_action( 'admin_head-edit.php', array( $this, 'tried_admin_head_edit' ) );

      add_action( 'add_meta_boxes', array( $this, 'tried_posttype_meta_boxes' ), 10, 2 );
      add_action( 'save_post', array( $this, 'tried_posttype_save_postdata' ) );
    }

    function tried_posttype_init() {
      if ( !empty( $this->posttypes ) ) {
        foreach ( $this->posttypes as $posttype ) {
          if ( isset( $posttype['is_custom'] ) && $posttype['is_custom'] ) {
            if ( isset( $posttype['cus_taxonomy'] ) && !empty( $posttype['cus_taxonomy'] ) ) {
              register_taxonomy( $posttype['cus_taxonomy']['id'], array(
                $posttype['slug']
              ), array(
                'hierarchical' => isset( $posttype['cus_taxonomy']['hierarchical'] ) ? $posttype['cus_taxonomy']['hierarchical'] : true,
                // This array of options controls the labels displayed in the WordPress Admin UI
                'labels' => array(
                  'name' => $posttype['cus_taxonomy']['name_taxonomy'],
                  'singular_name' => $posttype['cus_taxonomy']['name_taxonomy'],
                  'search_items' =>  __( 'Tìm kiếm', 'tried' ),
                  'all_items' => __( 'All', 'tried' ),
                  'edit_item' => __( 'Chỉnh sửa', 'tried' ),
                  'update_item' => __( 'Cập nhật', 'tried' ),
                  'add_new_item' => __( 'Thêm mới', 'tried' ),
                  'new_item_name' => __( 'Thêm mới', 'tried' ),
                  'menu_name' => $posttype['cus_taxonomy']['name_taxonomy']
                ),
                // Control the slugs used for this taxonomy
                'rewrite' => array(
                  'slug' => $posttype['cus_taxonomy']['id'], // This controls the base slug that will display before each term
                  'with_front' => false, // Don't display the category base before "/locations/"
                  'hierarchical' => isset( $posttype['cus_taxonomy']['hierarchical'] ) ? $posttype['cus_taxonomy']['hierarchical'] : true // This will allow URL's like "/locations/boston/cambridge/"
                ),
                'default_term' => $posttype['cus_taxonomy']['default_term']
              ) );
            }
          } else {
            $posttypeArgs = array(
              'label'               => $posttype['name'],
              'labels'              => array(
                'view_item'         => __( 'Chi tiết', 'tried' ),
                'search_item'       => __( 'Tìm kiếm', 'tried' ),
                'all_items'         => __( 'All', 'tried' ),
                'edit_item'         => __( 'Chỉnh sửa', 'tried' ),
                'update_item'       => __( 'Cập nhật', 'tried' ),
                'add_new'           => __( 'Thêm mới', 'tried' ),
                'new_item'          => __( 'Thêm mới', 'tried' ),
              ),
              'description'         => $posttype['name'],
              'supports'            => $posttype['supports'],
              'hierarchical'        => false,
              'public'              => true,
              'show_ui'             => true,
              'show_in_menu'        => true,
              'show_in_nav_menus'   => true,
              'show_in_admin_bar'   => true,
              'menu_position'       => 5,
              'can_export'          => true,
              'has_archive'         => true,
              'exclude_from_search' => false,
              'publicly_queryable'  => true,
              'capability_type'     => 'post',
              'show_in_rest'        => true
            );

            register_post_type( $posttype['slug'], $posttypeArgs );
            
            if ( isset( $posttype['taxonomy'] ) && !empty( $posttype['taxonomy'] ) ) {
              $taxonomyArgs = array(
                'hierarchical' => true,
                // This array of options controls the labels displayed in the WordPress Admin UI
                'labels' => array(
                  'name' => $posttype['taxonomy']['name_taxonomy'],
                  'singular_name' => $posttype['taxonomy']['name_taxonomy'],
                  'search_items' =>  __( 'Tìm kiếm', 'tried' ),
                  'all_items' => __( 'All', 'tried' ),
                  'parent_item' => $posttype['taxonomy']['parent_item_taxonomy'],
                  'parent_item_colon' => $posttype['taxonomy']['parent_item_taxonomy'],
                  'edit_item' => __( 'Chỉnh sửa', 'tried' ),
                  'update_item' => __( 'Cập nhật', 'tried' ),
                  'add_new_item' => __( 'Thêm mới', 'tried' ),
                  'new_item_name' => __( 'Thêm mới', 'tried' ),
                  'menu_name' => $posttype['taxonomy']['name_taxonomy']
                ),
                // Control the slugs used for this taxonomy
                'rewrite' => array(
                  'slug' => $posttype['taxonomy']['id'], // This controls the base slug that will display before each term
                  'with_front' => false, // Don't display the category base before "/locations/"
                  'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
                ),
                'default_term' => $posttype['taxonomy']['default_term']
              );
              register_taxonomy( $posttype['taxonomy']['id'], array( $posttype['slug']), $taxonomyArgs );

              if ( isset( $posttype['taxonomy']['terms'] ) && !empty( $posttype['taxonomy'] ) ) {
                foreach ( $posttype['taxonomy']['terms'] as $term ) {
                  wp_insert_term( $term['name'], $posttype['taxonomy']['id'], array(
                    'description'   => $term['description'],
                    'slug'          => $term['slug'],
                  ) );
                }
              }
            }

            if ( isset( $posttype['sub_taxonomy'] ) && !empty( $posttype['sub_taxonomy'] ) ) {
              register_taxonomy( $posttype['sub_taxonomy']['id'], array(
                $posttype['slug']
              ), array(
                'hierarchical' => isset( $posttype['sub_taxonomy']['hierarchical'] ) ? $posttype['sub_taxonomy']['hierarchical'] : true,
                // This array of options controls the labels displayed in the WordPress Admin UI
                'labels' => array(
                  'name' => $posttype['sub_taxonomy']['name_taxonomy'],
                  'singular_name' => $posttype['sub_taxonomy']['name_taxonomy'],
                  'search_items' =>  __( 'Tìm kiếm', 'tried' ),
                  'all_items' => __( 'All', 'tried' ),
                  'edit_item' => __( 'Chỉnh sửa', 'tried' ),
                  'update_item' => __( 'Cập nhật', 'tried' ),
                  'add_new_item' => __( 'Thêm mới', 'tried' ),
                  'new_item_name' => __( 'Thêm mới', 'tried' ),
                  'menu_name' => $posttype['sub_taxonomy']['name_taxonomy']
                ),
                // Control the slugs used for this taxonomy
                'rewrite' => array(
                  'slug' => $posttype['sub_taxonomy']['id'], // This controls the base slug that will display before each term
                  'with_front' => false, // Don't display the category base before "/locations/"
                  'hierarchical' => isset( $posttype['sub_taxonomy']['hierarchical'] ) ? $posttype['sub_taxonomy']['hierarchical'] : true // This will allow URL's like "/locations/boston/cambridge/"
                ),
                'default_term' => $posttype['sub_taxonomy']['default_term']
              ) );
            }
          }
        }
      }
    }
    
    function tried_posttype_meta_boxes( $posttype, $post ) {
      if ( !empty( $this->posttypes ) ) {
        foreach ( $this->posttypes as $pt ) {
          if ( !isset( $pt['metabox'] ) || empty( $pt['metabox'] ) ) continue;
          foreach ( $pt['metabox'] as $metabox ) {
              add_meta_box(
                'tried-metabox-'.$metabox['id'],
                $metabox['title'],
                array( $this, 'callback_metabox_function' ),
                $metabox['capability'],
                'normal',
                'high',
                array(
                  'posttype' => $pt['id'],
                  'id' => $metabox['id'],
                  'metabox' => $metabox
                )
              );
          }
        }
      }
    }

    function callback_metabox_function( $post, $callback_args ) {
      $args = $callback_args['args'];
      ?>
<div class="tried-admin-metabox" role="<?php echo $args['id']; ?>">
    <div class="wrapper">
        <?php get_template_part( 'includes/posttypes/metabox/'.$args['posttype'].'_'.$args['id'], 'template', $args['metabox']['info'] ); ?>
    </div>
</div>
<?php
    }

    function tried_posttype_save_postdata( $post_id ) {
      global $pagenow;
      if ( !empty( $this->posttypes ) ) {
        foreach ( $this->posttypes as $pt ) {
          if ( 'post.php' === $pagenow && isset($_POST) && $pt['slug'] == $_POST['post_type'] ) {
            include_once get_template_directory().'/includes/posttypes/metabox/'.$pt['id'].'-savepost.php';
          }
        }
      }
    }

    function tried_posttype_admin_submenu() {
      global $submenu;
      if ( !empty( $this->posttypes ) ) {
        foreach ( $this->posttypes as $pt ) {
          if ( isset( $pt['submenu'] ) && $pt['submenu'] ) {
            if ( isset( $pt['submenu']['capability'] ) && !empty( $pt['submenu']['capability'] ) ) {
              foreach ( $pt['submenu']['capability'] as $cap ) {
                $submenu['edit.php?post_type='.$pt['slug']][] = array( $pt['submenu']['title'], $cap, admin_url( $pt['submenu']['permalink'] ) );
              }
            }
          }
        }
      }
    }

    function tried_admin_head_edit() {
      global $current_screen;
      if ( 'prod' == $current_screen->post_type ) {
        // coding
      }
    }
      
    function load_vars() {
      $this->posttypes = array(
        array(
          'slug' => 'advice',
          'name' => __( 'Advice', 'tried' ), 
          'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt', 'custom-fields' ),
          'id' => 'advice',
          'metabox' => array(),
          'taxonomy' => array(
            'id' => 'advice_cat',
            'name_taxonomy' => __( 'Category', 'tried' ), 
            'parent_item_taxonomy' => __( 'Parent', 'tried' ), 
            'default_term' => array( 'name' => 'Unknown', 'slug' => 'unknown', 'description' => '' )
          ),
          'remove_supports' => false,
          'is_custom' => false,
          'save_post' => false,
          'submenu' => false
        ),
        array(
          'id' => 'jobpost',
          'slug' => 'jobpost',
          'metabox' => array(
            array(
              'id' => 'information',
              'title' => __( 'Basic information', 'tried' ),
              'capability' => array( 'jobpost' ),
              'info' => array()
            ),
            array(
              'id' => 'advanced',
              'title' => __( 'Advanced information', 'tried' ),
              'capability' => array( 'jobpost' ),
              'info' => array()
            )
          ),
          'cus_taxonomy' => array(
            'id' => 'jobpost_level',
            'name_taxonomy' => __( 'Job Levels', 'tried' ), 
            'parent_item_taxonomy' => __( 'Parent', 'tried' ), 
            'default_term' => array( 'name' => 'Unknown', 'slug' => 'unknown', 'description' => '' )
          ),
          'is_custom' => true,
          'save_post' => true
        ),
        array(
          'id' => 'page',
          'slug' => 'page',
          'metabox' => array(
            array(
              'id' => 'information',
              'title' => __( 'Basic information', 'tried' ),
              'capability' => array( 'page' ),
              'info' => array()
            )
          ),
          'is_custom' => true,
          'save_post' => false
        ),
        array(
          'slug' => 'calevents',
          'name' => __( 'Event', 'tried' ), 
          'supports' => array( 'title' ),
          'id' => 'calevents',
          'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
          'metabox' => array(
            array(
              'id' => 'info',
              'title' => __( 'Event Info', 'tried' ),
              'capability' => array( 'calevents' ),
              'info' => array()
            ),
            array(
              'id' => 'schedule',
              'title' => __( 'Event Schedule', 'tried' ),
              'capability' => array( 'calevents' ),
              'info' => array()
            )
          ),
          'remove_supports' => false,
          'is_custom' => false,
          'save_post' => false,
          'submenu' => false
        ),
        // array(
        //   'slug' => 'jobrequired',
        //   'name' => __( 'Job Required', 'tried' ), 
        //   'supports' => array( 'title' ),
        //   'id' => 'jobrequired',
        //   'status' => array(
        //     array(
        //       'name' => __( 'New', 'tried' ),
        //       'val' => 'new'
        //     )
        //   ),
        //   'metabox' => array(
        //     array(
        //       'id' => 'customer',
        //       'title' => __( 'Customer Info', 'tried' ),
        //       'capability' => array( 'jobrequired' ),
        //       'info' => array()
        //     ),
        //     array(
        //       'id' => 'job',
        //       'title' => __( 'Job Info', 'tried' ),
        //       'capability' => array( 'jobrequired' ),
        //       'info' => array()
        //     )
        //   ),
        //   'taxonomy' => array(
        //     'id' => 'jobrequired_cat',
        //     'name_taxonomy' => __( 'Category', 'tried' ), 
        //     'parent_item_taxonomy' => __( 'Parent', 'tried' ),
        //     'terms' => array(
        //       array(
        //         'name'          => __( 'Upload a Job Description', 'tried' ),
        //         'slug'          => 'upload-a-job-description',
        //         'description'   => ''
        //       ),
        //       array(
        //         'name'          => __( 'Request a Call Back', 'tried' ),
        //         'slug'          => 'request-a-call-back',
        //         'description'   => ''
        //       )
        //     ),
        //     'default_term' => array( 'name' => 'Unknown', 'slug' => 'unknown', 'description' => '' )
        //   ),
        //   'sub_taxonomy' => array(
        //     'id' => 'jobrequired_option',
        //     'name_taxonomy' => __( 'Options', 'tried' ), 
        //     'parent_item_taxonomy' => __( 'Parent', 'tried' ),
        //     'terms' => array(
        //       array(
        //         'name'          => __( 'Job', 'tried' ),
        //         'slug'          => 'job',
        //         'description'   => ''
        //       ),
        //       array(
        //         'name'          => __( 'Hire', 'tried' ),
        //         'slug'          => 'hire',
        //         'description'   => ''
        //       )
        //     ),
        //     'default_term' => array( 'name' => 'Unknown', 'slug' => 'unknown', 'description' => '' )
        //   ),
        //   'remove_supports' => false,
        //   'is_custom' => false,
        //   'save_post' => false,
        //   'submenu' => false
        // )
      );
    }

    function load_includes() {
      if ( !empty( $this->includes ) ) {
          foreach ( $this->includes as $include ) {
              include_once get_template_directory() . $include;
          }
      }
    }
  }

  return new Tried_Posttype();
}