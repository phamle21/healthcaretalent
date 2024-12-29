<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_event_carouselupcoming extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_event_carouselupcoming', 'Tried Event Carousel Upcoming',
			array(
				'classname' => 'widget_event_carouselupcoming',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ), 'title' => __( 'Title', 'tried' ), 'content' => '',
            'upcoming_button' => __( 'Upcoming event', 'tried' ), 'upcoming_button_link' => '',
            'upcomings_image' => array(), 'upcomings_usevideo' => array(), 'upcomings_link' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
        
		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
		$content = $instance['content'];
        
		$upcoming_button = $instance['upcoming_button'];
		$upcoming_button_link = $instance['upcoming_button_link'];

		$upcomings_image = $instance['upcomings_image'];
		$upcomings_usevideo = $instance['upcomings_usevideo'];
		$upcomings_link = $instance['upcomings_link'];

		$key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-event-carouselupcoming"
    data-control="<?php echo $key; ?>">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h4>
                <span><?php echo $subtitle; ?></span>
                <span><?php echo $title; ?></span>
            </h4>
            <p><?php echo $content; ?></p>
            <?php
                if ( !empty( $upcoming_button_link ) ) {
                    printf(
                        '<a href="%s" title="%s">%s</a>',
                        $upcoming_button_link,
                        $upcoming_button,
                        $upcoming_button
                    );
                }
            ?>
        </div>
        <div class="carouselupcoming-block">
            <?php
                if ( $upcomings_image ) {
                    echo '<div class="swiper widget-event-carouselupcoming"><div class="swiper-wrapper">';
                    for ( $l = 0; $l < count( $upcomings_image ); $l++ ) {
                        if ( empty( $upcomings_image ) ) continue;
                        printf(
                            '<div class="carouselupcoming-item %s swiper-slide">
                                <div class="wrap">
                                    <a href="%s" title="%s"></a>
                                    <img src="%s" alt=""/>
                                </div>
                            </div>',
                            $upcomings_usevideo[$l], $upcomings_link[$l], __( 'Upcoming event', 'tried' ), $upcomings_image[$l]
                        );
                    }
                    echo '</div></div><div class="swiper-pagination"></div>';
                }
            ?>
        </div>
    </div>

    <div class="modal-tried">
        <div class="modal-overlay"></div>
        <div class="modal-wrapper" style="max-width: 800px;">
            <div class="modal-head">
                <h4 class="modal-title"></h4>
                <span class="box-icon--close">
                    <svg width="20px" height="20px" viewBox="0 0 19 19" role="presentation">
                        <path
                            d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z"
                            fill="currentColor" fill-rule="evenodd"></path>
                    </svg>
                </span>
            </div>
            <div class="modal-body">
                <iframe width="560" height="315" src="" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>
<script>
$(document).on('click', '.section-event-carouselupcoming .carouselupcoming-item.video a', function(e) {
    e.preventDefault();

    var wrapper = $(this).closest('.section-event-carouselupcoming'),
        video = $(this).attr('href');

    wrapper.find('.modal-tried').addClass('opened');
    wrapper.find('.modal-tried iframe').attr('src', `https://www.youtube.com/embed/${video}`);
});
</script>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
        
		$instance['subtitle'] = ($new_instance['subtitle']);
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['upcoming_button'] = ($new_instance['upcoming_button']);
		$instance['upcoming_button_link'] = ($new_instance['upcoming_button_link']);
		$instance['upcomings_image'] = ($new_instance['upcomings_image']);
		$instance['upcomings_usevideo'] = ($new_instance['upcomings_usevideo']);
		$instance['upcomings_link'] = ($new_instance['upcomings_link']);

        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ), 'title' => __( 'Title', 'tried' ), 'content' => '',
            'upcoming_button' => __( 'Upcoming event', 'tried' ), 'upcoming_button_link' => '',
            'upcomings_image' => array(), 'upcomings_usevideo' => array(), 'upcomings_link' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Subtitle', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>"
        name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>"
        id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" />
</p>
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
    <label
        for="<?php echo esc_attr($this->get_field_id('upcoming_button')); ?>"><?php esc_html_e('Upcoming Button', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['upcoming_button']); ?>"
        name="<?php echo esc_attr($this->get_field_name('upcoming_button')); ?>"
        id="<?php echo esc_attr($this->get_field_id('upcoming_button')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('upcoming_button_link')); ?>"><?php esc_html_e('Upcoming Button(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['upcoming_button_link']); ?>"
        name="<?php echo esc_attr($this->get_field_name('upcoming_button_link')); ?>"
        id="<?php echo esc_attr($this->get_field_id('upcoming_button_link')); ?>" />
</p>
<h4><?php _e( 'List Images', 'tried' ); ?><a class="button button-primary addnew-reclistlink" href="javascript:void(0)"
        title="<?php _e( 'Add new', 'tried' ); ?>" style="float: right;"><?php _e( 'Add new', 'tried' ); ?></a></h4>
<div class="reclistlinks linktype">
    <?php
        if ( $instance['upcomings_link'] ) {
            foreach ( $instance['upcomings_link'] as $l => $litem ) {
                echo '<div class="reclistlink-item">'
                . '<h4>'.__( 'Item', 'tried' ).'<a href="javascript:void(0)" title="'.__( 'Remove', 'tried' ).'">'.__( 'Remove', 'tried' ).'</a></h4>'
                . '<p class="title">'
                . '<label for="'.esc_attr($this->get_field_id('upcomings_image')).'-'.$l.'">'.__( 'Image', 'tried' ).'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('upcomings_image')).'[]" id="'.esc_attr($this->get_field_id('upcomings_image')).'-'.$l.'" cols="30" rows="4">'.esc_attr($instance['upcomings_image'][$l]).'</textarea>'
                . '</p>'
                . '<p class="type">'
                . '<input class="widefat" type="checkbox" value="video" name="'.esc_attr($this->get_field_name('upcomings_usevideo')).'[]" id="'.esc_attr($this->get_field_id('upcomings_usevideo')).'-'.$l.'" '.(($instance['upcomings_usevideo'][$l] == 'video')?'checked':'').'/>'
                . '<label for="'.esc_attr($this->get_field_id('upcomings_usevideo')).'-'.$l.'">'.__( 'Use video?', 'tried' ).'</label>'
                . '</p>'
                . '<p class="link">'
                . '<label for="'.esc_attr($this->get_field_id('upcomings_link')).'-'.$l.'">'.__( 'Link(youtube)', 'tried' ).'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['upcomings_link'][$l]).'" name="'.esc_attr($this->get_field_name('upcomings_link')).'[]" id="'.esc_attr($this->get_field_id('upcomings_link')).'-'.$l.'" />'
                . '</p>'
                . '</div>';
            }
        } else {
            echo '<div class="reclistlink-item">'
            . '<h4>'.__( 'Item', 'tried' ).'</h4>'
            . '<p class="title">'
            .' <label for="'.esc_attr($this->get_field_id('upcomings_image')).'-1">'.__( 'Image', 'tried' ).'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('upcomings_image')).'[]" id="'.esc_attr($this->get_field_id('upcomings_image')).'-1" cols="30" rows="4"></textarea>'
            . '</p>'
            . '<p class="type">'
            . '<input class="widefat" type="checkbox" value="video" name="'.esc_attr($this->get_field_name('upcomings_usevideo')).'[]" id="'.esc_attr($this->get_field_id('upcomings_usevideo')).'-1"/>'
            . '<label for="'.esc_attr($this->get_field_id('upcomings_usevideo')).'-1">'.__( 'Use video?', 'tried' ).'</label>'
            . '</p>'
            . '<p class="link">'
            . '<label for="'.esc_attr($this->get_field_id('upcomings_link')).'-1">'.__( 'Link(youtube)', 'tried' ).'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('upcomings_link')).'[]" id="'.esc_attr($this->get_field_id('upcomings_link')).'-1" />'
            . '</p>'
            . '</div>';
        }
    ?>
</div>
<style>
.reclistlinks {
    counter-reset: reclistcarouselupcoming;
    padding-top: 5px;
}

.reclistlinks .reclistlink-item>h4::after {
    counter-increment: reclistcarouselupcoming;
    content: counter(reclistcarouselupcoming);
    margin-left: 5px;
}

.reclistlinks .reclistlink-item>h4>a {
    position: absolute;
    right: 16px;
}
</style>
<?php
    }
}