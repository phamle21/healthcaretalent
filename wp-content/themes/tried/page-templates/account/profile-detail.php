<?php 
/* Template Name: Account - Profile detail */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-account_profile_detail-block' );

global $current_user;
wp_get_current_user();

$ethnicities = array(
    'Hispanic or Latino',
    'White',
    'Black or African American',
    'Asian',
    'Native Hawaiian or Other Pacific Islander',
    'American Indian or Alaska Native',
    'Two or More Races',
    'I choose not to self-identify'
);
$veterans = array(
    'I am a Protected Veteran',
    'I am not a Protected Veteran',
    'I choose not to self-identify'
);
$disabilities = array(
    'Yes, I have a disability/history of having a disability',
    'No, I don’t have a disability/history of having a disability',
    'I choose not to self-identify'
);

    /** Basic info */
    $userFullname = $current_user->display_name?$current_user->display_name:'-';
    $userEmail = $current_user->user_email ?? 'info@temp.com';
    $userPhone = !empty( get_the_author_meta( 'phone', $current_user->ID ) ) ? get_the_author_meta( 'phone', $current_user->ID ) : '-';

    /** Additional info */
    $resumeEthnicity = !empty( get_the_author_meta( 'resume_ethnicity', $current_user->ID ) ) ? get_the_author_meta( 'resume_ethnicity', $current_user->ID ) : '-';
    $resumeVeteran = !empty( get_the_author_meta( 'resume_veteran', $current_user->ID ) ) ? get_the_author_meta( 'resume_veteran', $current_user->ID ) : '-';
    $resumeDisabilitie = !empty( get_the_author_meta( 'resume_disabilitie', $current_user->ID ) ) ? get_the_author_meta( 'resume_disabilitie', $current_user->ID ) : '-';

    $resumeCV = !empty( get_the_author_meta( 'resume_cv', $current_user->ID ) ) ? get_the_author_meta( 'resume_cv', $current_user->ID ) : array();
    
    $message_basic = array();
    $message_additional = array();
    $isEditing = false;
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        $isEditing = $_POST['profile_func'] ?? 'basic';
        if ( $isEditing == 'additional' ) {
            $message_additional = process_update_resume_info_form( $current_user->ID, $_POST );
            if ( $message_additional['notify'] == 'success' ) $isEditing = false;
            if ( $message_additional['parameters'] ) {
                $resumeEthnicity = $message_additional['parameters']['resume_ethnicity'];
                $resumeVeteran = $message_additional['parameters']['resume_veteran'];
                $resumeDisabilitie = $message_additional['parameters']['resume_disabilitie'];
            }
        } else {
            $message_basic = process_update_info_form( $current_user->ID, $_POST );
            if ( $message_basic['notify'] == 'success' ) $isEditing = false;
            if ( $message_basic['parameters'] ) {
                $userFullname = $message_basic['parameters']['fullname'];
                $userEmail = $message_basic['parameters']['email'];
                $userPhone = $message_basic['parameters']['phone'];
            }
        }
	}
?>
<div id="profile_detail_account-block">
    <div class="profile_details">
        <div class="profile_detail-item cv">
            <h4 class="profiletitle"><?php _e( 'My CV', 'tried' ); ?></h4>
            <div class="section-wrapper <?php echo $isEditing == 'basic'?'editing':''; ?>">
                <div class="section-info">
                    <div class="info-item">
                        <div class="list-cvs">
                            <?php
                                if ( $resumeCV ) {
                                    foreach ( $resumeCV as $c => $cv ) {
                                        if ( !$cv ) continue;
                                        printf(
                                            '<div class="cv-item" data-cv_id="%s">
                                                <div class="cv-wrap box-contain">
                                                    <div class="cv-context">
                                                        <h5>%s</h5>
                                                        <p>Uploaded media with <span>#%s</span></p>
                                                    </div>
                                                    <div class="cv-action">
                                                        <a class="action-option" href="javascript:void(0)" title="%s"></a>
                                                        <div class="wrapper-options">
                                                            <a class="open" href="%s" title="%s"
                                                                target="_blank">%s</a>
                                                            <a class="delete" href="javascript:void(0)" title="%s">%s</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>',
                                            $cv,
                                            basename( wp_get_attachment_url( $cv ) ),
                                            $cv,
                                            __( 'My CV Options', 'tried' ),
                                            wp_get_attachment_url( $cv ),
                                            __( 'Open', 'tried' ),
                                            __( 'Open', 'tried' ),
                                            __( 'Delete', 'tried' ),
                                            __( 'Delete', 'tried' )
                                        );
                                    }
                                } else {
                                    printf( '<h5 class="empty-cv">%s</h5>', __( 'Empty CV', 'tried' ) );
                                }
                            ?>
                        </div>
                        <p class="note-description">
                            <?php _e( 'You can upload up to 3 versions of your CV...', 'tried' ); ?></p>
                    </div>
                    <div class="info-action">
                        <?php
                            if ( count( $resumeCV ) < 3 ) {
                                printf(
                                    '<a href="%s" class="addnew_resume-action" title="%s">%s</a>',
                                    esc_url( add_query_arg( 'block', 'submit-resume', home_url( 'account' ) ) ),
                                    __( 'Add New', 'tried' ),
                                    __( 'Add New', 'tried' )
                                );
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile_detail-item">
            <h4 class="profiletitle"><?php _e( 'Personal Details', 'tried' ); ?></h4>
            <div class="section-wrapper <?php echo $isEditing == 'basic'?'editing':''; ?>">
                <div class="section-info">
                    <div class="info-item">
                        <h5><?php _e( 'Email Address', 'tried' ); ?></h5>
                        <span><?php echo $userEmail; ?></span>
                    </div>
                    <div class="info-item">
                        <h5><?php _e( 'Name', 'tried' ); ?></h5>
                        <span><?php echo $userFullname; ?></span>
                    </div>
                    <div class="info-item">
                        <h5><?php _e( 'Telephone', 'tried' ); ?></h5>
                        <span><?php echo $userPhone; ?></span>
                    </div>
                    <div class="info-action">
                        <button type="button" class="edit_profile-action"><?php _e( 'Edit', 'tried' ); ?></button>
                    </div>
                </div>
                <div class="section-update">
                    <form class="update_profile-form" method="post" action="">
                        <?php wp_nonce_field( 'tried-accountform', 'tried-accountform-nonce' ); ?>
                        <input type="hidden" name="profile_func" value="basic" />
                        <div class="message-field">
                            <?php
                                if ( !empty( $message_basic ) ) {
                                    printf( '<div class="message %s">%s</div>',
                                        $message_basic['notify'], $message_basic['content']
                                    );
                                }
                            ?>
                        </div>
                        <div class="col-field email">
                            <label><?php _e( 'Email', 'tried' ) ?></label>
                            <div class="wrap-fields">
                                <input type="text" name="email" id="user-email"
                                    value="<?php echo esc_attr( $userEmail ); ?>"
                                    placeholder="<?php _e( 'Enter email', 'tried' ); ?>">
                            </div>
                        </div>
                        <div class="col-field fullname">
                            <label><?php _e( 'Name', 'tried' ) ?></label>
                            <input type="text" name="fullname" id="user-fullname"
                                value="<?php echo esc_attr( $userFullname ); ?>"
                                placeholder="<?php _e( 'Enter fullname', 'tried' ); ?>">
                        </div>
                        <?php echo do_shortcode( '[tried_register_form_fields phone="'.$userPhone.'"]' ); ?>
                        <div class="col-field password">
                            <label><?php _e('Confirm password', 'tried'); ?></label>
                            <input type="password" name="password" id="user-password" value=""
                                placeholder="<?php _e( 'Enter pasword', 'tried' ); ?>">
                        </div>
                        <div class="col-field submit">
                            <input type="submit" value="<?php _e( 'Save Changes', 'tried' ); ?>" />
                            <input type="reset" class="edit_profile-action" value="<?php _e( 'Cancel', 'tried' ); ?>" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="profile_detail-item">
            <h4 class="profiletitle"><?php _e( 'Additional information', 'tried' ); ?></h4>
            <div class="section-wrapper <?php echo $isEditing == 'additional'?'editing':''; ?>">
                <div class="section-info">
                    <div class="info-item">
                        <h5><?php _e( 'Race/Ethnicity', 'tried' ); ?></h5>
                        <span><?php echo $resumeEthnicity; ?></span>
                    </div>
                    <div class="info-item">
                        <h5><?php _e( 'Protected Veteran Status', 'tried' ); ?></h5>
                        <span><?php echo $resumeVeteran; ?></span>
                    </div>
                    <div class="info-item">
                        <h5><?php _e( 'Section 503 Disability Status', 'tried' ); ?></h5>
                        <span><?php echo $resumeDisabilitie; ?></span>
                    </div>
                    <div class="info-action">
                        <button type="button" class="edit_profile-action"><?php _e( 'Edit', 'tried' ); ?></button>
                    </div>
                </div>
                <div class="section-update">
                    <form class="update_profile-form" method="post" action="">
                        <?php wp_nonce_field( 'tried-accountform', 'tried-accountform-nonce' ); ?>
                        <input type="hidden" name="profile_func" value="additional" />
                        <div class="message-field">
                            <?php
                                if ( !empty( $message_additional ) ) {
                                    printf( '<div class="message %s">%s</div>',
                                        $message_additional['notify'], $message_additional['content']
                                    );
                                }
                            ?>
                        </div>
                        <div class="col-field ethnicity">
                            <label><?php _e( 'Choose Ethnicity', 'tried' ) ?></label>
                            <select name="resume_ethnicity" id="resume-ethnicity">
                                <option value="" selected="selected">-- <?php _e( 'Select', 'tried' ); ?> --</option>
                                <?php
                                    if ( $ethnicities ) {
                                        foreach ( $ethnicities as $ethnicity ) {
                                            printf( '<option value="%s" %s>%s</option>', $ethnicity, selected( $ethnicity, $resumeEthnicity ), $ethnicity );
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-field veteran">
                            <label><?php _e( 'Protected Veteran Status', 'tried' ) ?></label>
                            <select name="resume_veteran" id="resume-veteran">
                                <option value="" selected="selected">-- <?php _e( 'Select', 'tried' ); ?> --</option>
                                <?php
                                    if ( $veterans ) {
                                        foreach ( $veterans as $veteran ) {
                                            printf( '<option value="%s" %s>%s</option>', $veteran, selected( $veteran, $resumeVeteran ), $veteran );
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-field disability">
                            <label><?php _e( 'Section 503 Disability Status', 'tried' ) ?></label>
                            <select name="resume_disabilitie" id="resume-disabilitie">
                                <option value="" selected="selected">-- <?php _e( 'Select', 'tried' ); ?> --</option>
                                <?php
                                    if ( $disabilities ) {
                                        foreach ( $disabilities as $disabilitie ) {
                                            printf( '<option value="%s" %s>%s</option>', $disabilitie, selected( $disabilitie, $resumeDisabilitie ), $disabilitie );
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-field submit">
                            <input type="submit" value="<?php _e( 'Save Changes', 'tried' ); ?>" />
                            <input type="reset" class="edit_profile-action" value="<?php _e( 'Cancel', 'tried' ); ?>" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>