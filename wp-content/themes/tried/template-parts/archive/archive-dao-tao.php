<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$pagination = false;
if ( $args['page_lịnks'] ) {
    $pagination = $args['posttype'];
}
?>

<div class="blogs">
    <?php 
        if( have_posts() ) {
            while( have_posts() ) {
                the_post();
                $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                $image = get_theme_file_uri( "/assets/img/placeholder.png" );
                if (!empty($image_url[0])) {
                    $image = $image_url[0];
                }
                ?>
                    <div class="service-item">
                        <div class="wrap">
                            <div class="featured-image">
                                <img src="<?php echo $image; ?>" alt="">
                            </div>
                            <div class="box-contain">
                                <a href="<?php echo get_permalink( get_the_ID() ); ?>">
                                    <h5 class="title"><?php echo get_the_title( get_the_ID() ); ?></h5>
                                    <p class="content"><?php echo get_the_excerpt( get_the_ID() ); ?></p>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
            }
            wp_reset_query();
			printf( '<div class="post-pagination">%s</div>', $pagination );
        } else {
            printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned.') );
        }
    ?>
</div>
