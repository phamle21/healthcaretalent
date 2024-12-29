<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_jobpostfilter extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_jobpostfilter', 'Tried Home Jobpost Filter',
			array(
				'classname' => 'widget_home_jobpostfilter',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'form_action' => 'job-seeker', 'have_suggest' => true,
            'background' => '',
            'title' => __( 'Title', 'tried' ), 'content' => __( 'Content', 'tried' ),
        );
        $instance = wp_parse_args($instance, $defaults);
        
		$form_action = $instance['form_action'];
		$have_suggest = $instance['have_suggest'];

		$background = $instance['background'];
		$title = $instance['title'];
		$content = $instance['content'];

		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-jobpostfilter">
    <div class="background-block"
        <?php echo !empty($background)?'style="background-image: url('.$background.');"':''; ?>></div>
    <div class="filter-block">
        <div class="wrap section-wrapper margin-auto">
            <div class="info-contain">
                <h4 class="title"><?php echo $title; ?></h4>
                <p class="content"><?php echo $content; ?></p>
            </div>
            <div class="box-contain">
                <?php echo do_shortcode( "[tried_filter form_action='{$form_action}' have_suggest='{$have_suggest}']" ); ?>
            </div>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['form_action'] = ($new_instance['form_action']);
		$instance['have_suggest'] = ($new_instance['have_suggest']);
        
		$instance['background'] = ($new_instance['background']);
        
		$instance['banner_title'] = ($new_instance['banner_title']);
		$instance['banner_content'] = ($new_instance['banner_content']);
		$instance['banner_download'] = ($new_instance['banner_download']);
		$instance['banner_download_link'] = ($new_instance['banner_download_link']);
		$instance['show_download'] = ($new_instance['show_download']);
        
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['readmore'] = ($new_instance['readmore']);
		$instance['link_readmore'] = ($new_instance['link_readmore']);
		$instance['show_match'] = ($new_instance['show_match']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'form_action' => 'job-seeker', 'have_suggest' => true,
            'background' => '',
            'title' => __( 'Title', 'tried' ), 'content' => __( 'Content', 'tried' ),
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
    <textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php echo esc_attr($instance['content']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('background')); ?>"><?php esc_html_e('Background Image(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['background']); ?>"
        name="<?php echo esc_attr($this->get_field_name('background')); ?>"
        id="<?php echo esc_attr($this->get_field_id('background')); ?>" />
</p>
<h4><?php _e( 'Filter block', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('form_action')); ?>"><?php esc_html_e('Form Action', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['form_action']); ?>"
        name="<?php echo esc_attr($this->get_field_name('form_action')); ?>"
        id="<?php echo esc_attr($this->get_field_id('form_action')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('have_suggest')); ?>"><?php esc_html_e('Have Suggest', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['have_suggest']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('have_suggest')); ?>"
        id="<?php echo esc_attr($this->get_field_id('have_suggest')); ?>" />
</p>
<?php
    }
}