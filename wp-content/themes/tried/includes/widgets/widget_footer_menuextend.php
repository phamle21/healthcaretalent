<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_menuextend extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_menuextend', 'Tried Footer Menu Extend',
			array(
				'classname' => 'widget_footer_menuextend',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array(
            'title_menu' => '', 'id_menu' => '',
            'title_social' => __('Link chung', 'tried'), 'social_facebook' => '', 'social_instagram' => '', 'social_linkedin' => '', 'social_youtube' => '', 'social_twitter' => '',
            'title_download' => '', 'download_chplay' => '', 'download_applestore' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$title_menu = $instance['title_menu'];
		$id_menu = $instance['id_menu'];
        $menu = wp_get_nav_menu_items($id_menu);
        
		$title_social = $instance['title_social'];
		$social_facebook = $instance['social_facebook'];
		$social_instagram = $instance['social_instagram'];
		$social_linkedin = $instance['social_linkedin'];
		$social_youtube = $instance['social_youtube'];
		$social_twitter = $instance['social_twitter'];

		$title_download = $instance['title_download'];
		$download_chplay = $instance['download_chplay'];
		$download_applestore = $instance['download_applestore'];
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-menuextend">
    <div class="section-wrapper margin-auto nav">
        <div class="menu-block">
            <h4 class="menu-title"><?php echo $title_menu; ?></h4>
            <?php
                            if (!empty($menu)) :
                                echo '<ul class="menu">';
                                foreach ($menu as $item) :
                        ?>
            <li class="item"><a href="<?php echo $item->url; ?>"
                    title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></li>
            <?php
                                endforeach;
                                echo '</ul>';
                            endif;
                        ?>
        </div>
        <div class="social-block">
            <h4 class="social-title"><?php echo $title_social; ?></h4>
            <ul class="socials">
                <?php if (!empty($social_instagram)) : ?>
                <li class="item instagram">
                    <a href="<?php echo $social_instagram; ?>" title="">
                        <img src="<?php echo get_theme_file_uri( "/assets/img/tried-linstagram.png" ); ?>" alt="" />
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($social_facebook)) : ?>
                <li class="item facebook">
                    <a href="<?php echo $social_facebook; ?>" title="">
                        <img src="<?php echo get_theme_file_uri( "/assets/img/tried-lfacebook.png" ); ?>" alt="" />
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($social_linkedin)) : ?>
                <li class="item youtube">
                    <a href="<?php echo $social_linkedin; ?>" title="">
                        <img src="<?php echo get_theme_file_uri( "/assets/img/tried-llinkedin.png" ); ?>" alt="" />
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($social_twitter)) : ?>
                <li class="item twitter">
                    <a href="<?php echo $social_twitter; ?>" title="">
                        <img src="<?php echo get_theme_file_uri( "/assets/img/tried-ltwitter.png" ); ?>" alt="" />
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($social_youtube)) : ?>
                <li class="item youtube">
                    <a href="<?php echo $social_youtube; ?>" title="">
                        <img src="<?php echo get_theme_file_uri( "/assets/img/tried-lyoutube.png" ); ?>" alt="" />
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="download-block">
            <h4 class="download-title"><?php echo $title_download; ?></h4>
            <ul class="downloads">
                <?php if (!empty($download_chplay)) : ?>
                <li class="item chplay">
                    <a href="<?php echo $download_chplay; ?>" title="">
                        <img src="<?php echo get_theme_file_uri( "/assets/img/tried-appchplay.png" ); ?>" alt="" />
                    </a>
                </li>
                <?php endif; ?>
                <?php if (!empty($download_applestore)) : ?>
                <li class="item chplay">
                    <a href="<?php echo $download_applestore; ?>" title="">
                        <img src="<?php echo get_theme_file_uri( "/assets/img/tried-appapplestore.png" ); ?>" alt="" />
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		$instance['title_menu'] = strip_tags($new_instance['title_menu']);
		$instance['id_menu'] = !empty($new_instance['id_menu']) ? $new_instance['id_menu'] : '0';
        
		$instance['title_social'] = $new_instance['title_social'];
		$instance['social_facebook'] = $new_instance['social_facebook'];
		$instance['social_instagram'] = $new_instance['social_instagram'];
		$instance['social_linkedin'] = $new_instance['social_linkedin'];
		$instance['social_youtube'] = $new_instance['social_youtube'];
		$instance['social_twitter'] = $new_instance['social_twitter'];

		$instance['title_download'] = $new_instance['title_download'];
		$instance['download_chplay'] = $new_instance['download_chplay'];
		$instance['download_applestore'] = $new_instance['download_applestore'];
		return $instance;
	}
	
	function form( $instance ) {
        $defaults = array(
            'title_menu' => '', 'id_menu' => '',
            'title_social' => __('Link chung', 'tried'), 'social_facebook' => '', 'social_instagram' => '', 'social_linkedin' => '', 'social_youtube' => '', 'social_twitter' => '',
            'title_download' => '', 'download_chplay' => '', 'download_applestore' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        $nav_menus = wp_get_nav_menus();
        ?>
<h5><?php esc_html_e('Menu', ''); ?></h5>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_menu')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_menu']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_menu')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_menu')); ?>" />
</p>
<div style="margin-bottom: 5px; min-height: 25px;">
    <?php if (!empty($nav_menus)) : ?>
    <span style="width: 20%; float:left; line-height: 20px;"><?php _e('Menu', ''); ?>:</span>
    <span style="float:left; : 70%; margin-left: 5%">
        <select id="<?php echo esc_attr($this->get_field_id('id_menu')); ?>" class="widefat"
            name="<?php echo esc_attr($this->get_field_name('id_menu')); ?>">
            <?php foreach ($nav_menus as $menu) : ?>
            <option value="<?=$menu->term_id?>" <?php selected($menu->term_id, $instance['id_menu']); ?>>
                <?=$menu->name ?></option>
            <?php endforeach; ?>
        </select>
    </span>
    <?php endif; ?>
</div>
<h5><?php esc_html_e('Mạng xã hội', ''); ?></h5>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('title_social')); ?>"><?php esc_html_e('Title', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_social']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_social')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_social')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>"><?php esc_html_e('Facebook', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_facebook']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_facebook')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_linkedin')); ?>"><?php esc_html_e('LinkedIn', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_linkedin']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_linkedin')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_linkedin')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_instagram')); ?>"><?php esc_html_e('Instagram', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_instagram']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_instagram')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_instagram')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>"><?php esc_html_e('Youtube', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_youtube']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_youtube')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>"><?php esc_html_e('Twitter', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_twitter']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_twitter')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>" />
</p>
<h5><?php esc_html_e('Tải xuống', ''); ?></h5>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('title_download')); ?>"><?php esc_html_e('Title', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_download']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_download')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_download')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('download_chplay')); ?>"><?php esc_html_e('CH Play', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['download_chplay']); ?>"
        name="<?php echo esc_attr($this->get_field_name('download_chplay')); ?>"
        id="<?php echo esc_attr($this->get_field_id('download_chplay')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('download_applestore')); ?>"><?php esc_html_e('AppleStore', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['download_applestore']); ?>"
        name="<?php echo esc_attr($this->get_field_name('download_applestore')); ?>"
        id="<?php echo esc_attr($this->get_field_id('download_applestore')); ?>" />
</p>
<?php
	}
}