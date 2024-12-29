<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-product-item');
$post_id = 0;
$index = 1;
$classes = 1;
if ( isset( $args['id'] ) ) {
    $post_id = $args['id'];
}
if ( isset( $args['index'] ) ) {
    $index = $args['index'];
}
if ( isset( $args['classes'] ) ) {
    $classes = $args['classes'];
}
$post = get_post($post_id);
if ($post) :
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
    $image = get_theme_file_uri( "/assets/img/placeholder.png" );
    if (!empty($image_url[0])) {
        $image = $image_url[0];
    }
    $terms = get_the_terms( $post->ID, 'category' );
?>
<div class="product-item <?php echo implode( ' ', $classes ); ?>" data-index="<?php echo $index; ?>">
    <div class="wrap">
        <a href="<?php echo get_permalink($post->ID); ?>" title=""></a>
        <div class="featured-image">
            <img src="<?php echo $image; ?>" alt="">
        </div>
        <div class="box-contain">
            <?php if ($index == 0 && false) : ?>
            <ul class="meta">
                <li class="author"><?php echo get_the_author_meta('display_name', $post->post_author); ?></li>
                <li class="date"><?php echo get_the_date('M d, Y'); ?></li>
            </ul>
            <?php endif; ?>
            <?php if (!empty($terms) && false) : ?>
            <ul class="terms">
                <li><a href="<?php echo get_term_link($terms[0]->term_id); ?>"><?php echo $terms[0]->name; ?></a></li>
            </ul>
            <?php endif; ?>
            <h5 class="title"><?php echo get_the_title($post->ID); ?></h5>
            <p class="price"><?php _e( 'Giá', 'tried' );?>: <span><?php _e( 'Liên hệ', 'tried' ); ?></span></p>
        </div>
    </div>
</div>
<?php
endif;