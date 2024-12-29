<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_footer_menucert extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_footer_menucert', 'Tried Footer Menu Cert',
			array(
				'classname' => 'widget_footer_menucert',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
	    $defaults = array(
            'title_menu' => '', 'id_menu' => '',
            'title_menu2' => '', 'id_menu2' => '',
            'title_cert' => '', 'image_cert' => '', 'link_cert' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$title_menu = $instance['title_menu'];
		$id_menu = $instance['id_menu'];
        $menu = wp_get_nav_menu_items($id_menu);

		$title_menu2 = $instance['title_menu2'];
		$id_menu2 = $instance['id_menu2'];
        $menu2 = wp_get_nav_menu_items($id_menu2);

		$title_cert = $instance['title_cert'];
		$image_cert = !empty( $instance['image_cert'] ) ? $instance['image_cert'] : get_theme_file_uri( "/assets/img/tried-lcert.png" );
		$link_cert = $instance['link_cert'];
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-footer-menucert">
    <div class="section-wrapper margin-auto nav">
        <div class="menu-block">
            <?php if ( !empty($menu) && !empty( $title_menu ) ) { ?>
            <h4 class="menu-title"><?php echo $title_menu; ?></h4>
            <ul class="menu">
                <?php foreach ($menu as $item) { ?>
                <li class="item"><a href="<?php echo $item->url; ?>"
                        title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
        <?php if ( !empty($menu2) && !empty( $title_menu2 ) ) { ?>
        <div class="menu-block">
            <h4 class="menu-title"><?php echo $title_menu2; ?></h4>
            <ul class="menu">
                <?php foreach ($menu2 as $item2) { ?>
                <li class="item"><a href="<?php echo $item2->url; ?>"
                        title="<?php echo $item2->title; ?>"><?php echo $item2->title; ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
        <?php if ( !empty( $link_cert ) ) : ?>
        <div class="cert-block">
            <h4 class="cert-title"><?php echo $title_cert; ?></h4>
            <a class="cert" href="<?php echo $link_cert; ?>" title="<?php _e( 'Chứng nhận', 'tried' ); ?>">
                <img src="<?php echo $image_cert; ?>" alt="" />
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		$instance['title_menu'] = strip_tags($new_instance['title_menu']);
		$instance['id_menu'] = !empty($new_instance['id_menu']) ? $new_instance['id_menu'] : '0';

		$instance['title_menu2'] = strip_tags($new_instance['title_menu2']);
		$instance['id_menu2'] = !empty($new_instance['id_menu2']) ? $new_instance['id_menu2'] : '0';

		$instance['title_cert'] = ($new_instance['title_cert']);
		$instance['image_cert'] = ($new_instance['image_cert']);
		$instance['link_cert'] = ($new_instance['link_cert']);
		return $instance;
	}
	
	function form( $instance ) {
        $defaults = array(
            'title_menu' => '', 'id_menu' => '',
            'title_menu2' => '', 'id_menu2' => '',
            'title_cert' => '', 'image_cert' => '', 'link_cert' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        $nav_menus = wp_get_nav_menus();
        ?>
<h5><?php esc_html_e('Menu 1', ''); ?></h5>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_menu')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_menu']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_menu')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_menu')); ?>" />
</p>
<div style="margin-bottom: 5px; min-height: 25px;">
    <?php if (!empty($nav_menus)) : ?>
    <span style="width: 20%; float:left; line-height: 20px;"><?php _e('Menu 1', ''); ?>:</span>
    <span style="float:left; : 70%; margin-left: 5%">
        <select id="<?php echo esc_attr($this->get_field_id('id_menu')); ?>" class="widefat"
            name="<?php echo esc_attr($this->get_field_name('id_menu')); ?>">
            <?php foreach ($nav_menus as $menu) : ?>
            <option value="<?=$menu->term_id?>" <?php selected($menu->term_id, $instance['id_menu']); ?>>
                <?=$menu->name ?></option>
            <?php endforeach; ?>
        </select>
    </span>
    <?php endif; ?>
</div>
<h5><?php esc_html_e('Menu 2', ''); ?></h5>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_menu2')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_menu2']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_menu2')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_menu2')); ?>" />
</p>
<div style="margin-bottom: 5px; min-height: 25px;">
    <?php if (!empty($nav_menus)) : ?>
    <span style="width: 20%; float:left; line-height: 20px;"><?php _e('Menu 2', ''); ?>:</span>
    <span style="float:left; : 70%; margin-left: 5%">
        <select id="<?php echo esc_attr($this->get_field_id('id_menu2')); ?>" class="widefat"
            name="<?php echo esc_attr($this->get_field_name('id_menu2')); ?>">
            <?php foreach ($nav_menus as $menu) : ?>
            <option value="<?=$menu->term_id?>" <?php selected($menu->term_id, $instance['id_menu2']); ?>>
                <?=$menu->name ?></option>
            <?php endforeach; ?>
        </select>
    </span>
    <?php endif; ?>
</div>
<h5><?php esc_html_e('Chứng nhận', ''); ?></h5>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_cert')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_cert']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_cert')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_cert')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('image_cert')); ?>"><?php esc_html_e('Đường dẫn hình ảnh', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['image_cert']); ?>"
        name="<?php echo esc_attr($this->get_field_name('image_cert')); ?>"
        id="<?php echo esc_attr($this->get_field_id('image_cert')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('link_cert')); ?>"><?php esc_html_e('Link', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['link_cert']); ?>"
        name="<?php echo esc_attr($this->get_field_name('link_cert')); ?>"
        id="<?php echo esc_attr($this->get_field_id('link_cert')); ?>" />
</p>
<?php
	}
}