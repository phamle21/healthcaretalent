<?php 
/* Template Name: Jobpost search */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-jobpost_search-page' );
?>
<?php get_header(); ?>
<main <?php post_class( 'site-main' ); ?> role="main">
    <div class="main-contain jobpost-search">
        <div class="wrapper">
            <?php dynamic_sidebar('jobpost_search_page'); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>