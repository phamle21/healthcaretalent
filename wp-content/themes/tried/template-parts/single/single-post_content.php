<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-content-post_content' );
wp_enqueue_script( 'tried-post_content' );
wp_enqueue_style( 'tried-toc' );
wp_enqueue_script( 'tried-toc' );
if ( has_post_thumbnail( $post->ID ) ) {
	$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	$image = get_theme_file_uri( "/assets/img/placeholder.png" );
	if (!empty($image_url[0])) {
		$image = $image_url[0];
	}
}
$terms = get_the_terms( $post->ID, 'category' );

$content = get_the_content();
$mode_eipostcontent = get_post_meta( $post->ID, 'mode_eipostcontent', true );
if ( $mode_eipostcontent && $mode_eipostcontent != '0' ) {
	$content = do_shortcode( "[render_eipostcontent post_id='{$post->ID}']" );
}
?>
<main <?php post_class( 'site-main' ); ?>>
	<div class="main-contain post_content">
		<div class="wrapper">
			<div class="page-content">
				<article class="single-blog">
					<div class="wrap">
						<div class="aside">
							<div id="toc">
								<h5 class="toc-title"><?php _e( 'Table of Contents', 'tried' ); ?></h5>
							</div>
						</div>
						<div class="content">
							<!-- <div class="featured-image">
								<img src="<?php echo $image; ?>" alt="">
							</div> -->
							<h1 class="title"><?php the_title(); ?></h1>
							<ul class="meta">
								<li class="author far fa-user">
									<?php echo get_the_author_meta( 'display_name', $post->post_author ); ?>
								</li>
								<li class="date far fa-clock">
									<?php echo get_the_date( 'M d, Y' ); ?>
								</li>
								<li class="term far fa-file-alt">
									<?php 
										if ( !empty( $terms ) ) :
											foreach ( $terms as $term ) :
												printf( '<a href="%s">%s</a>', get_term_link( $term->term_id ), $term->name );
											endforeach;
										endif;
									?>
								</li>
							</ul>
							<div id="tocontent" class="expert"><?php echo $content; ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>