<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $wp_query;
$total_pages = $wp_query->max_num_pages;
$pagination = paginate_links( array(
    'total' => $total_pages,
    'mid_size' => 2,
    'current'   => max( 1, $wp_query->query_vars['paged'] ),
) );
?>

<div class="blogs">
    <?php 
        if( have_posts() ) {
            while( have_posts() ) {
                the_post();
                get_template_part( 'template-parts/product-item/item', null, array(
                    'id' => get_the_ID()
                ) );
            }
            wp_reset_query();
        } else {
            printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned.') );
        }
    ?>
</div>

<?php printf( '<div class="post-pagination">%s</div>', $pagination ); ?>
