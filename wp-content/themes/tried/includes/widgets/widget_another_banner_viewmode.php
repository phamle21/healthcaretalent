<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_banner_viewmode extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_banner_viewmode', 'Tried Another Banner Viewmode',
			array(
				'classname' => 'widget_another_banner_viewmode',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'banner_title' => '', 'banner_image' => '',
            'show_viewmodeinfo' => '', 'viemodeinfo_title' => '', 'viemodeinfo_content' => '',
            'viemodeinfo_btn' => __( 'Read More', 'tried' ), 'viemodeinfo_btnlink' => '',
            'viemodeinfo_btn2' => __( 'Read More', 'tried' ), 'viemodeinfo_btnlink2' => '',
            'show_viewmodeinfo2' => '', 'viemodeinfo_title2' => '', 'viemodeinfo_content2' => '',
            'viemodeinfo2_btn' => __( 'Read More', 'tried' ), 'viemodeinfo2_btnlink' => '',
            'viemodeinfo2_btn2' => __( 'Read More', 'tried' ), 'viemodeinfo2_btnlink2' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        
		$banner_title = $instance['banner_title'];
        $banner_image = get_theme_file_uri( '/assets/img/contact-us-mp-us.jpg' );
        if ( !empty( $instance['banner_image'] ) ) {
            $banner_image = $instance['banner_image'];
        }

		$show_viewmodeinfo = $instance['show_viewmodeinfo'];
		$viemodeinfo_title = $instance['viemodeinfo_title'];
		$viemodeinfo_content = $instance['viemodeinfo_content'];
		$viemodeinfo_btn = $instance['viemodeinfo_btn'];
		$viemodeinfo_btnlink = $instance['viemodeinfo_btnlink'];
		$viemodeinfo_btn2 = $instance['viemodeinfo_btn2'];
		$viemodeinfo_btnlink2 = $instance['viemodeinfo_btnlink2'];

		$show_viewmodeinfo2 = $instance['show_viewmodeinfo2'];
		$viemodeinfo_title2 = $instance['viemodeinfo_title2'];
		$viemodeinfo_content2 = $instance['viemodeinfo_content2'];
		$viemodeinfo2_btn = $instance['viemodeinfo2_btn'];
		$viemodeinfo2_btnlink = $instance['viemodeinfo2_btnlink'];
		$viemodeinfo2_btn2 = $instance['viemodeinfo2_btn2'];
		$viemodeinfo2_btnlink2 = $instance['viemodeinfo2_btnlink2'];
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another_bannerviewmode">
    <div class="banner-block <?php echo ( !$show_viewmodeinfo && !$show_viewmodeinfo2 ) ? 'non-viewmode': ''; ?>">
        <div class="background-banner" style="background-image: url(<?php echo $banner_image; ?>);"></div>
        <h4 class="title-banner margin-auto"><?php echo $banner_title; ?></h4>
    </div>
    <?php if ( $show_viewmodeinfo || $show_viewmodeinfo2 ) { ?>
    <div class="viewmode-block margin-auto <?php echo $show_viewmodeinfo && $show_viewmodeinfo2?'viewmode-col2':''; ?>">
        <?php if ( $show_viewmodeinfo ) { ?>
        <div class="viewmode-item">
            <h4 class="title"><?php echo $viemodeinfo_title; ?></h4>
            <p class="content"><?php echo $viemodeinfo_content; ?></p>
            <div class="btnlinks">
                <?php
                    if ( !empty( $viemodeinfo_btnlink ) ) {
                        printf(
                            '<a href="%s" title="%s">%s</a>',
                            $viemodeinfo_btnlink, $viemodeinfo_btn, $viemodeinfo_btn
                        );
                    }
                    if ( !empty( $viemodeinfo_btnlink2 ) ) {
                        printf(
                            '<a href="%s" title="%s">%s</a>',
                            $viemodeinfo_btnlink2, $viemodeinfo_btn2, $viemodeinfo_btn2
                        );
                    }
                ?>
            </div>
        </div>
        <?php } ?>
        <?php if ( $show_viewmodeinfo2 ) { ?>
        <div class="viewmode-item">
            <h4 class="title"><?php echo $viemodeinfo_title2; ?></h4>
            <p class="content"><?php echo $viemodeinfo_content2; ?></p>
            <div class="btnlinks">
                <?php
                    if ( !empty( $viemodeinfo2_btnlink ) ) {
                        printf(
                            '<a href="%s" title="%s">%s</a>',
                            $viemodeinfo2_btnlink, $viemodeinfo2_btn, $viemodeinfo2_btn
                        );
                    }
                    if ( !empty( $viemodeinfo2_btnlink2 ) ) {
                        printf(
                            '<a href="%s" title="%s">%s</a>',
                            $viemodeinfo2_btnlink2, $viemodeinfo2_btn2, $viemodeinfo2_btn2
                        );
                    }
                ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['banner_title'] = ($new_instance['banner_title']);
		$instance['banner_image'] = ($new_instance['banner_image']);

		$instance['show_viewmodeinfo'] = ($new_instance['show_viewmodeinfo']);
		$instance['viemodeinfo_title'] = ($new_instance['viemodeinfo_title']);
		$instance['viemodeinfo_content'] = ($new_instance['viemodeinfo_content']);
		$instance['viemodeinfo_btn'] = ($new_instance['viemodeinfo_btn']);
		$instance['viemodeinfo_btnlink'] = ($new_instance['viemodeinfo_btnlink']);
		$instance['viemodeinfo_btn2'] = ($new_instance['viemodeinfo_btn2']);
		$instance['viemodeinfo_btnlink2'] = ($new_instance['viemodeinfo_btnlink2']);
        
		$instance['show_viewmodeinfo2'] = ($new_instance['show_viewmodeinfo2']);
		$instance['viemodeinfo_title2'] = ($new_instance['viemodeinfo_title2']);
		$instance['viemodeinfo_content2'] = ($new_instance['viemodeinfo_content2']);
		$instance['viemodeinfo2_btn'] = ($new_instance['viemodeinfo2_btn']);
		$instance['viemodeinfo2_btnlink'] = ($new_instance['viemodeinfo2_btnlink']);
		$instance['viemodeinfo2_btn2'] = ($new_instance['viemodeinfo2_btn2']);
		$instance['viemodeinfo2_btnlink2'] = ($new_instance['viemodeinfo2_btnlink2']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'banner_title' => '', 'banner_image' => '',
            'show_viewmodeinfo' => '', 'viemodeinfo_title' => '', 'viemodeinfo_content' => '',
            'viemodeinfo_btn' => __( 'Read More', 'tried' ), 'viemodeinfo_btnlink' => '',
            'viemodeinfo_btn2' => __( 'Read More', 'tried' ), 'viemodeinfo_btnlink2' => '',
            'show_viewmodeinfo2' => '', 'viemodeinfo_title2' => '', 'viemodeinfo_content2' => '',
            'viemodeinfo2_btn' => __( 'Read More', 'tried' ), 'viemodeinfo2_btnlink' => '',
            'viemodeinfo2_btn2' => __( 'Read More', 'tried' ), 'viemodeinfo2_btnlink2' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Banner', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('banner_title')); ?>"><?php esc_html_e('Title', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['banner_title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('banner_title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('banner_title')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('banner_image')); ?>"><?php esc_html_e('Background Image(link)', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['banner_image']); ?>"
        name="<?php echo esc_attr($this->get_field_name('banner_image')); ?>"
        id="<?php echo esc_attr($this->get_field_id('banner_image')); ?>" />
</p>
<h4><?php _e( 'Viewmode Info', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('show_viewmodeinfo')); ?>"><?php esc_html_e('Show viewmode info', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['show_viewmodeinfo']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('show_viewmodeinfo')); ?>"
        id="<?php echo esc_attr($this->get_field_id('show_viewmodeinfo')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo_title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo_title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo_title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo_title')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo_content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('viemodeinfo_content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo_content')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['viemodeinfo_content']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo_btn')); ?>"><?php esc_html_e('Button', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo_btn']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo_btn')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo_btn')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo_btnlink')); ?>"><?php esc_html_e('Button(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo_btnlink']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo_btnlink')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo_btnlink')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo_btn2')); ?>"><?php esc_html_e('Button 2', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo_btn2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo_btn2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo_btn2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo_btnlink2')); ?>"><?php esc_html_e('Button 2(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo_btnlink2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo_btnlink2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo_btnlink2')); ?>" />
</p>
<h4><?php _e( 'Viewmode Info 2', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('show_viewmodeinfo2')); ?>"><?php esc_html_e('Show viewmode info', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['show_viewmodeinfo2']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('show_viewmodeinfo2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('show_viewmodeinfo2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo_title2')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo_title2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo_title2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo_title2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo_content2')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('viemodeinfo_content2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo_content2')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['viemodeinfo_content2']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo2_btn')); ?>"><?php esc_html_e('Button', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo2_btn']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo2_btn')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo2_btn')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo2_btnlink')); ?>"><?php esc_html_e('Button(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo2_btnlink']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo2_btnlink')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo2_btnlink')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo2_btn2')); ?>"><?php esc_html_e('Button 2', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo2_btn2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo2_btn2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo2_btn2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viemodeinfo2_btnlink2')); ?>"><?php esc_html_e('Button 2(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viemodeinfo2_btnlink2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viemodeinfo2_btnlink2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viemodeinfo2_btnlink2')); ?>" />
</p>
<?php
    }
}