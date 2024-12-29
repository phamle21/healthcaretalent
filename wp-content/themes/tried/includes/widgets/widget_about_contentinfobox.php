<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_about_contentinfobox extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_about_contentinfobox', 'Tried About Content Infobox',
			array(
				'classname' => 'widget_about_contentinfobox',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'banner' => '',
            'title_infobox' => __( 'Title', 'tried' ), 'content_infobox' => __( 'Content', 'tried' ),
            'title_infobox2' => __( 'Title', 'tried' ), 'content_infobox2' => __( 'Content', 'tried' ),
            'title_infobox3' => __( 'Title', 'tried' ), 'content_infobox3' => __( 'Content', 'tried' ),
            'title_infobox4' => __( 'Title', 'tried' ), 'content_infobox4' => __( 'Content', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		
		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
        $content = $instance['content'];
        $banner = $instance['banner'] ? $instance['banner'] : get_theme_file_uri( '/assets/img/placeholder.png' );

        $title_infobox = $instance['title_infobox'];
        $content_infobox = $instance['content_infobox'];
        $title_infobox2 = $instance['title_infobox2'];
        $content_infobox2 = $instance['content_infobox2'];
        $title_infobox3 = $instance['title_infobox3'];
        $content_infobox3 = $instance['content_infobox3'];
        $title_infobox4 = $instance['title_infobox4'];
        $content_infobox4 = $instance['content_infobox4'];

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-about-contentinfobox">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h6><?php echo $subtitle; ?></h6>
            <h5><?php echo $title; ?></h5>
            <p><?php echo $content; ?></p>
            <div class="infoboxs">
                <?php
                    if ( !empty( $title_infobox ) && !empty( $content_infobox ) ) {
                        printf(
                            '<div class="infobox-item">
                                <div class="wrap">
                                    <h5>%s</h5>
                                    <p>%s</p>
                                </div>
                            </div>',
                            $title_infobox, $content_infobox
                        );
                    }
                    if ( !empty( $title_infobox2 ) && !empty( $content_infobox2 ) ) {
                        printf(
                            '<div class="infobox-item">
                                <div class="wrap">
                                    <h5>%s</h5>
                                    <p>%s</p>
                                </div>
                            </div>',
                            $title_infobox2, $content_infobox2
                        );
                    }
                    if ( !empty( $title_infobox3 ) && !empty( $content_infobox3 ) ) {
                        printf(
                            '<div class="infobox-item">
                                <div class="wrap">
                                    <h5>%s</h5>
                                    <p>%s</p>
                                </div>
                            </div>',
                            $title_infobox3, $content_infobox3
                        );
                    }
                    if ( !empty( $title_infobox4 ) && !empty( $content_infobox4 ) ) {
                        printf(
                            '<div class="infobox-item">
                                <div class="wrap">
                                    <h5>%s</h5>
                                    <p>%s</p>
                                </div>
                            </div>',
                            $title_infobox4, $content_infobox4
                        );
                    }
                ?>
            </div>
        </div>
        <div class="banner-block">
            <img src="<?php echo $banner; ?>" alt="" />
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();

		$instance['title'] = ($new_instance['title']);
		$instance['subtitle'] = ($new_instance['subtitle']);
		$instance['content'] = ($new_instance['content']);

		$instance['title_infobox'] = ($new_instance['title_infobox']);
		$instance['content_infobox'] = ($new_instance['content_infobox']);
		$instance['title_infobox2'] = ($new_instance['title_infobox2']);
		$instance['content_infobox2'] = ($new_instance['content_infobox2']);
		$instance['title_infobox3'] = ($new_instance['title_infobox3']);
		$instance['content_infobox3'] = ($new_instance['content_infobox3']);
		$instance['title_infobox4'] = ($new_instance['title_infobox4']);
		$instance['content_infobox4'] = ($new_instance['content_infobox4']);

		$instance['banner'] = ($new_instance['banner']);

        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'banner' => '',
            'title_infobox' => __( 'Title', 'tried' ), 'content_infobox' => __( 'Content', 'tried' ),
            'title_infobox2' => __( 'Title', 'tried' ), 'content_infobox2' => __( 'Content', 'tried' ),
            'title_infobox3' => __( 'Title', 'tried' ), 'content_infobox3' => __( 'Content', 'tried' ),
            'title_infobox4' => __( 'Title', 'tried' ), 'content_infobox4' => __( 'Content', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info block', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Subtitle', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>"
        name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>"
        id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content']); ?></textarea>
</p>
<h4><?php _e( 'Infoboxs', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('title_infobox')); ?>"><?php esc_html_e('Title 1', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_infobox']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_infobox')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_infobox')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_infobox')); ?>"><?php esc_html_e('Content 1', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_infobox')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_infobox')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content_infobox']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('title_infobox2')); ?>"><?php esc_html_e('Title 2', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_infobox2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_infobox2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_infobox2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_infobox2')); ?>"><?php esc_html_e('Content 2', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_infobox2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_infobox2')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content_infobox2']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('title_infobox3')); ?>"><?php esc_html_e('Title 3', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_infobox3']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_infobox3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_infobox3')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_infobox3')); ?>"><?php esc_html_e('Content 3', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_infobox3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_infobox3')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content_infobox3']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('title_infobox4')); ?>"><?php esc_html_e('Title 4', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_infobox4']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_infobox4')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_infobox4')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_infobox4')); ?>"><?php esc_html_e('Content 4', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_infobox4')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_infobox4')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content_infobox4']); ?></textarea>
</p>
<h4><?php _e( 'Banner block', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('banner')); ?>"><?php esc_html_e('Banner', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('banner')); ?>"
        id="<?php echo esc_attr($this->get_field_id('banner')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['banner']); ?></textarea>
</p>
<?php
    }
}