<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('Tried_Theme', false )) {
	class Tried_Theme {
        public $includes = array(
            '/includes/function-jobpost.php',
            '/includes/function-core.php',
            '/includes/function-shortcode.php',
            '/includes/function-ajax.php',
            '/includes/function-woocommerce.php',
            '/includes/function-account.php',
            '/includes/function-helper.php',
            '/includes/class-tried-posttype.php',
            '/includes/class-tried-backend.php',
            '/includes/class-tried-apis.php',
            '/includes/class-tried-user.php',
            '/includes/W_Deferred.php',
            '/includes/class-custom-email-template.php',
        );

        public $databases = array(
            // array(
            //     'path' => '/includes/databases/class-prodattribute-category.php',
            //     'class' => 'Tried_DB__ProdAttributeCategory'
            // )
        );

		function __construct() {
            $this->load_databases();
            $this->load_includes();
            $this->load_hooks();
		}
        
        function load_databases() {
            if ( !empty( $this->databases ) ) {
                foreach ( $this->databases as $database ) {
                    if ( !class_exists( $database['class'] ) ) {
                        include_once get_template_directory() . $database['path'];
                    }
                }
            }
        }

        function load_hooks() {
            add_action( 'wp_enqueue_scripts', array($this, 'tried_frontend_enqueue_scripts') );

            add_action( 'admin_enqueue_scripts', array( $this, 'tried_global_enqueue_scripts' ), 10 );
            add_action( 'wp_enqueue_scripts', array($this, 'tried_global_enqueue_scripts' ), 10 );

            add_action( 'after_setup_theme', array($this, 'tried_theme_theme_setup') );

            add_action( 'wp_head', array($this, 'tried_wp_head') );
            // add_action( 'wp_footer', array($this, 'tried_wp_footer') );

            add_filter( 'show_admin_bar', '__return_false' );
            add_filter( 'use_widgets_block_editor', '__return_false' );
            add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
            add_filter( 'use_block_editor_for_post_type', '__return_false' );
            
            add_action( 'customize_register', array($this, 'tried_theme_customizer_setting') );
        }

        function load_includes() {
            if (!empty($this->includes)) {
                foreach ($this->includes as $include) {
                    include_once get_template_directory() . $include;
                }
            }
        }

        function tried_global_enqueue_scripts() {
            // libs
            wp_enqueue_style( "select2-min", get_theme_file_uri( "/assets/lib/select2/select2.min.css" ), [], true );
            wp_enqueue_script( "select2-min", get_theme_file_uri( "/assets/lib/select2/select2.min.js" ), array(), false, false );
            
            // wp_enqueue_script( "isotope-min", get_theme_file_uri( "/assets/lib/isotope/isotope.min.js" ), array(), false, false );

            // wp_enqueue_style( "lightboxed", get_theme_file_uri( "/assets/lib/lightboxed/lightboxed.css" ), [], false );
            // wp_enqueue_script( "lightboxed", get_theme_file_uri( "/assets/lib/lightboxed/lightboxed.js" ), array(), false, false );

            wp_register_style( 'trumbowyg', get_theme_file_uri( "/assets/lib/trumbowyg-editor/trumbowyg.min.css" ), '', "1.0.0" );
            wp_register_script( 'trumbowyg', get_theme_file_uri( "/assets/lib/trumbowyg-editor/trumbowyg.min.js" ), null, "1.0.0", false );
            wp_register_style( 'trumbowyg-color', get_theme_file_uri( "/assets/lib/trumbowyg-editor/trumbowyg-color.min.css" ), '', "1.0.0" );
            wp_register_script( 'trumbowyg-color', get_theme_file_uri( "/assets/lib/trumbowyg-editor/trumbowyg-color.min.js" ), null, "1.0.0", false );
            wp_register_style( 'trumbowyg-table', get_theme_file_uri( "/assets/lib/trumbowyg-editor/trumbowyg-table.min.css" ), '', "1.0.0" );
            wp_register_script( 'trumbowyg-table', get_theme_file_uri( "/assets/lib/trumbowyg-editor/trumbowyg-table.min.js" ), null, "1.0.0", false );

            wp_register_style( 'richtext', get_theme_file_uri( "/assets/lib/richtext-editor/richtext.min.css" ), '', "1.0.0" );
            wp_register_script( 'richtext', get_theme_file_uri( "/assets/lib/richtext-editor/richtext.min.js" ), null, "1.0.0", false );

            wp_register_style( 'font-awesome-4.7.0', get_theme_file_uri( "/assets/lib/font-awesome/4.7.0/css/fontawesome.min.css" ), '', '4.7.0' );

            wp_register_script( 'jquery-print', get_theme_file_uri( "/assets/lib/jquery-print/print.min.js" ), null, "1.0.0", false );


            wp_register_style( 'tried-modal', get_theme_file_uri( "/assets/css/style-modal.css" ), '', '1.0.0' );
        }

        function tried_frontend_enqueue_scripts() {
            global $template;
            // jquery
            wp_enqueue_script( 'jquery-min', get_theme_file_uri( "/assets/lib/jquery/jquery.min.js" ), null, '3.5.1', false );
            
            // basic
            wp_enqueue_style( 'tried', get_template_directory_uri() . '/assets/css/style.css', '', '1.0.0' );
            wp_enqueue_script( 'tried', get_template_directory_uri() . '/assets/js/script.js', null, '1.0.0', true );
            wp_enqueue_style( 'tried-widget', get_template_directory_uri() . '/assets/css/style-widgets.css', '', '1.0.0' );

            wp_register_style( 'tried-fileupload', get_template_directory_uri() . '/assets/css/style-fileupload.css', '', '1.0.0' );
            wp_register_script( 'tried-fileupload', get_template_directory_uri() . '/assets/js/script-fileupload.js', null, '1.0.0', true );

            wp_register_style( 'tried-toc', get_template_directory_uri() . '/assets/css/style-toc.css', '', '1.0.0' );
            wp_register_script( 'tried-toc', get_template_directory_uri() . '/assets/js/script-toc.js', null, '1.0.0', true );

            // blog-item
            wp_register_style( 'tried-hotblog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-hot-item.css', '', '1.0.0' );
            wp_register_style( 'tried-gridblog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-grid-item.css', '', '1.0.0' );
            wp_register_style( 'tried-additionblog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-addition-item.css', '', '1.0.0' );
            wp_register_style( 'tried-smallblog-item', get_template_directory_uri() . '/assets/css/blog-item/blog-small-item.css', '', '1.0.0' );

            // form
            wp_register_style( 'tried-form-wpcf7', get_template_directory_uri() . '/assets/css/form/wpcf7.css', '', '1.0.0' );

            // header
            wp_enqueue_style( 'tried-header', get_template_directory_uri() . '/assets/css/header/header.css', '', '1.0.0' );
            wp_register_style( 'tried-header-primary', get_template_directory_uri() . '/assets/css/header/header-primary.css', '', '1.0.0' );
            wp_register_style( 'tried-header-content', get_template_directory_uri() . '/assets/css/header/header-content.css', '', '1.0.0' );

            // footer
            wp_enqueue_style( 'tried-footer', get_template_directory_uri() . '/assets/css/footer/footer.css', '', '1.0.0' );
            wp_register_style( 'tried-footer-content', get_template_directory_uri() . '/assets/css/footer/footer-content.css', '', '1.0.0' );

            // post_content
            wp_register_script( 'tried-post_content', get_template_directory_uri() . '/assets/js/script-post_content.js', null, '1.0.0', true );

            // content
            wp_register_style( 'tried-content-post_content', get_template_directory_uri() . '/assets/css/content/content-post_content.css', '', '1.0.0' );
            
            // single
            wp_register_style( 'tried-jobpost-single', get_template_directory_uri() . '/assets/css/single/single-jobpost.css', '', '1.0.0' );
            wp_register_style( 'tried-jobpost_detail-single', get_template_directory_uri() . '/assets/css/single/single-jobpost_detail.css', '', '1.0.0' );
            wp_register_style( 'tried-jobpost_apply-single', get_template_directory_uri() . '/assets/css/single/single-jobpost_apply.css', '', '1.0.0' );
            wp_register_style( 'tried-advice-single', get_template_directory_uri() . '/assets/css/single/single-advice.css', '', '1.0.0' );
            wp_register_style( 'tried-calevents-single', get_template_directory_uri() . '/assets/css/single/single-calevents.css', '', '1.0.0' );

            // archive
            wp_register_style( 'tried-jobpost-archive', get_template_directory_uri() . '/assets/css/archive/archive-jobpost.css', '', '1.0.0' );
            wp_register_style( 'tried-advice-archive', get_template_directory_uri() . '/assets/css/archive/archive-advice.css', '', '1.0.0' );

            // review-item
            wp_register_style( 'tried-review-item', get_template_directory_uri() . '/assets/css/review-item/review-item.css', '', '1.0.0' );
            wp_register_style( 'tried-review-quote-item', get_template_directory_uri() . '/assets/css/review-item/review-quote-item.css', '', '1.0.0' );

            // advice-item
            wp_register_style( 'tried-advice-item', get_template_directory_uri() . '/assets/css/advice-item/advice-item.css', '', '1.0.0' );
            wp_register_style( 'tried-advicethumbnail-item', get_template_directory_uri() . '/assets/css/advice-item/advicethumbnail-item.css', '', '1.0.0' );

            // event-item
            wp_register_style( 'tried-event-item', get_template_directory_uri() . '/assets/css/event-item/event-item.css', '', '1.0.0' );

            // jobpost-item
            wp_register_style( 'tried-jobpost-item', get_template_directory_uri() . '/assets/css/jobpost-item/jobpost-item.css', '', '1.0.0' );
            wp_register_style( 'tried-jobpostlist-item', get_template_directory_uri() . '/assets/css/jobpost-item/jobpostlist-item.css', '', '1.0.0' );
            wp_register_style( 'tried-jobpostgrid-item', get_template_directory_uri() . '/assets/css/jobpost-item/jobpostgrid-item.css', '', '1.0.0' );
            wp_register_style( 'tried-jobpostsmall-item', get_template_directory_uri() . '/assets/css/jobpost-item/jobpostsmall-item.css', '', '1.0.0' );
            wp_register_style( 'tried-jobpostsave-item', get_template_directory_uri() . '/assets/css/jobpost-item/jobpostsave-item.css', '', '1.0.0' );

            // jobpost
            wp_register_script( 'tried-job_filter', get_template_directory_uri() . '/assets/js/script-job_filter.js', null, '1.0.0', true );
            wp_register_script( 'tried-job_apply', get_template_directory_uri() . '/assets/js/script-job_apply.js', null, '1.0.0', true );
            wp_register_script( 'tried-job_action', get_template_directory_uri() . '/assets/js/script-job_action.js', null, '1.0.0', true );

            // wooCommerce
            if ( class_exists( 'WooCommerce' ) ) {
                wp_enqueue_style( 'tried-woocommerce', get_template_directory_uri() . '/assets/css/style-woocommerce.css', '', '1.0.0' );
            }

            // font
            wp_enqueue_style( 'tried-font', get_template_directory_uri() . '/assets/css/style-fonts.css', '', '1.0.0' );

            // lib
            wp_enqueue_style( "swiper-bundle-min", get_theme_file_uri( "/assets/lib/swiper-bundle/swiper-bundle.min.css" ), [], false );
            wp_enqueue_script( "swiper-bundle-min", get_theme_file_uri( "/assets/lib/swiper-bundle/swiper-bundle.min.js" ), array(), false, false );

            /** pages */
            wp_register_style( 'tried-jobpost_search-page', get_template_directory_uri() . '/assets/css/page/jobpost-search.css', '', '1.0.0' );
            wp_register_style( 'tried-advices-page', get_template_directory_uri() . '/assets/css/page/advices.css', '', '1.0.0' );
            wp_register_style( 'tried-about-page', get_template_directory_uri() . '/assets/css/page/about.css', '', '1.0.0' );
            wp_register_style( 'tried-contact-page', get_template_directory_uri() . '/assets/css/page/contact.css', '', '1.0.0' );
            wp_register_style( 'tried-event-page', get_template_directory_uri() . '/assets/css/page/event.css', '', '1.0.0' );
            wp_register_style( 'tried-request_callback-page', get_template_directory_uri() . '/assets/css/page/request-callback.css', '', '1.0.0' );
            wp_register_style( 'tried-login_register-page', get_template_directory_uri() . '/assets/css/page/login-register.css', '', '1.0.0' );
            wp_register_style( 'tried-job_seeker-page', get_template_directory_uri() . '/assets/css/page/job-seeker.css', '', '1.0.0' );
            wp_register_style( 'tried-default-page', get_template_directory_uri() . '/assets/css/page/default.css', '', '1.0.0' );

            wp_register_script( 'tried-job_search-page', get_template_directory_uri() . '/assets/js/script-job_search.js', null, '1.0.0', true );

            /** parts */
            wp_register_style( 'tried-login_form-block', get_template_directory_uri() . '/assets/css/parts/login-form.css', '', '1.0.0' );
            wp_register_style( 'tried-register_form-block', get_template_directory_uri() . '/assets/css/parts/register-form.css', '', '1.0.0' );
            wp_register_style( 'tried-account_dashboard-block', get_template_directory_uri() . '/assets/css/parts/account-dashboard.css', '', '1.0.0' );
            wp_register_style( 'tried-account_savejob-block', get_template_directory_uri() . '/assets/css/parts/account-savejob.css', '', '1.0.0' );
            wp_register_style( 'tried-account_profile_detail-block', get_template_directory_uri() . '/assets/css/parts/account-profile_detail.css', '', '1.0.0' );
            wp_register_style( 'tried-account_change_password-block', get_template_directory_uri() . '/assets/css/parts/account-change_password.css', '', '1.0.0' );
            wp_register_style( 'tried-account_submit_resume-block', get_template_directory_uri() . '/assets/css/parts/account-submit_resume.css', '', '1.0.0' );


            wp_localize_script( 'tried', 'tried_script', array(
                'ajax_url' => admin_url( 'admin-ajax.php' )
            ) );

            if ( $template && basename($template) == 'account.php' ) {
                wp_enqueue_style( 'tried-profile', get_template_directory_uri() . '/assets/css/style-profile.css', '', '1.0.0' );
                wp_enqueue_script( 'tried-profile', get_template_directory_uri() . '/assets/js/script-profile.js', null, '1.0.0', true );
            }

            if ( is_single() && get_post_type() == 'calevents' ) {
                wp_enqueue_script( "countdown-min", get_theme_file_uri( "/assets/lib/countdown/countdown.min.js" ), array(), true, false );
            }

            // if ( ! did_action( 'wp_enqueue_media' ) ) {
            //     wp_enqueue_media();
            // }
        }

        function tried_theme_theme_setup() {
            register_nav_menus(array(
                'header-menu'  => esc_html__('Header Menu', 'tried'),
                'header_mobile-menu'  => esc_html__('Header Menu(Mobile)', 'tried')
            ));
            
            $defaults = array(
                'flex-height'          => true,
                'flex-width'           => true,
                'header-text'          => array( 'site-title', 'site-description' ),
                'unlink-homepage-logo' => true, 
            );
            add_theme_support( 'custom-logo', $defaults );
            add_theme_support( 'post-thumbnails' );
            remove_theme_support( 'widgets-block-editor' );
        }
        
        function tried_theme_customizer_setting($wp_customize) {
            $wp_customize->add_setting( 'custom_second_logo' );
            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize, 
                    'custom_second_logo', 
                    array(
                        'label' => __( 'Second Logo' ),
                        'section' => 'title_tagline', //this is the section where the custom-logo from WordPress is
                        'settings' => 'custom_second_logo',
                        'priority' => 8 // show it just below the custom-logo
                    )
                )
            );
        }

        function tried_wp_head() {
            printf( '<script>var fileupload_url = "%s";</script>', get_site_url() );
            if ( is_single() && false ) {
                ?>
<link rel=stylesheet
    href="<?php echo get_template_directory_uri().'/assets/lib/mibreit-gallery/css/mibreitGallery.css'; ?>"
    type="text/css" />
<script src="<?php echo get_template_directory_uri().'/assets/lib/mibreit-gallery/mibreitGallery.min.js'; ?>"></script>
<script>
$(document).ready(function() {
    mibreitGallery.createGallery({
        slideshowContainer: "#full-gallery",
        thumbviewContainer: ".mibreit-thumbview",
        titleContainer: "#full-gallery-title",
        allowFullscreen: !0,
        preloadLeftNr: 2,
        preloadRightNr: 3
    })
})
</script>
<?php
            }
        }

        function tried_wp_footer() {
            $user = get_current_user_id();
            ?>
<div id="modal-file-up-load" style="display: none;" data-key="">
    <div class="wrapper">
        <h2 class="title"><?php _e('File Upload', 'woocommerce'); ?><span class="modal-fclose">&times;</span></h2>
        <div class="content">
            <iframe class="embed-responsive-item" id="my_media_list" name="my_media_list" src=""
                allowfullscreen=""></iframe>
        </div>
    </div>
</div>
<?php
        }
	}
    
    return new Tried_Theme();
}