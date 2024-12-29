<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_shortcode( 'render_eipostcontent', 'sc_render_eipostcontent' );
function sc_render_eipostcontent( $atts = array(), $content = null ) {
  ob_start();
  $args = shortcode_atts( array(
    'post_id' => false
  ),
  $atts );

	$post_id = '';
	if ( $args['post_id'] && is_numeric( $args['post_id'] ) ) {
		$post_id = $args['post_id'];
	}
  if ( class_exists( 'EIPost_Content_Database', false ) ) {
		$db = new EIPost_Content_Database();
		$eipostcontent = json_decode($db->select( $post_id )->post_content);
    if ( !empty( $eipostcontent ) ) {
      $str = "<div id='eipostcontent'>";
      foreach ( $eipostcontent as $kblock => $elblock ) {
        $str .= "<div class='elblock'>";
        if ( $elblock->elblock_status != '0' ) {
          $elblock_anchor = $elblock->elblock_anchor?$pc->elblock_anchor:convert_slug( $elblock->elblock_heading );
          $str .= "<h2 id='{$elblock_anchor}'>{$elblock->elblock_heading}</h2>";
          if ( empty( $elblock->elcontexts ) ) continue;
          foreach ( $elblock->elcontexts as $kcontext => $elcontext ) {
            $str .= "<div class='layout-elcontext'>
                <div class='elcontext'>
                  {$elcontext->elcontext_content}
                </div>
              </div>";
          }
        }
        $str .= "</div>";
      }
      $str .= "</div>";
      echo htmlspecialchars_decode( $str );
    }
  }
  $result = ob_get_contents();
  ob_end_clean();
  return $result;
}