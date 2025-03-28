<?php
/**
 * Simple_Job_Board_Typography Class
 * 
 * Load user defined styles on front-end.
 *
 * @link        https://wordpress.org/plugins/simple-job-board
 * @since       2.2.3
 * @since       2.4.0   Revised the Color Options with new HTML Design
 * @since       2.4.3   Added fonts enabling/disabling feature according to user defined settings.
 * 
 * @package     Simple_Job_Board
 * @subpackage  Simple_Job_Board/public
 * @author      PressTigers <support@presstigers.com> 
 */
class Simple_Job_Board_Typography {

    /**
     * Initialize the class and set its properties.
     *
     * @since   2.2.3
     */
    public function __construct() {

        // Hook -> Load user Defined Styles        
        add_action('wp_head', array($this, 'job_board_typography'));
    }

    /**
     * Load user defined styles. 
     * 
     * This function includes the user defined styles ( under Job Board> Settings> Appearance Tab )in head section of job listing and detail page.
     * 
     * @since    2.2.3
     * @since    2.9.5  Added !important for button background and text color.
     */
    public function job_board_typography() {

        // Load Inline Styles Only for SJB Pages        

            global $post;
            if (get_option('job_board_typography')) {
                $job_board_typography = get_option('job_board_typography');
            }
            
            // Job Listing Page Typography
            $filters_bg_color = isset($job_board_typography['filters_background_color']) ? esc_attr($job_board_typography['filters_background_color']) : '#f2f2f2';
            $job_title_color = isset($job_board_typography['job_listing_title_color']) ? esc_attr($job_board_typography['job_listing_title_color']) : '#3b3a3c';
            $heading_color = isset($job_board_typography['headings_color']) ? esc_attr($job_board_typography['headings_color']) : '#3297fa';
            $fontawesome_icon_color = isset($job_board_typography['fontawesome_icon_color']) ? esc_attr($job_board_typography['fontawesome_icon_color']) : '#3b3a3c';
            $fontawesome_text_color = isset($job_board_typography['fontawesome_text_color']) ? esc_attr($job_board_typography['fontawesome_text_color']) : '#3297fa';
            $btn_bg_color = isset($job_board_typography['job_submit_button_background_color']) ? esc_attr($job_board_typography['job_submit_button_background_color']) : '#3297fa';
            $btn_color = isset($job_board_typography['job_submit_button_text_color']) ? esc_attr($job_board_typography['job_submit_button_text_color']) : '#fff';
            $pagination_text_color = isset($job_board_typography['pagination_text_color']) ? esc_attr($job_board_typography['pagination_text_color']) : '#fff';
            $pagination_bg_color = isset($job_board_typography['pagination_background_color']) ? esc_attr($job_board_typography['pagination_background_color']) : '#3297fa';
            $enable_fonts = get_option( 'sjb_fonts' )  ? get_option('sjb_fonts') : 'enable-fonts';
            ?>

            <style type="text/css">
                
            /* SJB Fonts */
            <?php if ( 'enable-fonts' === $enable_fonts ) { ?>
                    .sjb-page {
                        font-family: "Roboto", sans-serif;
                    }
            <?php } ?>

                /* Job Filters Background Color */
                .sjb-page .sjb-filters
                {
                    background-color: <?php echo esc_attr( $filters_bg_color ); ?>;
                }
                                                    
                /* Listing & Detail Page Title Color */
                .sjb-page .list-data .v1 .job-info h4 a , 
                .sjb-page .list-data .v2 .job-info h4 a              
                {
                    color: <?php echo esc_attr( $job_title_color ); ?>;
                }                
                                                    
                /* Job Detail Page Headings */
                .sjb-page .sjb-detail .list-data .v1 h3,
                .sjb-page .sjb-detail .list-data .v2 h3,
                .sjb-page .sjb-detail .list-data ul li::before,
                .sjb-page .sjb-detail .list-data .v1 .job-detail h3,
                .sjb-page .sjb-detail .list-data .v2 .job-detail h3,
                .sjb-page .sjb-archive-page .job-title,
                .sjb-page .job-features h3
                {
                    color: <?php echo esc_attr( $heading_color ); ?>; 
                }
                                                    
                /* Fontawesome Icon Color */
                .sjb-page .list-data .v1 .job-type i,
                .sjb-page .list-data .v1 .job-location i,
                .sjb-page .list-data .v1 .job-date i,
                .sjb-page .list-data .v2 .job-type i,
                .sjb-page .list-data .v2 .job-location i,
                .sjb-page .list-data .v2 .job-date i,
                .sjb-page .sjb-detail .list-data .v2 .job-features .sjb-title-value h4 i,
                .sjb-listing .list-data .v2 .job-features .sjb-title-value h4 i
                {
                    color: <?php echo esc_attr( $fontawesome_icon_color ); ?>;
                }

                /* Fontawesome Text Color */
                .sjb-page .list-data .v1 .job-type,
                .sjb-page .list-data .v1 .job-location,
                .sjb-page .list-data .v1 .job-date,
                .sjb-page .list-data .v2 .job-type,
                .sjb-page .list-data .v2 .job-location,
                .sjb-page .list-data .v2 .job-date
                {
                    color: <?php echo esc_attr( $fontawesome_text_color ); ?>;
                }
                                                    
                /* Job Filters-> All Buttons Background Color */
                .sjb-page .btn-primary,
                .sjb-page .btn-primary:hover,
                .sjb-page .btn-primary:active:hover,
                .sjb-page .btn-primary:active:focus,
                .sjb-page .sjb-detail .jobpost-form .file div,                
                .sjb-page .sjb-detail .jobpost-form .file:hover div
                {
                    background-color: <?php echo esc_attr( $btn_bg_color ); ?> !important;
                    color: <?php echo esc_attr( $btn_color ); ?> !important;
                }
                
                .sjb-page .sjb-listing a.sjb_view_more_btn,
                .sjb-page .sjb-listing a.sjb_view_less_btn
                {
                    
                    color: <?php echo esc_attr( $btn_bg_color ); ?> !important;
                }

                /* Pagination Text Color */
                /* Pagination Background Color */                
                .sjb-page .pagination li.list-item span.current,
                .sjb-page .pagination li.list-item a:hover, 
                .sjb-page .pagination li.list-item span.current:hover
                {
                    background: <?php echo esc_attr( $pagination_bg_color ); ?>;
                    border-color: <?php echo esc_attr( $pagination_bg_color ); ?>;                    
                    color: <?php echo esc_attr( $pagination_text_color ); ?>;
                }
                                                    
            </style>        
            <?php
    }
}

new Simple_Job_Board_Typography();