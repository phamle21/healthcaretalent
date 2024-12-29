<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-jobpost-single' );
wp_enqueue_style( 'tried-jobpost_apply-single' );
wp_enqueue_script( 'tried-job_apply' );

$htmlJobCategory = array();
$jobpostCategory = get_the_terms( get_the_ID(), 'jobpost_category' );
if ( $jobpostCategory ) {
    foreach ( $jobpostCategory as $jCategory ) {
        array_push( $htmlJobCategory, $jCategory->name );
    }
}

$htmlJobSector = array();
$jobpostSector = get_the_terms( get_the_ID(), 'jobpost_job_type' );
if ( $jobpostSector ) {
    foreach ( $jobpostSector as $jSector ) {
        array_push( $htmlJobSector, $jSector->name );
    }
}

$htmlJobLocation = array();
$jobpostLocation = get_the_terms( get_the_ID(), 'jobpost_location' );
if ( $jobpostLocation ) {
    foreach ( $jobpostLocation as $jLocation ) {
        array_push( $htmlJobLocation, $jLocation->name );
    }
}

$htmlJobSalary = '';
$level = get_post_meta( $post->ID, 'level', true );
$max_salary = get_post_meta( $post->ID, 'max_salary', true );
$job_currency = get_post_meta( $post->ID, 'job_currency', true );
$currencies = array(
    'vnd' => 'VNĐ',
    'dolla' => 'Dolla'
);
$job_unit = get_post_meta( $post->ID, 'job_unit', true );
$units = array(
    'year' => __( 'Year', 'tried' ),
    'month' => __( 'Month', 'tried' ),
    'week' => __( 'Week', 'tried' ),
    'day' => __( 'Day', 'tried' ),
    'hour' => __( 'Hour', 'tried' )
);
if ( !empty( $level ) ) {
    $htmlJobSalary = $level.$currencies[$job_currency];
    if ( !empty( $max_salary ) ) {
        $htmlJobSalary .= ' - '.$max_salary.$currencies[$job_currency];
    }
    if ( !empty( $job_unit ) ) {
        $htmlJobSalary .= ' per '.$units[$job_unit];
    }
}

?>
<main <?php post_class( 'site-main' ); ?>>
    <div class="main-contain jobpost" role="apply_job">
        <div class="banner-joblist">
            <div class="wrapper">
                <h3 class="title"><?php wp_title( false ); ?></h3>
                <ul class="meta">
                    <li class="location" <?php echo !$htmlJobLocation?'style="display: none;"':''; ?>>
                        <?php echo join( ', ', $htmlJobLocation ); ?>
                    </li>
                    <li class="sector" <?php echo !$htmlJobSector?'style="display: none;"':''; ?>>
                        <?php echo join( ', ', $htmlJobSector ); ?>
                    </li>
                    <li class="salary" <?php echo !$htmlJobSalary?'style="display: none;"':''; ?>>
                        <?php echo $htmlJobSalary; ?>
                    </li>
                </ul>
            </div>
        </div>
        <?php if ( !is_user_logged_in() ) { ?>
        <div class="wrapper" style="background-color: #d2e0e9; max-width: 100%; padding: 90px 0; min-height: 75vh;">
            <div id="jobapply_info">
                <div class="jobapply_info-item active" role="apply_root">
                    <div class="info-body">
                        <?php
                            global $wp;
                            $shortcodeForm = '[tried_login_form redirect_to="'.home_url( $wp->request.'?apply_job='.$post->ID ).'"]';
                            printf( '<div class="form-login_register" style="background-color: #fff; max-width: 440px; margin: 0 auto; border-radius: 8px; box-shadow: 0px 20px 24px -5px #1213160a, 0px 8px 8px -6px #1213160a; padding: 30px 20px;">%s</div>', do_shortcode( $shortcodeForm ) );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="wrapper">
            <div id="jobapply_info">
                <div class="jobapply_info-item active" role="apply_root">
                    <div class="info-head">
                        <h4><?php _e( 'How would you like to apply?', 'tried' ); ?></h4>
                    </div>
                    <div class="info-body">
                        <div class="jobapply_info-toggles">
                            <input type="radio" id="jobapply_info_toggle-resume" name="jobapply_info_toggle"
                                value="apply_resume" style="display: none;" checked>
                            <label for="jobapply_info_toggle-resume"><?php _e( 'Apply with your resume', 'tried' ); ?><i
                                    class="fas fa-upload"></i></label>
                            <input type="radio" id="jobapply_info_toggle-linkedin" name="jobapply_info_toggle"
                                value="apply_linkedin" style="display: none;">
                            <label for="jobapply_info_toggle-linkedin"
                                style="display: none;"><?php _e( 'Apply with LinkedIn', 'tried' ); ?><i
                                    class="fab fa-linkedin"></i></label>
                        </div>
                        <button type="button" class="jobapply_info-action next"><?php _e( 'Next', 'tried' ); ?></button>
                    </div>
                </div>
                <div class="jobapply_info-item" role="apply_resume">
                    <div class="info-head">
                        <a class="jobapply_info-action back" href="javascript:void(0)"
                            title="<?php _e( 'Back', 'tried' ); ?>"><?php _e( 'Back', 'tried' ); ?></a>
                        <h4><?php echo apply_filters('sjb_job_application_form_title', esc_html__('Apply with your resume', 'simple-job-board')); ?>
                        </h4>
                    </div>
                    <div class="info-body">
                        <?php
                            do_action('sjb_enqueue_scripts');
                            do_action('sjb_single_job_content_start');
                            echo '<div id="jobpost_form_status"></div>';
                            do_action('sjb_job_application_before');
                        ?>
                        <form class="jobpost-form" id="sjb-application-form" name="c-assignments-form"
                            enctype="multipart/form-data">
                            <?php
                                do_action('sjb_job_application_form_fields_start');

                                echo '<div class="field-item"><p class="form-note">'.__( 'Please complete the below form and attach a resume to apply', 'tried' ).'</p></div>';

                                $allowed_tags = sjb_get_allowed_html_tags();
                                $keys = get_post_custom_keys(get_the_ID());
                                $section_no = 1;
                                $total_sections = 0;

        // Get total sections
        if (NULL != $keys) {
            foreach ($keys as $key):
                if (substr($key, 0, 7) == 'jobapp_'):
                    $val = get_post_meta(get_the_ID(), $key, TRUE);
                    $val = maybe_unserialize($val);
                    if ( isset( $val['type'] ) && 'section_heading' == $val['type'] ) {
                        $total_sections++;
                    }
                endif;
            endforeach;
        }

        if (NULL != $keys):
            foreach ($keys as $key):
                if (substr($key, 0, 7) == 'jobapp_'):
                    $val = get_post_meta(get_the_ID(), $key, TRUE);
                    $val = maybe_unserialize($val);
                    $is_required = isset($val['optional']) ? "checked" === $val['optional'] ? 'required="required"' : "" : 'required="required"';
                    $required_class = isset($val['optional']) ? "checked" === $val['optional'] ? "sjb-required" : "sjb-not-required" : "sjb-required";
                    $required_field_asterisk = isset($val['optional']) ? "checked" === $val['optional'] ? '<span class="required">*</span>' : "" : '<span id="sjb-required">*</span>';
                    $id = preg_replace('/[^\p{L}\p{N}\_]/u', '_', $key);
                    $name = preg_replace('/[^\p{L}\p{N}\_]/u', '_', $key);
                    $label = isset($val['label']) ? $val['label'] : ucwords(str_replace('_', ' ', substr($key, 7)));

                    // Field Type Meta
                    $field_type_meta = array(
                        'id' => $id,
                        'name' => $name,
                        'label' => $label,
                        'type' => isset($val['type'])?$val['type']:'text',
                        'is_required' => $is_required,
                        'required_class' => $required_class,
                        'required_field_asterisk' => $required_field_asterisk,
                        'options' => isset($val['options'])?$val['options']:'',
                    );

                    do_action('sjb_job_application_form_fields', $field_type_meta);

                    if ( isset( $val['type'] ) ) {
                        switch ($val['type']) {
                            case 'section_heading':
                                if (1 < $section_no) {
                                    echo '</div>';
                                }
                                echo '<div class="form-box">'
                                . '<h3>' . esc_attr($label) . '</h3>';
                                $section_no++;
                                break;
                            case 'text':
                                echo '<div class="field-item">'
                                . '<label for="' . esc_attr($key) . '">' . esc_attr($label) . wp_kses($required_field_asterisk, $allowed_tags) . '</label>'
                                . '<div class="form-group">'
                                . '<input type="text" name="' . esc_attr($name) . '" class="form-control ' . esc_attr($required_class) . '" id="' . esc_attr($id) . '" ' . esc_attr($is_required) . '>'
                                . '</div>'
                                . '</div>';
                                break;
                            case 'text_area':
                                echo '<div class="field-item">'
                                . '<label for="' . esc_attr($key) . '">' . esc_attr($label) . wp_kses($required_field_asterisk, $allowed_tags) . '</label>'
                                . '<div class="form-group">'
                                . '<textarea name="' . esc_attr($name) . '" class="form-control ' . esc_attr($required_class) . '" id="' . esc_attr($id) . '" ' . esc_attr($is_required) . '  cols="30" rows="5"></textarea>'
                                . '</div>'
                                . '</div>';
                                break;
                            case 'email':
                                echo '<div class="field-item">'
                                . '<label for="' . esc_attr($key) . '">' . esc_attr($label) . wp_kses($required_field_asterisk, $allowed_tags) . '</label>'
                                . '<div class="form-group">'
                                . '<input type="email" name="' . esc_attr($name) . '" class="form-control sjb-email-address ' . esc_attr($required_class) . '" id="' . esc_attr($id) . '" ' . esc_attr($is_required) . '><span class="sjb-invalid-email validity-note">' . esc_html__('A valid email address is required.', 'simple-job-board') . '</span>'
                                . '</div>'
                                . '</div>';
                                break;
                            case 'phone':
                                echo '<div class="field-item">'
                                . '<label for="' . esc_attr($key) . '">' . esc_attr($label) . wp_kses($required_field_asterisk, $allowed_tags) . '</label>'
                                . '<div class="form-group">'
                                . '<input type="tel" name="' . esc_attr($name) . '" class="form-control sjb-phone-number sjb-numbers-only ' . esc_attr($required_class) . '" id="' . esc_attr($id) . '" ' . esc_attr($is_required) . '>'
                                . '<p class="form-note">'.__( 'Please include your country and area code', 'tried' ).'</p>'
                                . '<span class="sjb-invalid-phone validity-note" id="' . esc_attr($id) . '-invalid-phone">' . esc_html__('A valid phone number is required.', 'simple-job-board') . ' </span>'
                                . '</div>'
                                . '</div>';
                                break;
                            case 'date':
                                echo '<div class="field-item">'
                                . '<label for="' . esc_attr($key) . '">' . esc_attr($label) . wp_kses($required_field_asterisk, $allowed_tags) . '</label>'
                                . '<div class="form-group">'
                                . '<input type="text" name="' . esc_attr($name) . '" class="form-control sjb-datepicker ' . esc_attr($required_class) . '" id="' . esc_attr($id) . '" ' . esc_attr($is_required) . ' maxlength="10">'
                                . '</div>'
                                . '</div>';
                                break;
                            case 'radio':
                                if ($val['options'] != '') {
                                    echo '<div class="field-item">'
                                    . '<label class="sjb-label-control" for="' . esc_attr($key) . '">' . esc_attr($label) . wp_kses($required_field_asterisk, $allowed_tags) . '</label>'
                                    . '<div class="form-group">';
                                    $options = explode(',', $val['options']);
                                    $i = 0;
                                    foreach ($options as $option) {
                                        echo '<label class="small"><input type="radio" name="' . esc_attr($name) . '" class=" ' . esc_attr($required_class) . '" id="' . esc_attr($id) . '" value="' . esc_attr($option) . '"  ' . sjb_is_checked($i) . ' ' . esc_attr($is_required) . '>' . esc_attr($option) . ' </label> ';
                                        $i++;
                                    }
                                    echo '</div></div>';
                                }
                                break;
                            case 'dropdown':
                                if ($val['options'] != '') {
                                    echo '<div class="field-item">'
                                    . '<label for="' . esc_attr($key) . '">' . esc_attr($label) . wp_kses($required_field_asterisk, $allowed_tags) . '</label>'
                                    . '<div class="form-group">'
                                    . '<select class="form-control" name="' . esc_attr($name) . '" id="' . esc_attr($id) . '" ' . esc_attr($is_required) . '>';
                                    $options = explode(',', $val['options']);
                                    foreach ($options as $option) {
                                        echo '<option class="' . esc_attr($required_class) . '" value="' . esc_attr($option) . '" >' . esc_attr($option) . ' </option>';
                                    }
                                    echo '</select>'
                                    . '</div>'
                                    . '</div>';
                                }
                                break;
                            case 'checkbox' :
                                if ($val['options'] != '') {
                                    echo '<div class="field-item">'
                                    . '<label for="' . esc_attr($key) . '">' . esc_attr($label) . wp_kses($required_field_asterisk, $allowed_tags) . '</label>'
                                    . '<div class="form-group">';
                                    $options = explode(',', $val['options']);
                                    $i = 0;

                                    foreach ($options as $option) {
                                        echo '<label class="small"><input type="checkbox" name="' . esc_attr($name) . '[]" class="' . esc_attr($required_class) . '" id="' . esc_attr($id) . '" value="' . esc_attr($option) . '"  ' . esc_attr($i) . ' ' . esc_attr($is_required) . '>' . esc_attr($option) . ' </label>';
                                        $i++;
                                    }
                                    echo '</div></div>';
                                }
                                break;
                        }
                    }
                endif;
            endforeach;
            if ($total_sections > 0 && $total_sections + 1 == $section_no) {
                echo '</div>';
            }
        endif;

        if (0 < $total_sections) {
            echo '<div class="form-box">';
        }

        $sjb_attach_resume = '<div class="field-item">'
                . '<label for="applicant_resume">' . apply_filters('sjb_resume_label', __('Upload CV', 'simple-job-board')) . '<span class="sjb-required required">*</span></label>'
                . '<div class="form-group">'
                . '<input type="file" name="applicant_resume" id="applicant-resume" class="sjb-attachment" accept=".pdf,.doc.docx,.odt,.rtf,.txt" form-control "' . apply_filters('sjb_resume_required', 'required="required"') . '>'
                . '<p class="form-note">'.__( 'File types accepted: TXT,PDF or Word Doc', 'tried' ).'</p>'
                . '<span class="sjb-invalid-attachment validity-note" id="file-error-message"></span>'
                . '</div>'
                . '</div>';
        echo apply_filters('sjb_attach_resume', $sjb_attach_resume);

        if (0 < $total_sections) {
            echo '</div>';
        }

        $sjb_gdpr_settings = get_option('job_board_privacy_settings');

        $privacy_policy_label = get_option('job_board_privacy_policy_label', '');
        $privacy_policy_content = get_option('job_board_privacy_policy_content', '');
        $term_conditions_label = get_option('job_board_term_conditions_label', '');
        $term_conditions_content = get_option('job_board_term_conditions_content', '');

        if ('yes' == $sjb_gdpr_settings) {
            ?>
                            <?php
            if ($privacy_policy_content) {
                if (0 < $total_sections) {
                    ?>
                            <div class="form-box">
                                <?php } ?>
                                <div class="field-item">
                                    <?php if ($privacy_policy_label) { ?>
                                    <div class="col-md-3 col-xs-12">
                                        <label for="jobapp_pp"
                                            class="sjb-privacy-policy-label"><?php printf(__("%s", 'simple-job-board'), esc_attr($privacy_policy_label)); ?></label>
                                    </div>
                                    <div class="col-md-9 col-xs-12">
                                        <div id="jobapp-pp">
                                            <p class="sjb-privacy-policy">
                                                <?php printf(__("%s", 'simple-job-board'), wp_kses_post(stripslashes_deep(trim($privacy_policy_content)))); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <div id="jobapp-pp">
                                        <p class="sjb-privacy-policy">
                                            <?php printf(__("%s", 'simple-job-board'), wp_kses_post(stripslashes_deep(trim($privacy_policy_content)))); ?>
                                        </p>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php if (0 < $total_sections) { ?>
                            </div>
                            <?php
                }
            }
            if ($term_conditions_content) {
                if (0 < $total_sections) {
                    ?>
                            <div class="form-box">
                                <?php } ?>
                                <div class="field-item">
                                    <?php if ($term_conditions_label) { ?>
                                    <label
                                        for="jobapp_tc"><?php printf(__("%s", 'simple-job-board'), esc_attr($term_conditions_label)); ?></label>
                                    <div id="jobapp-tc">
                                        <label class="small">
                                            <input type="checkbox" class="sjb-required" name="jobapp_tc" id="jobapp-tc"
                                                value="<?php echo wp_kses_post(stripslashes_deep(trim(htmlspecialchars($term_conditions_content)))); ?>"
                                                required="required">
                                            <?php printf( __("%s", 'simple-job-board'), wp_kses_post(stripslashes_deep(trim($term_conditions_content)))); ?>
                                            <span class="required">*</span>
                                        </label>
                                    </div>
                                    <?php } else { ?>
                                    <div id="jobapp-tc">
                                        <label class="small">
                                            <input type="checkbox" class="sjb-required" name="jobapp_tc" id="jobapp-tc"
                                                value="<?php echo wp_kses_post(stripslashes_deep(trim(htmlspecialchars($term_conditions_content)))); ?>"
                                                required="required">
                                            <?php printf(__("%s", 'simple-job-board'), wp_kses_post(stripslashes_deep(trim($term_conditions_content)))); ?>
                                            <span class="required">*</span>
                                        </label>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php
                                    if (0 < $total_sections) {
                                        echo '</div>';
                                    }
            }
        }

        do_action('sjb_job_application_form_fields_end');
        ?>
                                <input type="hidden" name="job_id" value="<?php the_ID(); ?>">
                                <input type="hidden" name="action" value="process_applicant_form">
                                <input type="hidden" name="wp_nonce"
                                    value="<?php echo wp_create_nonce('jobpost_security_nonce') ?>">
                                <?php if (0 === $total_sections) { ?>
                                <?php } ?>

                                <div class="field-item" id="sjb-form-padding-button">
                                    <?php
                                            do_action('sjb_job_application_form_submit_btn_start');
                                            echo '<button class="btn btn-primary app-submit">'.__('Apply Now', 'simple-job-board').'</button>';
                                            do_action('sjb_job_application_form_submit_btn_end');
                                        ?>
                                    <?php
                                if (0 === $total_sections) {
                                    echo '</div>';
                                }
                                get_simple_job_board_template('single-jobpost/loader.php');
                            ?>
                        </form>
                        <?php
                            do_action('sjb_job_application_end');
                            do_action('sjb_job_application_after');
                            do_action('sjb_single_job_content_end');
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</main>