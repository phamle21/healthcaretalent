<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_advicebycats extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_advicebycats', 'Tried Another Advice by Cats',
			array(
				'classname' => 'widget_another_advicebycats',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'categories' => array(),
			'limit' => 3
        );
        $instance = wp_parse_args($instance, $defaults);

		$categories = $instance['categories'];
		$limit = $instance['limit'];

		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another-advicebycats">
    <?php
        if ( !empty( $categories ) ) {
            foreach ( $categories as $catID ) {
                $advices = apply_filters( 'tried_all_posttype_of_taxonomy', $catID, 'advice_cat', 'advice' );
                if ( !empty( $advices ) ) {
                    echo '<div class="advice-block">'
                    . '<div class="section-wrapper margin-auto">'
                    . '<h4 class="title-advice">'.$advices[0]->clientName.'</h4>'
                    . '<a class="viewall-advice" href="'.get_term_link( intval( $catID ), 'advice_cat' ).'" title="'.$advices[0]->clientName.'">'.__( 'View All', 'tried' ).'</a>'
                    . '<div class="advices">';
                    foreach ( $advices as $ad => $advice ) {
                        if ($ad >= $limit) break; 
                        get_template_part( 'template-parts/advice-item/item', null, array(
                            'id' => $advice->ID
                        ) );
                    }
                    echo '</div></div></div>';
                } else {
                    _e( 'Không tìm thấy sản phẩm', '' );
                }
            }
        }
    ?>
</section>
<?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['categories'] = ($new_instance['categories']);
		$instance['limit'] = ($new_instance['limit']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'categories' => array(),
			'limit' => 3
        );
        $instance = wp_parse_args($instance, $defaults);
        $adviceCats = apply_filters( 'tried_all_taxonomy', 'advice_cat' );
		?>
<p id="inpt-catsadvice">
    <?php
                if ( !empty( $adviceCats ) ) {
                    foreach ( $adviceCats as $c => $cat ) {
                        printf(
                            '<div><input class="widefat" type="checkbox" name="%s[]" id="%s" value="%s" %s><label for="%s">%s</label></div>',
                            esc_attr($this->get_field_name('categories')),
                            esc_attr($this->get_field_id('categories')).'-'.$c,
                            $cat->term_id,
                            $instance['categories'] && in_array( $cat->term_id, $instance['categories'] )?'checked':'',
                            esc_attr($this->get_field_id('categories')).'-'.$c,
                            $cat->name
                        );
                    }
                }
            ?>
    </input>
    <style>
    #inpt-catsadvice select option {
        -webkit-line-clamp: 1;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        white-space: normal;
        overflow: hidden;
        height: 24px;
        font-size: 14px;
        padding: 5px 10px;
        box-sizing: border-box;
    }
    </style>
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>"><?php esc_html_e('Limit advice', ''); ?></label>
    <input class="widefat" type="number" value="<?php echo esc_attr($instance['limit']); ?>"
        name="<?php echo esc_attr($this->get_field_name('limit')); ?>"
        id="<?php echo esc_attr($this->get_field_id('limit')); ?>" />
</p>
<?php
    }
}