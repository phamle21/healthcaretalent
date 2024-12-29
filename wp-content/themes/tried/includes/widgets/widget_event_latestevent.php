<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_event_latestevent extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_event_latestevent', 'Tried Event Latest Event',
			array(
				'classname' => 'widget_event_latestevent',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'viewmore' => __( 'View all', 'tried' ),
            'viewmore_link' => '',
            'latest_events' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
		
		$title = $instance['title'];
		$content = $instance['content'];
		$viewmore = $instance['viewmore'];
		$viewmore_link = $instance['viewmore_link'];

		$latest_events = $instance['latest_events'];
        $latestevents = get_posts(array (
            'post_type' => 'calevents',
            'orderby' => 'date',
            'order'=> 'ASC', 
            'post_status' => 'publish',
            'post__in' => $latest_events,
        ));
		$key = wp_generate_uuid4();

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-event-latestevent"
    data-control="<?php echo $key; ?>">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h4>
                <?php echo $title; ?>
                <span><?php echo $content; ?></span>
            </h4>
            <!-- <a href="<?php echo $viewmore_link; ?>" title="<?php echo $viewmore; ?>">
                <?php echo $viewmore; ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.4419 3.55838C11.686 3.80246 11.686 4.19819 11.4419 4.44227L8.10861 7.7756C7.86453 8.01968 7.4688 8.01968 7.22472 7.7756C6.98065 7.53152 6.98065 7.13579 7.22472 6.89172L9.49112 4.62533L1 4.62533C0.654823 4.62533 0.375001 4.3455 0.375001 4.00033C0.375001 3.65515 0.654823 3.37533 1 3.37533L9.49112 3.37533L7.22473 1.10893C6.98065 0.864856 6.98065 0.469128 7.22473 0.22505C7.4688 -0.0190274 7.86453 -0.0190274 8.10861 0.22505L11.4419 3.55838Z"
                        fill="#226594" />
                </svg>
            </a> -->
        </div>
        <div class="latestevent-block">
            <div class="latestevents">
                <?php
                    if ( !empty( $latestevents ) ) {
                        echo '<div class="swiper widget-event-latestevent"><div class="swiper-wrapper">';
                        foreach ( $latestevents as $event ) {
                            get_template_part( 'template-parts/event-item/item', null, array(
                                'id' => $event->ID, 'is_slide' => true
                            ) );
                        }
                        echo '</div></div></div>';
                    }
                ?>
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
		$instance['content'] = ($new_instance['content']);
		$instance['viewmore'] = ($new_instance['viewmore']);
		$instance['viewmore_link'] = ($new_instance['viewmore_link']);

		$instance['latest_events'] = ($new_instance['latest_events']);
        
        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'viewmore' => __( 'View all', 'tried' ),
            'viewmore_link' => '',
            'latest_events' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
        $events = get_posts(array (
            'post_type' => 'calevents',
            'orderby' => 'date',
            'order'=> 'ASC', 
            'post_status' => 'publish',
            'posts_per_page' => -1
        ));
        ?>
<h4><?php _e( 'Info block', 'tried' ); ?></h4>
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
<h4><?php _e( 'Latest Event block', 'tried' ); ?></h4>
<?php
        if ( !empty( $events ) ) {
            foreach ( $events as $ev => $event ) {
                $newPostDate = date_create( get_post_meta( $event->ID, 'publish', true ) );
                $args = array(
                    'post_id' => $event->ID,
                    'post_title' => get_the_title( $event->ID ),
                    'calendar_day' => date_format( $newPostDate, 'j' ),
                    'calendar_month' => date_format( $newPostDate, 'n' ),
                    'calendar_year' => date_format( $newPostDate, 'Y' ),
                    'post_link' => get_permalink( $event->ID )
                );
                printf(
                    '<p>
                        <input type="checkbox" class="widefat" name="%s[]" id="%s" value="%s" %s/>
                        <label for="%s">%s - %s</label>
                    </p>',
                    esc_attr($this->get_field_name('latest_events')),
                    esc_attr($this->get_field_id('latest_events')).'-'.$ev,
                    $args['post_id'],
                    in_array( $args['post_id'], $instance['latest_events'] ) ? 'checked' : '',
                    esc_attr($this->get_field_id('latest_events')).'-'.$ev,
                    ucfirst( strlen( $args['post_title'] ) > 20 ? substr( $args['post_title'], 0, 17 ).'...' : $args['post_title'] ),
                    $args['calendar_day'].'/'.$args['calendar_month'].'/'.$args['calendar_year']
                );
            }
        }
    }
}