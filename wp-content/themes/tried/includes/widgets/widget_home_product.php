<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_product extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_home_product', 'Tried Home Product',
			array(
				'classname' => 'widget_home_product',
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

		$categories = get_field('cat_products','widget_'.$args['widget_id']);

		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-product">
				<?php if (!empty($subtitle)) : ?>
					<h5 class="section-subtitle"><?php echo $subtitle; ?></h5>
				<?php endif; ?>
				<h4 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title'];?></h4>
				<div class="section-wrapper margin-auto">
					<?php
                        if(!empty($categories)) :
												if (!empty($categories)) :
													$products = new WP_Query(array(
														'post_type' => 'product',
														'posts_per_page' => 8,
														// 'post__in' => $category['products']
														'tax_query'      => array( array(
															'taxonomy' => 'product_cat', // The taxonomy name
															'field'    => 'term_id', // Type of field ('term_id', 'slug', 'name' or 'term_taxonomy_id')
															'terms'    => $categories, // can be an integer, a string or an array
														) ),
													));
													if ( $products->have_posts() ) :
											?>
														<div class="swiper widget-home-products">
															<div class="swiper-wrapper">
											<?php
																while ( $products->have_posts() ) :
																	$products->the_post();
									                                global $post, $product;
																	$image_id  = get_post_thumbnail_id( $product->id );
																	$image_url = wp_get_attachment_image_url( $image_id, 'full' );
                                                                    $terms = get_the_terms( $product->ID, 'product_cat' );
											?>
																	<div class="swiper-slide product-item">
																		<div class="box">
																			<div class="feature-image">
																				<img src="<?php echo $image_url; ?>" alt="">
																				<a href="<?php echo get_permalink($product->ID); ?>" class="lightbox"><i class="fas fa-shopping-cart"></i><?php _e('Mua ngay', ''); ?></a>
																			</div>
																			<div class="info-block">
                                                                                <?php if (!empty($terms)) : ?>
                                                                                    <div class="terms">
                                                                                        <span><?php echo $terms[0]->name; ?></span>
                                                                                    </div>
                                                                                <?php endif; ?>
																				<h3 class="title"><a href="<?php echo get_permalink($product->ID); ?>"><?php echo get_the_title($product->ID); ?></a></h3>
                                                                                <!-- <div class="extra"> -->
                                                                                    <?php
                                                                                        // $_product = wc_get_product( $post->ID );
                                                                                        // if (!empty($_product->get_price_html())) :
                                                                                        //     echo '<p class="price">'.$_product->get_price_html().'</p>';
                                                                                        // else :
                                                                                        //     echo '<p class="no-price"><span>'.__('Liên hệ', '').'</span></p>';
                                                                                        // endif;
					                                                                ?>
                                                                                <!-- </div> -->
																			</div>
																		</div>
																	</div>
											<?php
																endwhile;
											?>
															</div>
														</div>
														<div class="swiper-button swiper-button-prev k-<?php echo $key; ?>"></div>
														<div class="swiper-button swiper-button-next k-<?php echo $key; ?>"></div>
											<?php
													else :
														_e( 'Không tìm thấy sản phẩm', '' );
													endif;
													wp_reset_postdata();
												else :
													_e( 'Không tìm thấy sản phẩm', '' );
												endif;
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
