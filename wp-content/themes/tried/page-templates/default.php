<?php 
/* Template Name: Default */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-default-page' );
?>
<?php get_header(); ?>
<main <?php post_class( 'site-main' ); ?> role="main">
    <div class="main-contain default">
        <div class="wrapper">
            <div class="page-widget">
                <?php dynamic_sidebar('default_page'); ?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>