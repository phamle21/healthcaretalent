<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_highlightevent extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_highlightevent', 'Tried Another Highlight Event',
			array(
				'classname' => 'widget_another_highlightevent',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'highlight_events' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
		
		$highlight_events = $instance['highlight_events'];
        $highlightevents = get_posts(array (
            'post_type' => 'calevents',
            'orderby' => 'date',
            'order'=> 'ASC', 
            'post_status' => 'publish',
            'post__in' => $highlight_events,
        ));
		$key = wp_generate_uuid4();

		// echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-another-highlightevent"
    data-control="<?php echo $key; ?>">
    <div class="section-wrapper margin-auto">
        <div class="highlightevent-block">
            <?php
                    if ( !empty( $highlightevents ) && !empty( $highlight_events ) ) {
                        echo '<div class="highlightevents">'
                        . '<div class="swiper widget-another-highlightevent">'
                        . '<div class="swiper-wrapper">';
                        foreach ( $highlightevents as $event ) {
                            $publish = get_post_meta( $event->ID, 'publish', true );
                            $newPostDate = date_create( $publish );
                            $longMonth = date_format( $newPostDate, 'M' );
                            $slugPostDate = convert_slug( $longMonth );
                            $location = get_post_meta( $event->ID, 'location', true );
                            $args = array(
                                'post_id' => $event->ID,
                                'post_title' => get_the_title( $event->ID ),
                                'post_date' => date_format( $newPostDate, 'M d, Y h:i A' ),
                                'post_location' => $location,
                                'post_publish' => $publish,
                                'calendar_day' => date_format( $newPostDate, 'j' ),
                                'calendar_month' => date_format( $newPostDate, 'n' ),
                                'post_link' => get_permalink( $event->ID )
                            );
                            printf(
                                '<div class="highlightevent-item swiper-slide">
                                    <a href="%s" title="%s"></a>
                                    <div class="publish-day">
                                        <span>%s</span>
                                        <span>%s</span>
                                    </div>
                                    <div class="info-event">
                                        <h5>%s</h5>
                                        <a href="%s" title="%s">%s</a>
                                    </div>
                                </div>',
                                $args['post_link'],
                                $args['post_title'],
                                $longMonth,
                                $args['calendar_day'],
                                ucfirst( strlen( $args['post_title'] ) > 70 ? substr( $args['post_title'], 0, 67 ).'...' : $args['post_title'] ),
                                $args['post_link'],
                                $args['post_title'],
                                __( 'Register', 'tried' )
                            );
                        }
                        echo '</div>'
                        . '</div>'
                        . '</div>'
                        . '</div>';
                    }
                ?>
        </div>
    </div>
    </div>
</section>
<?php
		// echo $args['after_widget'];
    }
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['highlight_events'] = ($new_instance['highlight_events']);
        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'highlight_events' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
        $events = get_posts(array (
            'post_type' => 'calevents',
            'orderby' => 'date',
            'order'=> 'ASC', 
            'post_status' => 'publish',
            'posts_per_page' => -1
        ));
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
                    esc_attr($this->get_field_name('highlight_events')),
                    esc_attr($this->get_field_id('highlight_events')).'-'.$ev,
                    $args['post_id'],
                    in_array( $args['post_id'], $instance['highlight_events'] ) ? 'checked' : '',
                    esc_attr($this->get_field_id('highlight_events')).'-'.$ev,
                    ucfirst( strlen( $args['post_title'] ) > 20 ? substr( $args['post_title'], 0, 17 ).'...' : $args['post_title'] ),
                    $args['calendar_day'].'/'.$args['calendar_month'].'/'.$args['calendar_year']
                );
            }
        }
    }
}