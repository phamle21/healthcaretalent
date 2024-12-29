<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_catproduct extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_catproduct', 'Tried Home Cat Product',
			array(
				'classname' => 'widget_home_catproduct',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array('title' => 'Sản phẩm nổi bật', 'subtitle' => '');
        $instance = wp_parse_args($instance, $defaults);

		$title = $instance['title'];
		$subtitle = $instance['subtitle'];

		$categories = get_field('categories','widget_'.$args['widget_id']);

		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-catproduct">
				<?php if (!empty($subtitle)) : ?>
					<h5 class="section-subtitle"><?php echo $subtitle; ?></h5>
				<?php endif; ?>
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title'];?></h4>
				<div class="section-wrapper margin-auto">
					<?php
						if(!empty($categories)) :
							foreach($categories as $key => $category) :
								$generate = wp_generate_uuid4();
					?>
								<div class="category-block" data-control="<?php echo $key; ?>">
										<div class="products">
											<?php
												if (!empty($category['category_product'])) :
											?>
													<div class="swiper widget-home-catproduct-<?php echo $key; ?>">
													<div class="swiper-wrapper">
											<?php
													foreach ($category['category_product'] as $key => $termid) :
														$cat = get_term_by( 'id', $termid, 'product_cat', 'ARRAY_A' );
														$thumbnail_id = get_woocommerce_term_meta( $cat['term_id'], 'thumbnail_id', true );
														$image_url = wp_get_attachment_url( $thumbnail_id );
											?>
																	<div class="swiper-slide product-item">
																		<div class="box">
																			<div class="feature-image">
																				<img src="<?php echo $image_url; ?>" alt="">
																			</div>
																			<div class="info-block">
																				<h3 class="title"><a href="<?php echo get_term_link($cat['term_id']); ?>"><?php echo $cat['name']; ?></a></h3>
																				<p class="count"><?php echo $cat['count'].' '.__('Sản phẩm', ''); ?></p>
																			</div>
																		</div>
																	</div>
											<?php
													endforeach;
											?>
													</div>
												</div>
												<div class="swiper-button swiper-button-prev" key="<?php echo $key; ?>"></div>
												<div class="swiper-button swiper-button-next" key="<?php echo $key; ?>"></div>
											<?php
												else :
													_e( 'Không tìm thấy sản phẩm', '' );
												endif;
											?>
										</div>
								</div>
					<?php 
							endforeach;
						endif;
					?>
				</div>
			</section>
        <?php
		echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title'] = ($new_instance['title']);
		$instance['subtitle'] = ($new_instance['subtitle']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array('title' => 'Sản phẩm nổi bật', 'subtitle' => '');
        $instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php esc_html_e('Title', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['subtitle']); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
		<?php
    }
}
