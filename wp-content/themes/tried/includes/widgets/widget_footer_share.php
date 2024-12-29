<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_share extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_share', 'Tried Footer Share',
			array(
				'classname' => 'widget_footer_share',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array('social_facebook' => '', 'social_google' => '', 'social_phone' => '', 'social_twitter' => '', 'social_linkedin' => '', 'social_youtube' => '');
        $instance = wp_parse_args($instance, $defaults);
		$social_facebook = $instance['social_facebook'];
		$social_google = $instance['social_google'];
		$social_phone = $instance['social_phone'];
		$social_twitter = $instance['social_twitter'];
		$social_linkedin = $instance['social_linkedin'];
		$social_youtube = $instance['social_youtube'];
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-share">
    <div class="section-wrapper">
        <ul class="socials">
            <?php if (!empty($social_facebook)) : ?>
            <li class="item facebook">
                <a href="<?php echo $social_facebook; ?>" title="<?php _e( 'Facebook', 'tried' ); ?>"></a>
            </li>
            <?php endif; ?>
            <?php if (!empty($social_google)) : ?>
            <li class="item google">
                <a href="<?php echo $social_google; ?>" title="<?php _e( 'Google', 'tried' ); ?>"></a>
            </li>
            <?php endif; ?>
            <?php if (!empty($social_phone)) : ?>
            <li class="item phone">
                <a href="<?php echo $social_phone; ?>" title="<?php _e( 'Phone', 'tried' ); ?>"></a>
            </li>
            <?php endif; ?>
            <?php if (!empty($social_twitter)) : ?>
            <li class="item twitter">
                <a href="<?php echo $social_twitter; ?>" title="<?php _e( 'Twitter', 'tried' ); ?>"></a>
            </li>
            <?php endif; ?>
            <?php if (!empty($social_linkedin)) : ?>
            <li class="item linkedin">
                <a href="<?php echo $social_linkedin; ?>" title="<?php _e( 'LinkedIn', 'tried' ); ?>"></a>
            </li>
            <?php endif; ?>
            <?php if (!empty($social_youtube)) : ?>
            <li class="item youtube">
                <a href="<?php echo $social_youtube; ?>" title="<?php _e( 'Youtube', 'tried' ); ?>"></a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</section>
<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		$instance['social_facebook'] = $new_instance['social_facebook'];
		$instance['social_google'] = $new_instance['social_google'];
		$instance['social_phone'] = $new_instance['social_phone'];
		$instance['social_twitter'] = $new_instance['social_twitter'];
		$instance['social_linkedin'] = $new_instance['social_linkedin'];
		$instance['social_youtube'] = $new_instance['social_youtube'];
		return $instance;
	}
	
	function form( $instance ) {
	    $defaults = array('social_facebook' => '', 'social_google' => '', 'social_phone' => '', 'social_twitter' => '', 'social_linkedin' => '', 'social_youtube' => '');
        $instance = wp_parse_args($instance, $defaults);
        $nav_menus = wp_get_nav_menus();
        ?>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>"><?php esc_html_e('Facebook', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_facebook']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_facebook')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_google')); ?>"><?php esc_html_e('Google', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_google']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_google')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_google')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_phone')); ?>"><?php esc_html_e('Phone', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_phone']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_phone')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_phone')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>"><?php esc_html_e('Twitter', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_twitter']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_twitter')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_linkedin')); ?>"><?php esc_html_e('LinkedIn', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_linkedin']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_linkedin')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_linkedin')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>"><?php esc_html_e('Youtube', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_youtube']); ?>"
        name="<?php echo esc_attr($this->get_field_name('social_youtube')); ?>"
        id="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>" />
</p>
<?php
	}
}