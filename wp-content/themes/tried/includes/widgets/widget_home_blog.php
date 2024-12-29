<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_blog extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_blog', 'Tried Home Blog',
			array(
				'classname' => 'widget_home_blog',
				'description' => esc_html__('Danh sách Bài viết', ''),
				'customize_selective_refresh' => true
			)
		);
	}

	function widget($args, $instance) {
		$defaults = array('title' => 'Tin tức nổi bật');
        $instance = wp_parse_args($instance, $defaults);
		$title = $instance['title'];
		$key = wp_generate_uuid4();
		$posts = get_posts(array (
			'post_type' => 'post',
			'orderby' => 'date',
			'order'=> 'DESC', 
			'post_status' => 'publish',
			'posts_per_page' => 6
		));
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-blog" data-control="<?php echo $key; ?>">
				<h3 class="section-title"><?php echo $args['before_title'] .$title. $args['after_title']; ?></h3>
				<div class="section-navbutton mwidth-main margin-auto">
					<div class="swiper-button swiper-button-prev"></div>
					<div class="swiper-button swiper-button-next"></div>
				</div>
				<div class="section-wrapper margin-auto">
					<div class="swiper widget-home-blog">
						<div class="swiper-wrapper">
							<?php 
								if (!empty($posts)) :
									foreach ($posts as $post) :
										$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
										$terms = get_the_terms( $post->ID, 'category' );
							?>
										<div class="blog-item swiper-slide">
											<div class="wrap">
												<div class="featured-image">
													<a href="<?php echo get_permalink($post->ID); ?>" title=""><img src="<?php echo $image_url[0]; ?>" alt=""></a>
												</div>
												<div class="box-contain">
													<h5 class="title"><?php echo get_the_title($post->ID); ?></h5>
													<ul class="meta">
														<li class="date">
															<i class="far fa-calendar-alt"></i>
															<span><?php echo get_the_date('M d, Y'); ?></span>
														</li>
														<?php if (!empty($terms)) : ?>
															<li class="terms">
																<i class="fas fa-folder"></i>
																<span><?php echo $terms[0]->name; ?></span>
															</li>
														<?php endif; ?>
													</ul>
													<p class="content"><?php echo get_the_excerpt($post->ID); ?></p>
													<div class="view">
														<a href="<?php echo get_permalink($post->ID); ?>" title=""><?php _e('Xem thêm', ''); ?></a>
													</div>
												</div>
											</div>
										</div>
							<?php
									endforeach;
								endif;
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
		return $instance;
	}

	function form($instance) {
		$defaults = array('title' => 'Tin tức nổi bật');
		$instance = wp_parse_args($instance, $defaults);
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title']); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
			</p>
		<?php
	}
}
