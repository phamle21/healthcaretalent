<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!class_exists('Tried_Theme_Backend', false )) {
	class Tried_Theme_Backend {
        public $includes = array();
        
        public $widgets = array(
            array(
                'path' => '/includes/widgets/widget_footer_information.php',
                'class' => 'widget_footer_information'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_footer_contact.php',
            //     'class' => 'widget_footer_contact'
            // ),
            array(
                'path' => '/includes/widgets/widget_header_logo.php',
                'class' => 'widget_header_logo'
            ),
            array(
                'path' => '/includes/widgets/widget_another_bannernormal.php',
                'class' => 'widget_another_bannernormal'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_contact_content.php',
            //     'class' => 'widget_contact_content'
            // ),
            array(
                'path' => '/includes/widgets/widget_contact_mapform.php',
                'class' => 'widget_contact_mapform'
            ),
            array(
                'path' => '/includes/widgets/widget_another_listclient.php',
                'class' => 'widget_another_listclient'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_home_about.php',
            //     'class' => 'widget_home_about'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_form.php',
            //     'class' => 'widget_home_form'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_footer_form.php',
            //     'class' => 'widget_footer_form'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_slider.php',
            //     'class' => 'widget_home_slider'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_service.php',
            //     'class' => 'widget_home_service'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_partner.php',
            //     'class' => 'widget_home_partner'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_footer_recentform.php',
            //     'class' => 'widget_footer_recentform'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_footer_menu.php',
            //     'class' => 'widget_footer_menu'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_footer_menusocial.php',
            //     'class' => 'widget_footer_menusocial'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_footer_workinghours.php',
            //     'class' => 'widget_footer_workinghours'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_banner.php',
            //     'class' => 'widget_home_banner'
            // ),
            array(
                'path' => '/includes/widgets/widget_event_latestevent.php',
                'class' => 'widget_event_latestevent'
            ),
            array(
                'path' => '/includes/widgets/widget_event_contentinfobox.php',
                'class' => 'widget_event_contentinfobox'
            ),
            array(
                'path' => '/includes/widgets/widget_about_listservice.php',
                'class' => 'widget_about_listservice'
            ),
            array(
                'path' => '/includes/widgets/widget_event_info.php',
                'class' => 'widget_event_info'
            ),
            array(
                'path' => '/includes/widgets/widget_event_infoimage.php',
                'class' => 'widget_event_infoimage'
            ),
            array(
                'path' => '/includes/widgets/widget_another_cardbox.php',
                'class' => 'widget_another_cardbox'
            ),
            array(
                'path' => '/includes/widgets/widget_about_contentinfobox.php',
                'class' => 'widget_about_contentinfobox'
            ),
            array(
                'path' => '/includes/widgets/widget_another_content.php',
                'class' => 'widget_another_content'
            ),
            array(
                'path' => '/includes/widgets/widget_another_contentfull.php',
                'class' => 'widget_another_contentfull'
            ),
            array(
                'path' => '/includes/widgets/widget_about_colinfobox.php',
                'class' => 'widget_about_colinfobox'
            ),
            array(
                'path' => '/includes/widgets/widget_about_reverseboxs.php',
                'class' => 'widget_about_reverseboxs'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_home_review.php',
            //     'class' => 'widget_home_review'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_catproduct.php',
            //     'class' => 'widget_home_catproduct'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_product.php',
            //     'class' => 'widget_home_product'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_blog.php',
            //     'class' => 'widget_home_blog'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_header_info.php',
            //     'class' => 'widget_header_info'
            // ),
            array(
                'path' => '/includes/widgets/widget_header_action.php',
                'class' => 'widget_header_action'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_header_menu.php',
            //     'class' => 'widget_header_menu'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_header_share.php',
            //     'class' => 'widget_header_share'
            // ),
            array(
                'path' => '/includes/widgets/widget_header_textarea.php',
                'class' => 'widget_header_textarea'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_header_contact.php',
            //     'class' => 'widget_header_contact'
            // ),
            array(
                'path' => '/includes/widgets/widget_footer_share.php',
                'class' => 'widget_footer_share'
            ),
            array(
                'path' => '/includes/widgets/widget_home_testimonial.php',
                'class' => 'widget_home_testimonial'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_about_timeline.php',
            //     'class' => 'widget_about_timeline'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_footer_location.php',
            //     'class' => 'widget_footer_location'
            // ),widget_another_listquotes
            array(
                'path' => '/includes/widgets/widget_another_listquotes.php',
                'class' => 'widget_another_listquotes'
            ),
            array(
                'path' => '/includes/widgets/widget_another_text.php',
                'class' => 'widget_another_text'
            ),
            array(
                'path' => '/includes/widgets/widget_jobpost_form.php',
                'class' => 'widget_jobpost_form'
            ),
            array(
                'path' => '/includes/widgets/widget_another_boxviewmore.php',
                'class' => 'widget_another_boxviewmore'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_another_login.php',
            //     'class' => 'widget_another_login'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_footer_infobox.php',
            //     'class' => 'widget_footer_infobox'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_catservice.php',
            //     'class' => 'widget_home_catservice'
            // ),
            array(
                'path' => '/includes/widgets/widget_home_filter_job.php',
                'class' => 'widget_home_filter_job'
            ),
            array(
                'path' => '/includes/widgets/widget_home_latest_job.php',
                'class' => 'widget_home_latest_job'
            ),
            array(
                'path' => '/includes/widgets/widget_another_shortcode.php',
                'class' => 'widget_another_shortcode'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_menuextend.php',
                'class' => 'widget_footer_menuextend'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_menucol.php',
                'class' => 'widget_footer_menucol'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_menucert.php',
                'class' => 'widget_footer_menucert'
            ),
            array(
                'path' => '/includes/widgets/widget_home_boxcontact.php',
                'class' => 'widget_home_boxcontact'
            ),
            array(
                'path' => '/includes/widgets/widget_home_latest_advice.php',
                'class' => 'widget_home_latest_advice'
            ),
            array(
                'path' => '/includes/widgets/widget_home_infocontact.php',
                'class' => 'widget_home_infocontact'
            ),
            array(
                'path' => '/includes/widgets/widget_contact_infoform.php',
                'class' => 'widget_contact_infoform'
            ),
            array(
                'path' => '/includes/widgets/widget_another_review.php',
                'class' => 'widget_another_review'
            ),
            array(
                'path' => '/includes/widgets/widget_another_highlightevent.php',
                'class' => 'widget_another_highlightevent'
            ),
            array(
                'path' => '/includes/widgets/widget_event_carouselupcoming.php',
                'class' => 'widget_event_carouselupcoming'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_home_bannerexperience.php',
            //     'class' => 'widget_home_bannerexperience'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_member.php',
            //     'class' => 'widget_home_member'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_header_banner.php',
            //     'class' => 'widget_header_banner'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_trending_blog.php',
            //     'class' => 'widget_home_trending_blog'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_hotblog.php',
            //     'class' => 'widget_home_hotblog'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_additionblog.php',
            //     'class' => 'widget_home_additionblog'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_home_gridblog.php',
            //     'class' => 'widget_home_gridblog'
            // ),
            // array(
            //     'path' => '/includes/widgets/widget_footer_logo.php',
            //     'class' => 'widget_footer_logo'
            // ),
            array(
                'path' => '/includes/widgets/widget_about_bannertitle.php',
                'class' => 'widget_about_bannertitle'
            ),
            array(
                'path' => '/includes/widgets/widget_header_mainmenu.php',
                'class' => 'widget_header_mainmenu'
            ),
            array(
                'path' => '/includes/widgets/widget_another_explore_advicecats.php',
                'class' => 'widget_another_explore_advicecats'
            ),
            array(
                'path' => '/includes/widgets/widget_another_jobsearch.php',
                'class' => 'widget_another_jobsearch'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_copyright.php',
                'class' => 'widget_footer_copyright'
            ),
            array(
                'path' => '/includes/widgets/widget_footer_vertical_menu.php',
                'class' => 'widget_footer_vertical_menu'
            ),
            array(
                'path' => '/includes/widgets/widget_menu_introimage.php',
                'class' => 'widget_menu_introimage'
            ),
            array(
                'path' => '/includes/widgets/widget_another_slide_advice.php',
                'class' => 'widget_another_slide_advice'
            ),
            array(
                'path' => '/includes/widgets/widget_another_advicebycats.php',
                'class' => 'widget_another_advicebycats'
            ),
            array(
                'path' => '/includes/widgets/widget_another_banner_viewmode.php',
                'class' => 'widget_another_banner_viewmode'
            ),
            array(
                'path' => '/includes/widgets/widget_contact_infocollapse.php',
                'class' => 'widget_contact_infocollapse'
            ),
            array(
                'path' => '/includes/widgets/widget_another_infolistlink.php',
                'class' => 'widget_another_infolistlink'
            ),
            array(
                'path' => '/includes/widgets/widget_sidebar_form.php',
                'class' => 'widget_sidebar_form'
            ),
            array(
                'path' => '/includes/widgets/widget_sidebar_banner.php',
                'class' => 'widget_sidebar_banner'
            ),
            array(
                'path' => '/includes/widgets/widget_sidebar_searchform.php',
                'class' => 'widget_sidebar_searchform'
            ),
            array(
                'path' => '/includes/widgets/widget_home_client.php',
                'class' => 'widget_home_client'
            ),
            array(
                'path' => '/includes/widgets/widget_contact_infomap.php',
                'class' => 'widget_contact_infomap'
            ),
            array(
                'path' => '/includes/widgets/widget_home_recapgallery.php',
                'class' => 'widget_home_recapgallery'
            ),
            array(
                'path' => '/includes/widgets/widget_another_calendarevent.php',
                'class' => 'widget_another_calendarevent'
            ),
            array(
                'path' => '/includes/widgets/widget_another_contentpage.php',
                'class' => 'widget_another_contentpage'
            ),
            array(
                'path' => '/includes/widgets/widget_home_jobpostfilter.php',
                'class' => 'widget_home_jobpostfilter'
            ),
            array(
                'path' => '/includes/widgets/widget_home_infoabout.php',
                'class' => 'widget_home_infoabout'
            ),
            // array(
            //     'path' => '/includes/widgets/widget_sidebar_mostblog.php',
            //     'class' => 'widget_sidebar_mostblog'
            // )
        );

        public $widget_sidebars = array(
            array(
                'id' => 'header_banner_info', 
                'name' => 'Header Banner Info'
            ),
            array(
                'id' => 'header_banner_outfit', 
                'name' => 'Header Banner Outfit'
            ),
            // array(
            //     'id' => 'header_container', 
            //     'name' => 'Header Container'
            // ),
            array(
                'id' => 'footer_top', 
                'name' => 'Footer Top'
            ),
            array(
                'id' => 'footer_middle', 
                'name' => 'Footer Middle'
            ),
            array(
                'id' => 'footer_bottom', 
                'name' => 'Footer Bottom'
            ),
            array(
                'id' => 'home_page', 
                'name' => 'Home page'
            ),
            array(
                'id' => 'contact_page', 
                'name' => 'Contact page'
            ),
            array(
                'id' => 'about_page', 
                'name' => 'About page'
            ),
            array(
                'id' => 'event_page', 
                'name' => 'Event page'
            ),
            array(
                'id' => 'advice_page', 
                'name' => 'Advice page'
            ),
            array(
                'id' => 'jobpost_search_page', 
                'name' => 'Job search page'
            ),
            array(
                'id' => 'request_callback_page', 
                'name' => 'Request callback page'
            ),
            array(
                'id' => 'upload_jobdescription_page', 
                'name' => 'Upload Job Description page'
            ),
            array(
                'id' => 'sidebar_advice', 
                'name' => 'Advice detail Sidebar'
            ),
            array(
                'id' => 'default_page', 
                'name' => 'Default page'
            )
        );

        public $settings = array(
            // 'admin_page' => array(
            //     'menu_page' => array(
            //         array(
            //             'page_title' => 'Tried',
            //             'menu_title' => 'Tried',
            //             'capability' => 'tried_dashboard',
            //             'menu_slug' => 'tried-dashboard',
            //             'callback_function' => 'dashboard',
            //             'icon_url' => '',
            //             'position' => 10,
            //         )
            //     ),
            //     'submenu_page' => array(
            //         array(
            //             'parent_slug' => 'tried-dashboard',
            //             'page_title' => 'Thuộc tính sản phẩm',
            //             'menu_title' => 'Thuộc tính sản phẩm',
            //             'capability' => 'tried_prodattribute',
            //             'menu_slug' => 'tried-prodattribute',
            //             'callback_function' => 'prodattribute',
            //             'position'  => null
            //         )
            //     )
            // )
        );

		function __construct() {
            $this->load_hooks();
		}

        function load_hooks() {
            add_action( 'admin_enqueue_scripts', array( $this, 'tried_admin_enqueue_scripts' ) );
            add_action( 'login_enqueue_scripts', array( $this, 'tried_login_enqueue_scripts' ), 1001 );

            add_action( 'widgets_init', array( $this, 'tried_widgets_init' ) );
            
            add_action( 'admin_body_class', array( $this, 'tried_admin_body_class' ), 10, 1 );
            
            add_action( 'admin_menu', array( $this, 'tried_admin_menu' ), 10 );
            add_action( 'admin_head', array( $this, 'tried_admin_head' ) );
            add_action( 'admin_footer', array( $this, 'tried_admin_footer' ) );
            
            add_filter( 'tried_header_message', array($this, 'tried_header_message'), 10, 1);

            // Disable Plugins to specific user
            add_filter( 'option_active_plugins', array( $this, 'tried_disable_logged_in_plugin' ) );
        }

        function tried_login_enqueue_scripts() {
            $logo = get_theme_file_uri( "/assets/img/logo.jpg" );
            $logo_bg = get_theme_file_uri( "/assets/img/login-bg.png" );
            if ( $logo && $logo_bg) {
                ?>
<style type="text/css">
body.login {
    background-image: url(<?php echo $logo_bg; ?>);
    background-size: cover;
    background-repeat: no-repeat;
}

body.login #login h1 a {
    /* background-image: url(<?php echo $logo; ?>); */
    background-position: center center;
    background-repeat: no-repeat;
    background-size: contain;
    width: 250px;
    height: 75px;
    margin-bottom: 30px;
}

body.login #login h1 a:focus {
    box-shadow: none;
}
</style>
<?php
            }
        }

        function tried_admin_enqueue_scripts() {
            global $pagenow;
            wp_enqueue_style( 'tried-admin', get_template_directory_uri() . '/assets/css/style-admin.css', '', '1.0.0' );
            wp_enqueue_script( 'tried-admin', get_template_directory_uri() . '/assets/js/script-admin.js', null, '1.0.0', true );
            if( $pagenow == "admin.php" && isset( $_GET['page'] ) && explode( '-', $_GET['page'] )[0] == 'tried' ) {
                wp_enqueue_style( 'tried-manage', get_template_directory_uri() . '/assets/css/admin/manage.css', '', '1.0.0' );
                wp_enqueue_script( 'tried-header', get_template_directory_uri() . '/assets/js/admin/header.js', null, '1.0.0', true );
                wp_enqueue_script( 'tried-body', get_template_directory_uri() . '/assets/js/admin/body.js', null, '1.0.0', true );
                if ( str_contains( $_GET['page'], 'printprodprice' ) ) {
                    wp_enqueue_script( 'jquery-print' );
                    wp_enqueue_style( 'tried-manage-printprodprice', get_template_directory_uri() . '/assets/css/admin/templates/manage-printprodprice.css', '', '1.0.0' );
                    wp_enqueue_script( 'tried-printprodprice', get_template_directory_uri() . '/assets/js/admin/templates/printprodprice.js', array('jquery'), '1.0.0', true );
                }
            }

            // posttype
            wp_register_style( 'tried-metabox-attribute_san-pham', get_template_directory_uri() . '/assets/css/admin/posttype/metabox-attribute_san-pham.css', '', '1.0.0' );

            if ( ! did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }
        }

        function tried_admin_menu() {
            $this->add_menu_page();
            $this->add_submenu_page();
        }

        function get_submenu_page() {
            return (!empty($this->settings['admin_page']['submenu_page']))?$this->settings['admin_page']['submenu_page']:false;
        }

        function add_submenu_page() {
            $admin_submenu_page = $this->get_submenu_page();
            if ( $admin_submenu_page ) {
                foreach ( $admin_submenu_page as $page ) {
                    $submenu_page = add_submenu_page(
                        $page['parent_slug'],
                        $page['page_title'],
                        $page['menu_title'],
                        $page['capability'],
                        $page['menu_slug'],
                        array($this, 'callback_function'),
                        ($page['position'])?$page['position']:null
                    );
                    $this->views[$submenu_page] = $page['callback_function'];
                    $this->views_info[$submenu_page] = array(
                        'title' => $page['page_title']
                    );
                }
            }
        }

        function get_menu_page() {
            return (!empty($this->settings['admin_page']['menu_page']))?$this->settings['admin_page']['menu_page']:false;
        }

        function add_menu_page() {
            $admin_menu_page = $this->get_menu_page();
            if ( $admin_menu_page ) {
                foreach ( $admin_menu_page as $page ) {
                    $menu_page = add_menu_page(
                        $page['page_title'], 
                        $page['menu_title'], 
                        $page['capability'],
                        $page['menu_slug'],
                        array($this, 'callback_function'),
                        ($page['icon_url'])?$page['icon_url']:null,
                        ($page['position'])?$page['position']:null
                    );
                    $this->views[$menu_page] = $page['callback_function'];
                }
            }
        }

        function callback_function() {
            $current_views = $this->views[current_filter()];
            $current_viewsinfo = false;
            if ( isset( $this->views_info ) ) {
                $current_viewsinfo = $this->views_info[current_filter()];
            }
            ?>
<div class="tried-admin-page" role="<?php echo $current_views; ?>">
    <div class="wrapper">
        <?php
                            get_template_part( 'includes/templates/backend/body', null, array(
                                'render' => $current_views,
                                'info' => $current_viewsinfo
                            ) );
                        ?>
    </div>
</div>
<?php
        }
        
        function tried_widgets_init() {
            if (!empty($this->widget_sidebars)) {
                foreach ($this->widget_sidebars as $sidebars) {
                    register_sidebar(array(
                        'id'            => $sidebars['id'],
                        'name'          => $sidebars['name'],
                        'before_widget' => '<div class="widget-component">',
                        'after_widget'  => '</div>',
                        'before_title'  => '',
                        'after_title'   => ''
                    ));
                }
            }

            if (!empty($this->widgets)) {
                foreach ($this->widgets as $widget) {
                    include_once get_template_directory() . $widget['path'];
                    if ( class_exists($widget['class'], false) ) {
                        register_widget($widget['class']);
                    }
                }
            }
        }
        
        function tried_admin_body_class($classes) {
            global $pagenow;
            if($pagenow == "admin.php" && isset($_GET['page']) && explode('-', $_GET['page'])[0] == 'tried') {
                $classes .= 'admin-tried';
            }
            return $classes;
        }

        function tried_admin_head() {
            // coding
        }

        function tried_admin_footer() {
            global $pagenow;
            if( $pagenow == "admin.php" && isset( $_GET['page'] ) && explode( '-', $_GET['page'] )[0] == 'tried' ) {
                // coding
            }
            if ( $pagenow == "post.php" && isset($_GET['post']) && 'jobpost' === get_post_type( $_GET['post'] ) ) {
                ?>
<style type="text/css">
#jobapp_form_fields,
#app_form_fields>li .jobapp-field-div .removeField,
#app_form_fields>li .jobapp-field-div .applicant-columns-div {
    display: none !important;
}
</style>
<script>
(function($) {
    $('#jobapp_form_fields').remove();
    $('#app_form_fields>li .jobapp-field-div .removeField').remove();
    $('#app_form_fields>li .jobapp-field-div .applicant-columns-div').each(function() {
        $(this).remove();
    });
    setTimeout(function() {
        $('#app_form_fields').removeClass('ui-sortable');
        $('#app_form_fields>li').each(function() {
            $(this).removeClass('ui-sortable-handle');
        });
    }, 1000);
})(jQuery);
</script>
<?php
            }
            $isTaxonomyCondition = false;
            if ( isset( $_GET['taxonomy'] ) && ( $_GET['taxonomy'] == 'jobrequired_cat' || $_GET['taxonomy'] == 'jobrequired_option' ) ) {
                $isTaxonomyCondition = true;
            }
            if( ( $pagenow == "term.php" || $pagenow == 'edit-tags.php' ) &&  $isTaxonomyCondition ) {
                ?>
<style type="text/css">
#the-list tr td .row-actions,
#the-list tr td .row-actions .delete #delete-link {
    display: none !important;
}
</style>
<script>
(function($) {
    $('#delete-link').remove();
    $('#the-list tr td .row-actions').each(function() {
        $(this).html('');
    });
})(jQuery);
</script>
<?php
            }
                ?>
<script>
(function($) {
    'use strict';

    initializeSelect2($('.select2'), true);

    function initializeSelect2(slct, dynamic = false) {
        var selectValue = [],
            args = {
                width: 'style',
                allowClear: true,
                placeholder: "<?php _e( 'Select values', 'tried' ); ?>"
            };
        if (dynamic) {
            args.tags = true;
        }
        slct.select2(args);
        slct.find('option').each(function() {
            if ($(this).val() != '') selectValue.push($(this).val());
        });
        slct.val(selectValue).val('').trigger('change');
    }
})(jQuery);
</script>
<?php
        }
        
        function tried_header_message($args = null) {
            $messages = array();
            for ($i = 1; $i < 10; $i++) { 
                array_push($messages, array(
                    'type' => 'plain',
                    'content' => array(
                        'date' => $i." hours ago",
                        'title' => "The first ".$i." things to customize in your store",
                        'text' => "Deciding what to start with first is tricky. To help you properly prioritize, we've put together this short list of the first few things you should customize in Estimated."
                    ),
                    'action' => array(
                        array(
                            'title' => 'Learn more',
                            'href' => ''
                        ),
                        array(
                            'title' => 'Dismiss',
                            'href' => ''
                        )
                    )
                ));
            }
            return $messages;
        }

        function tried_disable_logged_in_plugin( $plugins ) {
            // The 'option_active_plugins' hook occurs before any user information get generated,
            // so we need to require this file early to be able to check for logged in status
            require (ABSPATH . WPINC . '/pluggable.php');
            // If we are logged in, and NOT an admin...
            if ( current_user_can('Administrator') ) {
                // Use the plugin folder and main file name here.
                // is used here as an example
                $plugins_not_needed = array ('/woocommerce-pay-per-post/woocommerce-pay-per-post.php');
                foreach ( $plugins_not_needed as $plugin ) {
                    $key = array_search( $plugin, $plugins );
                    if ( false !== $key ) {
                        unset( $plugins[ $key ] );
                    }
                }
            }
            return $plugins;
        }
	}

    return new Tried_Theme_Backend();
}