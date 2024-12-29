<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_boxcontact extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_boxcontact', 'Tried Home Box Contact',
			array(
				'classname' => 'widget_home_boxcontact',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array(
            'icon' => 'fas fa-users', 'title' => __( 'Title', 'tried' ), 'content' => __( 'Content', 'tried' ), 'readmore' => 'Xem thêm', 'link_readmore' => '',
            'icon2' => 'fas fa-users', 'title2' => __( 'Title', 'tried' ), 'content2' => __( 'Content', 'tried' ), 'readmore2' => 'Xem thêm', 'link_readmore2' => '',
            'icon3' => 'fas fa-users', 'title3' => __( 'Title', 'tried' ), 'content3' => __( 'Content', 'tried' ), 'readmore3' => 'Xem thêm', 'link_readmore3' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		$icon = $instance['icon'];
		$title = $instance['title'];
		$content = $instance['content'];
		$readmore = $instance['readmore'];
		$link_readmore = $instance['link_readmore'];

		$icon2 = $instance['icon2'];
		$title2 = $instance['title2'];
		$content2 = $instance['content2'];
		$readmore2 = $instance['readmore2'];
		$link_readmore2 = $instance['link_readmore2'];

		$icon3 = $instance['icon3'];
		$title3 = $instance['title3'];
		$content3 = $instance['content3'];
		$readmore3 = $instance['readmore3'];
		$link_readmore3 = $instance['link_readmore3'];
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-boxcontact">
    <div class="section-wrapper margin-auto">
        <div class="boxscontact-block">
            <div class="boxcontact-item">
                <i class="icon <?php echo $icon; ?>"></i>
                <h4 class="title"><?php echo $title; ?></h4>
                <p class="content"><?php echo $content; ?></p>
                <a href="<?php echo $link_readmore; ?>" class="readmore"><?php echo $readmore; ?></a>
            </div>
            <div class="boxcontact-item">
                <i class="icon <?php echo $icon2; ?>"></i>
                <h4 class="title"><?php echo $title2; ?></h4>
                <p class="content"><?php echo $content2; ?></p>
                <a href="<?php echo $link_readmore2; ?>" class="readmore"><?php echo $readmore2; ?></a>
            </div>
            <div class="boxcontact-item">
                <i class="icon <?php echo $icon3; ?>"></i>
                <h4 class="title"><?php echo $title3; ?></h4>
                <p class="content"><?php echo $content3; ?></p>
                <a href="<?php echo $link_readmore3; ?>" class="readmore"><?php echo $readmore3; ?></a>
            </div>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['icon'] = ($new_instance['icon']);
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['readmore'] = ($new_instance['readmore']);
		$instance['link_readmore'] = ($new_instance['link_readmore']);

		$instance['icon2'] = ($new_instance['icon2']);
		$instance['title2'] = ($new_instance['title2']);
		$instance['content2'] = ($new_instance['content2']);
		$instance['readmore2'] = ($new_instance['readmore2']);
		$instance['link_readmore2'] = ($new_instance['link_readmore2']);

		$instance['icon3'] = ($new_instance['icon3']);
		$instance['title3'] = ($new_instance['title3']);
		$instance['content3'] = ($new_instance['content3']);
		$instance['readmore3'] = ($new_instance['readmore3']);
		$instance['link_readmore3'] = ($new_instance['link_readmore3']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array(
            'icon' => 'fas fa-users', 'title' => __( 'Title', 'tried' ), 'content' => __( 'Content', 'tried' ), 'readmore' => 'Xem thêm', 'link_readmore' => '',
            'icon2' => 'fas fa-users', 'title2' => __( 'Title', 'tried' ), 'content2' => __( 'Content', 'tried' ), 'readmore2' => 'Xem thêm', 'link_readmore2' => '',
            'icon3' => 'fas fa-users', 'title3' => __( 'Title', 'tried' ), 'content3' => __( 'Content', 'tried' ), 'readmore3' => 'Xem thêm', 'link_readmore3' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Hộp thông tin 1', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('icon')); ?>"><?php esc_html_e('Icon', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['icon']); ?>"
        name="<?php echo esc_attr($this->get_field_name('icon')); ?>"
        id="<?php echo esc_attr($this->get_field_id('icon')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('readmore')); ?>"><?php esc_html_e('Xem thêm', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['readmore']); ?>"
        name="<?php echo esc_attr($this->get_field_name('readmore')); ?>"
        id="<?php echo esc_attr($this->get_field_id('readmore')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('link_readmore')); ?>"><?php esc_html_e('Link xem thêm', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['link_readmore']); ?>"
        name="<?php echo esc_attr($this->get_field_name('link_readmore')); ?>"
        id="<?php echo esc_attr($this->get_field_id('link_readmore')); ?>" />
</p>
<h4><?php _e( 'Hộp thông tin 2', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('icon2')); ?>"><?php esc_html_e('Icon', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['icon2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('icon2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('icon2')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title2')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title2')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content2')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('content2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content2')); ?>"><?php echo esc_attr($instance['content2']); ?></textarea>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('readmore2')); ?>"><?php esc_html_e('Xem thêm', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['readmore2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('readmore2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('readmore2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('link_readmore2')); ?>"><?php esc_html_e('Link xem thêm', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['link_readmore2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('link_readmore2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('link_readmore2')); ?>" />
</p>
<h4><?php _e( 'Hộp thông tin 3', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('icon3')); ?>"><?php esc_html_e('Icon', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['icon3']); ?>"
        name="<?php echo esc_attr($this->get_field_name('icon3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('icon3')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title3')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title3']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title3')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content3')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('content3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content3')); ?>"><?php echo esc_attr($instance['content3']); ?></textarea>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('readmore3')); ?>"><?php esc_html_e('Xem thêm', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['readmore3']); ?>"
        name="<?php echo esc_attr($this->get_field_name('readmore3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('readmore3')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('link_readmore3')); ?>"><?php esc_html_e('Link xem thêm', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['link_readmore3']); ?>"
        name="<?php echo esc_attr($this->get_field_name('link_readmore3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('link_readmore3')); ?>" />
</p>
<?php
    }
}