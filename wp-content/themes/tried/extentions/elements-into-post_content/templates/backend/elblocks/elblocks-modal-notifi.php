<?php
// Template: Modal Elblock

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$post_id = false;
if ( isset( $_GET['post'] ) ) {
    $post_id = $_GET['post'];
}
if ( isset( $args['post_id'] ) ) {
	$post_id = $args['post_id'];
}

$custom_logo = get_theme_mod( 'custom_logo' );
$logo = wp_get_attachment_image_src( $custom_logo , 'full' );
?>
<div id="modal-elblocks" style="display: none;" data-action="false" data-role="false">
    <div class="modal-wrapper">
        <div class="wrap-modal head">
            <div class="modal-logo">
                <?php
                    if ( $logo ) :
                    printf( 
                        '<a href="%s" class="custom-second-logo" title="%s" rel="home"><img src="%s" alt="%s"></a>',
                        esc_url( admin_url( '/' ) ),
                        esc_attr( 'Home', 'tried' ),
                        esc_url( $logo[0] ),
                        get_bloginfo( 'name' )
                    );
                    endif;
                ?>
            </div>
            <div class="handle-actions">
                <div class="wrap">
                    <button type="button" class="action dashicons" data-target="modal" data-action="close"></button>
                </div>
            </div>
        </div>
        <div class="wrap-modal body">
            <div class="contain">
                <div class="content remove">
                    <div class="left-content"><span class="message-icon dashicons dashicons-dismiss"></span></div>
                    <div class="right-content">
                        <?php printf( '<p class="message">%s</p>', __( 'Bạn đồng ý yêu cầu xóa này không?', 'tried' ) ); ?>
                    </div>
                </div>
                <div class="content warning">
                    <div class="left-content"><span class="message-icon dashicons dashicons-warning"></span></div>
                    <div class="right-content">
                        <?php printf( '<p class="message">%s</p>', __( 'Cảnh báo, đây có thể ảnh hưởng đến dữ liệu.', 'tried' ) ); ?>
                    </div>
                </div>
                <div class="content confirm">
                    <div class="left-content"><span class="message-icon dashicons dashicons-yes-alt"></span></div>
                    <div class="right-content">
                        <?php printf( '<p class="message">%s</p>', __( 'Xác nhận chấp thuận hành động này không?', 'tried' ) ); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrap-modal foot">
            <div class="contain">
                <div class="handle-actions">
                    <button type="button" class="button action" data-target="modal" data-action="ok"><?php _e( 'Chấp nhận', 'tried' ); ?></button>
                    <button type="button" class="button action" data-target="modal" data-action="cancel"><?php _e( 'Không, cảm ơn!', 'tried' ); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
