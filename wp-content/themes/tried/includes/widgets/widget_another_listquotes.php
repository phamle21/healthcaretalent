<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_listquotes extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_listquotes', 'Tried Another List Quotes',
			array(
				'classname' => 'widget_another_listquotes',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'listquotes_title' => array(), 'listquotes_content' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
        
		$title = $instance['title'];
		$listquotes_title = $instance['listquotes_title'];
		$listquotes_content = $instance['listquotes_content'];

		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another_listquotes">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <h4><?php echo $title; ?></h4>
        </div>
        <?php if ( $listquotes_title ) { ?>
        <div class="listquotes-block">
            <div class="listquotes">
                <?php
                    for ( $l = 0; $l < count( $listquotes_title ); $l++ ) {
                        if ( empty( $listquotes_title ) ) continue;
                        printf(
                            '<div class="quote-item"><p>%s</p><h4>%s</h4></div>',
                            $listquotes_content[$l], $listquotes_title[$l]
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
		$instance['listquotes_title'] = ($new_instance['listquotes_title']);
		$instance['listquotes_content'] = ($new_instance['listquotes_content']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => __( 'Title', 'tried' ),
            'listquotes_title' => array(), 'listquotes_content' => array()
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
<h4><?php _e( 'List links', 'tried' ); ?><a class="button button-primary addnew-reclistlink" href="javascript:void(0)"
        title="<?php _e( 'Add new', 'tried' ); ?>" style="float: right;"><?php _e( 'Add new', 'tried' ); ?></a></h4>
<div class="reclistlinks">
    <?php
        if ( $instance['listquotes_title'] ) {
            foreach ( $instance['listquotes_title'] as $l => $litem ) {
                echo '<div class="reclistlink-item">'
                . '<h4>'.__( 'Item', 'tried' ).'<a href="javascript:void(0)" title="'.__( 'Remove', 'tried' ).'">'.__( 'Remove', 'tried' ).'</a></h4>'
                . '<p class="title"><label for="'.esc_attr($this->get_field_id('listquotes_content')).'-'.$l.'">'.__('Content', '').'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listquotes_content')).'[]"
                id="'.esc_attr($this->get_field_id('listquotes_content')).'-1" cols="30"
                rows="4">'.esc_attr($instance['listquotes_content'][$l]).'</textarea>'
                . '</p><p class="link">'
                . '<label
                for="'.esc_attr($this->get_field_id('listquotes_title')).'-'.$l.'">'.__('Title', '').'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['listquotes_title'][$l]).'" name="'.esc_attr($this->get_field_name('listquotes_title')).'[]" id="'.esc_attr($this->get_field_id('listquotes_title')).'-'.$l.'" />'
                . '</p></div>';
            }
        } else {
            echo '<div class="reclistlink-item">'
            . '<h4>'.__( 'Item', 'tried' ).'</h4>'
            . '<p class="title"><label for="'.esc_attr($this->get_field_id('listquotes_content')).'-1">'.__('Content', '').'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listquotes_content')).'[]"
            id="'.esc_attr($this->get_field_id('listquotes_content')).'-1" cols="30"
            rows="4"></textarea>'
            . '</p><p class="link">'
            . '<label
            for="'.esc_attr($this->get_field_id('listquotes_title')).'-1">'.__('Title', '').'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('listquotes_title')).'[]" id="'.esc_attr($this->get_field_id('listquotes_title')).'-1" />'
            . '</p></div>';
        }
    ?>
</div>
<style>
.reclistlinks {
    counter-reset: reclistquotes;
    padding-top: 5px;
}

.reclistlinks .reclistlink-item>h4::after {
    counter-increment: reclistquotes;
    content: counter(reclistquotes);
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