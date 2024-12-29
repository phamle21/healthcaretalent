<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_jobpost_form extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_jobpost_form', 'Tried Jobpost Form',
			array(
				'classname' => 'widget_jobpost_form',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Request a Call Back', 'tried' ), 'content' => '', 'shortcode' => '', 'terms' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$content = $instance['content'];
		$shortcode = $instance['shortcode'];
		$terms = $instance['terms'];

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-jobpost-requestback_form">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h4><?php echo $title; ?></h4>
            <div><?php echo $content; ?></div>
        </div>
        <div class="form-block">
            <?php
                if ( !empty( $shortcode ) ) {
                    echo do_shortcode( $shortcode );
                }
            ?>
        </div>
        <div class="terms-block">
            <div><?php echo $terms; ?></div>
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
		$instance['shortcode'] = ($new_instance['shortcode']);
		$instance['terms'] = ($new_instance['terms']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => __( 'Request a Call Back', 'tried' ), 'content' => '', 'shortcode' => '', 'terms' => ''
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
    <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" rows="4" name="<?php echo esc_attr($this->get_field_name('content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('shortcode')); ?>"><?php esc_html_e('Shortcode', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['shortcode']); ?>"
        name="<?php echo esc_attr($this->get_field_name('shortcode')); ?>"
        id="<?php echo esc_attr($this->get_field_id('shortcode')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('terms')); ?>"><?php esc_html_e('Terms and Conditions', ''); ?></label>
    <?php wp_editor( esc_attr($instance['terms']), esc_attr($this->get_field_name('terms')) ); ?>
</p>
<?php
    }
}