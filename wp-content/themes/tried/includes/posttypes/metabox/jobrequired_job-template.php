<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$jobtitle = get_post_meta( $post->ID, 'job_title', true );
$joblocation = get_post_meta( $post->ID, 'job_location', true );
$jobsector = get_post_meta( $post->ID, 'job_sector', true );
$jobtag = get_post_meta( $post->ID, 'job_tag', true );
$jobsector = get_post_meta( $post->ID, 'job_sector', true );
$jobcv = get_post_meta( $post->ID, 'job_cv', true );

$jobCats = apply_filters( 'tried_all_taxonomy', 'jobpost_category' );
$jobLocations = apply_filters( 'tried_all_taxonomy', 'jobpost_location' );
$jobSectors = apply_filters( 'tried_all_taxonomy', 'jobpost_job_type' );
$jobTitles = apply_filters( 'tried_all_taxonomy', 'jobpost_tag' );
?>

<fieldset class="metabox-block">
    <article class="metabox-article">
        <div class="metabox-option jobtitle-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Job Title', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="text" name="job_title" value="<?php echo $jobtitle; ?>"
                        placeholder="<?php _e( 'Enter Job Title', 'tried' ); ?>" />
                </div>
                <p class="option-desc">
                    <!-- <strong>Chú thích</strong>: Giá gốc khi đăng thông tin bán sản phẩm(lần đầu). -->
                </p>
            </div>
        </div>
    </article>
    <article class="metabox-article grid grid-col3">
        <div class="metabox-option joblocation-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Job Location', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <select name="job_location">
                        <option value=""><?php _e( 'Choose Job Location', 'tried' ); ?></option>
                        <?php
                            if ( !empty( $jobLocations ) ) {
                                foreach ( $jobLocations as $jlocation ) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $jlocation->term_id, selected( $jlocation->term_id, $joblocation ), $jlocation->name
                                    );
                                }
                            }
                        ?>
                    </select>
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option jobsector-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Job Function', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <select name="job_sector">
                        <option value=""><?php _e( 'Choose Job Function', 'tried' ); ?></option>
                        <?php
                            if ( !empty( $jobSectors ) ) {
                                foreach ( $jobSectors as $jsector ) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $jsector->term_id, selected( $jsector->term_id, $jobsector ), $jsector->name
                                    );
                                }
                            }
                        ?>
                    </select>
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option jobtag-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Job Title(Sector of the position)', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <select name="job_tag">
                        <option value=""><?php _e( 'Choose Job Function', 'tried' ); ?></option>
                        <?php
                            if ( !empty( $jobTitles ) ) {
                                foreach ( $jobTitles as $jtitle ) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        $jtitle->term_id, selected( $jtitle->term_id, $jobtag ), $jtitle->name
                                    );
                                }
                            }
                        ?>
                    </select>
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
    </article>
    <article class="metabox-article">
        <div class="metabox-option jobtitle-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'File CV', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <div id="current_img">
                        <?php
                            $icon_dir = apply_filters( 'icon_dir',  get_site_url() . '/' . WPINC . '/images/media' );
                            $upload_url = $icon_dir.'/document.png';
                            if ( false ) {
                                printf(
                                    '<img class="tried-current-img" src="%s" />
                                    <div class="edit_options uploaded">
                                        <a class="remove_img" href="javascript:void(0)" title="%s">%s</a>
                                        <a class="edit_img" href="%s"
                                            target="_blank" title="%s">%s</a>
                                    </div>',
                                    esc_url( $upload_url ),
                                    __( 'Delete', 'tried' ),
                                    __( 'Delete', 'tried' ),
                                    esc_url( $upload_url ),
                                    __( 'Chỉnh sửa', 'tried' ),
                                    __( 'Chỉnh sửa', 'tried' )
                                );
                            } elseif ( $jobcv ) {
                                printf(
                                    '<img class="tried-current-document" src="%s/document.png" alt=""/>
                                    <img class="tried-current-img" src="%s/document.png" alt="" style="display: none;"/>',
                                    $icon_dir, $icon_dir
                                );
                            } else {
                                printf(
                                    '<img class="tried-current-img placeholder" src="%s" alt="" />',
                                    get_theme_file_uri( "/assets/img/placeholder.png" )
                                );
                            }
                        ?>
                    </div>
                    <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                    <div id="tried_external" style="display: none;">
                        <input class="regular-text" type="text" name="job_url_cv" id="tried_meta"
                            value="<?php echo esc_url_raw( wp_get_attachment_url( $jobcv ) ); ?>" />
                    </div>
                    <!-- Hold the value here if this is a WPMU image -->
                    <div id="tried_upload">
                        <input class="hidden" type="hidden" name="tried_placeholder_meta" id="tried_placeholder_meta"
                            value="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>" />
                        <input class="hidden" type="hidden" name="job_media_cv" id="tried_upload_meta"
                            value="<?php echo esc_url_raw( wp_get_attachment_url( $jobcv ) ); ?>" disabled />
                        <input class="hidden" type="hidden" name="tried_upload_edit_meta" id="tried_upload_edit_meta"
                            value="<?php echo esc_url_raw( get_site_url().'/wp-admin/post.php?post='.$jobcv.'&action=edit&image-editor' ); ?>" />
                        <input id="uploadimage" type='button' class="tried_wpmu_button button-primary"
                            value="<?php _e( 'Upload', 'tried' ); ?>" />
                    </div>
                    <!-- Select an option: Upload to WPMU or External URL -->
                    <div id="tried_options">
                        <label for="upload_option">
                            <input type="radio" id="upload_option" name="img_option" value="upload" class="tog">
                            <?php _e( 'Hình ảnh hệ thống', 'tried' ); ?>
                        </label>
                        <label for="external_option">
                            <input type="radio" id="external_option" name="img_option" value="external" class="tog"
                                checked>
                            <?php _e( 'Đường dẫn URL', 'tried' ); ?>
                        </label>
                    </div>
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
    </article>
</fieldset>