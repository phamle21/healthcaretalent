<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_explore_advicecats extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_explore_advicecats', 'Tried Another Explore Advice Cats',
			array(
				'classname' => 'widget_another_explore_advicecats',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'title' => __( 'Explore all categories', 'tried' ),
            'categories' => array()
        );
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$categories = $instance['categories'];
        
        $htmlAdviceCatRoot = '';
        $htmlAdviceCatChild = '';
        if ( !empty( $categories ) ) {
            foreach ( $categories as $c => $catID ) {
                $adviceCat = get_term( $catID, 'advice_cat' );
                if ( $adviceCat ) {
                    $adviceCatChilds = get_term_children( $adviceCat->term_id, 'advice_cat' );
                    $htmlAdviceCatRoot .= '<a class="'.($c==0?'active':'').'" href="javascript:void(0)" data-catid="'.$adviceCat->term_id.'" title="'.$adviceCat->name.'">'.$adviceCat->name.'</a>';
                    if ( !empty( $adviceCatChilds ) ) {
                        $htmlAdviceCatChild .= '<div class="group-advice-catchild '.($c==0?'active':'').'" data-role="'.$adviceCat->term_id.'"><div class="advice-catchilds">';
                        foreach ( $adviceCatChilds as $catChild ) {
                            $adviceCatChild = get_term( $catChild, 'advice_cat' );
                            if ( $adviceCatChild ) {
                                $htmlAdviceCatChild .= '<a href="'.get_term_link( $adviceCatChild->term_id, 'advice_cat' ).'" data-root="'.$adviceCatChild->term_id.'" title="'.$adviceCatChild->name.'">'.$adviceCatChild->name.'<span class="count-advice">('.$adviceCatChild->count.')</span></a>';
                            }
                        }
                        $htmlAdviceCatChild .= '</div><div class="advice-catrootlink"><a href="'.get_term_link( $adviceCat->term_id, 'advice_cat' ).'" title="'.$adviceCat->name.'">'.__( 'View all', 'tried' ).' '.$adviceCat->name.'</a></div></div>';
                    }
                }
            }
        }
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another-explore_advicecats">
    <div class="section-wrapper margin-auto">
        <h4 class="title-advice"><?php echo $title; ?></h4>
        <div class="advice_cats-block">
            <div class="advice_cats-root">
                <?php echo $htmlAdviceCatRoot; ?>
            </div>
            <div class="advice_cats-child">
                <?php echo $htmlAdviceCatChild; ?>
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
		$instance['categories'] = ($new_instance['categories']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'title' => __( 'Explore all categories', 'tried' ),
            'categories' => array()
        );
        $instance = wp_parse_args($instance, $defaults);
        $adviceCats = apply_filters( 'tried_all_taxonomy', 'advice_cat' );
		?>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
</p>
<p id="inpt-explore_advicecats">
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
    #inpt-explore_advicecats select option {
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
<?php
    }
}