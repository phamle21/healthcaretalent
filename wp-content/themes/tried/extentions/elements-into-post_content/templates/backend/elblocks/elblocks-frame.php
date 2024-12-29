<?php

// Template: Modal Elblock

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$post_id = false;
if ( isset( $_GET['post'] ) ) {
    $post_id = $_GET['post'];
}
if ( $args['post_id'] ) {
	$post_id = $args['post_id'];
}
?>
<div id="frame-elblocks" style="display: none;">
    <div class="wrapper">
        <div class="header">
            <div class="contain">
                <div class="top">
                    <h5 class="title"><?php _e( 'Bảng điều khiển', 'tried' ); ?></h5>
                    <span class="close">&times;</span>
                </div>
                <div class="bottom">
                    <ul class="breadcrumbs">
                        <li><strong><?php _e( 'Thành phần', 'tried' ); ?></strong></li>
                        <li><a href="javascript:void(0)"><?php _e( 'Tất cả', 'tried' ); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="contain">
                <form id="frame-elblocks-form" action="frame-elblocks_result" method="post">
                    <input type="hidden" name="elblock" value="false">
                    <input type="hidden" name="elcontext" value="false">
                    <input type="hidden" name="type" value="paragraph">
                    <input type="hidden" name="title" value="false">
                    <input type="hidden" name="action" value="insert">
                    <input type="hidden" name="toposition" value="false">
                    <div id="element-context"></div>
                    <div id="element-action" style="display: none;">
                        <button type="submit" class="button button-primary"><?php _e( 'Áp dụng', 'tried' ); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer">
            <div class="contain">
                <p class="message"></p>
                <p class="status"><strong><?php _e( 'Hoạt động', 'tried' ); ?>:</strong> <span></span></p>
            </div>
        </div>
    </div>
</div>
