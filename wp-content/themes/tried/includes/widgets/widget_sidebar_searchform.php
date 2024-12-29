<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_sidebar_searchform extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_sidebar_searchform', 'Tried Sidebar Search Form',
			array(
				'classname' => 'widget_sidebar_searchform',
				'description' => esc_html__('Sidebar Form', ''),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array();
        $instance = wp_parse_args($instance, $defaults);
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-sidebar-searchform">
    <div class="section-wrapper">
        <div class="sidebarsearchform-block">
            <?php get_search_form(); ?>
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