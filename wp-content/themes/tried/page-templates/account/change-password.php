<?php 
/* Template Name: Account - Profile detail */
defined('ABSPATH') || exit;

global $current_user;
wp_get_current_user();

wp_enqueue_style( 'tried-account_change_password-block' );

$message_form = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$message_form = process_change_password_form( $current_user->ID, $_POST );
}
?>
<div id="change_password_account-block">
    <div class="change_passwords">
        <div class="change_password-item">
            <h4 class="profiletitle"><?php _e( 'Personal Details', 'tried' ); ?></h4>
            <div class="section-wrapper editing">
                <div class="section-update">
                    <form class="change_password-form" method="post" action="">
                        <?php wp_nonce_field( 'tried-accountform', 'tried-accountform-nonce' ); ?>
                        <div class="message-field">
                            <?php
                                if ( !empty( $message_form ) ) {
                                    printf( '<div class="message %s">%s</div>',
                                        $message_form['notify'], $message_form['content']
                                    );
                                }
                            ?>
                        </div>
                        <div class="col-field currentpassword">
                            <label for="user-currentpassword"><?php _e( 'Current password', 'tried' ); ?>:</label>
                            <input type="password" name="currentpassword" id="user-currentpassword" value="">
                        </div>
                        <div class="col-field newpassword">
                            <label for="user-newpassword"><?php _e( 'Password', 'tried' ); ?>:</label>
                            <input type="password" name="newpassword" id="user-newpassword" value="">
                        </div>
                        <div class="col-field submit">
                            <input type="submit" value="<?php _e('Confirm Change', 'tried'); ?>" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>