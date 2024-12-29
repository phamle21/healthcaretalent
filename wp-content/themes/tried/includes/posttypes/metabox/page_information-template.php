<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$top_banner = get_post_meta( $post->ID, 'top_banner', true );
?>

<fieldset class="metabox-block">
    <article class="metabox-article grid grid-col2">
        <div class="metabox-option fullname-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Top Banner(Image)', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="text" name="top_banner" value="<?php echo $top_banner; ?>"
                        placeholder="<?php _e( 'Enter Link Image', 'tried' ); ?>" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
    </article>
</fieldset>