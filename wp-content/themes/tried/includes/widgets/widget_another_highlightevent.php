<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class widget_another_highlightevent extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            'widget_another_highlightevent',
            'Tried Another Highlight Event',
            array(
                'classname' => 'widget_another_highlightevent',
                'description' => '',
                'customize_selective_refresh' => true
            )
        );
    }

    function widget($args, $instance)
    {
        $defaults = array(
            'highlight_events' => array()
        );
        $instance = wp_parse_args($instance, $defaults);

        $highlight_events = $instance['highlight_events'];
        $highlightevents = get_posts(array(
            'post_type' => 'calevents',
            'orderby' => 'date',
            'order' => 'ASC',
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
                    if (!empty($highlightevents) && !empty($highlight_events)) {
                        echo '<div class="highlightevents">'
                            . '<div class="swiper widget-another-highlightevent">'
                            . '<div class="swiper-wrapper">';
                        foreach ($highlightevents as $event) {
                            $publish = get_post_meta($event->ID, 'publish', true);
                            $newPostDate = date_create($publish);
                            $longMonth = date_format($newPostDate, 'M');
                            $slugPostDate = convert_slug($longMonth);
                            $location = get_post_meta($event->ID, 'location', true);
                            $args = array(
                                'post_id' => $event->ID,
                                'post_title' => get_the_title($event->ID),
                                'post_date' => date_format($newPostDate, 'M d, Y h:i A'),
                                'post_location' => $location,
                                'post_publish' => $publish,
                                'calendar_day' => date_format($newPostDate, 'j'),
                                'calendar_month' => date_format($newPostDate, 'n'),
                                'post_link' => get_permalink($event->ID)
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
                                ucfirst(strlen($args['post_title']) > 70 ? substr($args['post_title'], 0, 67) . '...' : $args['post_title']),
                                $args['post_link'],
                                $args['post_title'],
                                __('Register', 'tried')
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
    function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['highlight_events'] = ($new_instance['highlight_events']);
        return $instance;
    }
    function form($instance)
    {
        $defaults = array(
            'highlight_events' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
        $selected_events = is_array($instance['highlight_events']) ?
            array_map('intval', $instance['highlight_events']) : array();

        $events = get_posts(array(
            'post_type' => 'calevents',
            'orderby' => 'date',
            'order' => 'ASC',
            'post_status' => 'publish',
            'posts_per_page' => -1
        ));

        if (empty($events)) {
            echo '<p>' . esc_html__('No events found.', 'tried') . '</p>';
            return;
        }
    ?>
        <div class="highlight-events-selection">
            <p><?php esc_html_e('Select events to highlight:', 'tried'); ?></p>
            <?php
            foreach ($events as $index => $event) {
                $publish = get_post_meta($event->ID, 'publish', true);
                $newPostDate = $publish ? date_create($publish) : false;
                $date_display = $newPostDate ?
                    date_format($newPostDate, 'j/n/Y') :
                    esc_html__('No date', 'tried');

                $title = get_the_title($event->ID);
                $short_title = strlen($title) > 20 ? substr($title, 0, 17) . '...' : $title;
            ?>
                <p>
                    <input type="checkbox"
                        class="checkbox"
                        name="<?php echo esc_attr($this->get_field_name('highlight_events')); ?>[]"
                        id="<?php echo esc_attr($this->get_field_id('highlight_events') . '-' . $index); ?>"
                        value="<?php echo esc_attr($event->ID); ?>"
                        <?php checked(in_array($event->ID, $selected_events)); ?> />
                    <label for="<?php echo esc_attr($this->get_field_id('highlight_events') . '-' . $index); ?>">
                        <?php echo esc_html(ucfirst($short_title) . ' - ' . $date_display); ?>
                    </label>
                </p>
            <?php
            }
            ?>
        </div>
<?php
    }
}
