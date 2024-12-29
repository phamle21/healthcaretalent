<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$editor_applicant = get_post_meta( $post->ID, 'editor_applicant', true );
$editor_offer = get_post_meta( $post->ID, 'editor_offer', true );
?>

<fieldset class="metabox-block">
    <legend class="metabox-title"><?php _e( 'Your skills and experience', 'tried' ); ?></legend>
    <article class="metabox-article">
        <div class="metabox-option editor_applicant-<?php echo $post->ID; ?>-posttype">
            <div class="option-wrapper">
                <div class="option-inpt">
                    <?php wp_editor( $editor_applicant, 'editor_applicant' ); ?>
                </div>
            </div>
        </div>
    </article>
    <legend class="metabox-title"><?php _e( "Why you'll love working here", 'tried' ); ?></legend>
    <article class="metabox-article">
        <div class="metabox-option editor_offer-<?php echo $post->ID; ?>-posttype">
            <div class="option-wrapper">
                <div class="option-inpt">
                    <?php wp_editor( $editor_offer, 'editor_offer' ); ?>
                </div>
            </div>
        </div>
    </article>
</fieldset>