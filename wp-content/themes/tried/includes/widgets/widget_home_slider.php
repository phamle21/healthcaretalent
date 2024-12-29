<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_home_slider extends WP_Widget {
	function __construct() {
		parent::__construct(
			'widget_home_slider', 'Tried Home Slider',
			array(
				'classname' => 'widget_home_slider',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	public function widget( $args, $instance ){
		extract($args);
		$sliders = get_field('sliders','widget_'.$args['widget_id']);
		$infoboxs = get_field('infoboxs','widget_'.$args['widget_id']);
		$infoboxs_cols = !empty($infoboxs['item_4']['title'])?4:3;
		$key = wp_generate_uuid4();
		echo $args['before_widget'];
		?>
			<section id="section-<?php echo $args['widget_id']; ?>" class="section-home-slider full" data-control="<?php echo $key; ?>">
				<div class="section-wrapper margin-auto">
					<div class="swiper widget-home-slider">
						<div class="swiper-wrapper">
							<?php
								if(!empty($sliders)):
									foreach( $sliders as $slider ): 
										?>
										<div class="swiper-slide box">
											<div class="background-overlay">
												<img src="<?php echo $slider['image']; ?>" alt="">
											</div>
											<div class="box-content mwidth-main margin-auto" data-reverse="<?php echo $slider['reverse']?$slider['reverse']:'0'; ?>">
												<div class="wrapper">
													<h5 class="subtitle"><?php echo $slider['subtitle']; ?></h5>
													<h3 class="title"><?php echo $slider['title']; ?></h3>
													<p class="content"><?php echo $slider['content']; ?></p>
													<div class="more">
														<a href="<?php echo $slider['viewmore']; ?>"  class="viewmore"><i class="far fa-shield-alt"></i><?php _e('Xem thêm', 'tried'); ?></a>
													</div>
												</div>
											</div>	
										</div>
										<?php
									endforeach;
								endif; 
							?>
						</div>
						<!-- <div class="swiper-pagination"></div> -->
						<div class="swiper-button swiper-button-prev" key="<?php echo $key; ?>"></div>
						<div class="swiper-button swiper-button-next" key="<?php echo $key; ?>"></div>
					</div>
				</div>
				<div class="section-wrapper margin-auto infoboxs">
					<div class="wrapper" data-columns="<?php echo $infoboxs_cols; ?>" style="grid-template-columns: repeat(<?php echo $infoboxs_cols.', '.(100/$infoboxs_cols).'%'; ?>);">
						<?php
							if (!empty($infoboxs['item_1']['title'])) :
								$icon = !empty($infoboxs['item_1']['icon'])?$infoboxs['item_1']['icon']:'fas fa-home';
						?>
								<div class="item">
									<a class="box" href="<?php echo $infoboxs['item_1']['link']; ?>">
										<span class="icon <?php echo $icon; ?>"></span>
										<h4 class="title"><?php echo $infoboxs['item_1']['title']; ?></h4>
									</a>
								</div>
						<?php endif; ?>
						<?php
							if (!empty($infoboxs['item_2']['title'])) :
								$icon = !empty($infoboxs['item_2']['icon'])?$infoboxs['item_2']['icon']:'fas fa-home';
						?>
								<div class="item">
									<a class="box" href="<?php echo $infoboxs['item_2']['link']; ?>">
										<span class="icon <?php echo $icon; ?>"></span>
										<h4 class="title"><?php echo $infoboxs['item_2']['title']; ?></h4>
									</a>
								</div>
						<?php endif; ?>
						<?php
							if (!empty($infoboxs['item_3']['title'])) :
								$icon = !empty($infoboxs['item_3']['icon'])?$infoboxs['item_3']['icon']:'fas fa-home';
						?>
								<div class="item">
									<a class="box" href="<?php echo $infoboxs['item_3']['link']; ?>">
										<span class="icon <?php echo $icon; ?>"></span>
										<h4 class="title"><?php echo $infoboxs['item_3']['title']; ?></h4>
									</a>
								</div>
						<?php endif; ?>
						<?php
							if (!empty($infoboxs['item_4']['title'])) :
								$icon = !empty($infoboxs['item_4']['icon'])?$infoboxs['item_4']['icon']:'fas fa-home';
						?>
								<div class="item">
									<a class="box" href="<?php echo $infoboxs['item_4']['link']; ?>">
										<span class="icon <?php echo $icon; ?>"></span>
										<h4 class="title"><?php echo $infoboxs['item_4']['title']; ?></h4>
									</a>
								</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$default = array();
		$instance = wp_parse_args( (array) $instance, $default );
	}

	public function update( $new_instance, $old_instance ){
		$instance = $old_instance;
		return $instance;
	}
}