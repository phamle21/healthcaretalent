<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_latest_advice extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_latest_advice', 'Tried Home Latest Advice',
			array(
				'classname' => 'widget_home_latest_advice',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array(
            'title' => __( 'Title', 'tried' ),
            'description' => __( 'Content', 'tried' ),
			'limit' => 6
        );
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$description = $instance['description'];
		$limit = $instance['limit'];

		$key = wp_generate_uuid4();
		
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-latest_advice"
    data-control="<?php echo $key; ?>">
    <div class="section-wrapper margin-auto">
        <div class="head-block">
            <h4><?php echo $title; ?></h4>
            <p><?php echo $description; ?></p>
        </div>
        <div class="advice-block">
            <div div class="advices">
                <div class="swiper widget-home-latest_advice">
                    <div class="swiper-wrapper">
                        <?php 
							$advices = get_posts(array (
								'post_type' => 'advice',
								'orderby' => 'date',
								'order'=> 'DESC', 
								'post_status' => 'publish',
								'posts_per_page' => $limit
							));
							if (!empty($advices)) {
								foreach ($advices as $s => $advice) {
									get_template_part('template-parts/advice-item/item', null, array(
										'id' => $advice->ID,
										'is_slide' => true
									) );
								}
							}
						?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
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
		$instance['description'] = ($new_instance['description']);
		$instance['limit'] = ($new_instance['limit']);

		return $instance;
	}

	function form($instance) {
		$defaults = array(
            'title' => __( 'Title', 'tried' ),
            'description' => __( 'Content', 'tried' ),
			'limit' => 6
        );
		$instance = wp_parse_args($instance, $defaults);
		?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['description']); ?>"
        name="<?php echo esc_attr($this->get_field_name('description')); ?>"
        id="<?php echo esc_attr($this->get_field_id('description')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>"><?php esc_html_e('Limit advice', ''); ?></label>
    <input class="widefat" type="number" value="<?php echo esc_attr($instance['limit']); ?>"
        name="<?php echo esc_attr($this->get_field_name('limit')); ?>"
        id="<?php echo esc_attr($this->get_field_id('limit')); ?>" />
</p>
<?php
	}
}