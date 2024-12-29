<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_textarea extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_textarea', 'Tried Header Textarea',
			array(
				'classname' => 'widget_header_textarea',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array(
            'description' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		$description = $instance['description'];
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-textarea">
    <div class="section-wrapper margin-auto">
        <p><?php echo $description; ?></p>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
    
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['description'] = ($new_instance['description']);
        return $instance;
    }
    
    function form($instance) {
	    $defaults = array(
            'description' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        ?>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Mô tả', 'tried'); ?></label>
    <textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('description')); ?>"
        id="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php echo esc_attr($instance['description']); ?></textarea>
</p>
<?php
    }
}