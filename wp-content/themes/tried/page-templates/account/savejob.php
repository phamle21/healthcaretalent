<?php 
/* Template Name: Account - Savejob */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-account_savejob-block' );

global $current_user;
wp_get_current_user();
    $savejobsMeta = get_the_author_meta( 'savejobs', get_current_user_id() );
    $savejobs = array();
    if ( $savejobsMeta ) {
        $jobpostArgs = array(
            'post_type' => 'jobpost',
            'orderby' => 'date',
            'order'=> 'DESC', 
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'post__in' => $savejobsMeta
        );
        $savejobs = get_posts( $jobpostArgs );
    }
?>
<div id="savejob_account-block">
    <?php
        if ( !empty( $savejobs ) ) {
            printf(
                '<div class="title-savejob">%s<span class="count">(%s)</span></div>',
                __( 'Saved Jobs', 'tried' ), count( $savejobs )
            );
            echo '<div class="list-savejob">';
            foreach ( $savejobs as $job ) {
                get_template_part( 'template-parts/jobpost-item/item', 'savejob', array(
                    'id' => $job->ID
                ) );
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            printf(
                '<div class="no-saved-jobs">
                    <img src="%s" alt="" width="100" height="100"/>
                    <h4>%s</h4>
                    <p>%s</p>
                    <a href="%s" title="">%s</a>
                </div>',
                get_theme_file_uri( '/assets/img/tried-nostar.svg' ),
                __( 'Jobs you save will appear here...', 'tried' ),
                __( 'Press the star icon to save a job', 'tried' ),
                esc_url( add_query_arg( 'block', 'dashboard', home_url( 'account') ) ),
                __( 'Back to My account ', 'tried' )
            );
        }
    ?>
</div>