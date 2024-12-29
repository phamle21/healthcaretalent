<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_contact_infoform extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_contact_infoform', 'Tried Contact Info Form',
			array(
				'classname' => 'widget_contact_infoform',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title_info' => __( 'Contact', 'tried' ),
            'content_info' => '',
            'content_phone' => '',
            'content_email' => '',
            'content_address' => '',
            'link_address' => '',
            'listreviews_logo' => array(),
            'listreviews_content' => array(),
            'listreviews_author' => array(),
            'listreviews_avatar' => array(),
            'title_form' => __( 'Title', 'tried' ),
            'context_form' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		$title_info = $instance['title_info'];
		$content_info = $instance['content_info'];
		$content_phone = $instance['content_phone'];
		$content_email = $instance['content_email'];
		$content_address = $instance['content_address'];
		$link_address = $instance['link_address'];

		$listreviews_logo = $instance['listreviews_logo'];
		$listreviews_content = $instance['listreviews_content'];
		$listreviews_author = $instance['listreviews_author'];
		$listreviews_avatar = $instance['listreviews_avatar'];

        $key = wp_generate_uuid4();

		$title_form = $instance['title_form'];
		$context_form = $instance['context_form'];
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-contact-infoform"
    data-control="<?php echo $key; ?>">
    <div class="section-wrapper margin-auto">
        <div class="info-block">
            <div class="wrapper">
                <h4 class="title"><?php echo $title_info; ?></h4>
                <div class="infos">
                    <?php if ( !empty( $content_info ) ) { ?>
                    <p class="info-item info"><?php echo $content_info; ?></p>
                    <?php } ?>
                    <?php if ( !empty( $content_phone ) ) { ?>
                    <p class="info-item phone">
                        <a href="tel:<?php echo $content_phone; ?>" title="<?php echo $content_phone; ?>">
                            <span></span>
                            <strong><?php echo $content_phone; ?></strong>
                        </a>
                    </p>
                    <?php } ?>
                    <?php if ( !empty( $content_email ) ) { ?>
                    <p class="info-item email">
                        <a href="mailto:<?php echo $content_email; ?>" title="<?php echo $content_email; ?>">
                            <span></span>
                            <strong><?php echo $content_email; ?></strong>
                        </a>
                    </p>
                    <?php } ?>
                    <?php if ( !empty( $content_address ) ) { ?>
                    <p class="info-item address">
                        <a <?php echo !empty( $link_address ) ? 'target="_blank"' : ''; ?> href="<?php echo !empty( $link_address ) ? $link_address : 'javascript:void(0)'; ?>" title="<?php echo $content_address; ?>">
                            <span></span>
                            <strong><?php echo $content_address; ?></strong>
                        </a>
                    </p>
                    <?php } ?>
                </div>
                <div class="reviews">
                    <?php
                        if ( !empty( $listreviews_author ) ) {
                            echo '<div class="swiper widget-contact-infoform"><div class="swiper-wrapper">';
                            foreach ( $listreviews_author as $l => $litem ) {
                                get_template_part( 'template-parts/review-item/item', null, array(
                                    'logo' => $listreviews_logo[$l],
                                    'content' => $listreviews_content[$l],
                                    'author' => $listreviews_author[$l],
                                    'avatar' => $listreviews_avatar[$l],
                                    'is_slide' => true
                                ) );
                            }
                            echo '</div></div><div class="swiper-pagination"></div>';
                        } else {
                            printf( '<p class="not-found">%s</p>', __( 'Không tìm thấy sản phẩm', 'tried' ) );
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="form-block">
            <div class="wrapper">
                <h4 class="title"><?php echo $title_form; ?></h4>
                <div class="form-box">
                    <?php
                        if (!empty($context_form)) {
                            echo do_shortcode('[contact-form-7 id="'.$context_form.'"]');
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title_info'] = ($new_instance['title_info']);
		$instance['content_info'] = ($new_instance['content_info']);
		$instance['content_phone'] = ($new_instance['content_phone']);
		$instance['content_email'] = ($new_instance['content_email']);
		$instance['content_address'] = ($new_instance['content_address']);
		$instance['link_address'] = ($new_instance['link_address']);

		$instance['listreviews_logo'] = ($new_instance['listreviews_logo']);
		$instance['listreviews_content'] = ($new_instance['listreviews_content']);
		$instance['listreviews_author'] = ($new_instance['listreviews_author']);
		$instance['listreviews_avatar'] = ($new_instance['listreviews_avatar']);

		$instance['title_form'] = ($new_instance['title_form']);
		$instance['context_form'] = ($new_instance['context_form']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title_info' => __( 'Contact', 'tried' ),
            'content_info' => '',
            'content_phone' => '',
            'content_email' => '',
            'content_address' => '',
            'link_address' => '',
            'listreviews_logo' => array(),
            'listreviews_content' => array(),
            'listreviews_author' => array(),
            'listreviews_avatar' => array(),
            'title_form' => __( 'Title', 'tried' ),
            'context_form' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        $cf7 = get_posts(array(
            'post_type'     => 'wpcf7_contact_form',
            'numberposts'   => -1
        ));
		?>
<h4><?php _e( 'Info block', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_info')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_info']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_info')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_info')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_info')); ?>"><?php esc_html_e('Content', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_info')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_info')); ?>" cols="30"
        rows="4"><?php echo esc_attr($instance['content_info']); ?></textarea>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content_phone')); ?>"><?php esc_html_e('Phone', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['content_phone']); ?>"
        name="<?php echo esc_attr($this->get_field_name('content_phone')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_phone')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('content_email')); ?>"><?php esc_html_e('Email', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['content_email']); ?>"
        name="<?php echo esc_attr($this->get_field_name('content_email')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_email')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('content_address')); ?>"><?php esc_html_e('Address', ''); ?></label>
    <textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_address')); ?>"
        id="<?php echo esc_attr($this->get_field_id('content_address')); ?>" cols="30"
        rows="2"><?php echo esc_attr($instance['content_address']); ?></textarea>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('link_address')); ?>"><?php esc_html_e('EmailE(link)', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['link_address']); ?>"
        name="<?php echo esc_attr($this->get_field_name('link_address')); ?>"
        id="<?php echo esc_attr($this->get_field_id('link_address')); ?>" />
</p>
<h4><?php _e( 'List reviews', 'tried' ); ?><a class="button button-primary addnew-reclistlink" href="javascript:void(0)"
        title="<?php _e( 'Add new', 'tried' ); ?>" style="float: right;"><?php _e( 'Add new', 'tried' ); ?></a></h4>
<div class="reclistlinks">
    <?php
        if ( $instance['listreviews_author'] ) {
            foreach ( $instance['listreviews_author'] as $l => $litem ) {
                echo '<div class="reclistlink-item">'
                . '<h4>'.__( 'Item', 'tried' ).'<a href="javascript:void(0)" title="'.__( 'Remove', 'tried' ).'">'.__( 'Remove', 'tried' ).'</a></h4>'
                . '<p><label for="'.esc_attr($this->get_field_id('listreviews_logo')).'-'.$l.'">'.__( 'Logo', 'tried' ).'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listreviews_logo')).'[]"
                id="'.esc_attr($this->get_field_id('listreviews_logo')).'-1" cols="30" rows="2">'.esc_attr($instance['listreviews_logo'][$l]).'</textarea>'
                . '</p><p cl><label for="'.esc_attr($this->get_field_id('listreviews_content')).'-'.$l.'">'.__( 'Content', 'tried' ).'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listreviews_content')).'[]"
                id="'.esc_attr($this->get_field_id('listreviews_content')).'-1" cols="30" rows="4">'.esc_attr($instance['listreviews_content'][$l]).'</textarea>'
                . '</p><p>'
                . '<label for="'.esc_attr($this->get_field_id('listreviews_author')).'-'.$l.'">'.__( 'Author', 'tried' ).'</label>'
                . '<input class="widefat" type="text" value="'.esc_attr($instance['listreviews_author'][$l]).'" name="'.esc_attr($this->get_field_name('listreviews_author')).'[]" id="'.esc_attr($this->get_field_id('listreviews_author')).'-'.$l.'" />'
                . '</p><p>'
                . '<label for="'.esc_attr($this->get_field_id('listreviews_avatar')).'-'.$l.'">'.__( 'Avatar', 'tried' ).'</label>'
                . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listreviews_avatar')).'[]"
                id="'.esc_attr($this->get_field_id('listreviews_avatar')).'-1" cols="30" rows="2">'.esc_attr($instance['listreviews_avatar'][$l]).'</textarea>'
                . '</p></div>';
            }
        } else {
            echo '<div class="reclistlink-item">'
            . '<h4>'.__( 'Item', 'tried' ).'</h4>'
            . '<p><label for="'.esc_attr($this->get_field_id('listreviews_logo')).'-1">'.__( 'Logo', 'tried' ).'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listreviews_logo')).'[]"
            id="'.esc_attr($this->get_field_id('listreviews_logo')).'-1" cols="30" rows="2"></textarea>'
            . '</p><p><label for="'.esc_attr($this->get_field_id('listreviews_content')).'-1">'.__( 'Content', 'tried' ).'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listreviews_content')).'[]"
            id="'.esc_attr($this->get_field_id('listreviews_content')).'-1" cols="30" rows="4"></textarea>'
            . '</p><p>'
            . '<label for="'.esc_attr($this->get_field_id('listreviews_author')).'-1">'.__( 'Author', 'tried' ).'</label>'
            . '<input class="widefat" type="text" value="" name="'.esc_attr($this->get_field_name('listreviews_author')).'[]" id="'.esc_attr($this->get_field_id('listreviews_author')).'-1" />'
            . '</p><p>'
            . '<label for="'.esc_attr($this->get_field_id('listreviews_avatar')).'-1">'.__( 'Avatar', 'tried' ).'</label>'
            . '<textarea class="widefat" name="'.esc_attr($this->get_field_name('listreviews_avatar')).'[]"
            id="'.esc_attr($this->get_field_id('listreviews_avatar')).'-1" cols="30" rows="2"></textarea>'
            . '</p></div>';
        }
    ?>
</div>
<h4><?php _e( 'Form block', 'tried' ); ?></h4>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title_form')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title_form']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title_form')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title_form')); ?>" />
</p>
<?php if (!empty($cf7)) : ?>
<div style="margin-bottom: 5px; min-height: 25px;">
    <span style="width: 20%; float:left; line-height: 20px;"><?php _e('Form', ''); ?>:</span>
    <span style="float:left; : 70%; margin-left: 5%">
        <select id="<?php echo esc_attr($this->get_field_id('context_form')); ?>" class="widefat"
            name="<?php echo esc_attr($this->get_field_name('context_form')); ?>">
            <?php foreach ($cf7 as $it_7) : ?>
            <option value="<?=$it_7->ID?>" <?php selected($it_7->ID, $instance['context_form']); ?>>
                <?php echo $it_7->post_title ?></option>
            <?php endforeach; ?>
        </select>
    </span>
</div>
<?php endif; ?>
<style>
.reclistlinks {
    counter-reset: reclistreviews;
    padding-top: 5px;
}

.reclistlinks .reclistlink-item>h4::after {
    counter-increment: reclistreviews;
    content: counter(reclistreviews);
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