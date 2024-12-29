<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-advice-item');
$post_id = 0;
if ( isset( $args['id'] ) ) {
    $post_id = $args['id'];
}
$isSlide = false;
if ( isset( $args['is_slide'] ) ) {
    $isSlide = $args['is_slide'];
}
$post = get_post($post_id);
if ($post) {
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
    $image = get_theme_file_uri( "/assets/img/placeholder.png" );
    if (!empty($image_url[0])) {
        $image = $image_url[0];
    }
    $terms = get_the_terms( $post->ID, 'advice_cat' );
?>
<div class="advice-item <?php echo ($isSlide)?'swiper-slide':''; ?>">
    <a href="<?php echo get_permalink($post->ID); ?>"></a>
    <div class="wrap">
        <div class="featured-image">
            <img src="<?php echo $image; ?>" alt="">
        </div>
        <div class="box-contain">
            <h6 class="date"><?php echo get_the_date('M d, Y'); ?></h6>
            <h5 class="title"><?php echo get_the_title($post->ID); ?></h5>
            <p class="content"><?php echo get_the_excerpt($post->ID); ?></p>
        </div>
    </div>
</div>
<?php
}