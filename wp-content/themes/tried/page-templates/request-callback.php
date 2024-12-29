<?php 
/* Template Name: Request Callback */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-request_callback-page' );
?>
<?php get_header(); ?>
<main <?php post_class( 'site-main' ); ?> role="main">
    <div class="main-contain requet-callback">
        <div class="wrapper">
            <?php dynamic_sidebar('request_callback_page'); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>