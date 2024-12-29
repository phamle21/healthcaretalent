<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_about_listservice extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_about_listservice', 'Tried About List Service',
			array(
				'classname' => 'widget_about_listservice',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' ),
            'description' => __( 'Description', 'tried' ),
            'listservices_title' => array(),
            'listservices_content' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
		
		$subtitle = $instance['subtitle'];
		$title = $instance['title'];
		$description = $instance['description'];

		$listservices_title = $instance['listservices_title'];
		$listservices_content = $instance['listservices_content'];

		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-about-listservice">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h6><?php echo $subtitle; ?></h6>
            <h5><?php echo $title; ?></h5>
            <p><?php echo $description; ?></p>
        </div>
        <div class="listservice-block">
            <div class="listservices">
                <?php
                    if ( !empty( $listservices_title ) ) {
                        foreach ( $listservices_title as $l => $litem ) {
                            printf(
                                '<div class="listservice-item">
                                    <div class="wrap">
                                        <h6>%s</h6>
                                        <p>%s</p>
                                    </div>
                                </div>',
                                $listservices_title[$l], $listservices_content[$l]
                            );
                        }
                    } else {
                        printf( '<p class="not-found">%s</p>', _e( 'Không tìm thấy sản phẩm', 'tried' ) );
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
		$instance['subtitle'] = ($new_instance['subtitle']);
		$instance['description'] = ($new_instance['description']);

		$instance['listservices_title'] = ($new_instance['listservices_title']);
		$instance['listservices_content'] = ($new_instance['listservices_content']);
        
        return $instance;
    }
    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'subtitle' => __( 'Subtitle', 'tried' ),
            'description' => __( 'Description', 'tried' ),
            'listservices_title' => array(),
            'listservices_content' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info block', 'tried' ); ?></h4>
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
    <label
        for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('description')); ?>"
        id="<?php echo esc_attr($this->get_field_id('description')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['description']); ?></textarea>
</p>
<h4><?php _e( 'List Service block', 'tried' ); ?><a class="button button-primary addnew-reclistlink"
        href="javascript:void(0)" title="<?php _e( 'Add new', 'tried' ); ?>"
        style="float: right;"><?php _e( 'Add new', 'tried' ); ?></a></h4>
<div class="reclistlinks">
    <?php
        if ( $instance['listservices_title'] ) {
            foreach ( $instance['listservices_title'] as $l => $litem ) {
                echo '<div class="reclistlink-item">'
                . '<h4>'.__( 'Item', 'tried' ).'<a href="javascript:void(0)" title="'.__( 'Remove', 'tried' ).'">'.__( 'Remove', 'tried' ).'</a></h4>'
                . '<p><label for="'.esc_attr($this->get_field_id('listservices_title')).'-'.$l.'">'.__( 'Title', 'tried' ).'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['listservices_title'][$l]).'" name="'.esc_attr($this->get_field_name('listservices_title')).'[]" id="'.esc_attr($this->get_field_id('listservices_title')).'-'.$l.'" />'
                . '</p><p>'
                . '<label for="'.esc_attr($this->get_field_id('listservices_content')).'-'.$l.'">'.__( 'Content', 'tried' ).'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listservices_content')).'[]"
                id="'.esc_attr($this->get_field_id('listservices_content')).'-1" cols="30" rows="2">'.esc_attr($instance['listservices_content'][$l]).'</textarea>'
                . '</p></div>';
            }
        } else {
            echo '<div class="reclistlink-item">'
            . '<h4>'.__( 'Item', 'tried' ).'</h4>'
            . '<p><label for="'.esc_attr($this->get_field_id('listservices_title')).'-1">'.__( 'Title', 'tried' ).'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('listservices_title')).'[]" id="'.esc_attr($this->get_field_id('listservices_title')).'-1" />'
            . '</p><p>'
            . '<label for="'.esc_attr($this->get_field_id('listservices_content')).'-1">'.__( 'Content', 'tried' ).'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listservices_content')).'[]"
            id="'.esc_attr($this->get_field_id('listservices_content')).'-1" cols="30" rows="2"></textarea>'
            . '</p></div>';
        }
    ?>
</div>
<style>
.reclistlinks {
    counter-reset: reclistservices;
    padding-top: 5px;
}

.reclistlinks .reclistlink-item>h4::after {
    counter-increment: reclistservices;
    content: counter(reclistservices);
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