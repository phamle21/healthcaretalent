<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-jobpostsave-item');
wp_enqueue_script( 'tried-job_action' );
$post_id = 0;
if ( isset( $args['id'] ) ) {
    $post_id = $args['id'];
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
if ($post) {
    $jobpostCategory = get_the_terms( $post->ID, 'jobpost_category', true );
    $jobpostSector = get_the_terms( $post->ID, 'jobpost_job_type', true );
    $jobpostLocation = get_the_terms( $post->ID, 'jobpost_location', true );
    $jobpostMinSalary = get_post_meta( $post->ID, 'level', true );
    $jobpostMaxSalary = get_post_meta( $post->ID, 'max_salary', true );
    $jobpostCurrency = get_post_meta( $post->ID, 'job_currency', true );
    $currencies = array(
        'vnd' => 'VNĐ',
        'dolla' => 'Dolla'
    );
    $jobpostUnit = get_post_meta( $post->ID, 'job_unit', true );
    $units = array(
        'year' => __( 'Year', 'tried' ),
        'month' => __( 'Month', 'tried' ),
        'week' => __( 'Week', 'tried' ),
        'day' => __( 'Day', 'tried' ),
        'hour' => __( 'Hour', 'tried' )
    );
?>
<div class="jobsave-item" data-jobsave_id="<?php echo $post->ID; ?>">
    <div class="wrap">
        <div class="box-contain">
            <div class="box-col">
                <h5 class="title"><a
                        href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a></h5>
                <ul class="job-listing-meta meta">
                    <?php
                        if ( !empty( $jobpostLocation ) ) {
                            echo '<li class="location">'.$jobpostLocation[0]->name.'</li>';
                        }
                        if ( !empty( $jobpostSector ) ) {
                            echo '<li class="sector">'.$jobpostSector[0]->name.'</li>';
                        }
                        if ( !empty( $jobpostMinSalary ) ) {
                            $jobpostMinSalary .= $currencies[$jobpostCurrency];
                            if ( !empty( $jobpostMaxSalary ) ) {
                                $jobpostMinSalary .= ' - '.$jobpostMaxSalary.$currencies[$jobpostCurrency];
                            }
                            if ( !empty( $jobpostUnit ) ) {
                                $jobpostMinSalary .= ' per '.$units[$jobpostUnit];
                            }
                            echo '<li class="salary">'.$jobpostMinSalary.'</li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="box-col">
                <div class="actions">
                    <a class="viewjob" href="<?php echo get_permalink( $post->ID ); ?>"
                        title="<?php _e( 'View job', 'tried' ); ?>"><?php _e( 'View Job', 'tried' ); ?></a>
                </div>
                <a class="action-option" href="javascript:void(0)"
                    title="<?php _e( 'Save Job Options', 'tried' ); ?>"></a>
                <div class="wrapper-options">
                    <a class="remove" href="javascript:void(0)"
                        title="<?php _e( 'Remove saved job', 'tried' ); ?>"><?php _e( 'Remove saved job', 'tried' ); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}