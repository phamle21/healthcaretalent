<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$video = get_post_meta( $post->ID, 'video', true );
$location = get_post_meta( $post->ID, 'location', true );
$publish = get_post_meta( $post->ID, 'publish', true );
$publish_finish = get_post_meta( $post->ID, 'publish_finish', true );
$currentNow = current_datetime()->format( 'Y-m-d H:i' );
if ( !empty( $publish ) ) {
    if ( ( strtotime( 'now' ) - strtotime( $publish ) ) > 0 ) {
        $currentNow = $publish;
    }
}
?>

<fieldset class="metabox-block">
    <article class="metabox-article grid grid-col2">
        <div class="metabox-option video-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Youtube(ID)', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="text" name="video" value="<?php echo $video; ?>"
                        placeholder="<?php _e( 'Enter Youtube ID', 'tried' ); ?>" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option location-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Location', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="text" name="location" value="<?php echo $location; ?>"
                        placeholder="<?php _e( 'Enter Location', 'tried' ); ?>" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option publish-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Event open at', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="datetime-local" name="publish" value="<?php echo $publish; ?>"
                        placeholder="<?php _e( 'Enter Publish', 'tried' ); ?>" min="<?php echo $currentNow; ?>"
                        required />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option publish_finish-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Event finish at', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="datetime-local" name="publish_finish" value="<?php echo $publish_finish; ?>"
                        placeholder="<?php _e( 'Enter Publish-finish', 'tried' ); ?>"
                        min="<?php echo $currentNow; ?>" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
    </article>
</fieldset>