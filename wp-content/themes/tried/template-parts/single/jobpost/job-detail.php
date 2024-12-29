<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-jobpost-single' );
wp_enqueue_style( 'tried-jobpost_detail-single' );

$joblistRelated = get_posts( array (
    'post_type' => get_post_type(),
    'orderby' => 'date',
    'order'=> 'DESC', 
    'post_status' => 'publish',
    'posts_per_page' => 3
) );

$htmlJobCategory = array();
$jobpostCategory = get_the_terms( get_the_ID(), 'jobpost_category' );
if ( $jobpostCategory ) {
    foreach ( $jobpostCategory as $jCategory ) {
        array_push( $htmlJobCategory, $jCategory->name );
    }
}

$htmlJobSector = array();
$jobpostSector = get_the_terms( get_the_ID(), 'jobpost_job_type' );
if ( $jobpostSector ) {
    foreach ( $jobpostSector as $jSector ) {
        array_push( $htmlJobSector, $jSector->name );
    }
}

$htmlJobLevel = array();
$jobpostLevel = get_the_terms( get_the_ID(), 'jobpost_level' );
if ( $jobpostLevel ) {
    foreach ( $jobpostLevel as $jLevel ) {
        array_push( $htmlJobLevel, $jLevel->name );
    }
}

$htmlJobLocation = array();
$jobpostLocation = get_the_terms( get_the_ID(), 'jobpost_location' );
if ( $jobpostLocation ) {
    foreach ( $jobpostLocation as $jLocation ) {
        array_push( $htmlJobLocation, $jLocation->name );
    }
}

$editor_description = get_post_meta( get_the_ID(), 'editor_description', true );
$editor_applicant = get_post_meta( get_the_ID(), 'editor_applicant', true );
$editor_offer = get_post_meta( get_the_ID(), 'editor_offer', true );

$htmlJobSalary = '';
$level = get_post_meta( $post->ID, 'level', true );
$max_salary = get_post_meta( $post->ID, 'max_salary', true );
$job_currency = get_post_meta( $post->ID, 'job_currency', true );
$currencies = array(
    'vnd' => 'VNĐ',
    'dolla' => 'Dolla'
);
$job_unit = get_post_meta( $post->ID, 'job_unit', true );
$units = array(
    'year' => __( 'Year', 'tried' ),
    'month' => __( 'Month', 'tried' ),
    'week' => __( 'Week', 'tried' ),
    'day' => __( 'Day', 'tried' ),
    'hour' => __( 'Hour', 'tried' )
);
if ( !empty( $level ) ) {
    $htmlJobSalary = $level.$currencies[$job_currency];
    if ( !empty( $max_salary ) ) {
        $htmlJobSalary .= ' - '.$max_salary.$currencies[$job_currency];
    }
    if ( !empty( $job_unit ) ) {
        $htmlJobSalary .= ' per '.$units[$job_unit];
    }
}

$activeSaveJob = false;
if ( is_user_logged_in() ) {
    $savejobsMeta = get_the_author_meta( 'savejobs', get_current_user_id() );
    if ( in_array( $post->ID, $savejobsMeta ) ) $activeSaveJob = true;
}

$company_name = get_post_meta( $post->ID, 'simple_job_board_company_name', true );
$company_website = get_post_meta( $post->ID, 'simple_job_board_company_website', true );
$company_tagline = get_post_meta( $post->ID, 'simple_job_board_company_tagline', true );
$company_logo = get_post_meta( $post->ID, 'simple_job_board_company_logo', true );
?>
<main <?php post_class( 'site-main' ); ?>>
    <div class="main-contain jobpost">
        <div class="banner-joblist">
            <div class="wrapper <?php echo !empty( $company_logo ) ? 'is-logo' : ''; ?>">
                <div class="joblist-headup">
                    <a href="<?php echo home_url(); ?>" title="<?php _e( 'Homepage', 'tried' ); ?>"
                        class="backtohome"><?php _e( 'Back to Homepage', 'tried' ); ?></a>
                    <h3 class="title"><?php wp_title( false ); ?></h3>
                    <ul class="meta">
                        <li class="location" <?php echo !$htmlJobLocation?'style="display: none;"':''; ?>>
                            <?php echo join( ', ', $htmlJobLocation ); ?>
                        </li>
                        <li class="sector" <?php echo !$htmlJobSector?'style="display: none;"':''; ?>>
                            <?php echo join( ', ', $htmlJobSector ); ?>
                        </li>
                        <li class="salary" <?php echo !$htmlJobSalary?'style="display: none;"':''; ?>>
                            <?php echo $htmlJobSalary; ?>
                        </li>
                    </ul>
                </div>
                <?php
                    if ( !empty( $company_logo ) ) {
                        printf(
                            '<div class="joblist-logo">
                                <a href="%s" title="%s"><img src="%s" alt="%s"></a>
                            </div>',
                            !empty( $company_website ) ? $company_website : 'javascript:void(0)', $company_name, $company_logo, $company_tagline
                        );
                    }
                ?>
            </div>
        </div>
        <div class="wrapper">
            <article class="single-blog have-sidebar">
                <div class="wrapper">
                    <div class="content-joblist">
                        <div class="content-joblist-context">
                            <div class="job-entry-content entry-content">
                                <div class="job_listing-content">
                                    <div class="content-job-block">
                                        <h5 class="content-job-block-title"><?php _e( 'Job Description', 'tried' ); ?>
                                        </h5>
                                        <div class="content-job-block-description"><?php echo get_the_content(); ?>
                                        </div>
                                    </div>
                                    <?php
                                        $joblistingMetaBoxs = array(
                                            array(
                                                'id' => 'editor_applicant',
                                                'title' => __( 'Your skills and experience', 'tried' )
                                            ),
                                            array(
                                                'id' => 'editor_offer',
                                                'title' => __( "Why you'll love working here", 'tried' )
                                            )
                                        );
                                        if ( $joblistingMetaBoxs ) {
                                            foreach ( $joblistingMetaBoxs as $metabox ) {
                                                $metaboxContent = get_post_meta( get_the_ID(), $metabox['id'], true );
                                                if ( $metaboxContent ) {
                                                    printf(
                                                        '<div class="content-job-block">
                                                            <h5 class="content-job-block-title">%s</h5>
                                                            <div class="content-job-block-description">%s</div>
                                                        </div>',
                                                        $metabox['title'],
                                                        $metaboxContent
                                                    );
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="job_listing-meta">
                                    <?php
                                        $keys = sjb_job_features_count();
                                        $job_category = wp_get_post_terms( $post->ID, 'jobpost_category' );
                                        $metas = '';
                                            
                                        // Show Job Features Title, If Features Exist.
                                        $job_features_title = apply_filters( 'sjb_job_features_title', esc_html__( 'Job summary', 'simple-job-board' ) );
                                        if ( !$job_features_title ) $job_features_title = esc_html__( 'Job summary', 'simple-job-board' );
                                        if ( 0 < $keys || NULL != $job_category ) echo '<h3 class="jobmeta-title">'.$job_features_title.'</h3>';
                                        echo '<div class="jobmeta-features">';
                                        do_action("sjb_job_features_category_before");
                                            
                                        // Job Function
                                        if ( $jobpostSector ) {
                                            echo '<div class="jobfeature-item"><span>' . esc_html__('Function', 'simple-job-board') . '</span><strong>'.array_shift( $htmlJobSector ).'</strong></div>';
                                            echo '<div class="jobfeature-item"><span>' . esc_html__('Sub Function', 'simple-job-board') . '</span><strong>'.join( ', ', $htmlJobSector ).'</strong></div>';
                                        }
                                            
                                        // Job Location
                                        if ( $jobpostLocation ) {
                                            echo '<div class="jobfeature-item"><span>' . esc_html__('Location', 'simple-job-board') . '</span><strong>'.join( ', ', $htmlJobLocation ).'</strong></div>';
                                        }
                                            
                                        // Job Level
                                        if ( $jobpostLocation ) {
                                            echo '<div class="jobfeature-item"><span>' . esc_html__('Level', 'simple-job-board') . '</span><strong>'.join( ', ', $htmlJobLevel ).'</strong></div>';
                                        }
                                            
                                        // Job Category
                                        if ( sjb_get_the_job_category() ) {
                                            echo '<div class="jobfeature-item"><span>' . esc_html__('Category', 'simple-job-board') . '</span><strong>';
                                            sjb_the_job_category();
                                            echo '</strong></div>';
                                        }
                                        do_action( 'sjb_job_features_category_after' );
                                            // Display Job Features
                                        $enable_feature = get_post_meta(get_the_ID(), 'enable_job_feature', TRUE);
                                        if( $enable_feature == 'jobfeatures' || $enable_feature == '' ) {
                                            $keys = get_post_custom_keys(get_the_ID());
                                            if ( $keys != NULL ) {
                                                foreach ( $keys as $key ) {
                                                    if ( substr($key, 0, 11) == 'jobfeature_' ) {
                                                        $val = get_post_meta($post->ID, $key, TRUE);
                                                        $val = maybe_unserialize($val);
                                                        $label = isset($val['label']) ? $val['label'] : __(ucwords(str_replace('_', ' ', substr($key, 11))), 'simple-job-board');
                                                        $value = isset($val['value']) ? $val['value'] : $val;
                                                        if ( $value != NULL ) {
                                                            $metas.= '<div class="jobfeature-item"><span>' . esc_attr( $label ) . '</span><strong>' . esc_attr( $value ) . ' </strong></div>';
                                                        }
                                                    }
                                                }
                                            }
                                            echo apply_filters( 'sjb_job_features', $metas );
                                        } else {
                                            $settings_options = maybe_unserialize(get_option('jobfeature_settings_options'));
                                            if ( NULL == $settings_options ) $settings_options = '';
                                            if ( $settings_options != NULL ) {
                                                foreach ( $settings_options as $key => $val ) {
                                                    if ( substr( $key, 0, 11 ) == 'jobfeature_' ) {
                                                        $label = isset($val['label']) ? $val['label'] : __(ucwords(str_replace('_', ' ', substr($key, 11))), 'simple-job-board');
                                                        $value = isset($val['value']) ? $val['value'] : $val;
                                                        if ( $value != NULL ) {
                                                            $metas.= '<div class="jobfeature-item"><span>' . esc_attr( $label ) . '</span><strong>' . esc_attr( $value ) . ' </strong></div>';
                                                        }
                                                    }
                                                }
                                            }
                                            echo apply_filters( 'sjb_job_features', $metas );
                                        }
                                        echo '</>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="job_apply-content">
                        <div class="job_applys">
                            <a class="savejob <?php echo $activeSaveJob?'active':''; ?>" href="javascript:void(0)"
                                data-job_id="<?php echo $post->ID; ?>" title="<?php _e( 'Save job', 'tried' ); ?>"><i
                                    class="far fa-star"></i><?php _e( 'Save Job', 'tried' ); ?></a>
                            <a class="viewjob"
                                href="<?php echo get_permalink( get_the_ID() ).'?apply_job='.get_the_ID(); ?>"
                                title="<?php _e( 'Apply job', 'tried' ); ?>"><?php _e( 'Apply now', 'tried' ); ?></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-joblist">
                    <div class="sidebar-job-wrapper">
                        <!-- <div class="sidebar-job-block" style="display: none;">
                            <h5 class="sidebar-job-block-title" style="margin-top: 20px;">
                                <?php _e( 'Sign up to receive job alerts', 'tried' ); ?></h5>
                            <div class="sidebar-job-block-content">
                                <p>We will let you know when any new <strong>Construction</strong> jobs In
                                    <strong>Boston</strong> are
                                    available.
                                </p>
                                <button type="button"
                                    class="jobapply-btn"><?php _e( 'Create Job Alert', 'tried' ); ?></button>
                            </div>
                        </div>
                        <div class="sidebar-job-block">
                            <h5 class="sidebar-job-block-title text-center">
                                <?php _e( 'Looking for your next leadership challenge?', 'tried' ); ?></h5>
                            <div class="sidebar-job-block-content">
                                <p class="text-center">
                                    Page Executive specialises in senior management, executive and leadership
                                    opportunities, suitable for candidates like you!
                                </p>
                                <button type="button"
                                    class="executive-btn"><?php _e( 'Explore Page Executive Now', 'tried' ); ?></button>
                            </div>
                        </div> -->
                        <div class="sidebar-job-block info-related">
                            <h5 class="sidebar-job-block-title"><?php _e( 'Other Jobs', 'tried' ); ?></h5>
                            <div class="sidebar-job-block-content">
                                <div class="related-joblists">
                                    <?php
                                        if ( $joblistRelated ) {
                                            foreach ( $joblistRelated as $related ) {
                                                get_template_part( 'template-parts/jobpost-item/item', 'small', array(
                                                    'id' => $related->ID
                                                ) );
                                            }
                                            wp_reset_postdata();
                                        } else {
                                            printf( '<p class="not-found">%s</p>', __( 'Không tìm thấy kết quả', 'tried' ) );
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</main>