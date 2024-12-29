<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_event_infoimage extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_event_infoimage', 'Tried Event Info Image',
			array(
				'classname' => 'widget_event_infoimage',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ),
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'image' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		
		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
		$content = $instance['content'];
		$image = $instance['image'] ? $instance['image'] : get_theme_file_uri( '/assets/img/placeholder.png' );

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-event-infoimage">
    <div class="section-wrapper margin-auto">
        <div class="infoimage-block">
            <div class="infoimages">
                <?php
                    if ( !empty( $title ) && !empty( $content ) ) {
                        printf(
                            '<div class="infoimage-item">
                                <div class="wrap">
                                    <div>
                                        <h6>%s</h6>
                                        <h5>%s</h5>
                                        <p>%s</p>
                                    </div>
                                    <div>
                                        <img src="%s" alt=""/>
                                    </div>
                                </div>
                            </div>',
                            $subtitle, $title, $content, $image
                        );
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();

		$instance['subtitle'] = ($new_instance['subtitle']);
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['image'] = ($new_instance['image']);

        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ),
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'image' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info Image block', 'tried' ); ?></h4>
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
<p>
    <label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_html_e('Image', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('image')); ?>"
        id="<?php echo esc_attr($this->get_field_id('image')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['image']); ?></textarea>
</p>
<?php
    }
}