<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'EIPost_Content_Template', false ) ) {
	class EIPost_Content_Template extends EIPost_Content {
    public $includes = array(
      'includes/function-shortcode.php'
    );
    public $elements = array();

		function __construct() {
      $this->load_hooks();
      $this->includes();

      $this->elements = array(
        'heading' => array( 'name' => __( 'Title', 'tried' ), 'image' => TREXT_EIPOSTCONTENT_URL . 'assets/image/element/heading.svg', 'status' => true ),
        'list' => array( 'name' => __( 'Danh sách', 'tried' ), 'image' => TREXT_EIPOSTCONTENT_URL . 'assets/image/element/list.svg', 'status' => false ),
        'table' => array( 'name' => __( 'Bảng', 'tried' ), 'image' => TREXT_EIPOSTCONTENT_URL . 'assets/image/element/table.svg', 'status' => true ),
        'paragraph' => array( 'name' => __( 'Đoạn văn', 'tried' ), 'image' => TREXT_EIPOSTCONTENT_URL . 'assets/image/element/paragraph.svg', 'status' => true ),
        'code' => array( 'name' => __( 'Mã Code', 'tried' ), 'image' => TREXT_EIPOSTCONTENT_URL . 'assets/image/element/code.svg', 'status' => true ),
        'frame' => array( 'name' => __( 'Nhúng', 'tried' ), 'image' => TREXT_EIPOSTCONTENT_URL . 'assets/image/element/frame.svg', 'status' => false ),
        'image' => array( 'name' => __( 'Hình ảnh', 'tried' ), 'image' => TREXT_EIPOSTCONTENT_URL . 'assets/image/element/image.svg', 'status' => false ),
        'quote' => array( 'name' => __( 'Trích dẫn', 'tried' ), 'image' => TREXT_EIPOSTCONTENT_URL . 'assets/image/element/quote.svg', 'status' => true ),
        'note' => array( 'name' => __( 'Chú Thích', 'tried' ), 'image' => TREXT_EIPOSTCONTENT_URL . 'assets/image/element/note.svg', 'status' => true )
      );
		}

    function load_hooks() {
      add_action( 'wp_ajax_elements_frame', array( $this, 'ajx_elements_frame' ) );
      
      // posttype
      add_action( 'load-post-new.php', array( $this, 'eipostcontent_load_post_content' ) );
      add_action( 'load-post.php', array( $this, 'eipostcontent_load_post_content' ) );
      add_action( 'edit_form_after_title', array( $this, 'eipostcontent_post_edit_form_after_title' ) );
      add_action( 'edit_form_advanced', array( $this, 'eipostcontent_post_edit_form_advanced' ) );
      add_action( 'add_meta_boxes', array( $this, 'eipostcontent_posttype_meta_boxes' ), 10, 2 );
      add_action( 'save_post', array( $this, 'eipostcontent_save_postdata' ) );
    }

    function eipostcontent_post_edit_form_after_title( $post ) {
      global $pagenow, $typenow;
      if ( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && $typenow == 'post' ) {
        $mode_eipostcontent = get_post_meta( $post->ID, 'mode_eipostcontent', true )?get_post_meta( $post->ID, 'mode_eipostcontent', true ):'0';
        printf(
          '<div id="eldoms">
            <div class="eldom-item">
              <input type="hidden" name="mode_eipostcontent" value="%s">
              <button type="button" class="button button-primary %s" data-action="mode" data-target="eldom" data-textback="%s">%s</button>
            </div>
          </div>',
          $mode_eipostcontent,
          ( $mode_eipostcontent != '0' )?'active':'',
          __( 'Quay lại', 'tried' ),
          __( 'Chế độ Eipostcontent', 'tried' )
        );
      }
    }

    function eipostcontent_post_edit_form_advanced( $post ) {
      global $pagenow, $typenow;
      if ( ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) && $typenow == 'post' ) {
        $mode_eipostcontent = get_post_meta( $post->ID, 'mode_eipostcontent', true );
        if ( $mode_eipostcontent && $mode_eipostcontent != '0' ) {
          $id_target = 'poststuff';
          $new_class = 'mode-eipostcontent';
          echo "<script>document.getElementById('{$id_target}').classList.add('{$new_class}');</script>";
        }
      }
    }

    function eipostcontent_posttype_meta_boxes( $post_type, $post ) {
      $metaboxs = array( 
        array( 'id' => 'post', 'title' => __( 'Chế độ Eipostcontent', 'trỉed' ), 'render' => 'post' )
      );
      
      if ( !empty( $metaboxs ) ) {
        foreach ($metaboxs as $metabox) {
          add_meta_box(
            'eipostcontent-meta-box',
            $metabox['title'],
            array( $this, "render_{$metabox['render']}_meta_box" ),
            $metabox['id'],
            'normal',
            'high'
          );
        }
      }
    }

    function render_post_meta_box( $post_id ) {
      if ( isset( $_GET['post'] ) ) {
        $post_id = $_GET['post'];
      }

      $args = array(
        'post_id' => $post_id
      );
      
      if ( class_exists( 'EIPost_Content_Database', false ) ) {
        $db = new EIPost_Content_Database();
        $args['eipostcontent'] = json_decode($db->select( $post_id )->post_content);
        $args['elements'] = $this->elements;
      }
      get_template_part( TREXT_EIPOSTCONTENT_ROOT . '/templates/backend/elblocks/elblocks', 'element', $args );
    }

    function eipostcontent_save_postdata( $post_id ) {
      if ( array_key_exists( 'mode_eipostcontent', $_POST ) ) {
        update_post_meta( $post_id, 'mode_eipostcontent', $_POST['mode_eipostcontent'] );
      }

      $post_content = $this->analys_elcontext_content( $_POST );
      if ( $post_content ) {
        $args = array(
          'post_content' => json_encode( $post_content )
        );
        $db = new EIPost_Content_Database();
        if ( $db->exist( $post_id ) ) {
          $db->update( $post_id, $args );
        } else {
          $args['post_id'] = $post_id;
          $db->insert( $args );
        }
      }
    }

    function analys_elcontext_content( $args = array() ) {
      if ( empty( $args ) ) return false;
      $result = array();
      $keys_pattern = array( 'elcontext_type', 'elcontext_type', 'elblock_status', 'elblock_heading', 'elblock_anchor', 'elcontext_type', 'elcontext_content' );
      foreach ( $args as $key => $value ) {
        $ckey = explode( '__', $key );
        if ( !count( $ckey ) > 0 || !in_array( $ckey[0], $keys_pattern ) ) continue;
        if ( count( $ckey ) === 3 ) {
          $result[$ckey[1]]['elcontexts'][$ckey[2]][$ckey[0]] = str_replace( '\\', '', html_entity_decode($value));
        } else {
          $result[$ckey[1]][$ckey[0]] = $value;
        }
      }
      return $result;
    }

    function eipostcontent_load_post_content( $post_id )  {
      if ( !isset( $_GET['post'] ) ) return;
      $post_id = $_GET['post'];
      
      $args = array(
        false,
        array( 'post_id' => $post_id )
      );
      $paths = array(
        array( 'slug' => '/templates/backend/elblocks/elblocks', 'name' => 'modal-notifi' ),
        array( 'slug' => '/templates/backend/elblocks/elblocks', 'name' => 'frame' ),
      );
      if ( !empty( $paths ) ) {
        foreach ( $paths as $p => $path ) {
          get_template_part( TREXT_EIPOSTCONTENT_ROOT . $path['slug'], $path['name'], $args[$p] );
        }
      }
    }

    function is_edit_page( $new_edit = null ) {
      if ( !is_admin() ) return false;

      global $pagenow;
      if( $new_edit == 'edit' ) {
        return in_array( $pagenow, array( 'post.php' ) );
      } elseif ($new_edit == 'new' ) { //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
      } else { //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
      }
    }

    function ajx_elements_frame() {
      $response = array();
      $slug = '';
      $args = array();
      $message = '';
      $libs = json_encode("{ 'trumbowyg': true }");

      if ( isset( $_GET['post_id'] ) && !empty( $_GET['post_id'] ) && is_numeric( $_GET['post_id'] ) ) {
        $args['post_id'] = $_GET['post_id'];
      }
      if ( isset( $_GET['element'] ) ) {
        $slug = $_GET['element'];;
        $response['libs'] = $libs;
        $response['title'] = $this->elements[$slug]['name'];
        $message = __( 'Đang sử dụng tài nguyên', 'tried' ) . ': ' . $this->elements[$slug]['name'];
      } else {
        $args['elements'] = $this->elements;
        $message = __( 'Tổng cộng', 'tried' ) . ': ' . count( $this->elements ) . ' item';
      }

      ob_start();
      get_template_part( TREXT_EIPOSTCONTENT_ROOT .'/templates/backend/elements/element', $slug, $args );
      $result = ob_get_contents();
      ob_end_clean();

      $response['result'] = $result;
      $response['message'] = $message;
      $response['breadcrumbs'] = $this->breadcrumb_elements_ipc_frame( $slug, $this->elements, true );
        
      wp_send_json( $response );
    }

    function breadcrumb_elements_ipc_frame($tar = '', $cpnts = array()) {
      ob_start();
      if ( isset( $cpnts[$tar] ) ) {
        printf( '<li><a href="javascript:void(0)">%s</a></li><li><span>%s</span></li>', __( 'Tất cả', 'tried' ), $cpnts[$tar]['name'] );
      } else {
        printf( '<li><strong>%s</strong></li><li><span>%s</span></a>', __( 'Thành phần', 'tried' ), __( 'Chung', 'tried' ) );
      }
      $breadcrumbs = ob_get_contents();
      ob_end_clean();
      return $breadcrumbs;
    }
	}

  return new EIPost_Content_Template();
}
