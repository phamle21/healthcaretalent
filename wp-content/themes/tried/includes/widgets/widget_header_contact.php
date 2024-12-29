<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_contact extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_contact', 'Tried Header Contact',
			array(
				'classname' => 'widget_header_contact',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array(
            'phone' => '',
            'email' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		$phone = $instance['phone'];
		$email = $instance['email'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-contact">
                <div class="section-wrapper margin-auto">
                    <ul class="contacts">
                        <?php if (!empty($phone)) : ?>
                            <li class="item phone">
                                <i class="fas fa-phone-square-alt"></i>
                                <?php _e('Call', ''); ?>: <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (!empty($email)) : ?>
                            <li class="item email">
                                <i class="fas fa-envelope"></i>
                                <?php _e('Email', ''); ?>: <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
			</section>
        <?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['phone'] = ($new_instance['phone']);
		$instance['email'] = ($new_instance['email']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array(
            'phone' => '',
            'email' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php esc_html_e('Phone', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['phone']); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('Email', ''); ?></label>
                <input class="widefat" type="text" value="<?php echo esc_attr($instance['email']); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" id="<?php echo esc_attr($this->get_field_id('email')); ?>" />
            </p>
        <?php
    }
}
