<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_infolistlink extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_infolistlink', 'Tried Another Info List Link',
			array(
				'classname' => 'widget_another_infolistlink',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ), 'content' => '',
            'listlinks_title' => array(), 'listlinks_link' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
        
		$title = $instance['title'];
		$content = $instance['content'];
		$listlinks_title = $instance['listlinks_title'];
		$listlinks_link = $instance['listlinks_link'];

		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another_infolistlink">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h4><?php echo $title; ?></h4>
            <p><?php echo $content; ?></p>
        </div>
        <?php if ( $listlinks_title ) { ?>
        <div class="listlinks-block">
            <div class="listlinks">
                <?php
                    for ( $l = 0; $l < count( $listlinks_title ); $l++ ) {
                        printf(
                            '<span><a href="%s" title="%s">%s</a></span>',
                            $listlinks_link[$l], $listlinks_title[$l], $listlinks_title[$l]
                        );
                    }
                ?>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['content'] = ($new_instance['content']);
		$instance['listlinks_title'] = ($new_instance['listlinks_title']);
		$instance['listlinks_link'] = ($new_instance['listlinks_link']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ), 'content' => '',
            'listlinks_title' => array(), 'listlinks_link' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Info', 'tried' ); ?></h4>
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
<h4><?php _e( 'List links', 'tried' ); ?><a class="button button-primary addnew-reclistlink" href="javascript:void(0)"
        title="<?php _e( 'Add new', 'tried' ); ?>" style="float: right;"><?php _e( 'Add new', 'tried' ); ?></a></h4>
<div class="reclistlinks">
    <?php
        if ( $instance['listlinks_title'] ) {
            foreach ( $instance['listlinks_title'] as $l => $litem ) {
                echo '<div class="reclistlink-item">'
                . '<h4>'.__( 'Item', 'tried' ).'<a href="javascript:void(0)" title="'.__( 'Remove', 'tried' ).'">'.__( 'Remove', 'tried' ).'</a></h4>'
                . '<p class="title"><label for="'.esc_attr($this->get_field_id('listlinks_title')).'-'.$l.'">'.__('Button', '').'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['listlinks_title'][$l]).'" name="'.esc_attr($this->get_field_name('listlinks_title')).'[]" id="'.esc_attr($this->get_field_id('listlinks_title')).'-'.$l.'" />'
                . '</p><p class="link">'
                . '<label
                for="'.esc_attr($this->get_field_id('listlinks_link')).'-'.$l.'">'.__('Button link', '').'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['listlinks_link'][$l]).'" name="'.esc_attr($this->get_field_name('listlinks_link')).'[]" id="'.esc_attr($this->get_field_id('listlinks_link')).'-'.$l.'" />'
                . '</p></div>';
            }
        } else {
            echo '<div class="reclistlink-item">'
            . '<h4>'.__( 'Item', 'tried' ).'</h4>'
            . '<p class="title"><label for="'.esc_attr($this->get_field_id('listlinks_title')).'-1">'.__('Button', '').'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('listlinks_title')).'[]" id="'.esc_attr($this->get_field_id('listlinks_title')).'-1" />'
            . '</p><p class="link">'
            . '<label
            for="'.esc_attr($this->get_field_id('listlinks_link')).'-1">'.__('Button link', '').'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('listlinks_link')).'[]" id="'.esc_attr($this->get_field_id('listlinks_link')).'-1" />'
            . '</p></div>';
        }
    ?>
</div>
<style>
.reclistlinks {
    counter-reset: reclistlinks;
    padding-top: 5px;
}

.reclistlinks .reclistlink-item>h4::after {
    counter-increment: reclistlinks;
    content: counter(reclistlinks);
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