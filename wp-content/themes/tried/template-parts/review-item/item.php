<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-review-item');

$isSlide = false;
if ( isset( $args['is_slide'] ) ) {
    $isSlide = $args['is_slide'];
}

$logo = get_theme_file_uri( "/assets/img/placeholder.png" );
if ( isset( $args['logo'] ) && !empty( $args['logo'] ) ) {
    $logo = $args['logo'];
}
$content = '...';
if ( isset( $args['content'] ) && !empty( $args['content'] ) ) {
    $content = $args['content'];
}
$author = 'Name';
if ( isset( $args['author'] ) && !empty( $args['author'] ) ) {
    $author = $args['author'];
}
$avatar = '';
if ( isset( $args['avatar'] ) && !empty( $args['avatar'] ) ) {
    $avatar = $args['avatar'];
}
?>
<div class="review-item <?php echo ($isSlide)?'swiper-slide':''; ?>">
    <div class="wrap">
        <div class="logo-contain">
            <img src="<?php echo $logo; ?>" alt="">
        </div>
        <div class="info-contain">
            <p class="content"><?php echo $content; ?></p>
            <div class="author">
                <img src="<?php echo $avatar; ?>" alt="<?php echo $author; ?>" />
                <h4><?php echo $author; ?></h4>
            </div>
        </div>
    </div>
</div>