<?php 
/* Template Name: About */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-about-page' );
?>
<?php get_header(); ?>
<main <?php post_class( 'site-main' ); ?> role="main">
    <div class="main-contain about">
        <div class="wrapper">
            <div class="page-widget">
                <?php dynamic_sidebar('about_page'); ?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>