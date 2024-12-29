<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-single-book' );
$relate_posts = get_posts(array (
    'post_type' => get_post_type(),
    'orderby' => 'date',
    'order'=> 'DESC', 
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'category__in' => wp_get_post_categories( get_the_ID() )
));

$gallery = get_field( 'gallery' );
$terms = get_the_terms( get_the_ID(), 'book_cat' );
$author = get_field('author' );
$publish_at = get_field('publish_at');
$introduced = get_field('introduced');

?>
<main <?php post_class( 'site-main' ); ?>>
	<div class="main-contain post">
		<div class="wrapper">
			<div class="page-content">
                <article class="single-blog have-sidebar">
					<div class="wrap">
						<div class="sidebar-book">
                                <div class="gallery-book">
                                        <div class="featured-book">
                                            <div id="full-gallery">
                                                <?php
                                                    if (has_post_thumbnail( get_the_ID() ) ) :
                                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
                                                        ?>
                                                            <div class="mibreit-imageElement">
                                                                <img src="<?php echo $image[0]; ?>" data-src="<?php echo $image[0]; ?>" data-title="Image featured" alt="Image featured" />
                                                            </div>
                                                        <?php
                                                    endif;
                                                ?>
                                                <?php if ( !empty( $gallery ) ) : ?>
                                                    <?php foreach ( $gallery as $o => $g ) : ?>
                                                        <div class="mibreit-imageElement">
                                                            <img src="<?php echo $g; ?>" data-src="<?php echo $g; ?>" data-title="Image <?php echo $o; ?>" alt="Image <?php echo $o; ?>" />
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="thumb-book" style="display: none;">
                                            <div class="mibreit-thumbview">
                                                <?php
                                                    if (has_post_thumbnail( get_the_ID() ) ) :
                                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
                                                        ?>
                                                            <div class="mibreit-thumbElement">
                                                                <img src="<?php echo $image[0]; ?>" data-src="<?php echo $image[0]; ?>" width="100" height="60" data-title="Thumbnail featured" alt="Thumbnail featured" />
                                                            </div>
                                                        <?php
                                                    endif;
                                                ?>
                                                <?php if ( !empty( $gallery ) ) : ?>
                                                    <?php foreach ( $gallery as $q => $g ) : ?>
                                                        <div class="mibreit-thumbElement">
                                                            <img src="<?php echo $g; ?>" data-src="<?php echo $g; ?>" width="100" height="60" alt="Thumbnail <?php echo $q; ?>" />
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                </div>
                                <div class="author-book">
                                    <h4 class="title-highlight"><?php _e( 'Thông tin tác giả', 'tried' ); ?></h4>
                                    <div class="author-wrapper">
                                        <div class="author-info">
                                            <div class="author-avatar">
                                                <?php
                                                    // $author_avatar_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                                    $author_avatar_url = 'http://localhost:8888/sachmoi/wp-content/uploads/2023/07/Ellipse-97-3.png';
                                                    $author_avatar = get_theme_file_uri( "/assets/img/placeholder.png" );
                                                    if ( !empty( $author_avatar_url ) ) {
                                                    // if ( !empty( $author_avatar_url[0] ) ) {
                                                        // $author_avatar = $author_avatar_url[0];
                                                        $author_avatar = $author_avatar_url;
                                                    }
                                                ?>
                                                <img src="<?php echo $author_avatar; ?>" width="60" height="60" alt=""/>
                                            </div>
                                            <div class="author-achievement">
                                                <h4 class="authortitle">Richard P. Feynman</h4>
                                                <ul class="authorextend">
                                                    <li><span>11</span> <?php _e( 'books', 'tried' ); ?></li>
                                                    <li><span>24k</span> <?php _e( 'followers', 'tried' ); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="author-meta">
                                            <ul class="authormeta">
                                                <li><strong class="metatitle"><?php _e( 'Born', 'tried' ); ?></strong><span class="metacontent">in Far Rockaway, Queens, New York, The United States . May 11, 1918</span></li>
                                                <li><strong class="metatitle"><?php _e( 'Died', 'tried' ); ?></strong><span class="metacontent">February 15, 1988</li>
                                                <li><strong class="metatitle"><?php _e( 'Genre', 'tried' ); ?></strong><span class="metacontent">Science, Memoir</li>
                                            </ul>
                                        </div>
                                        <div class="author-story">
                                            <p>Richard Phillips Feynman was an American physicist known for the path integral formulation of quantum mechanics, the theory of quantum electrodynamics and the physics of the superfluidity of supercooled liquid helium, as well as work in particle physics (he proposed the parton model).</p><br>
                                            <p>In addition to his work in theoretical physics, Feynman has been credited with pioneering the field of quantum computing, and introducing the concept of nanotechnology (creation of devices at the molecular scale).</p>
                                        </div>
                                    </div>
                                </div>
						</div>
						<div class="content-blog">
							<div class="content">
                                <div class="primary-book">
                                    <div class="info-book">
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
                                            <div class="publish-book"><?php printf( '%s: <strong>%s</strong>', __( 'Ngày xuất bản', 'tried' ), $publish_at?$publish_at:__( 'Chưa rõ', 'tried' ) ); ?></div>
                                        </div>
                                        <div class="rating-book">
                                            <?php
                                                $rating = 4;
                                                for ( $star = 0; $star < 5; $star++ ) {
                                                    if ( $star < $rating ) {
                                                        printf( '<span class="rate"><i class="fas fa-star"></i></span>' );
                                                        continue;
                                                    }
                                                    printf( '<span class="rate"><i class="far fa-star"></i></span>' );
                                                }
                                            ?>
                                        </div>
                                        <div class="function-book flex-space-between">
                                            <a href="/sachmoi/doc-sach?id=<?php echo get_the_ID(); ?>" class="btn-readbook text-uppercase" title="<?php _e( 'Đọc sách', 'tried' ); ?>"><?php _e( 'Đọc sách', 'tried' ); ?></a>
                                            <a href="javascript:void(0)" class="btn-addwishlist" data-bookid="<?php echo get_the_ID(); ?>" title="<?php _e( 'Thêm vào tủ sách của tôi', 'tried' ); ?>"><?php _e( 'Thêm vào tủ sách của tôi', 'tried' ); ?></a>
                                        </div>
                                        <p class="description-book"><?php echo get_the_content(); ?></p>
                                    </div>
                                    <div class="chapter-book">
                                        <h4 class="title-highlight"><?php _e( 'Danh sách chương', 'tried' ); ?></h4>
                                        <div class="chapter-wrapper">
                                            <ul class="chapters">
                                                <?php
                                                    for ( $chapter = 1; $chapter < 20; $chapter++ ) {
                                                        printf( 
                                                            '<li class="chapter-item"><span class="chapter-title">%s</span><a href="%s" title="%s" class="chapter-viewmore">%s</a></li>',
                                                            __( 'Chương', 'tried' ).' '.$chapter,
                                                            '/sachmoi/doc-sach?id='.get_the_ID().'&chap='.$chapter,
                                                            __( 'Chương', 'tried' ).' '.$chapter,
                                                            __( 'Xem', 'tried' )
                                                        );
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="introduced-book">
                                        <h4 class="title-highlight"><?php _e( 'Giới thiệu bởi người nổi tiếng', 'tried' ); ?></h4>
                                        <div class="introduced-wrapper">
                                            <div class="introduceds">
                                                <?php
                                                    if ( $introduced && !empty( $introduced ) ) {
                                                        $u = wp_generate_uuid4();
                                                        printf ( '<div class="swiper single-book-introduced" data-control="%s"><div class="swiper-wrapper">', $u );
                                                        foreach ( $introduced as $itd ) {
                                                            printf(
                                                                '<div class="introduced-item swiper-slide">
                                                                    <div class="introduced-head">
                                                                        <img src="%s" alt=""/>
                                                                        <div><h6><span>%s</span> %s</h6></div>
                                                                    </div>
                                                                    <div class="introduced-body">%s</div>
                                                                </div>',
                                                                $itd['avatar']?$itd['avatar']:get_theme_file_uri( "/assets/img/placeholder.png" ),
                                                                $itd['name'], __( 'giới thiệu', 'tried' ), $itd['content'],

                                                            );
                                                        }
                                                        printf( '</div></div><div class="swiper-button swiper-button-prev" key="%s"></div>
                                                        <div class="swiper-button swiper-button-next" key="%s"></div>', $u, $u );
                                                    } else {
                                                        printf( '<p class="no-result">%s</p>', __('Đang cập nhật..') );
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-book">
                                        <h4 class="title-highlight"><?php _e( 'Đánh giá và bình luận', 'tried' ); ?></h4>
                                        <div class="review-wrapper">
                                            <?php
                                                if ( comments_open() || '0' != get_comments_number() ) {
                                                    // comments_template( '', true );
                                                    echo do_shortcode('[wpse_comments_template]');
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<div class="related-book">
						<h3 class="title"><?php _e('Sách cùng thể loại', 'tried'); ?>:</h3>
						<div class="books">
							<?php 
								if (!empty($relate_posts)) {
									$key = wp_generate_uuid4();
									// echo '<div class="swiper widget-single-relate" data-control="'.$key.'"><div class="swiper-wrapper">';
									foreach ($relate_posts as $post) {
										get_template_part( 'template-parts/book-item/item', null, array(
											'id' => $post->ID
										) );
                                    }
									wp_reset_postdata();
									// echo '</div></div>';
                                } else {
									printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned', 'tried') );
                                }
							?>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</main>

<script>
(function ($) {
    'use strict';

    $('.btn-addwishlist').on('click', function() {
        var _this = $(this),
            book_id = $(this).attr('data-bookid');
        if ( book_id ) {
            $.ajax({
                type : "get", 
                url : tried_script.ajax_url, 
                data : {
                    action: 'update_wishlist',
                    bookid: book_id
                },
                success: function(res) {
                    if ( res.code == 200 && res.result ) {
                        var result = res.result.split( ',' );
                        if ( result.includes(book_id.toString()) ) {
                            _this.addClass('liked');
                        } else {
                            _this.removeClass('liked');
                        }
                    } else if ( res.code == 403 ) {
                        location.href = "/sachmoi/tai-khoan/?block=profile";
                    } else {
                        console.log('Có lỗi xảy ra!');
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });
        }
    });
})(jQuery);
</script>