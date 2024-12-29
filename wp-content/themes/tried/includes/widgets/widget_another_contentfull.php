<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_contentfull extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_contentfull', 'Tried Another Content(Full)',
			array(
				'classname' => 'widget_another_contentfull',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		
		$subtitle = $instance['subtitle'];
		$title = $instance['title'];

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-another-content">
    <div class="section-wrapper margin-auto">
        <div class="info-block full">
            <h5><?php echo $subtitle; ?></h5>
            <h3><?php echo $title; ?></h3>
        </div>
        <div class="content-block full">
            <div class="contents"><?php the_content(); ?></div>
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
        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' )
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
    <span><?php _e( 'The content will be taken from the page content.'); ?></span>
</p>
<?php
    }
}