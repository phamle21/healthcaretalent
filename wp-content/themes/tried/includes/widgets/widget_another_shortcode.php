<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_shortcode extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_shortcode', 'Tried Another Shortcode',
			array(
				'classname' => 'widget_another_shortcode',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('shortcode' => '');
        $instance = wp_parse_args($instance, $defaults);
		$shortcode = $instance['shortcode'];
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-another-shortcode">
    <div class="section-wrapper margin-auto">
        <div class="shortcode-block">
            <?php
                            if (!empty($shortcode)) :
                                echo do_shortcode($shortcode);
                            endif;
                        ?>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['shortcode'] = ($new_instance['shortcode']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array('shortcode' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('shortcode')); ?>"><?php esc_html_e('Code ngắn(shortcode)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['shortcode']); ?>"
        name="<?php echo esc_attr($this->get_field_name('shortcode')); ?>"
        id="<?php echo esc_attr($this->get_field_id('shortcode')); ?>" />
</p>
<?php
    }
}