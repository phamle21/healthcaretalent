<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_listclient extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_listclient', 'Tried Another List Client',
			array(
				'classname' => 'widget_another_listclient',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => '',
            'clients_logo' => array(), 'clients_link' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
        
		$title = $instance['title'];

		$clients_logo = $instance['clients_logo'];
		$clients_link = $instance['clients_link'];

		$key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another-listclient"
    data-control="<?php echo $key; ?>">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <?php
                if ( !empty( $title ) ) {
                    printf(
                        '<h4>%s</h4>',
                        $title
                    );
                }
            ?>
        </div>
        <div class="listclient-block">
            <?php if ( $clients_logo ) { ?>
            <div class="swiper widget-another-listclient">
                <div class="swiper-wrapper">
                    <?php 
                    for ( $l = 0; $l < count( $clients_logo ); $l++ ) {
                        if ( empty( $clients_logo[$l] ) ) continue;
                        printf(
                            '<div class="listclient-item swiper-slide"><div class="wrap"><a href="%s" title=""></a><img src="%s" alt=""/></div></div>',
                            $clients_link[$l], $clients_logo[$l]
                        );
                    }
                ?>
                </div>
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
		$instance['clients_logo'] = ($new_instance['clients_logo']);
		$instance['clients_link'] = ($new_instance['clients_link']);

        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => '',
            'clients_logo' => array(), 'clients_link' => array()
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
<h4><?php _e( 'List logos', 'tried' ); ?><a class="button button-primary addnew-reclistlink" href="javascript:void(0)"
        title="<?php _e( 'Add new', 'tried' ); ?>" style="float: right;"><?php _e( 'Add new', 'tried' ); ?></a></h4>
<div class="reclistlinks">
    <?php
        if ( $instance['clients_logo'] ) {
            foreach ( $instance['clients_logo'] as $l => $litem ) {
                echo '<div class="reclistlink-item">'
                . '<h4>'.__( 'Item', 'tried' ).'<a href="javascript:void(0)" title="'.__( 'Remove', 'tried' ).'">'.__( 'Remove', 'tried' ).'</a></h4>'
                . '<p><label for="'.esc_attr($this->get_field_id('clients_logo')).'-'.$l.'">'.__('Logo', '').'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('clients_logo')).'[]"
                id="'.esc_attr($this->get_field_id('clients_logo')).'-1" cols="30"
                rows="4">'.esc_attr($instance['clients_logo'][$l]).'</textarea>'
                . '</p><p>'
                . '<label
                for="'.esc_attr($this->get_field_id('clients_link')).'-'.$l.'">'.__('Link', 'tried').'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['clients_link'][$l]).'" name="'.esc_attr($this->get_field_name('clients_link')).'[]" id="'.esc_attr($this->get_field_id('clients_link')).'-'.$l.'" />'
                . '</p></div>';
            }
        } else {
            echo '<div class="reclistlink-item">'
            . '<h4>'.__( 'Item', 'tried' ).'</h4>'
            . '<p><label for="'.esc_attr($this->get_field_id('clients_logo')).'-1">'.__('Logo', 'tried').'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('clients_logo')).'[]"
            id="'.esc_attr($this->get_field_id('clients_logo')).'-1" cols="30"
            rows="4"></textarea>'
            . '</p><p>'
            . '<label
            for="'.esc_attr($this->get_field_id('clients_link')).'-1">'.__('Link', 'tried').'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('clients_link')).'[]" id="'.esc_attr($this->get_field_id('clients_link')).'-1" />'
            . '</p></div>';
        }
    ?>
</div>
<style>
.reclistlinks {
    counter-reset: reclistclients;
    padding-top: 5px;
}

.reclistlinks .reclistlink-item>h4::after {
    counter-increment: reclistclients;
    content: counter(reclistclients);
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