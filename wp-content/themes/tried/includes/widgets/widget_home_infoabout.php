<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_infoabout extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_infoabout', 'Tried Home Info About',
			array(
				'classname' => 'widget_home_infoabout',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ),
            'title' => __( 'Title', 'tried' ),
            'suptitle' => __( 'Suptitle', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'viewmore' => __( 'View more', 'tried' ),
            'viewmore_link' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
		$suptitle = $instance['suptitle'];
		$content = $instance['content'];
		$viewmore = $instance['viewmore'];
		$viewmore_link = $instance['viewmore_link'];

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-home-infoabout">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h4>
                <span><?php echo $subtitle; ?></span>
                <span><?php echo $title; ?></span>
                <span><?php echo $suptitle; ?></span>
            </h4>
        </div>
        <div class="content-block">
            <div><?php echo $content; ?></div>
            <?php
                if ( !empty( $viewmore_link ) ) {
                    printf(
                        '<a href="%s" title="%s">%s</a>',
                        $viewmore_link,
                        $viewmore,
                        $viewmore
                    );
                }
            ?>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();

		$instance['subtitle'] = ($new_instance['subtitle']);
		$instance['title'] = ($new_instance['title']);
		$instance['suptitle'] = ($new_instance['suptitle']);
		$instance['content'] = ($new_instance['content']);
		$instance['viewmore'] = ($new_instance['viewmore']);
		$instance['viewmore_link'] = ($new_instance['viewmore_link']);

        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'subtitle' => __( 'Subtitle', 'tried' ),
            'title' => __( 'Title', 'tried' ),
            'suptitle' => __( 'Suptitle', 'tried' ),
            'content' => __( 'Content', 'tried' ),
            'viewmore' => __( 'View more', 'tried' ),
            'viewmore_link' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        ?>
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
    <label for="<?php echo esc_attr($this->get_field_id('suptitle')); ?>"><?php esc_html_e('Suptitle', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['suptitle']); ?>"
        name="<?php echo esc_attr($this->get_field_name('suptitle')); ?>"
        id="<?php echo esc_attr($this->get_field_id('suptitle')); ?>" />
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