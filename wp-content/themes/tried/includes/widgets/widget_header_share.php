<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_share extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_share', 'Tried Header Share',
			array(
				'classname' => 'widget_header_share',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array('social_facebook' => '', 'social_instagram' => '', 'social_youtube' => '', 'social_twitter' => '');
        $instance = wp_parse_args($instance, $defaults);
		$social_facebook = $instance['social_facebook'];
		$social_instagram = $instance['social_instagram'];
		$social_youtube = $instance['social_youtube'];
		$social_twitter = $instance['social_twitter'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-share">
				<div class="section-wrapper margin-auto">
					<ul class="socials">
						<?php if (!empty($social_facebook)) : ?>
							<li class="item facebook">
								<a class="fab fa-facebook-f" href="<?php echo $social_facebook; ?>" title=""></a>
							</li>
						<?php endif; ?>
						<?php if (!empty($social_instagram)) : ?>
							<li class="item instagram">
								<a class="fab fa-instagram" href="<?php echo $social_instagram; ?>" title=""></a>
							</li>
						<?php endif; ?>
						<?php if (!empty($social_youtube)) : ?>
							<li class="item youtube">
								<a class="fab fa-youtube" href="<?php echo $social_youtube; ?>" title=""></a>
							</li>
						<?php endif; ?>
						<?php if (!empty($social_twitter)) : ?>
							<li class="item twitter">
								<a class="fab fa-twitter" href="<?php echo $social_twitter; ?>" title=""></a>
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

		$instance['social_facebook'] = ($new_instance['social_facebook']);
		$instance['social_instagram'] = ($new_instance['social_instagram']);
		$instance['social_youtube'] = ($new_instance['social_youtube']);
		$instance['social_twitter'] = ($new_instance['social_twitter']);

		return $instance;
	}
	
	function form( $instance ) {
	    $defaults = array('social_facebook' => '', 'social_instagram' => '', 'social_youtube' => '', 'social_twitter' => '');
        $instance = wp_parse_args($instance, $defaults);
        $nav_menus = wp_get_nav_menus();
        ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>"><?php esc_html_e('Facebook', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_facebook']); ?>" name="<?php echo esc_attr($this->get_field_name('social_facebook')); ?>" id="<?php echo esc_attr($this->get_field_id('social_facebook')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_instagram')); ?>"><?php esc_html_e('Instagram', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_instagram']); ?>" name="<?php echo esc_attr($this->get_field_name('social_instagram')); ?>" id="<?php echo esc_attr($this->get_field_id('social_instagram')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>"><?php esc_html_e('Youtube', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_youtube']); ?>" name="<?php echo esc_attr($this->get_field_name('social_youtube')); ?>" id="<?php echo esc_attr($this->get_field_id('social_youtube')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>"><?php esc_html_e('Twitter', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['social_twitter']); ?>" name="<?php echo esc_attr($this->get_field_name('social_twitter')); ?>" id="<?php echo esc_attr($this->get_field_id('social_twitter')); ?>" />
            </p>
        <?php
	}
}
