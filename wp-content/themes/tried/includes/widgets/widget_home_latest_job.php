<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_latest_job extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_latest_job', 'Tried Home Latest Job',
			array(
				'classname' => 'widget_home_latest_job',
				'description' => esc_html__('Bài viết trending', 'tried'),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array(
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'viewmore' => __( 'View all', 'tried' ),
            'viewmore_link' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$content = $instance['content'];
		$viewmore = $instance['viewmore'];
		$viewmore_link = $instance['viewmore_link'];

        $latestJobs = get_posts(array (
            'post_type' => 'jobpost',
            'orderby' => 'date',
            'order'=> 'DESC', 
            'post_status' => 'publish',
            'posts_per_page' => 6
        ));

		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-latest_job">
    <div class="section-wrapper margin-auto">
        <div class="head-block">
            <div>
                <h4><?php echo $title; ?></h4>
                <p><?php echo $content; ?></p>
            </div>
            <div>
                <a href="<?php echo $viewmore_link; ?>" title="<?php echo $viewmore; ?>"><?php echo $viewmore; ?></a>
            </div>
        </div>
        <div class="trendings-block">
            <div class="latest-jobs <?php echo empty( $latestJobs ) ? 'not-found' : ''; ?>">
                <?php
                    if ( !empty( $latestJobs ) ) {
                        foreach ( $latestJobs as $job ) {
                            get_template_part('template-parts/jobpost-item/item', 'small', array( 
                                'id' => $job->ID
                            ) );
                        }
                    } else {
                        printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned', 'tried') );
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<style>
</style>
<?php
		echo $args['after_widget'];
	}

	function update($new_instance, $old_instance) {
		$instance = array();

		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['viewmore'] = ($new_instance['viewmore']);
		$instance['viewmore_link'] = ($new_instance['viewmore_link']);

		return $instance;
	}

	function form($instance) {
		$defaults = array(
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'viewmore' => __( 'View all', 'tried' ),
            'viewmore_link' => ''
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
    <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('viewmore')); ?>"><?php esc_html_e('Viewmore', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmore']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmore')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmore')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmore_link')); ?>"><?php esc_html_e('Viewmore(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmore_link']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmore_link')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmore_link')); ?>" />
</p>
<?php
	}
}