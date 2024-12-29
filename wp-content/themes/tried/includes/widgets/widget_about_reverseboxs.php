<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_about_reverseboxs extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_about_reverseboxs', 'Tried About Reverse Boxs',
			array(
				'classname' => 'widget_about_reverseboxs',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ),
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'image' => '',
            'subtitle2' => __( 'Subtitle', 'tried' ),
            'title2' => __( 'Title', 'tried' ),
            'content2' => __( 'Content', 'tried' ),
            'image2' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		
		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
		$content = $instance['content'];
		$image = $instance['image'] ? $instance['image'] : get_theme_file_uri( '/assets/img/placeholder.png' );

		$subtitle2 = $instance['subtitle2'];
		$title2 = $instance['title2'];
		$content2 = $instance['content2'];
		$image2 = $instance['image2'] ? $instance['image2'] : get_theme_file_uri( '/assets/img/placeholder.png' );

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-about-reverseboxs">
    <div class="section-wrapper margin-auto">
        <div class="reverseboxs-block">
            <div class="reverseboxs">
                <?php
                    if ( !empty( $title ) && !empty( $content ) ) {
                        printf(
                            '<div class="reversebox-item">
                                <div class="wrap">
                                    <div>
                                        <h6>%s</h6>
                                        <h5>%s</h5>
                                        <p>%s</p>
                                    </div>
                                    <div>
                                        <img src="%s" alt=""/>
                                    </div>
                                </div>
                            </div>',
                            $subtitle, $title, $content, $image
                        );
                    }
                    if ( !empty( $title2 ) && !empty( $content2 ) ) {
                        printf(
                            '<div class="reversebox-item">
                                <div class="wrap">
                                    <div>
                                        <h6>%s</h6>
                                        <h5>%s</h5>
                                        <p>%s</p>
                                    </div>
                                    <div>
                                        <img src="%s" alt=""/>
                                    </div>
                                </div>
                            </div>',
                            $subtitle2, $title2, $content2, $image2
                        );
                    }
                ?>
            </div>
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
		$instance['content'] = ($new_instance['content']);
		$instance['image'] = ($new_instance['image']);

		$instance['subtitle2'] = ($new_instance['subtitle2']);
		$instance['title2'] = ($new_instance['title2']);
		$instance['content2'] = ($new_instance['content2']);
		$instance['image2'] = ($new_instance['image2']);

        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ),
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'image' => '',
            'subtitle2' => __( 'Subtitle', 'tried' ),
            'title2' => __( 'Title', 'tried' ),
            'content2' => __( 'Content', 'tried' ),
            'image2' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Box 1 block', 'tried' ); ?></h4>
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
    <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content']); ?></textarea>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_html_e('Image', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('image')); ?>"
        id="<?php echo esc_attr($this->get_field_id('image')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['image']); ?></textarea>
</p>
<h4><?php _e( 'Box 2 block', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('subtitle2')); ?>"><?php esc_html_e('Subtitle', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['subtitle2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('subtitle2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('subtitle2')); ?>" />
</p>
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
        rows="2"><?php echo esc_attr($instance['content2']); ?></textarea>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('image2')); ?>"><?php esc_html_e('Image', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('image2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('image2')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['image2']); ?></textarea>
</p>
<?php
    }
}