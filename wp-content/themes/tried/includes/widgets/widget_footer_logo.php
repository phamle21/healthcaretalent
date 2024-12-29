<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_logo extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_logo', 'Tried Footer Logo',
			array(
				'classname' => 'widget_footer_logo',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('choose_logo' => 'custom_logo');
        $instance = wp_parse_args($instance, $defaults);
		$choose_logo = $instance['choose_logo'];
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-logo">
				<div class="section-wrapper margin-auto">
					<div class="logo-block">
						<?php
							if (!empty($instance['choose_logo']) && $choose_logo != 'custom_logo') :
								$second_custom_logo = get_theme_mod( $choose_logo );
								?>
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo" title="<?php esc_attr_e( 'Home', 'tried' ); ?>" rel="home">
										<img src="<?php echo esc_url( $second_custom_logo ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
									</a>
								<?php
							else :
								$custom_logo = get_theme_mod( 'custom_logo' );
								$logo = wp_get_attachment_image_src( $custom_logo , 'full' );
								?>
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo" title="<?php esc_attr_e( 'Home', 'tried' ); ?>" rel="home">
										<img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
									</a>
								<?php
							endif;
						?>
					</div>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['choose_logo'] = ($new_instance['choose_logo']);
        return $instance;
    }
    function form($instance) {
	    $defaults = array('choose_logo' => 'custom_logo');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<div>
				<h4><?php esc_html_e('Chọn logo hiển thị', ''); ?></h4>
				<label for="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_logo">
					<input type="radio" id="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_logo" name="<?php echo esc_attr($this->get_field_name('choose_logo')); ?>" value="custom_logo" <?php echo !empty($instance['choose_logo']) && (esc_attr($instance['choose_logo']) == 'custom_logo')?'checked':''; ?>>
			  		<?php esc_html_e('Logo chính', ''); ?>
				</label>
			  	<label for="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_second_logo">
					<input type="radio" id="<?php echo esc_attr($this->get_field_id('choose_logo')); ?>_custom_second_logo" name="<?php echo esc_attr($this->get_field_name('choose_logo')); ?>" value="custom_second_logo" <?php echo !empty($instance['choose_logo']) && (esc_attr($instance['choose_logo']) == 'custom_second_logo')?'checked':''; ?>>
			  		<?php esc_html_e('Logo phụ', ''); ?>
				</label>
			</div>
   		<?php
    }
}
