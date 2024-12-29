<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$fullname = get_post_meta( $post->ID, 'cus_fullname', true );
$telephone = get_post_meta( $post->ID, 'cus_telephone', true );
$email = get_post_meta( $post->ID, 'cus_email', true );
$company = get_post_meta( $post->ID, 'cus_company', true );
?>

<fieldset class="metabox-block">
    <article class="metabox-article grid grid-col2">
        <div class="metabox-option fullname-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Full Name', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="text" name="cus_fullname" value="<?php echo $fullname; ?>"
                        placeholder="<?php _e( 'Enter Fullname', 'tried' ); ?>" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option telephone-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Telephone', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="text" name="cus_telephone" value="<?php echo $telephone; ?>"
                        placeholder="<?php _e( 'Enter Telephone', 'tried' ); ?>" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option email-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Email', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="text" name="cus_email" value="<?php echo $email; ?>"
                        placeholder="<?php _e( 'Enter Email', 'tried' ); ?>" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
        <div class="metabox-option company-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Company', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <input type="text" name="cus_company" value="<?php echo $company; ?>"
                        placeholder="<?php _e( 'Enter Company', 'tried' ); ?>" />
                </div>
                <p class="option-desc"></p>
            </div>
        </div>
    </article>
</fieldset>