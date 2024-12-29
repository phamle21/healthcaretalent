<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_filter_job extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_filter_job', 'Tried Home Filter Job',
			array(
				'classname' => 'widget_home_filter_job',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'form_action' => 'jobs', 'have_suggest' => true,
            'background' => '',
            'banner_title' => '', 'banner_content' => '', 'banner_download' => __( 'Download Your Copy', 'tried' ),
            'banner_download_link' => '', 'show_download' => '',
            'logo' => '', 'title' => '', 'content' => '',
            'readmore' => __( 'Upload your CV', 'tried' ), 'link_readmore' => '', 'show_match' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        
		$form_action = $instance['form_action'];
		$have_suggest = $instance['have_suggest'];

		$background = $instance['background'];

		$banner_title = $instance['banner_title'];
		$banner_content = $instance['banner_content'];
		$banner_download = $instance['banner_download'];
		$banner_download_link = $instance['banner_download_link'];
		$show_download = $instance['show_download'];

		$logo = $instance['logo'];
		$title = $instance['title'];
		$content = $instance['content'];
		$readmore = $instance['readmore'];
		$link_readmore = $instance['link_readmore'];
		$show_match = $instance['show_match'];

		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-filter_job">
    <div class="background-block"
        <?php echo !empty($background)?'style="background-image: url('.$background.');"':''; ?>></div>
    <div class="filter-block">
        <div class="wrap section-wrapper margin-auto">
            <div class="box-contain">
                <?php if ( $show_download ) { ?>
                <div class="banner-info">
                    <h5><?php echo $banner_title; ?></h5>
                    <p><?php echo $banner_content; ?></p>
                    <?php if ( !empty( $banner_download_link ) ) { ?>
                    <a href="<?php echo $banner_download_link; ?>" title=""><?php echo $banner_download; ?></a>
                    <?php } ?>
                </div>
                <?php } ?>
                <div class="filter-info <?php echo !$have_suggest?'none-suggest':''; ?>">
                    <?php echo do_shortcode( "[tried_filter form_action='{$form_action}' have_suggest='{$have_suggest}']" ); ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ( $show_match ) { ?>
    <div class="match-block">
        <div class="wrap section-wrapper margin-auto">
            <div class="box-contain">
                <h4 class="title"><?php echo $title; ?></h4>
                <p class="content"><?php echo $content; ?></p>
            </div>
            <a href="<?php echo $link_readmore; ?>" class="readmore"><?php echo $readmore; ?></a>
        </div>
    </div>
    <?php } ?>
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
            'form_action' => 'jobs', 'have_suggest' => true,
            'background' => '',
            'banner_title' => '', 'banner_content' => '', 'banner_download' => __( 'Download Your Copy', 'tried' ),
            'banner_download_link' => '', 'show_download' => '',
            'logo' => '', 'title' => '', 'content' => '',
            'readmore' => __( 'Upload your CV', 'tried' ), 'link_readmore' => '', 'show_match' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Filter Job', 'tried' ); ?></h4>
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
<h4><?php _e( 'Banner download', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('background')); ?>"><?php esc_html_e('Background Image(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['background']); ?>"
        name="<?php echo esc_attr($this->get_field_name('background')); ?>"
        id="<?php echo esc_attr($this->get_field_id('background')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('show_download')); ?>"><?php esc_html_e('Show Banner Download', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['show_download']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('show_download')); ?>"
        id="<?php echo esc_attr($this->get_field_id('show_download')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('banner_title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['banner_title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('banner_title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('banner_title')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('banner_content')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" rows="6" name="<?php echo esc_attr($this->get_field_name('banner_content')); ?>"
        id="<?php echo esc_attr($this->get_field_id('banner_content')); ?>"><?php echo esc_attr($instance['banner_content']); ?></textarea>
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('banner_download')); ?>"><?php esc_html_e('Nút download', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['banner_download']); ?>"
        name="<?php echo esc_attr($this->get_field_name('banner_download')); ?>"
        id="<?php echo esc_attr($this->get_field_id('banner_download')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('banner_download_link')); ?>"><?php esc_html_e('Link download', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['banner_download_link']); ?>"
        name="<?php echo esc_attr($this->get_field_name('banner_download_link')); ?>"
        id="<?php echo esc_attr($this->get_field_id('banner_download_link')); ?>" />
</p>
<h4><?php _e( 'Job Match', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('show_match')); ?>"><?php esc_html_e('Show Job Match', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['show_match']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('show_match')); ?>"
        id="<?php echo esc_attr($this->get_field_id('show_match')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('logo')); ?>"><?php esc_html_e('Logo', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['logo']); ?>"
        name="<?php echo esc_attr($this->get_field_name('logo')); ?>"
        id="<?php echo esc_attr($this->get_field_id('logo')); ?>" />
</p>
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
    <label for="<?php echo esc_attr($this->get_field_id('readmore')); ?>"><?php esc_html_e('Xem thêm', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['readmore']); ?>"
        name="<?php echo esc_attr($this->get_field_name('readmore')); ?>"
        id="<?php echo esc_attr($this->get_field_id('readmore')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('link_readmore')); ?>"><?php esc_html_e('Link xem thêm', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['link_readmore']); ?>"
        name="<?php echo esc_attr($this->get_field_name('link_readmore')); ?>"
        id="<?php echo esc_attr($this->get_field_id('link_readmore')); ?>" />
</p>
<?php
    }
}