<?php 
/* Template Name: Contact */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-contact-page' );
?>
<?php get_header(); ?>
<main <?php post_class( 'site-main' ); ?> role="main">
    <div class="main-contain contact">
        <div class="wrapper">
            <div class="page-widget">
                <?php dynamic_sidebar('contact_page'); ?>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>