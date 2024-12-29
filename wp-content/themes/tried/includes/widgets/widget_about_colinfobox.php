<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_about_colinfobox extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_about_colinfobox', 'Tried About Column Infobox',
			array(
				'classname' => 'widget_about_colinfobox',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'title2' => __( 'Title', 'tried' ),
            'content2' => __( 'Content', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		
		$title = $instance['title'];
		$content = $instance['content'];

		$title2 = $instance['title2'];
		$content2 = $instance['content2'];

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-about-colinfobox">
    <div class="section-wrapper margin-auto">
        <div class="infobox-block">
            <div class="infoboxs">
                <div class="infobox-item">
                    <div class="wrap">
                        <span></span>
                        <h5><?php echo $title; ?></h5>
                        <p><?php echo $content; ?></p>
                    </div>
                </div>
                <div class="infobox-item">
                    <div class="wrap">
                        <span></span>
                        <h5><?php echo $title2; ?></h5>
                        <p><?php echo $content2; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();

		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);

		$instance['title2'] = ($new_instance['title2']);
		$instance['content2'] = ($new_instance['content2']);

        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'title2' => __( 'Title', 'tried' ),
            'content2' => __( 'Content', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info block', 'tried' ); ?></h4>
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
<h4><?php _e( 'Info 2 block', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title2')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title2')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content2')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content2')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content2']); ?></textarea>
</p>
<?php
    }
}