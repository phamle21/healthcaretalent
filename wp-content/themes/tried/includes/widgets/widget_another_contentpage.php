<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_contentpage extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_contentpage', 'Tried Another Content Page',
			array(
				'classname' => 'widget_another_contentpage',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array();
        $instance = wp_parse_args($instance, $defaults);
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-another-contentpage">
    <div class="section-wrapper margin-auto">
        <div class="content-block">
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
        return $instance;
    }

    function form($instance) {
        $defaults = array();
        $instance = wp_parse_args($instance, $defaults);
    }
}