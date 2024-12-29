<?php
if (! defined('ABSPATH')) {
    exit;
}

if (!class_exists('Custom_Email_Template', false)) {
    class Custom_Email_Template
    {
        public function __construct()
        {
            // apply_job Subject
            add_filter('sjb_admin_notification_sbj', [$this, 'sjb_admin_notification_sbj'], 50, 3);

            // apply_job Start body
            add_filter('sjb_email_start_template', [$this, 'sjb_email_start_template'], 50, 3);

            // apply_job Body admin
            add_filter('sjb_admin_email_template', [$this, 'sjb_admin_email_template'], 50, 3);
        }

        function sjb_admin_notification_sbj($text, $job_title, $post_id)
        {
            return sprintf(esc_html__('New Job Application Submitted for %s ', 'simple-job-board'), html_entity_decode($job_title));
        }

        function sjb_email_start_template($message, $notification_receiver, $post_id)
        {
            // Applied Job Title
            $job_title = get_the_title($post_id);

            $header_title = ('applicant' != $notification_receiver) ? esc_html__('New Job Application Submitted for ' . $job_title, 'simple-job-board') : esc_html__('Job Application Acknowledgement', 'simple-job-board');
            $message = '<div style="width:700px; margin:0 auto;  border: 1px solid #95B3D7;font-family:Arial; word-wrap: break-word;">'
                . '<div style="border: 1px solid #95B3D7; background-color:#95B3D7; word-wrap: break-word;">'
                . ' <h2 style="text-align:center; word-wrap: break-word;">' . $header_title . '</h2>'
                . ' </div>'
                . '<div  style="margin:10px; word-wrap: break-word;">'
                . '<p>';

            return $message;
        }

        function sjb_admin_email_template($message, $post_id, $notification_receiver)
        {
            // Job URL         
            $job_id = get_post_parent($post_id);
            $job_url = get_permalink($job_id);

            // Applied Job Title
            $job_title = get_the_title($post_id);

            // Applicant Name       
            $applicant_name = Simple_Job_Board_Notifications::applicant_details('name', $post_id);
            $applicant_email = Simple_Job_Board_Notifications::applicant_details('email', $post_id);
            // Date
            $date_format = (get_option('sjb_date_format')) ? (get_option('sjb_date_format')) : 'd/m/Y';

            $admin = esc_html__('Admin', 'simple-job-board');
            $message = sprintf(esc_html__('Hello %s', 'simple-job-board'), $admin) . ',</p>';
            $message .= '<p>' . esc_html__('A new application has been submitted on the Healthcare Talent website.', 'simple-job-board');

            $message = apply_filters('sjb_applicant_details_notification', $message, $post_id, $notification_receiver);

            $message .= '<p>' . __('Candidate Details:', 'simple-job-board') . '</p>';
            $message .= '<ul>';
            $message .= '<li>Name: ' . $applicant_name . '</li>';
            $message .= '<li>Email: ' . $applicant_email . '</li>';
            $message .= '<li>Position Applied For: <a href="' . esc_url($job_url) . '">' . wp_kses_post($job_title)  . '</a></li>';
            $message .= '<li>Application Date: ' . date($date_format) . '</li>';
            $message .= '</ul>';

            $message .= '<b>' . __('Next Steps:', 'simple-job-board') . '</b><br>';
            $message .= '<p>' . __('Please review the candidate\'s application and follow up as necessary. You can access the full application details through the admin portal or contact the candidate directly at their provided email address.', 'simple-job-board') . '</p>';

            $message .= '<p>' . __('Best regards,', 'simple-job-board') . '</p>';
            $message .= '<p>' . __('Healthcare Talent Website System', 'simple-job-board') . '</p>';
            $message .= '<a href="' . get_site_url() . '">' . get_site_url() . '</a>';

            return $message;
        }
    }

    new Custom_Email_Template();
}
