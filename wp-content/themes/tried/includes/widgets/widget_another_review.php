<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_review extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_review', 'Tried Another Review',
			array(
				'classname' => 'widget_another_review',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'reviews_content' => array(),
            'reviews_author' => array(),
            'reviews_subauthor' => array(),
            'reviews_avatar' => array(),
            'reviews_logo' => array()
        );
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$content = $instance['content'];

		$reviews_content = $instance['reviews_content'];
		$reviews_author = $instance['reviews_author'];
		$reviews_subauthor = $instance['reviews_subauthor'];
		$reviews_avatar = $instance['reviews_avatar'];
		$reviews_logo = $instance['reviews_logo'];

        $key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-another-review"
    data-control="<?php echo $key; ?>">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <div class="wrap">
                <h4><?php echo $title; ?></h4>
                <p><?php echo $content; ?></p>
            </div>
        </div>
        <div class="reviews-block">
            <div class="reviews">
                <?php
                    if ( !empty( $reviews_author ) ) {
                        echo '<div class="swiper widget-another-review"><div class="swiper-wrapper">';
                        foreach ( $reviews_author as $l => $litem ) {
                            get_template_part( 'template-parts/review-item/item', 'quote', array(
                                'content' => $reviews_content[$l],
                                'author' => $reviews_author[$l],
                                'subauthor' => $reviews_subauthor[$l],
                                'avatar' => $reviews_avatar[$l],
                                'logo' => $reviews_logo[$l],
                                'is_slide' => true
                            ) );
                        }
                        echo '</div></div><div class="swiper-pagination"></div>';
                    } else {
                        printf( '<p class="not-found">%s</p>', __( 'Không tìm thấy sản phẩm', 'tried' ) );
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

		$instance['reviews_content'] = ($new_instance['reviews_content']);
		$instance['reviews_author'] = ($new_instance['reviews_author']);
		$instance['reviews_subauthor'] = ($new_instance['reviews_subauthor']);
		$instance['reviews_avatar'] = ($new_instance['reviews_avatar']);
		$instance['reviews_logo'] = ($new_instance['reviews_logo']);

        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'reviews_content' => array(),
            'reviews_author' => array(),
            'reviews_subauthor' => array(),
            'reviews_avatar' => array(),
            'reviews_logo' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
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
<h4><?php _e( 'List reviews block', 'tried' ); ?><a class="button button-primary addnew-reclistlink"
        href="javascript:void(0)" title="<?php _e( 'Add new', 'tried' ); ?>"
        style="float: right;"><?php _e( 'Add new', 'tried' ); ?></a></h4>
<div class="reclistlinks">
    <?php
        if ( $instance['reviews_author'] ) {
            foreach ( $instance['reviews_author'] as $l => $litem ) {
                echo '<div class="reclistlink-item">'
                . '<h4>'.__( 'Item', 'tried' ).'<a href="javascript:void(0)" title="'.__( 'Remove', 'tried' ).'">'.__( 'Remove', 'tried' ).'</a></h4>'
                . '<p><label for="'.esc_attr($this->get_field_id('reviews_logo')).'-'.$l.'">'.__( 'Logo', 'tried' ).'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('reviews_logo')).'[]"
                id="'.esc_attr($this->get_field_id('reviews_logo')).'-'.$l.'" cols="30" rows="2">'.esc_attr($instance['reviews_logo'][$l]).'</textarea>'
                . '</p><p cl><label for="'.esc_attr($this->get_field_id('reviews_content')).'-'.$l.'">'.__( 'Content', 'tried' ).'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('reviews_content')).'[]"
                id="'.esc_attr($this->get_field_id('reviews_content')).'-'.$l.'" cols="30" rows="4">'.esc_attr($instance['reviews_content'][$l]).'</textarea>'
                . '</p><p>'
                . '<label for="'.esc_attr($this->get_field_id('reviews_author')).'-'.$l.'">'.__( 'Author', 'tried' ).'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['reviews_author'][$l]).'" name="'.esc_attr($this->get_field_name('reviews_author')).'[]" id="'.esc_attr($this->get_field_id('reviews_author')).'-'.$l.'" />'
                . '</p><p>'
                . '<label for="'.esc_attr($this->get_field_id('reviews_subauthor')).'-'.$l.'">'.__( 'Subauthor', 'tried' ).'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['reviews_subauthor'][$l]).'" name="'.esc_attr($this->get_field_name('reviews_subauthor')).'[]" id="'.esc_attr($this->get_field_id('reviews_subauthor')).'-'.$l.'" />'
                . '</p><p>'
                . '<label for="'.esc_attr($this->get_field_id('reviews_avatar')).'-'.$l.'">'.__( 'Avatar', 'tried' ).'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('reviews_avatar')).'[]"
                id="'.esc_attr($this->get_field_id('reviews_avatar')).'-1" cols="30" rows="2">'.esc_attr($instance['reviews_avatar'][$l]).'</textarea>'
                . '</p></div>';
            }
        } else {
            echo '<div class="reclistlink-item">'
            . '<h4>'.__( 'Item', 'tried' ).'</h4>'
            . '<p><label for="'.esc_attr($this->get_field_id('reviews_logo')).'-1">'.__( 'Logo', 'tried' ).'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('reviews_logo')).'[]"
            id="'.esc_attr($this->get_field_id('reviews_logo')).'-1" cols="30" rows="2"></textarea>'
            . '</p><p><label for="'.esc_attr($this->get_field_id('reviews_content')).'-1">'.__( 'Content', 'tried' ).'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('reviews_content')).'[]"
            id="'.esc_attr($this->get_field_id('reviews_content')).'-1" cols="30" rows="4"></textarea>'
            . '</p><p>'
            . '<label for="'.esc_attr($this->get_field_id('reviews_author')).'-1">'.__( 'Author', 'tried' ).'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('reviews_author')).'[]" id="'.esc_attr($this->get_field_id('reviews_author')).'-1" />'
            . '</p><p>'
            . '<label for="'.esc_attr($this->get_field_id('reviews_subauthor')).'-1">'.__( 'Subauthor', 'tried' ).'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('reviews_subauthor')).'[]" id="'.esc_attr($this->get_field_id('reviews_subauthor')).'-1" />'
            . '</p><p>'
            . '<label for="'.esc_attr($this->get_field_id('reviews_avatar')).'-1">'.__( 'Avatar', 'tried' ).'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('reviews_avatar')).'[]"
            id="'.esc_attr($this->get_field_id('reviews_avatar')).'-1" cols="30" rows="2"></textarea>'
            . '</p></div>';
        }
    ?>
</div>
<style>
.reclistlinks {
    counter-reset: recreviews;
    padding-top: 5px;
}

.reclistlinks .reclistlink-item>h4::after {
    counter-increment: recreviews;
    content: counter(recreviews);
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