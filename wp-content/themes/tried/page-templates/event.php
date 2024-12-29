<?php 
/* Template Name: Event */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-event-page' );
?>
<?php get_header(); ?>
<main <?php post_class( 'site-main' ); ?> role="main">
    <div class="main-contain event">
        <div class="wrapper">
            <div class="page-widget">
                <?php dynamic_sidebar('event_page'); ?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>