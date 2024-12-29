<?php 
/* Template Name: Submit resume */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-account_submit_resume-block' );
wp_enqueue_script( 'tried-job_apply' );

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

/** Additional info */
$resumeEthnicity = !empty( get_the_author_meta( 'resume_ethnicity', $current_user->ID ) ) ? get_the_author_meta( 'resume_ethnicity', $current_user->ID ) : '-';
$resumeVeteran = !empty( get_the_author_meta( 'resume_veteran', $current_user->ID ) ) ? get_the_author_meta( 'resume_veteran', $current_user->ID ) : '-';
$resumeDisabilitie = !empty( get_the_author_meta( 'resume_disabilitie', $current_user->ID ) ) ? get_the_author_meta( 'resume_disabilitie',$current_user->ID ) : '-';

$message = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = process_update_resume_info_form( $current_user->ID, $_POST );
    if ( $message['parameters'] ) {
        $resumeEthnicity = $message['parameters']['resume_ethnicity'];
        $resumeVeteran = $message['parameters']['resume_veteran'];
        $resumeDisabilitie = $message['parameters']['resume_disabilitie'];
    }
}
?>
<?php get_header(); ?>
<div id="submitresume_account-block">
    <form id="submit_resume" class="submit_resume-form" action="" method="post" enctype="multipart/form-data">
        <?php wp_nonce_field( 'tried-jobpostform', 'tried-jobpostform-nonce' ); ?>
        <input type="hidden" name="resume_uploadfile" value="true" />
        <div class="message-field">
            <?php
                if ( !empty( $message ) ) {
                    printf( '<div class="message %s">%s</div>',
                        $message['notify'], $message['content']
                    );
                }
            ?>
        </div>
        <?php if ( false ) { ?>
        <div class="form-field">
            <label for="submit_resume-ethnicity"><?php _e( 'Choose Ethnicity', 'tried' ); ?></label>
            <select name="resume_ethnicity" id="submit_resume-ethnicity" required>
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
        <div class="form-field">
            <label for="submit_resume-veteran"><?php _e( 'Protected Veteran Status', 'tried' ); ?></label>
            <select name="resume_veteran" id="submit_resume-veteran" required>
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
        <div class="form-field">
            <label for="submit_resume-disabilitie"><?php _e( 'Section 503 Disability Status', 'tried' ); ?></label>
            <select name="resume_disabilitie" id="submit_resume-disabilitie" required>
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
        <?php } ?>
        <div class="form-field upload-file">
            <label><?php _e( 'Upload File', 'tried' ); ?></label>
            <div class="uploadfile-list">
                <div class="files-choosed"></div>
                <a href="javascript:void(0)"
                    title="<?php _e( 'Upload File', 'tried' ); ?>"><?php _e( 'Upload File', 'tried' ); ?></a>
                <div class="uploadfile-wrapper" style="display: none;">
                    <label for="submit_resume-uploadfile"><?php _e( 'Upload File', 'tried' ); ?></label>
                    <input type="file" accept=".<?php echo join( ',.', array( 'pdf', 'doc', 'docx') ); ?>"
                        id="submit_resume-uploadfile" style="display:none;" name="resume_cv">
                </div>
            </div>
        </div>
        <div class="form-submit">
            <button type="submit"><?php _e( 'Submit', 'tried' ); ?></button>
        </div>
    </form>
</div>