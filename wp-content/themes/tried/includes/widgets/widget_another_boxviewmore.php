<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_boxviewmore extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_boxviewmore', 'Tried Another Box Viewmore',
			array(
				'classname' => 'widget_another_boxviewmore',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'show_viewmodeinfo' => '', 'viewmoreinfo_title' => '', 'viewmoreinfo_content' => '',
            'viewmoreinfo_btn' => __( 'Read More', 'tried' ), 'viewmoreinfo_btnlink' => '',
            'show_viewmodeinfo2' => '', 'viewmoreinfo_title2' => '', 'viewmoreinfo_content2' => '',
            'viewmoreinfo2_btn' => __( 'Read More', 'tried' ), 'viewmoreinfo2_btnlink' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$show_viewmodeinfo = $instance['show_viewmodeinfo'];
		$viewmoreinfo_title = $instance['viewmoreinfo_title'];
		$viewmoreinfo_content = $instance['viewmoreinfo_content'];
		$viewmoreinfo_btn = $instance['viewmoreinfo_btn'];
		$viewmoreinfo_btnlink = $instance['viewmoreinfo_btnlink'];

		$show_viewmodeinfo2 = $instance['show_viewmodeinfo2'];
		$viewmoreinfo_title2 = $instance['viewmoreinfo_title2'];
		$viewmoreinfo_content2 = $instance['viewmoreinfo_content2'];
		$viewmoreinfo2_btn = $instance['viewmoreinfo2_btn'];
		$viewmoreinfo2_btnlink = $instance['viewmoreinfo2_btnlink'];
        
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another_boxviewmore">
    <?php if ( $show_viewmodeinfo || $show_viewmodeinfo2 ) { ?>
    <div class="viewmode-block margin-auto <?php echo $show_viewmodeinfo && $show_viewmodeinfo2?'viewmode-col2':''; ?>">
        <?php if ( $show_viewmodeinfo ) { ?>
        <div class="viewmode-item">
            <h4 class="title"><?php echo $viewmoreinfo_title; ?></h4>
            <p class="content"><?php echo $viewmoreinfo_content; ?></p>
            <div class="btnlinks">
                <?php
                    if ( !empty( $viewmoreinfo_btnlink ) ) {
                        printf(
                            '<a href="%s" title="%s">%s</a>',
                            $viewmoreinfo_btnlink, $viewmoreinfo_btn, $viewmoreinfo_btn
                        );
                    }
                ?>
            </div>
        </div>
        <?php } ?>
        <?php if ( $show_viewmodeinfo2 ) { ?>
        <div class="viewmode-item">
            <h4 class="title"><?php echo $viewmoreinfo_title2; ?></h4>
            <p class="content"><?php echo $viewmoreinfo_content2; ?></p>
            <div class="btnlinks">
                <?php
                    if ( !empty( $viewmoreinfo2_btnlink ) ) {
                        printf(
                            '<a href="%s" title="%s">%s</a>',
                            $viewmoreinfo2_btnlink, $viewmoreinfo2_btn, $viewmoreinfo2_btn
                        );
                    }
                ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['show_viewmodeinfo'] = ($new_instance['show_viewmodeinfo']);
		$instance['viewmoreinfo_title'] = ($new_instance['viewmoreinfo_title']);
		$instance['viewmoreinfo_content'] = ($new_instance['viewmoreinfo_content']);
		$instance['viewmoreinfo_btn'] = ($new_instance['viewmoreinfo_btn']);
		$instance['viewmoreinfo_btnlink'] = ($new_instance['viewmoreinfo_btnlink']);
        
		$instance['show_viewmodeinfo2'] = ($new_instance['show_viewmodeinfo2']);
		$instance['viewmoreinfo_title2'] = ($new_instance['viewmoreinfo_title2']);
		$instance['viewmoreinfo_content2'] = ($new_instance['viewmoreinfo_content2']);
		$instance['viewmoreinfo2_btn'] = ($new_instance['viewmoreinfo2_btn']);
		$instance['viewmoreinfo2_btnlink'] = ($new_instance['viewmoreinfo2_btnlink']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'show_viewmodeinfo' => '', 'viewmoreinfo_title' => '', 'viewmoreinfo_content' => '',
            'viewmoreinfo_btn' => __( 'Read More', 'tried' ), 'viewmoreinfo_btnlink' => '',
            'show_viewmodeinfo2' => '', 'viewmoreinfo_title2' => '', 'viewmoreinfo_content2' => '',
            'viewmoreinfo2_btn' => __( 'Read More', 'tried' ), 'viewmoreinfo2_btnlink' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Viewmode Info', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('show_viewmodeinfo')); ?>"><?php esc_html_e('Show viewmode info', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['show_viewmodeinfo']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('show_viewmodeinfo')); ?>"
        id="<?php echo esc_attr($this->get_field_id('show_viewmodeinfo')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmoreinfo_title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmoreinfo_title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmoreinfo_title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmoreinfo_title')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmoreinfo_content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('viewmoreinfo_content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmoreinfo_content')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['viewmoreinfo_content']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmoreinfo_btn')); ?>"><?php esc_html_e('Button', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmoreinfo_btn']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmoreinfo_btn')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmoreinfo_btn')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmoreinfo_btnlink')); ?>"><?php esc_html_e('Button(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmoreinfo_btnlink']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmoreinfo_btnlink')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmoreinfo_btnlink')); ?>" />
</p>
<h4><?php _e( 'Viewmode Info 2', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('show_viewmodeinfo2')); ?>"><?php esc_html_e('Show viewmode info', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['show_viewmodeinfo2']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('show_viewmodeinfo2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('show_viewmodeinfo2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmoreinfo_title2')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmoreinfo_title2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmoreinfo_title2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmoreinfo_title2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmoreinfo_content2')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('viewmoreinfo_content2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmoreinfo_content2')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['viewmoreinfo_content2']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmoreinfo2_btn')); ?>"><?php esc_html_e('Button', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmoreinfo2_btn']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmoreinfo2_btn')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmoreinfo2_btn')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('viewmoreinfo2_btnlink')); ?>"><?php esc_html_e('Button(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['viewmoreinfo2_btnlink']); ?>"
        name="<?php echo esc_attr($this->get_field_name('viewmoreinfo2_btnlink')); ?>"
        id="<?php echo esc_attr($this->get_field_id('viewmoreinfo2_btnlink')); ?>" />
</p>
<?php
    }
}