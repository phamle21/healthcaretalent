<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_testimonial extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_testimonial', 'Tried Home Testimonial',
			array(
				'classname' => 'widget_home_testimonial',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
		$defaults = array(
			'title' => __( 'Title', 'tried' ),
            'testimonials_title' => array(),
			'testimonials_subtitle' => array(),
			'testimonials_image' => array(),
			'testimonials_content' => array()
		);
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];

		$testimonials_title = $instance['testimonials_title'];
		$testimonials_subtitle = $instance['testimonials_subtitle'];
		$testimonials_image = $instance['testimonials_image'];
		$testimonials_content = $instance['testimonials_content'];

		$key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-testimonial"
    data-control="<?php echo $key; ?>">
    <h3 class="section-title"><?php echo $title; ?></h3>
    <div class="section-navbutton mwidth-main margin-auto">
        <div class="swiper-button swiper-button-prev" key="<?php echo $key; ?>"></div>
        <div class="swiper-button swiper-button-next" key="<?php echo $key; ?>"></div>
    </div>
    <div class="section-wrapper margin-auto">
        <div class="swiper widget-home-testimonial">
            <div class="swiper-wrapper">
                <?php
					if ( !empty( $testimonials_title ) ) {
						for ( $l = 0; $l < count( $testimonials_title ); $l++ ) {
							if ( empty( $testimonials_title[$l] ) ) continue;
                            $testimonialImage = !empty( $testimonials_image[$l] ) ? $testimonials_image[$l] : get_theme_file_uri( "/assets/img/logo.jpg" );
							printf(
								'<div class="testimonial-item swiper-slide">
									<div class="wrap">
                                        <div class="mega-box">
                                            <div class="featured-image">
                                                <img src="%s" alt="">
                                            </div>
											<h4 class="title">%s</h4>
											<h6 class="subtitle">%s</h6>
                                        </div>
										<div class="info-box">
											<p class="content">%s</p>
										</div>
									</div>
								</div>',
								$testimonialImage, $testimonials_title[$l], $testimonials_subtitle[$l], $testimonials_content[$l]
							);
						}
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
		$instance['title'] = ($new_instance['title']);
		$instance['testimonials_title'] = ($new_instance['testimonials_title']);
		$instance['testimonials_subtitle'] = ($new_instance['testimonials_subtitle']);
		$instance['testimonials_image'] = ($new_instance['testimonials_image']);
		$instance['testimonials_content'] = ($new_instance['testimonials_content']);
        return $instance;
    }

    function form($instance) {
		$defaults = array(
			'title' => __( 'Title', 'tried' ),
            'testimonials_title' => array(),
			'testimonials_subtitle' => array(),
			'testimonials_image' => array(),
			'testimonials_content' => array()

		);
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<h4><?php _e( 'List links', 'tried' ); ?><a class="button button-primary addnew-reclistlink" href="javascript:void(0)"
        title="<?php _e( 'Add new', 'tried' ); ?>" style="float: right;"><?php _e( 'Add new', 'tried' ); ?></a></h4>
<div class="reclistlinks">
    <?php
        if ( $instance['testimonials_title'] ) {
            foreach ( $instance['testimonials_title'] as $l => $litem ) {
                echo '<div class="reclistlink-item">'
                . '<h4>'.__( 'Item', 'tried' ).'<a href="javascript:void(0)" title="'.__( 'Remove', 'tried' ).'">'.__( 'Remove', 'tried' ).'</a></h4>'
                . '<p class="link"><label for="'.esc_attr($this->get_field_id('testimonials_title')).'-'.$l.'">'.__('Title', '').'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['testimonials_title'][$l]).'" name="'.esc_attr($this->get_field_name('testimonials_title')).'[]" id="'.esc_attr($this->get_field_id('testimonials_title')).'-'.$l.'" /></p>'
                . '<p class="link"><label for="'.esc_attr($this->get_field_id('testimonials_subtitle')).'-'.$l.'">'.__('Subtitle', '').'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['testimonials_subtitle'][$l]).'" name="'.esc_attr($this->get_field_name('testimonials_subtitle')).'[]" id="'.esc_attr($this->get_field_id('testimonials_subtitle')).'-'.$l.'" /></p>'
				. '<p class="title"><label for="'.esc_attr($this->get_field_id('testimonials_content')).'-'.$l.'">'.__('Content', '').'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('testimonials_content')).'[]"
                id="'.esc_attr($this->get_field_id('testimonials_content')).'-1" cols="30"
                rows="4">'.esc_attr($instance['testimonials_content'][$l]).'</textarea></p>'
				. '<p class="link"><label
                for="'.esc_attr($this->get_field_id('testimonials_image')).'-'.$l.'">'.__('Image', '').'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['testimonials_image'][$l]).'" name="'.esc_attr($this->get_field_name('testimonials_image')).'[]" id="'.esc_attr($this->get_field_id('testimonials_image')).'-'.$l.'" /></p>'
				. '</div>';
            }
        } else {
            echo '<div class="reclistlink-item">'
            . '<h4>'.__( 'Item', 'tried' ).'</h4>'
			. '<p class="link"><label for="'.esc_attr($this->get_field_id('testimonials_title')).'-1">'.__('Title', '').'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('testimonials_title')).'[]" id="'.esc_attr($this->get_field_id('testimonials_title')).'-1" /></p>'
			. '<p class="link"><label for="'.esc_attr($this->get_field_id('testimonials_subtitle')).'-1">'.__('Subtitle', '').'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('testimonials_subtitle')).'[]" id="'.esc_attr($this->get_field_id('testimonials_subtitle')).'-1" /></p>'
            . '<p class="title"><label for="'.esc_attr($this->get_field_id('testimonials_content')).'-1">'.__('Content', '').'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('testimonials_content')).'[]"
            id="'.esc_attr($this->get_field_id('testimonials_content')).'-1" cols="30"
            rows="4"></textarea></p>'
			. '<p class="link"><label for="'.esc_attr($this->get_field_id('testimonials_image')).'-1">'.__('Image', '').'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('testimonials_image')).'[]" id="'.esc_attr($this->get_field_id('testimonials_image')).'-1" /></p>'
			. '</div>';
        }
    ?>
</div>
<style>
.reclistlinks {
    counter-reset: reclistquotes;
    padding-top: 5px;
}

.reclistlinks .reclistlink-item>h4::after {
    counter-increment: reclistquotes;
    content: counter(reclistquotes);
    margin-left: 5px;
}

.reclistlinks .reclistlink-item>h4>a {
    position: absolute;
    right: 16px;
}
</style>
<?php
    }
}