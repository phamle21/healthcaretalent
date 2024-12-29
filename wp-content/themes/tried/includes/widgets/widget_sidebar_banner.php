<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_sidebar_banner extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_sidebar_banner', 'Tried Sidebar Banner',
			array(
				'classname' => 'widget_sidebar_banner',
				'description' => esc_html__('Sidebar Banner', 'tried'),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array(
            'background' => '', 'title' => __('Giới thiệu',' tried'), 'content' => '', 'viewmore' => __( 'View More', 'tried' ), 'viewmore_link' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		$background = $instance['background'];
		$title = $instance['title'];
		$content = $instance['content'];
		$viewmore = $instance['viewmore'];
		$viewmore_link = $instance['viewmore_link'];
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-sidebar-banner">
    <div class="section-wrapper">
        <div class="background-block"
            <?php echo !empty($background)?'style="background-image: url('.$background.');"':''; ?>>
        </div>
        <div class="info-block">
            <h4 class="title"><?php echo $title; ?></h4>
            <p class="content"><?php echo $content; ?></p>
            <?php if ( !empty( $viewmore_link ) ) { ?>
            <a class="viewmore" href="<?php echo $viewmore_link; ?>"
                title="<?php echo $title; ?>"><?php echo $viewmore; ?></a>
            <?php } ?>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
	}

	function update($new_instance, $old_instance) {
		$instance = array();
		$instance['background'] = $new_instance['background'];
		$instance['title'] = $new_instance['title'];
		$instance['content'] = $new_instance['content'];
		$instance['viewmore'] = $new_instance['viewmore'];
		$instance['viewmore_link'] = $new_instance['viewmore_link'];
		return $instance;
	}

	function form($instance) {
		$defaults = array(
            'background' => '', 'title' => __('Title',' tried'), 'content' => '', 'viewmore' => __( 'View More', 'tried' ), 'viewmore_link' => ''
        );
		$instance = wp_parse_args($instance, $defaults);
		?>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('background')); ?>"><?php esc_html_e('Background image', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['background']); ?>"
        name="<?php echo esc_attr($this->get_field_name('background')); ?>"
        id="<?php echo esc_attr($this->get_field_id('background')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" rows="3" name="<?php echo esc_attr($this->get_field_name('content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmore')); ?>"><?php esc_html_e('Viewmore', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmore']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmore')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmore')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmore_link')); ?>"><?php esc_html_e('Viewmore Link', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmore_link']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmore_link')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmore_link')); ?>" />
</p>
<?php
	}
}