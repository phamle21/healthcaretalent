<?php

// Template: Modal Elblock

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$post_id = false;
if ( isset( $args['post_id'] ) ) {
	$post_id = $args['post_id'];
}
$eipostcontent = array();
if ( isset( $args['eipostcontent'] ) ) {
	$eipostcontent = $args['eipostcontent'];
}
$elements = array();
if ( isset( $args['elements'] ) ) {
	$elements = $args['elements'];
}
$eldefault_type = 'paragraph';
?>
<h3 class="title-elblocks"><?php _e( 'Content', 'tried' ); ?></h3>
<div id="element-elblocks">
    <div class="elblock-wrapper <?php echo empty( $eipostcontent )?'empty':''; ?>">
        <a class="elinsertblock" href="javascript:void(0)" data-position="top"></a>
        <div class="elblock pattern">
            <input type="hidden" class="elblock-status" value="1">
            <div class="wrap-elblock handle">
                <h4 class="handle-title" data-translate="<?php _e( 'Đoạn', 'tried' ); ?>"></h4>
                <div class="handle-actions">
                    <div class="wrap">
                        <button type="button" class="action dashicons" data-action="up"></button>
                        <button type="button" class="action dashicons" data-action="down"></button>
                        <button type="button" class="action dashicons" data-action="view"></button>
                        <button type="button" class="action dashicons" data-action="toggle"></button>
                    </div>
                    <div class="wrap remove">
                        <button type="button" class="action dashicons" data-action="remove"></button>
                    </div>
                </div>
            </div>
            <div class="wrap-elblock heading">
                <input type="text" class="elinput elblock-heading" placeholder="<?php _e( 'Thêm tiêu đề', 'tried' ); ?>"/>
                <div class="elanchor" style="display: none;">
                    <strong><?php _e('Đánh dấu', 'tried'); ?>:</strong>
                    <span class="text-anchor"></span>
                    <div class="wrap-anchor">
                        <input type="text" class="elinput elblock-anchor"/>
                        <a href="javascript:void(0)" class="button" data-action="save"><?php _e( 'Ok', 'tried' ); ?></a>
                        <a href="javascript:void(0)" class="button-link" data-action="cancel"><?php _e( 'Hủy', 'tried' ); ?></a>
                    </div>
                </div>
            </div>
            <div class="wrap-elblock context">
                <div class="elcontext-wrapper empty">
                    <a href="javascript:void(0)" class="elinsertelement" data-position="top"></a>
                    <div class="elcontext pattern">
                        <input type="hidden" class="elcontext-type" value="<?php echo $eldefault_type; ?>"/>
                        <div class="wrap-elcontext heading">
                            <img class="icon-elcontext" src="<?php echo $elements[$eldefault_type]['image']; ?>" alt="" data-origin="<?php echo TREXT_EIPOSTCONTENT_URL . 'assets/image/element/'; ?>">
                            <h4 class="title-elcontext" data-default="<?php _e( 'Thành phần', 'tried' ); ?>"><?php echo $elements[$eldefault_type]['name']; ?></h4>
                        </div>
                        <div class="wrap-elcontext content">
                            <textarea class="elcontext-content" cols="30" rows="2" placeholder="<?php _e( 'Thêm nội dung', 'tried' ); ?>"></textarea>
                            <div class="layout-elcontext"></div>
                        </div>
                        <div class="wrap-elcontext handle">
                            <div class="handle-actions">
                                <div class="wrap">
                                    <button type="button" class="action dashicons" data-action="html" data-role="elcontext"></button>
                                    <button type="button" class="action dashicons" data-action="edit" data-role="elcontext"></button>
                                    <button type="button" class="action dashicons" data-action="trash" data-role="elcontext"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="elinsertelement"></a>
                </div>
            </div>
        </div>
        <?php
            if ( !empty( $eipostcontent ) ) :
                foreach ( $eipostcontent as $kblock => $elblock ) :
        ?>
                    <div class="elblock<?php echo $elblock->elblock_status === '0'?' hidden':''; ?>" data-key="<?php echo $kblock; ?>">
                        <input type="hidden" class="elblock-status" name="<?php echo 'elblock_status__'.$kblock; ?>" value="<?php echo $elblock->elblock_status; ?>">
                        <div class="wrap-elblock handle">
                            <h4 class="handle-title" data-translate="<?php _e( 'Đoạn', 'tried' ); ?>"><?php echo $elblock->elblock_heading; ?></h4>
                            <div class="handle-actions">
                                <div class="wrap">
                                    <button type="button" class="action dashicons" data-action="up"></button>
                                    <button type="button" class="action dashicons" data-action="down"></button>
                                    <button type="button" class="action dashicons<?php echo $elblock->elblock_status === '0'?' none-visibility':''; ?>" data-action="view"></button>
                                    <button type="button" class="action dashicons" data-action="toggle"></button>
                                </div>
                                <div class="wrap remove">
                                    <button type="button" class="action dashicons" data-action="remove"></button>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-elblock heading">
                            <input type="text" class="elinput elblock-heading" name="<?php echo 'elblock_heading__'.$kblock; ?>" placeholder="<?php _e( 'Thêm tiêu đề', 'tried' ); ?>" value="<?php echo $elblock->elblock_heading; ?>"/>
                            <div class="elanchor"<?php echo !$elblock->elblock_heading?'style="display: none;"':''; ?>>
                                <strong><?php _e('Đánh dấu', 'tried'); ?>:</strong>
                                <span class="text-anchor"><?php echo $elblock->elblock_anchor?$elblock->elblock_anchor:convert_slug( $elblock->elblock_heading ); ?></span>
                                <div class="wrap-anchor">
                                    <input type="text" class="elinput elblock-anchor" name="<?php echo 'elblock_anchor__'.$kblock; ?>" value="<?php echo $elblock->elblock_anchor?$elblock->elblock_anchor:convert_slug( $elblock->elblock_heading ); ?>"/>
                                    <a href="javascript:void(0)" class="button" data-action="save"><?php _e( 'Ok', 'tried' ); ?></a>
                                    <a href="javascript:void(0)" class="button-link" data-action="cancel"><?php _e( 'Hủy', 'tried' ); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-elblock context">
                            <div class="elcontext-wrapper<?php echo ( empty( $elblock->elcontexts ) )?' empty':''; ?>">
                                <a href="javascript:void(0)" class="elinsertelement" data-position="top"></a>
                                <div class="elcontext pattern">
                                    <input type="hidden" class="elcontext-type" value="<?php echo $eldefault_type; ?>"/>
                                    <div class="wrap-elcontext heading">
                                        <img class="icon-elcontext" src="<?php echo $elements[$eldefault_type]['image']; ?>" alt="" data-origin="<?php echo TREXT_EIPOSTCONTENT_URL . 'assets/image/element/'; ?>">
                                        <h4 class="title-elcontext" data-default="<?php echo $elements[$eldefault_type]['name']; ?>"><?php echo $elements[$eldefault_type]['name']; ?></h4>
                                    </div>
                                    <div class="wrap-elcontext content">
                                        <textarea class="elcontext-content" cols="30" rows="2" placeholder="<?php _e( 'Thêm nội dung', 'tried' ); ?>"></textarea>
                                        <div class="layout-elcontext"></div>
                                    </div>
                                    <div class="wrap-elcontext handle">
                                        <div class="handle-actions">
                                            <div class="wrap">
                                                <button type="button" class="action dashicons" data-action="html" data-role="elcontext"></button>
                                                <button type="button" class="action dashicons" data-action="edit" data-role="elcontext"></button>
                                                <button type="button" class="action dashicons" data-action="trash" data-role="elcontext"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    if ( !empty( $elblock->elcontexts ) ) :
                                        foreach ( $elblock->elcontexts as $kcontext => $elcontext ) :
                                            $elcontext_type = $elcontext->elcontext_type?$elcontext->elcontext_type:$eldefault_type;
                                ?>
                                            <div class="elcontext" data-key="<?php echo $kcontext; ?>">
                                                <input type="hidden" class="elcontext-type" name="<?php echo 'elcontext_type__'.$kblock.'__'.$kcontext; ?>" value="<?php echo $elcontext_type; ?>"/>
                                                <div class="wrap-elcontext heading">
                                                    <img class="icon-elcontext" src="<?php echo $elements[$elcontext_type]['image']; ?>" alt="" data-origin="<?php echo TREXT_EIPOSTCONTENT_URL . 'assets/image/element/'; ?>">
                                                    <h4 class="title-elcontext" data-default="<?php _e( 'Thành phần', 'tried' ); ?>"><?php echo $elements[$elcontext_type]['name']; ?></h4>
                                                </div>
                                                <div class="wrap-elcontext content">
                                                    <textarea class="elcontext-content" name="<?php echo 'elcontext_content__'.$kblock.'__'.$kcontext; ?>" cols="30" rows="2" placeholder="<?php _e( 'Thêm nội dung', 'tried' ); ?>"><?php echo $elcontext->elcontext_content; ?></textarea>
                                                    <div class="layout-elcontext"><?php echo $elcontext->elcontext_content; ?></div>
                                                </div>
                                                <div class="wrap-elcontext handle">
                                                    <div class="handle-actions">
                                                        <div class="wrap">
                                                            <button type="button" class="action dashicons" data-action="html" data-role="elcontext"></button>
                                                            <button type="button" class="action dashicons" data-action="edit" data-role="elcontext"></button>
                                                            <button type="button" class="action dashicons" data-action="trash" data-role="elcontext"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                <?php
                                        endforeach;
                                    endif;
                                ?>
                                <a href="javascript:void(0)" class="elinsertelement"></a>
                            </div>
                        </div>
                    </div>
        <?php
                endforeach;
            endif;
        ?>
        <a class="elinsertblock" href="javascript:void(0)"></a>
    </div>
</div>
