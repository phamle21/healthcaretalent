<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_recapgallery extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_recapgallery', 'Tried Home Recap Gallery',
			array(
				'classname' => 'widget_home_recapgallery',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
        $events = get_posts( array (
            'post_type' => 'calevents',
            'orderby' => 'date',
            'order'=> 'ASC', 
            'post_status' => 'publish',
            'posts_per_page' => 6
        ) );
		$key = wp_generate_uuid4();
        
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-recapgallery"
    data-control="<?php echo $key; ?>">
    <div class="section-wrapper margin-auto">
        <div class="head-block">
            <h4><?php echo $title; ?></h4>
            <div class="navbutton">
                <div class="swiper-button swiper-button-prev" key="<?php echo $key; ?>"></div>
                <div class="swiper-button swiper-button-next" key="<?php echo $key; ?>"></div>
            </div>
        </div>
        <div class="body-block">
            <div class="swiper widget-home-recapgallery">
                <div class="swiper-wrapper">
                    <?php 
                        if ( !empty( $events ) ) {
                            foreach ( $events as $event ) {
                                $video = get_post_meta( $event->ID, 'video', true );
                                $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $event->ID ), 'full' );
                                $image = get_theme_file_uri( "/assets/img/placeholder.png" );
                                if (!empty($image_url[0])) {
                                    $image = $image_url[0];
                                }
                                printf(
                                    '<div class="recapgallery-item swiper-slide">
                                        <a href="javascript:void(0)" title="%s" data-video="%s"></a>
                                        <div class="wrap">
                                            <div><img src="%s" alt=""/></div>
                                            <h5>%s</h5>
                                            <p>%s</p>
                                        </div>
                                    </div>',
                                    $event->post_title, $video, $image, get_the_title( $event->ID ), get_the_excerpt( $event->ID )
                                );
                            }
                        }
                    ?>
                </div>
            </div>
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
$(document).on('click', '.recapgallery-item > a', function() {
    var wrapper = $(this).closest('.section-home-recapgallery'),
        video = $(this).attr('data-video');
    wrapper.find('.modal-tried').addClass('opened');
    wrapper.find('.modal-tried iframe').attr('src', `https://www.youtube.com/embed/${video}`);
});
</script>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<?php
    }
}