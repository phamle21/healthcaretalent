<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-jobpostsmall-item' );
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
if ($post) {
    $jobpostCategory = get_the_terms( $post->ID, 'jobpost_category', true );
    $jobpostSector = get_the_terms( $post->ID, 'jobpost_job_type', true );
    $jobpostLocation = get_the_terms( $post->ID, 'jobpost_location', true );
    $jobpostMinSalary = get_post_meta( $post->ID, 'level', true );
    $jobpostMaxSalary = get_post_meta( $post->ID, 'max_salary', true );
    $jobpostCurrency = get_post_meta( $post->ID, 'job_currency', true )?get_post_meta( $post->ID, 'job_currency', true ):'dolla';
    $currencies = array(
        'vnd' => 'VNĐ',
        'dolla' => 'Dolla'
    );
    $jobpostUnit = get_post_meta( $post->ID, 'job_unit', true )?get_post_meta( $post->ID, 'job_unit', true ):'month';
    $units = array(
        'year' => __( 'Year', 'tried' ),
        'month' => __( 'Month', 'tried' ),
        'week' => __( 'Week', 'tried' ),
        'day' => __( 'Day', 'tried' ),
        'hour' => __( 'Hour', 'tried' )
    );
?>
<div class="jobsmall-item <?php echo ($isSlide)?'swiper-slide':''; ?>">
    <div class="wrap">
        <div class="box-contain">
            <ul class="headjob">
                <?php
                    if ( !empty( $jobpostSector ) ) {
                        echo '<li class="sector"><a href="javascript:void(0)" title="'.$jobpostSector[0]->name.'">'.$jobpostSector[0]->name.'</a></li>';
                    }
                ?>
                <li class="date"><?php echo get_the_date('M d, Y'); ?></li>
            </ul>
            <h5 class="title">
                <a href="<?php echo get_permalink($post->ID); ?>"
                    title="<?php echo get_the_title($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a>
            </h5>
            <ul class="meta">
                <?php
                    if ( !empty( $jobpostLocation ) ) {
                        echo '<li class="location">'.$jobpostLocation[0]->name.'</li>';
                    }
                    if ( !empty( $jobpostMinSalary ) ) {
                        $jobpostMinSalary .= ' '.$currencies[$jobpostCurrency];
                        if ( !empty( $jobpostMaxSalary ) ) {
                            $jobpostMinSalary .= ' - '.$jobpostMaxSalary.' '.$currencies[$jobpostCurrency];
                        }
                        if ( !empty( $jobpostUnit ) ) {
                            $jobpostMinSalary .= '/'.$units[$jobpostUnit];
                        }
                        echo '<li class="salary">'.$jobpostMinSalary.'</li>';
                    } else if ( !empty( $jobpostMaxSalary ) ) {
                        $jobpostMaxSalary = '~'.$jobpostMaxSalary.' '.$currencies[$jobpostCurrency];
                        if ( !empty( $jobpostUnit ) ) {
                            $jobpostMaxSalary .= '/'.$units[$jobpostUnit];
                        }
                        echo '<li class="salary">'.$jobpostMaxSalary.'</li>';
                    }
                ?>
            </ul>
            <!-- <div class="actions">
                <a class="savejob far fa-star <?php echo $isActiveSavejob?'active':''; ?>" href="javascript:void(0)"
                    title="<?php _e( 'Save job', 'tried' ); ?>" data-job_id="<?php echo $post->ID; ?>"></a>
            </div> -->
        </div>
    </div>
</div>
<?php
}