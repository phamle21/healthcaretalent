<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-advice-archive' );
global $wp_query;
$total_pages = $wp_query->max_num_pages;
$limit = 10;
if ( $wp_query->query_vars['posts_per_page'] ) {
    $limit = $wp_query->query_vars['posts_per_page'];
}
$pagination = paginate_links( array(
    'total' => $total_pages,
    'mid_size' => 2,
    'current'   => max( 1, $wp_query->query_vars['paged'] ),
) );

$posttype = get_post_type();
if ( isset( $args['posttype'] ) ) {
    $posttype = $args['posttype'];
}

$advices = get_posts( array (
    'post_type' => $posttype,
    'orderby' => 'date',
    'order'=> 'DESC', 
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'advice_cat',
            'field'    => 'term_id',
            'terms'    => array( get_queried_object_id() ),
        ),
    ),
    'posts_per_page' => $limit
) );
print_r();
?>
<main <?php post_class( 'site-main' ); ?> role="main">
    <div class="main-contain advice">
        <div class="banner-advice">
            <div class="wrapper">
                <h2 class="advice-title"><?php echo get_the_archive_title(); ?></h2>
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
            <div class="advice-totalsort">
                <div class="total-result">Showing 1 - 48 of 102 articles</div>
            </div>
            <div class="advice-wrapper">
                <div class="jobs-result">
                    <div class="advices">
                        <?php
                            if ( !empty( $advices ) ) {
                                foreach ( $advices as $advice ) {
                                    get_template_part( 'template-parts/advice-item/item', null, array(
                                        'id' => $advice->ID
                                    ) );
                                }
                                wp_reset_postdata();
                            } else {
                                printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned', 'tried') );
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>