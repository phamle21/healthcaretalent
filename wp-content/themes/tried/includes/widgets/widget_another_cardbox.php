<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_cardbox extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_cardbox', 'Tried Another Cardbox',
			array(
				'classname' => 'widget_another_cardbox',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'banner' => '',
            'cardbox_image' => '', 'cardbox_title' => __( 'Title', 'tried' ), 'cardbox_content' => __( 'Content', 'tried' ),
            'cardbox_image2' => '', 'cardbox_title2' => __( 'Title', 'tried' ), 'cardbox_content2' => __( 'Content', 'tried' ),
            'cardbox_image3' => '', 'cardbox_title3' => __( 'Title', 'tried' ), 'cardbox_content3' => __( 'Content', 'tried' ),
            'cardbox_image4' => '', 'cardbox_title4' => __( 'Title', 'tried' ), 'cardbox_content4' => __( 'Content', 'tried' ),
            'cardbox_image5' => '', 'cardbox_title5' => __( 'Title', 'tried' ), 'cardbox_content5' => __( 'Content', 'tried' ),
            'cardbox_image6' => '', 'cardbox_title6' => __( 'Title', 'tried' ), 'cardbox_content6' => __( 'Content', 'tried' ),
            'cardbox_image7' => '', 'cardbox_title7' => __( 'Title', 'tried' ), 'cardbox_content7' => __( 'Content', 'tried' ),
            'cardbox_image8' => '', 'cardbox_title8' => __( 'Title', 'tried' ), 'cardbox_content8' => __( 'Content', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		
		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
        $content = $instance['content'];
        $banner = $instance['banner'] ? $instance['banner'] : get_theme_file_uri( '/assets/img/placeholder.png' );

        $cardbox_image = $instance['cardbox_image'];
        $cardbox_title = $instance['cardbox_title'];
        $cardbox_content = $instance['cardbox_content'];

        $cardbox_image2 = $instance['cardbox_image2'];
        $cardbox_title2 = $instance['cardbox_title2'];
        $cardbox_content2 = $instance['cardbox_content2'];

        $cardbox_image3 = $instance['cardbox_image3'];
        $cardbox_title3 = $instance['cardbox_title3'];
        $cardbox_content3 = $instance['cardbox_content3'];

        $cardbox_image4 = $instance['cardbox_image4'];
        $cardbox_title4 = $instance['cardbox_title4'];
        $cardbox_content4 = $instance['cardbox_content4'];

        $cardbox_image5 = $instance['cardbox_image5'];
        $cardbox_title5 = $instance['cardbox_title5'];
        $cardbox_content5 = $instance['cardbox_content5'];

        $cardbox_image6 = $instance['cardbox_image6'];
        $cardbox_title6 = $instance['cardbox_title6'];
        $cardbox_content6 = $instance['cardbox_content6'];

        $cardbox_image7 = $instance['cardbox_image7'];
        $cardbox_title7 = $instance['cardbox_title7'];
        $cardbox_content7 = $instance['cardbox_content7'];

        $cardbox_image8 = $instance['cardbox_image8'];
        $cardbox_title8 = $instance['cardbox_title8'];
        $cardbox_content8 = $instance['cardbox_content8'];

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-another-cardbox">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h6><?php echo $subtitle; ?></h6>
            <div>
                <h5><?php echo $title; ?></h5>
                <p><?php echo $content; ?></p>
            </div>
        </div>
        <div class="cardbox-block">
            <div class="cardboxs">
                <?php if ( $cardbox_title || $cardbox_title2 || $cardbox_title3 || $cardbox_title4 || $cardbox_title5 || $cardbox_title6 || $cardbox_title7 || $cardbox_title8) { ?>
                    <div class="swiper widget-another-cardbox">
                        <div class="swiper-wrapper">
                            <?php
                                if ( !empty( $cardbox_title ) && !empty( $cardbox_content ) ) {
                                    printf(
                                        '<div class="cardbox-item swiper-slide">
                                            <div class="wrap">
                                                <img src="%s" alt=""/>
                                                <h5>%s</h5>
                                                <p>%s</p>
                                            </div>
                                        </div>',
                                        $cardbox_image, $cardbox_title, $cardbox_content
                                    );
                                }
                                if ( !empty( $cardbox_title2 ) && !empty( $cardbox_content2 ) ) {
                                    printf(
                                        '<div class="cardbox-item swiper-slide">
                                            <div class="wrap">
                                                <img src="%s" alt=""/>
                                                <h5>%s</h5>
                                                <p>%s</p>
                                            </div>
                                        </div>',
                                        $cardbox_image2, $cardbox_title2, $cardbox_content2
                                    );
                                }
                                if ( !empty( $cardbox_title3 ) && !empty( $cardbox_content3 ) ) {
                                    printf(
                                        '<div class="cardbox-item swiper-slide">
                                            <div class="wrap">
                                                <img src="%s" alt=""/>
                                                <h5>%s</h5>
                                                <p>%s</p>
                                            </div>
                                        </div>',
                                        $cardbox_image3, $cardbox_title3, $cardbox_content3
                                    );
                                }
                                if ( !empty( $cardbox_title4 ) && !empty( $cardbox_content4 ) ) {
                                    printf(
                                        '<div class="cardbox-item swiper-slide">
                                            <div class="wrap">
                                                <img src="%s" alt=""/>
                                                <h5>%s</h5>
                                                <p>%s</p>
                                            </div>
                                        </div>',
                                        $cardbox_image4, $cardbox_title4, $cardbox_content4
                                    );
                                }
                                if ( !empty( $cardbox_title5 ) && !empty( $cardbox_content5 ) ) {
                                    printf(
                                        '<div class="cardbox-item swiper-slide">
                                            <div class="wrap">
                                                <img src="%s" alt=""/>
                                                <h5>%s</h5>
                                                <p>%s</p>
                                            </div>
                                        </div>',
                                        $cardbox_image5, $cardbox_title5, $cardbox_content5
                                    );
                                }
                                if ( !empty( $cardbox_title6 ) && !empty( $cardbox_content6 ) ) {
                                    printf(
                                        '<div class="cardbox-item swiper-slide">
                                            <div class="wrap">
                                                <img src="%s" alt=""/>
                                                <h5>%s</h5>
                                                <p>%s</p>
                                            </div>
                                        </div>',
                                        $cardbox_image6, $cardbox_title6, $cardbox_content6
                                    );
                                }
                                if ( !empty( $cardbox_title7 ) && !empty( $cardbox_content7 ) ) {
                                    printf(
                                        '<div class="cardbox-item swiper-slide">
                                            <div class="wrap">
                                                <img src="%s" alt=""/>
                                                <h5>%s</h5>
                                                <p>%s</p>
                                            </div>
                                        </div>',
                                        $cardbox_image7, $cardbox_title7, $cardbox_content7
                                    );
                                }
                                if ( !empty( $cardbox_title8 ) && !empty( $cardbox_content8 ) ) {
                                    printf(
                                        '<div class="cardbox-item swiper-slide">
                                            <div class="wrap">
                                                <img src="%s" alt=""/>
                                                <h5>%s</h5>
                                                <p>%s</p>
                                            </div>
                                        </div>',
                                        $cardbox_image8, $cardbox_title8, $cardbox_content8
                                    );
                                }
                            ?>
                        </div>
                    </div>
                <?php } ?>
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
		$instance['subtitle'] = ($new_instance['subtitle']);
		$instance['content'] = ($new_instance['content']);

		$instance['cardbox_image'] = ($new_instance['cardbox_image']);
		$instance['cardbox_title'] = ($new_instance['cardbox_title']);
		$instance['cardbox_content'] = ($new_instance['cardbox_content']);

		$instance['cardbox_image2'] = ($new_instance['cardbox_image2']);
		$instance['cardbox_title2'] = ($new_instance['cardbox_title2']);
		$instance['cardbox_content2'] = ($new_instance['cardbox_content2']);

		$instance['cardbox_image3'] = ($new_instance['cardbox_image3']);
		$instance['cardbox_title3'] = ($new_instance['cardbox_title3']);
		$instance['cardbox_content3'] = ($new_instance['cardbox_content3']);

		$instance['cardbox_image4'] = ($new_instance['cardbox_image4']);
		$instance['cardbox_title4'] = ($new_instance['cardbox_title4']);
		$instance['cardbox_content4'] = ($new_instance['cardbox_content4']);

		$instance['cardbox_image5'] = ($new_instance['cardbox_image5']);
		$instance['cardbox_title5'] = ($new_instance['cardbox_title5']);
		$instance['cardbox_content5'] = ($new_instance['cardbox_content5']);

		$instance['cardbox_image6'] = ($new_instance['cardbox_image6']);
		$instance['cardbox_title6'] = ($new_instance['cardbox_title6']);
		$instance['cardbox_content6'] = ($new_instance['cardbox_content6']);

		$instance['cardbox_image7'] = ($new_instance['cardbox_image7']);
		$instance['cardbox_title7'] = ($new_instance['cardbox_title7']);
		$instance['cardbox_content7'] = ($new_instance['cardbox_content7']);

		$instance['cardbox_image8'] = ($new_instance['cardbox_image8']);
		$instance['cardbox_title8'] = ($new_instance['cardbox_title8']);
		$instance['cardbox_content8'] = ($new_instance['cardbox_content8']);

        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'banner' => '',
            'cardbox_image' => '', 'cardbox_title' => __( 'Title', 'tried' ), 'cardbox_content' => __( 'Content', 'tried' ),
            'cardbox_image2' => '', 'cardbox_title2' => __( 'Title', 'tried' ), 'cardbox_content2' => __( 'Content', 'tried' ),
            'cardbox_image3' => '', 'cardbox_title3' => __( 'Title', 'tried' ), 'cardbox_content3' => __( 'Content', 'tried' ),
            'cardbox_image4' => '', 'cardbox_title4' => __( 'Title', 'tried' ), 'cardbox_content4' => __( 'Content', 'tried' ),
            'cardbox_image5' => '', 'cardbox_title5' => __( 'Title', 'tried' ), 'cardbox_content5' => __( 'Content', 'tried' ),
            'cardbox_image6' => '', 'cardbox_title6' => __( 'Title', 'tried' ), 'cardbox_content6' => __( 'Content', 'tried' ),
            'cardbox_image7' => '', 'cardbox_title7' => __( 'Title', 'tried' ), 'cardbox_content7' => __( 'Content', 'tried' ),
            'cardbox_image8' => '', 'cardbox_title8' => __( 'Title', 'tried' ), 'cardbox_content8' => __( 'Content', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info block', 'tried' ); ?></h4>
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
<h4><?php _e( 'Banner block', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_image')); ?>"><?php esc_html_e('Image 1', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_image')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_image')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['cardbox_image']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_title')); ?>"><?php esc_html_e('Title 1', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['cardbox_title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('cardbox_title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_title')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_content')); ?>"><?php esc_html_e('Content 1', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_content')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['cardbox_content']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_image2')); ?>"><?php esc_html_e('Image 2', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_image2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_image2')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['cardbox_image2']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_title2')); ?>"><?php esc_html_e('Title 2', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['cardbox_title2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('cardbox_title2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_title2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_content2')); ?>"><?php esc_html_e('Content 2', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_content2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_content2')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['cardbox_content2']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_image3')); ?>"><?php esc_html_e('Image 3', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_image3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_image3')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['cardbox_image3']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_title3')); ?>"><?php esc_html_e('Title 3', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['cardbox_title3']); ?>"
        name="<?php echo esc_attr($this->get_field_name('cardbox_title3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_title3')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_content3')); ?>"><?php esc_html_e('Content 3', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_content3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_content3')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['cardbox_content3']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_image4')); ?>"><?php esc_html_e('Image 4', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_image4')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_image4')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['cardbox_image4']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_title4')); ?>"><?php esc_html_e('Title 4', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['cardbox_title4']); ?>"
        name="<?php echo esc_attr($this->get_field_name('cardbox_title4')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_title4')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_content4')); ?>"><?php esc_html_e('Content 4', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_content4')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_content4')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['cardbox_content4']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_image5')); ?>"><?php esc_html_e('Image 5', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_image5')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_image5')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['cardbox_image5']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_title5')); ?>"><?php esc_html_e('Title 5', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['cardbox_title5']); ?>"
        name="<?php echo esc_attr($this->get_field_name('cardbox_title5')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_title5')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_content5')); ?>"><?php esc_html_e('Content 5', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_content5')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_content5')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['cardbox_content5']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_image6')); ?>"><?php esc_html_e('Image 6', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_image6')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_image6')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['cardbox_image6']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_title6')); ?>"><?php esc_html_e('Title 6', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['cardbox_title6']); ?>"
        name="<?php echo esc_attr($this->get_field_name('cardbox_title6')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_title6')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_content6')); ?>"><?php esc_html_e('Content 6', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_content6')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_content6')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['cardbox_content6']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_image7')); ?>"><?php esc_html_e('Image 7', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_image7')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_image7')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['cardbox_image7']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_title7')); ?>"><?php esc_html_e('Title 7', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['cardbox_title7']); ?>"
        name="<?php echo esc_attr($this->get_field_name('cardbox_title7')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_title7')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_content7')); ?>"><?php esc_html_e('Content 7', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_content7')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_content7')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['cardbox_content7']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_image8')); ?>"><?php esc_html_e('Image 8', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_image8')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_image8')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['cardbox_image8']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_title8')); ?>"><?php esc_html_e('Title 8', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['cardbox_title8']); ?>"
        name="<?php echo esc_attr($this->get_field_name('cardbox_title8')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_title8')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('cardbox_content8')); ?>"><?php esc_html_e('Content 8', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('cardbox_content8')); ?>"
        id="<?php echo esc_attr($this->get_field_id('cardbox_content8')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['cardbox_content8']); ?></textarea>
</p>
<?php
    }
}