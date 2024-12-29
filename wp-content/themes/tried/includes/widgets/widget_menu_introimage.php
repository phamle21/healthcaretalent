<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_menu_introimage extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_menu_introimage', 'Tried Menu introimage',
			array(
				'classname' => 'widget_menu_introimage',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array(
            'image' => 'image',
            'title' => '',
            'content' => '',
            'viewmore' => '',
            'link_viewmore' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$content = $instance['content'];
		$viewmore = $instance['viewmore']?$instance['viewmore']:__( 'View more', 'tried' );
		$link_viewmore = $instance['link_viewmore'];
        $image = $instance['image'];
        $image_url = get_theme_file_uri( "/assets/img/placeholder.png" );
        if ( !empty( $image ) ) {
            $image_url = $image;
        }
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-menu-introimage">
    <div class="section-wrapper margin-auto">
        <div class="image-block">
            <img src="<?php echo $image_url; ?>" alt="">
        </div>
        <div class="content-block">
            <h3 class="title mwidth-main margin-auto"><?php echo $title; ?></h3>
            <div class="content">
                <?php echo $content; ?>
            </div>
            <?php if ( !empty( $link_viewmore ) ) { ?>
            <a class="viewmore" href="<?php echo $link_viewmore; ?>"><?php echo $viewmore; ?></a>
            <?php } ?>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['image'] = ($new_instance['image']);
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['viewmore'] = ($new_instance['viewmore']);
		$instance['link_viewmore'] = ($new_instance['link_viewmore']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array(
            'image' => '',
            'title' => '',
            'content' => '',
            'viewmore' => '',
            'link_viewmore' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_html_e('Hình ảnh(link)', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['image']); ?>"
        name="<?php echo esc_attr($this->get_field_name('image')); ?>"
        id="<?php echo esc_attr($this->get_field_id('image')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Mô tả', 'tried'); ?></label>
    <textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmore')); ?>"><?php esc_html_e('Xem thêm', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmore']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmore')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmore')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('link_viewmore')); ?>"><?php esc_html_e('Link xem thêm', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['link_viewmore']); ?>"
        name="<?php echo esc_attr($this->get_field_name('link_viewmore')); ?>"
        id="<?php echo esc_attr($this->get_field_id('link_viewmore')); ?>" />
</p>
<?php
    }
}