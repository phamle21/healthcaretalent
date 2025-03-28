<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'archive-help' );

global $wp_query;
$total_pages = $wp_query->max_num_pages;
$pagination = paginate_links( array(
    'total' => $total_pages,
    'mid_size' => 2,
    'current'   => max( 1, $wp_query->query_vars['paged'] ),
) );
if( have_posts() ) {
    echo '<div class="helps">';
    while( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/help-item/item', null, array(
            'id' => get_the_ID()
        ) );
    }
    wp_reset_query();
	printf( '<div class="post-pagination">%s</div>', $pagination );
    echo '</div>';
} else {
    printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned.') );
}
