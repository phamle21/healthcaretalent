<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_event_info extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_event_info', 'Tried Event Info',
			array(
				'classname' => 'widget_event_info',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ),
            'title' => __( 'Title', 'tried' ),
            'suptitle' => __( 'Suptitle', 'tried' ),
            'content' => __( 'Content', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);

		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
		$suptitle = $instance['suptitle'];
		$content = $instance['content'];

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-event-info">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h4>
                <span><?php echo $subtitle; ?></span>
                <span><?php echo $title; ?></span>
                <span><?php echo $suptitle; ?></span>
            </h4>
        </div>
        <div class="content-block">
            <div><?php echo $content; ?></div>
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
		$instance['suptitle'] = ($new_instance['suptitle']);
		$instance['content'] = ($new_instance['content']);

        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ),
            'title' => __( 'Title', 'tried' ),
            'suptitle' => __( 'Suptitle', 'tried' ),
            'content' => __( 'Content', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
        ?>
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
    <label for="<?php echo esc_attr($this->get_field_id('suptitle')); ?>"><?php esc_html_e('Suptitle', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['suptitle']); ?>"
        name="<?php echo esc_attr($this->get_field_name('suptitle')); ?>"
        id="<?php echo esc_attr($this->get_field_id('suptitle')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <?php wp_editor( esc_attr($instance['content']), esc_attr($this->get_field_name('content')) ); ?>
</p>
<?php
    }
}