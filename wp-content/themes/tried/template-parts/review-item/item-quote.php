<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-review-quote-item');

$isSlide = false;
if ( isset( $args['is_slide'] ) ) {
    $isSlide = $args['is_slide'];
}

$logo = '';
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
$subauthor = 'Subtitle';
if ( isset( $args['subauthor'] ) && !empty( $args['subauthor'] ) ) {
    $subauthor = $args['subauthor'];
}
$avatar = get_theme_file_uri( "/assets/img/placeholder.png" );
if ( isset( $args['avatar'] ) && !empty( $args['avatar'] ) ) {
    $avatar = $args['avatar'];
}
?>
<div class="review-item <?php echo ($isSlide)?'swiper-slide':''; ?>">
    <div class="wrap">
        <div class="info-contain">
            <p class="content"><?php echo $content; ?></p>
            <div class="author">
                <img src="<?php echo $avatar; ?>" alt="<?php echo $author; ?>" />
                <div>
                    <h4><?php echo $author; ?></h4>
                    <h5><?php echo $subauthor; ?></h5>
                </div>
            </div>
            <div class="logo">
                <?php
                    if ( !empty( $logo ) ) {
                        printf(
                            '<img src="%s" alt="">', $logo
                        );
                    }
                ?>
            </div>
        </div>
    </div>
</div>