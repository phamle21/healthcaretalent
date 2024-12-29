<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_contact_infomap extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_contact_infomap', 'Tried Contact Info Map',
			array(
				'classname' => 'widget_contact_infomap',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title_phone' => __( 'Contact', 'tried' ), 'content_phone' => '',
            'title_email' => __( 'Mail', 'tried' ), 'content_email' => '',
            'title_website' => __( 'Website', 'tried' ), 'content_website' => '',
            'title_address' => __( 'Address', 'tried' ), 'content_address' => '',
            'map' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$title_phone = $instance['title_phone'];
		$content_phone = $instance['content_phone'];

		$title_email = $instance['title_email'];
		$content_email = $instance['content_email'];

		$title_website = $instance['title_website'];
		$content_website = $instance['content_website'];

		$title_address = $instance['title_address'];
		$content_address = $instance['content_address'];

		$map = $instance['map'];
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-contact-infomap">
    <div class="section-wrapper margin-auto">
        <div class="map-block">
            <?php echo $map; ?>
        </div>
        <div class="info-block">
            <ul class="infos">
                <?php if ( !empty( $content_phone ) ) { ?>
                <li class="info-item phone">
                    <a href="tel:<?php echo $content_phone; ?>" title="<?php echo $title_phone; ?>">
                        <span><?php echo $title_phone; ?></span>
                        <strong><?php echo $content_phone; ?></strong>
                    </a>
                </li>
                <?php } ?>
                <?php if ( !empty( $content_email ) ) { ?>
                <li class="info-item email">
                    <a href="mailto:<?php echo $content_email; ?>" title="<?php echo $title_email; ?>">
                        <span><?php echo $title_email; ?></span>
                        <strong><?php echo $content_email; ?></strong>
                    </a>
                </li>
                <?php } ?>
                <?php if ( !empty( $content_website ) ) { ?>
                <li class="info-item website">
                    <a href="<?php echo $content_website; ?>" title="<?php echo $title_website; ?>">
                        <span><?php echo $title_website; ?></span>
                        <strong><?php echo $content_website; ?></strong>
                    </a>
                </li>
                <?php } ?>
                <?php if ( !empty( $content_address ) ) { ?>
                <li class="info-item address">
                    <a href="<?php echo $content_address; ?>" title="<?php echo $title_address; ?>">
                        <span><?php echo $title_address; ?></span>
                        <strong><?php echo $content_address; ?></strong>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title_phone'] = ($new_instance['title_phone']);
		$instance['content_phone'] = ($new_instance['content_phone']);
        
		$instance['title_email'] = ($new_instance['title_email']);
		$instance['content_email'] = ($new_instance['content_email']);

		$instance['title_website'] = ($new_instance['title_website']);
		$instance['content_website'] = ($new_instance['content_website']);

		$instance['title_address'] = ($new_instance['title_address']);
		$instance['content_address'] = ($new_instance['content_address']);

		$instance['map'] = ($new_instance['map']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title_phone' => __( 'Contact', 'tried' ), 'content_phone' => '',
            'title_email' => __( 'Mail', 'tried' ), 'content_email' => '',
            'title_website' => __( 'Website', 'tried' ), 'content_website' => '',
            'title_address' => __( 'Address', 'tried' ), 'content_address' => '',
            'map' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Phone Info', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_phone')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_phone']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_phone')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_phone')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_phone')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_phone')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_phone')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content_phone']); ?></textarea>
</p>
<h4><?php _e( 'Email Info', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_email')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_email']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_email')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_email')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_email')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_email')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_email')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content_email']); ?></textarea>
</p>
<h4><?php _e( 'Website Info', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_website')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_website']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_website')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_website')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_website')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_website')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_website')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content_website']); ?></textarea>
</p>
<h4><?php _e( 'Address Info', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_address')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_address']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_address')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_address')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_address')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_address')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_address')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content_address']); ?></textarea>
</p>
<h4><?php _e( 'Embed Map', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('map')); ?>"><?php esc_html_e('Map', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('map')); ?>"
        id="<?php echo esc_attr($this->get_field_id('map')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['map']); ?></textarea>
</p>
<?php
    }
}