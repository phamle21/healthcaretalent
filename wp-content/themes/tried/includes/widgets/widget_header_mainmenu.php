<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_mainmenu extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_mainmenu', 'Tried Header Main Menu',
			array(
				'classname' => 'widget_header_mainmenu',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
        $defaults = array();
        $instance = wp_parse_args($instance, $defaults);
        
        $location_menu = 'header-menu';
        if ( isset( $args['menu_location'] ) ) {
            $location_menu = $args['menu_location'];
        }
        $header_nav_menu = wp_nav_menu( [
            'theme_location' => $location_menu,
            'fallback_cb' => false,
            'echo' => false,
            'container_class' => 'nav-menu'
        ] );
        
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-mainmenu">
    <div class="section-wrapper margin-auto">
        <div class="nav-block">
            <?php
                if ( $header_nav_menu ) {
                    printf(
                        '<nav class="site-navigation" role="navigation">
                            <div class="site-navigation-wrapper">
                                <div class="nav-desktop">%s</div>
                            </div>
                            <div class="site-navigation-toggle" role="menu">
                                <i aria-hidden="true" class="fal fa-bars icon-nav open"></i>
                                <i aria-hidden="true" class="fas fa-times icon-nav close"></i>
                            </div>
                        </nav>',
                        $header_nav_menu
                    );
                }
            ?>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		return $instance;
	}
	
	function form( $instance ) {
        $defaults = array();
        $instance = wp_parse_args($instance, $defaults);
	}
}