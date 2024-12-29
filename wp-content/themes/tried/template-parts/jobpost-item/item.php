<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-jobpost-item' );
wp_enqueue_script( 'tried-job_action' );
$post_id = 0;
$isSlide = false;
if ( isset( $args['id'] ) ) {
    $post_id = $args['id'];
}
if ( isset( $args['is_slide'] ) ) {
    $isSlide = $args['is_slide'];
}
$isActiveSavejob = false;
if ( is_user_logged_in() ) {
	global $current_user;
	wp_get_current_user();
    $savejobs = get_the_author_meta( 'savejobs', $current_user->ID );
    if ( in_array( $post_id, $savejobs ) ) {
        $isActiveSavejob = true;
    }
}
$post = get_post($post_id);
    $jobpostCategory = get_the_terms( $post_id, 'jobpost_category', true );
    $jobpostSector = get_the_terms( $post_id, 'jobpost_job_type', true );
    $jobpostLocation = get_the_terms( $post_id, 'jobpost_location', true );
    $jobpostMinSalary = get_post_meta( $post_id, 'level', true ) ? get_post_meta( $post_id, 'level', true ) : '';
    $jobpostMaxSalary = get_post_meta( $post_id, 'max_salary', true ) ? get_post_meta( $post_id, 'max_salary', true ) : '';
    $jobpostCurrency = get_post_meta( $post_id, 'job_currency', true );
    $currencies = array(
        'vnd' => 'VNĐ',
        'dolla' => 'Dolla'
    );
    $jobpostUnit = get_post_meta( $post_id, 'job_unit', true );
    $units = array(
        'year' => __( 'Year', 'tried' ),
        'month' => __( 'Month', 'tried' ),
        'week' => __( 'Week', 'tried' ),
        'day' => __( 'Day', 'tried' ),
        'hour' => __( 'Hour', 'tried' )
    );
?>
<div class="job-item <?php echo ($isSlide)?'swiper-slide':''; ?>">
    <a href="<?php echo get_permalink($post_id); ?>"></a>
    <div class="wrap">
        <div class="box-contain">
            <h5 class="title"><?php echo get_the_title($post_id); ?></h5>
            <ul class="meta">
                <?php
                    // if ( !empty( $jobpostLocation ) ) {
                    //     echo '<li class="location">'.$jobpostLocation[0]->name.'</li>';
                    // }
                    // if ( !empty( $jobpostSector ) ) {
                    //     echo '<li class="sector">'.$jobpostSector[0]->name.'</li>';
                    // }
                    // if ( !empty( $jobpostMinSalary ) ) {
                    //     $jobpostMinSalary .= $currencies[$jobpostCurrency];
                    //     if ( !empty( $jobpostMaxSalary ) ) {
                    //         $jobpostMinSalary .= ' - '.$jobpostMaxSalary.$currencies[$jobpostCurrency];
                    //     }
                    //     if ( !empty( $jobpostUnit ) ) {
                    //         $jobpostMinSalary .= ' per '.$units[$jobpostUnit];
                    //     }
                    //     echo '<li class="salary">'.$jobpostMinSalary.'</li>';
                    // }
                ?>
            </ul>
            <div class="actions">
                <a class="savejob far fa-star <?php echo $isActiveSavejob?'active':''; ?>" href="javascript:void(0)"
                    title="<?php _e( 'Save job', 'tried' ); ?>" data-job_id="<?php echo $post_id; ?>"></a>
                <a class="viewjob fas fa-long-arrow-alt-right" href="<?php echo get_permalink( $post_id ); ?>"
                    title="<?php _e( 'View job', 'tried' ); ?>"></a>
            </div>
        </div>
    </div>
</div>