<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_text extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_text', 'Tried Another Text',
			array(
				'classname' => 'widget_another_text',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => '', 'content' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$content = $instance['content'];
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-another-text">
    <div class="section-wrapper margin-auto">
        <h4 class="title"><?php echo $title; ?></h4>
        <div class="content">
            <?php echo $content; ?>
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
        return $instance;
    }

    function form($instance) {
	    $defaults = array('title' => '', 'content' => '');
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
    <?php wp_editor( esc_attr($instance['content']), esc_attr($this->get_field_name('content')) ); ?>
</p>
<?php
    }
}