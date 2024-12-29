<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_contact_infocollapse extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_contact_infocollapse', 'Tried Contact Info Collapse',
			array(
				'classname' => 'widget_contact_infocollapse',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ), 'content' => '',
            'collapse_title' => __( 'Title collapse', 'tried' ), 'collapse_content' => '',
            'collapse_title2' => __( 'Title collapse', 'tried' ), 'collapse_content2' => '',
            'collapse_title3' => __( 'Title collapse', 'tried' ), 'collapse_content3' => '',
            'collapse_title4' => __( 'Title collapse', 'tried' ), 'collapse_content4' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$content = $instance['content'];

		$collapse_title = $instance['collapse_title'];
		$collapse_content = $instance['collapse_content'];

		$collapse_title2 = $instance['collapse_title2'];
		$collapse_content2 = $instance['collapse_content2'];

		$collapse_title3 = $instance['collapse_title3'];
		$collapse_content3 = $instance['collapse_content3'];

		$collapse_title4 = $instance['collapse_title4'];
		$collapse_content4 = $instance['collapse_content4'];
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-contact-infocollapse">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h4><?php echo $title; ?></h4>
            <p><?php echo $content; ?></p>
        </div>
        <div class="infocollapse-block">
            <?php if ( !empty( $collapse_content ) ) { ?>
            <div class="infocollapse-item">
                <a href="javascript:void(0)" title="<?php echo $collapse_title; ?>"><?php echo $collapse_title; ?></a>
                <div><?php echo $collapse_content; ?></div>
            </div>
            <?php } ?>
            <?php if ( !empty( $collapse_content2 ) ) { ?>
            <div class="infocollapse-item">
                <a href="javascript:void(0)" title="<?php echo $collapse_title2; ?>"><?php echo $collapse_title2; ?></a>
                <div><?php echo $collapse_content2; ?></div>
            </div>
            <?php } ?>
            <?php if ( !empty( $collapse_content3 ) ) { ?>
            <div class="infocollapse-item">
                <a href="javascript:void(0)" title="<?php echo $collapse_title3; ?>"><?php echo $collapse_title3; ?></a>
                <div><?php echo $collapse_content3; ?></div>
            </div>
            <?php } ?>
            <?php if ( !empty( $collapse_content4 ) ) { ?>
            <div class="infocollapse-item">
                <a href="javascript:void(0)" title="<?php echo $collapse_title4; ?>"><?php echo $collapse_title4; ?></a>
                <div><?php echo $collapse_content4; ?></div>
            </div>
            <?php } ?>
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

		$instance['collapse_title'] = ($new_instance['collapse_title']);
		$instance['collapse_content'] = ($new_instance['collapse_content']);

		$instance['collapse_title2'] = ($new_instance['collapse_title2']);
		$instance['collapse_content2'] = ($new_instance['collapse_content2']);

		$instance['collapse_title3'] = ($new_instance['collapse_title3']);
		$instance['collapse_content3'] = ($new_instance['collapse_content3']);

		$instance['collapse_title4'] = ($new_instance['collapse_title4']);
		$instance['collapse_content4'] = ($new_instance['collapse_content4']);
        
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ), 'content' => '',
            'collapse_title' => __( 'Title collapse', 'tried' ), 'collapse_content' => '',
            'collapse_title2' => __( 'Title collapse', 'tried' ), 'collapse_content2' => '',
            'collapse_title3' => __( 'Title collapse', 'tried' ), 'collapse_content3' => '',
            'collapse_title4' => __( 'Title collapse', 'tried' ), 'collapse_content4' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Information', 'tried' ); ?></h4>
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
<h4><?php _e( 'Collapse items', 'tried' ); ?></h4>
<h4><?php _e( 'Item 1', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('collapse_title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['collapse_title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('collapse_title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('collapse_title')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('collapse_content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <?php wp_editor( esc_attr($instance['collapse_content']), esc_attr($this->get_field_name('collapse_content')) ); ?>
</p>
<h4><?php _e( 'Item 2', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('collapse_title2')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['collapse_title2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('collapse_title2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('collapse_title2')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('collapse_content2')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <?php wp_editor( esc_attr($instance['collapse_content2']), esc_attr($this->get_field_name('collapse_content2')) ); ?>
</p>
<h4><?php _e( 'Item 3', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('collapse_title3')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['collapse_title3']); ?>"
        name="<?php echo esc_attr($this->get_field_name('collapse_title3')); ?>"
        id="<?php echo esc_attr($this->get_field_id('collapse_title3')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('collapse_content3')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <?php wp_editor( esc_attr($instance['collapse_content3']), esc_attr($this->get_field_name('collapse_content3')) ); ?>
</p>
<h4><?php _e( 'Item 4', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('collapse_title4')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['collapse_title4']); ?>"
        name="<?php echo esc_attr($this->get_field_name('collapse_title4')); ?>"
        id="<?php echo esc_attr($this->get_field_id('collapse_title4')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('collapse_content4')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <?php wp_editor( esc_attr($instance['collapse_content4']), esc_attr($this->get_field_name('collapse_content4')) ); ?>
</p>
<?php
    }
}