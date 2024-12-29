<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$pagination = false;
if ( $args['page_lịnks'] ) {
    $pagination = $args['posttype'];
}
?>

<div class="blogs">
    <?php 
        if( have_posts() ) {
            while( have_posts() ) {
                the_post();
                get_template_part( 'template-parts/blog-item/item', 'addition', array(
                    'id' => get_the_ID()
                ) );
            }
            wp_reset_query();
			printf( '<div class="post-pagination">%s</div>', $pagination );
        } else {
            printf( '<p class="no-result">%s</p>', __('Sorry, no results were returned.') );
        }
    ?>
</div>
