<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_bannernormal extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_bannernormal', 'Tried Another Banner Normal',
			array(
				'classname' => 'widget_another_bannernormal',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'subtitle' => '',
            'banner_image' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        
        $subtitle = $instance['subtitle'];
        if ( !$subtitle ) {
            if ( wp_get_post_parent_id( get_the_ID() ) != 0 ) {
                $subtitle = get_the_title( wp_get_post_parent_id( get_the_ID() ) );
            }
        }
        $banner_image = get_theme_file_uri( '/assets/img/contact-us-mp-us.jpg' );
        if ( !empty( $instance['banner_image'] ) ) {
            $banner_image = $instance['banner_image'];
        }
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another_bannernormal">
    <div class="banner-block non-viewmode">
        <div class="background-banner" style="background-image: url(<?php echo $banner_image; ?>);"></div>
        <h4 class="subtitle-banner margin-auto"><?php echo $subtitle; ?></h4>
        <h4 class="title-banner margin-auto"><?php echo get_the_title(); ?></h4>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['banner_image'] = ($new_instance['banner_image']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'subtitle' => '',
            'banner_image' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Sutitle', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>"
        name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>"
        id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" />
</p>
<h4><?php _e( 'Banner', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('banner_image')); ?>"><?php esc_html_e('Background Image(link)', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['banner_image']); ?>"
        name="<?php echo esc_attr($this->get_field_name('banner_image')); ?>"
        id="<?php echo esc_attr($this->get_field_id('banner_image')); ?>" />
</p>
<?php
    }
}