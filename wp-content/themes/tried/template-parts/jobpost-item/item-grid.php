<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-jobpostgrid-item');

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
    $jobpostCategory = get_the_terms( $post_id, 'jobpost_category', true );
    $jobpostSector = get_the_terms( $post_id, 'jobpost_job_type', true );
    $jobpostLocation = get_the_terms( $post_id, 'jobpost_location', true );
    $jobpostMinSalary = get_post_meta( $post_id, 'min_salary', true ) ? get_post_meta( $post_id, 'min_salary', true ) : '';
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
<div class="jobgrid-item <?php echo ($isSlide)?'swiper-slide':''; ?>">
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
            <h5 class="title"><a
                    href="<?php echo get_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h5>
            <ul class="meta">
                <?php
                    if ( !empty( $jobpostLocation ) ) {
                        echo '<li class="location">'.__( 'Location', 'tried' ).': '.$jobpostLocation[0]->name.'</li>';
                    }
                    // if ( !empty( $jobpostSector ) ) {
                    //     echo '<li class="sector">'.__( 'Sector', 'tried' ).': '.$jobpostSector[0]->name.'</li>';
                    // }
                    if ( !empty( $jobpostMinSalary ) ) {
                        $jobpostMinSalary .= ' '.$currencies[$jobpostCurrency];
                        if ( !empty( $jobpostMaxSalary ) ) {
                            $jobpostMinSalary .= ' - '.$jobpostMaxSalary.' '.$currencies[$jobpostCurrency];
                        }
                        if ( !empty( $jobpostUnit ) ) {
                            $jobpostMinSalary .= '/'.$units[$jobpostUnit];
                        }
                        echo '<li class="salary">'.__( 'Salary', 'tried' ).': '.$jobpostMinSalary.'</li>';
                    } else if ( !empty( $jobpostMaxSalary ) ) {
                        $jobpostMaxSalary = '~'.$jobpostMaxSalary.' '.$currencies[$jobpostCurrency];
                        if ( !empty( $jobpostUnit ) ) {
                            $jobpostMaxSalary .= '/'.$units[$jobpostUnit];
                        }
                        echo '<li class="salary">'.__( 'Salary', 'tried' ).': '.$jobpostMaxSalary.'</li>';
                    }
                ?>
            </ul>
        </div>
        <div class="action-contain">
            <div class="actions">
                <a class="viewjob" href="<?php echo get_permalink( $post_id ); ?>"
                    title="<?php _e( 'Apply now', 'tried' ); ?>"><?php _e( 'Apply now', 'tried' ); ?></a>
            </div>
        </div>
    </div>
</div>