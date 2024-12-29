<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-single-help' );
$relate_posts = get_posts(array (
    'post_type' => get_post_type(),
    'orderby' => 'date',
    'order'=> 'DESC', 
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'category__in' => wp_get_post_categories( get_the_ID() )
));

$terms = get_the_terms( get_the_ID(), 'book_cat' );

?>
<main <?php post_class( 'site-main' ); ?>>
	<div class="main-contain post">
		<div class="wrapper">
			<div class="page-content">
                <article class="single-blog">
					<div class="wrap">
						<div class="content-blog">
							<div class="content">
                                <div class="primary-book">
                                    <div class="info-book">
                                            <div class="author-avatar">
                                                <?php
                                                    $author_avatar_url = 'http://localhost:8888/sachmoi/wp-content/uploads/2023/07/Ellipse-97-3.png';
                                                    $author_avatar = get_theme_file_uri( "/assets/img/placeholder.png" );
                                                    if ( !empty( $author_avatar_url ) ) {
                                                        $author_avatar = $author_avatar_url;
                                                    }
                                                ?>
                                                <img src="<?php echo $author_avatar; ?>" width="60" height="60" alt=""/>
                                            </div>
                                        <h3 class="title-book"><?php the_title(); ?></h3>
                                        <div class="metainfo-book flex-space-between">
                                            <ul class="meta-book">
                                                <li class="author"><?php _e( 'Tác giả:', 'tried' ); ?><strong> <?php echo !empty($author)?$author:__('Đang cập nhật', 'tried'); ?></strong></li>
                                                <li class="terms">
                                                    <?php _e( 'Thể loại:', 'tried' ); ?>
                                                    <strong>
                                                        <?php 
                                                            if ( !empty( $terms ) ) {
                                                                foreach ( $terms as $term ) {
                                                                    printf( '<a href="%s">%s</a>', get_term_link( $term->term_id ), $term->name );
                                                                }
                                                            } else {
                                                                _e( 'Đang cập nhật', 'tried' );
                                                            }
                                                        ?>
                                                    </strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <p class="description-book"><?php echo get_the_content(); ?></p>
                                    </div>
                                    <div class="review-book">
                                        <h4 class="title-highlight"><?php _e( 'Đánh giá và bình luận', 'tried' ); ?></h4>
                                        <div class="review-wrapper">
                                            <?php
                                                if ( comments_open() || '0' != get_comments_number() ) {
                                                    echo do_shortcode('[wpse_comments_template]');
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</main>
