<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_location extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_location', 'Tried Footer Location',
			array(
				'classname' => 'widget_footer_location',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => 'Our Locations', 'map' => '');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$map = $instance['map'];
		$locations = get_field('locations','widget_'.$args['widget_id']);
		// echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-location">
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title']; ?></h4>
				<div class="section-wrapper margin-auto">
                    <div class="locations">
                        <?php if (!empty($locations)) : ?>
                            <select name="ft_location">
                                <?php foreach ($locations as $i => $location) : ?>
                                    <option value="<?php echo $i; ?>"><?php echo $location['item']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                        <span class="fas fa-caret-down"></span>
                    </div>
					<div class="map">
                    	<?php echo $map; ?>
					</div>
			    </div>
			</section>
        <?php
		// echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['map'] = ($new_instance['map']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('title' => 'Our Locations', 'map' => '');
        $instance = wp_parse_args($instance, $defaults);
	    ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('map')); ?>"><?php esc_html_e('Bản đồ', ''); ?></label>
                <textarea class="widefat" rows="8" name="<?php echo esc_attr($this->get_field_name('map')); ?>" id="<?php echo esc_attr($this->get_field_id('map')); ?>"><?php echo esc_attr($instance['map']); ?></textarea>
            </p>
   	    <?php
    }
}
