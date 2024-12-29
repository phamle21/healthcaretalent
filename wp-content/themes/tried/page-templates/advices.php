<?php 
/* Template Name: Advices */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-advices-page' );
?>
<?php get_header(); ?>
<main <?php post_class( 'site-main' ); ?> role="main">
    <div class="main-contain advice">
        <div class="banner-advice">
            <div class="wrapper">
                <h2 class="advice-title"><?php _e( 'Advice', 'tried' ); ?></h2>
                <div class="advice-searchform">
                    <form role="search" method="get" class="search-form"
                        action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="hidden" name="post_type" value="advice">
                        <input type="search" class="search-field" placeholder="<?php _e( 'Search', 'tried' ); ?>"
                            value="<?php echo get_search_query(); ?>" name="s" />
                        <button type="submit" class="fas fa-search search-submit"></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <?php dynamic_sidebar('advice_page'); ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>