<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_about_bannertitle extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_about_bannertitle', 'Tried About Banner Title',
			array(
				'classname' => 'widget_about_bannertitle',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' ),
            'usevideo' => '',
            'videocontrol' => '',
            'banner' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$subtitle = $instance['subtitle'];
		$usevideo = $instance['usevideo'];
		$videocontrol = $instance['videocontrol'];
        $banner = $instance['banner'] ? $instance['banner'] : get_theme_file_uri( '/assets/img/placeholder.png' );

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-about-bannertitle">
    <div class="section-wrapper margin-auto">
        <div class="content-block">
            <div class="info-block">
                <h3><?php echo $title; ?></h3>
                <h5><?php echo $subtitle; ?></h5>
            </div>
        </div>
        <div class="banner-block">
            <?php
                if ( !empty( $banner ) ) {
                    if ( $usevideo && $usevideo == 'true' ) {
                        printf( '<video width="400" %s>
                                <source src="%s" type="video/mp4">
                                Your browser does not support HTML video.
                            </video>',
                            ( $videocontrol && $videocontrol == 'true' ) ? 'controls' : 'muted autoplay webkit-playsinline',
                            $banner
                        );
                    } else {
                        printf( '<img src="%s" alt=""/>', $banner );
                    }
                }
            ?>
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
		$instance['usevideo'] = ($new_instance['usevideo']);
		$instance['videocontrol'] = ($new_instance['videocontrol']);
		$instance['banner'] = ($new_instance['banner']);
        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' ),
            'usevideo' => '',
            'videocontrol' => '',
            'banner' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Subtitle', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>"
        name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>"
        id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('usevideo')); ?>"><?php esc_html_e('Use Video(URL Media)', ''); ?></label>
    <input class="widefat" type="checkbox" value="true"
        <?php echo $instance['usevideo'] == 'true'?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('usevideo')); ?>"
        id="<?php echo esc_attr($this->get_field_id('usevideo')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('videocontrol')); ?>"><?php esc_html_e('Use Video(Control)', ''); ?></label>
    <input class="widefat" type="checkbox" value="true"
        <?php echo $instance['videocontrol'] == 'true'?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('videocontrol')); ?>"
        id="<?php echo esc_attr($this->get_field_id('videocontrol')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('banner')); ?>"><?php esc_html_e('Banner', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('banner')); ?>"
        id="<?php echo esc_attr($this->get_field_id('banner')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['banner']); ?></textarea>
</p>
<?php
    }
}