<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_slide_advice extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_slide_advice', 'Tried Another Slide Advice',
			array(
				'classname' => 'widget_another_slide_advice',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'advices' => array()
        );
        $instance = wp_parse_args($instance, $defaults);

        $adviceArgs = array (
            'post_type' => 'advice',
            'orderby' => 'date',
            'order'=> 'DESC', 
            'post_status' => 'publish',
            'posts_per_page' => 6
        );
            
        if ( $instance['advices'] ) {
            $adviceArgs['post__in'] = $instance['advices'];
        }
        $advices = get_posts( $adviceArgs );
        $key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another-slide_advice"
    data-control="<?php echo $key; ?>">
    <div class="section-wrapper margin-auto">
        <?php
            if ( !empty( $advices ) ) {
                echo '<div class="swiper widget-another-slide_advice"><div class="swiper-wrapper">';
                foreach ( $advices as $advice ) {
                    get_template_part( 'template-parts/advice-item/item', 'thumbnail', array(
                        'id' => $advice->ID, 'is_slide' => true
                    ) );
				}
                wp_reset_postdata();
				echo '</div><div class="navs-button">'
				. '<div class="swiper-button swiper-button-prev" key="'.$key.'"></div>'
				. '<div class="swiper-button swiper-button-next" key="'.$key.'"></div>'
                . '</div><div class="swiper-pagination"></div></div>';
			} else {
				_e( 'Không tìm thấy sản phẩm', '' );
            }
        ?>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['advices'] = ($new_instance['advices']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'advices' => array()
        );
        $instance = wp_parse_args($instance, $defaults);

        $advices = get_posts( array (
            'post_type' => 'advice',
            'orderby' => 'date',
            'order'=> 'DESC', 
            'post_status' => 'publish',
            'posts_per_page' => -1
        ) );
		?>
<p id="inpt-sideadvice">
    <?php
        if ( !empty( $advices ) ) {
            foreach ( $advices as $ad => $advice ) {
                printf(
                    '<div><input class="widefat" type="checkbox" name="%s[]" id="%s" value="%s" %s><label for="%s">%s</label></div>',
                    esc_attr($this->get_field_name('advices')),
                    esc_attr($this->get_field_id('advices')).'-'.$ad,
                    $advice->ID,
                    $instance['advices'] && in_array( $advice->ID, $instance['advices'] )?'checked':'',
                    esc_attr($this->get_field_id('advices')).'-'.$ad,
                    get_the_title($advice->ID)
                );
            }
        }
    ?>
    </input>
    <style>
    #inpt-sideadvice select option {
        -webkit-line-clamp: 1;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        white-space: normal;
        overflow: hidden;
        height: 24px;
        font-size: 14px;
        padding: 5px 10px;
        box-sizing: border-box;
    }
    </style>
</p>
<?php
    }
}