<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$relate_posts = get_posts(array (
    'post_type' => get_post_type(),
    'orderby' => 'date',
    'order'=> 'DESC', 
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'category__in' => wp_get_post_categories( get_the_ID() )
));
?>
<main <?php post_class( 'site-main' ); ?>>
	<div class="main-contain post">
		<div class="wrapper">
			<div class="page-content">
                <article class="single-blog have-sidebar">
					<div class="wrap">
						<div class="sidebar">
							<?php dynamic_sidebar('sidebar_post'); ?>
						</div>
						<div class="content-blog">
							<h3 class="title"><?php wp_title( false ); ?></h3>
							<div class="content"><?php the_content(); ?></div>
							<div class="related-blog">
								<h3 class="title"><?php _e('Tin liên quan', 'tried'); ?></h3>
								<div class="blogs">
									<?php 
										if (!empty($relate_posts)) :
											$key = wp_generate_uuid4();
									?>
												<!-- <div class="swiper widget-single-relate" data-control="<?php echo $key; ?>">
													<div class="swiper-wrapper"> -->
									<?php
													foreach ($relate_posts as $post) :
														get_template_part( 'template-parts/blog-item/item', null, array(
															'id' => $post->ID
														) );
												endforeach;
												wp_reset_postdata();
									?>
												<!-- </div>
											</div> -->
									<?php
										else :
											printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned', 'tried') );
										endif;
									?>
								</div>
							</div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</main>