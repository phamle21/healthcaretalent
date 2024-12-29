<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_script( 'tried-job_filter' );
wp_enqueue_style( 'tried-jobpost-archive' );

$taxonomy = false;
global $wp;
$searchKeyword = __( 'Job Title', 'tried' );
$currentSite = get_site_url();
if ( $wp ) $currentSite = home_url( $wp->request );
if ( isset( $args['taxonomy'] ) ) {
    if ( $args['taxonomy'] ) {
        $taxonomy = $posttype.'_'.$args['taxonomy']['tax'];
    }
    if ( $args['taxonomy']['tax'] ) {
        $currentSite = get_term_link( $args['taxonomy']['term'], $args['taxonomy']['tax'] );
    }
    if ( $args['taxonomy']['name'] ) {
        $searchKeyword = $args['taxonomy']['name'];
    }
}

$posttype = get_post_type();
if ( isset( $args['posttype'] ) ) {
    $posttype = $args['posttype'];
}

$listParams = array(
    'location' => 'jobpost_location',
    'category' => 'jobpost_category',
    'sector' => 'jobpost_job_type',
    'title' => 'jobpost_tag',
    'level' => 'level',
    'max_salary' => 'max_salary'
);

$getParamsURL = array();
if ( !empty( $_GET ) ) {
    $getParamsURL = array_intersect_key( $_GET, $listParams );
}

$jobpostArgs = array(
    'post_type' => $posttype,
    'orderby' => 'date',
    'order'=> 'DESC', 
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'tax_query' => array()
);

if ( $getParamsURL ) {
    $currentSite .= '?'.htmlspecialchars( http_build_query( $getParamsURL ) );
    $jobpostArgs['tax_query']['relation'] = 'AND';
    foreach ( $getParamsURL as $kparam => $param ) {
        if ( !$param ) continue;
        if ( $kparam == 'level' || $kparam == 'max_salary' ) continue;
        $jobpostArgs['tax_query'][] =  array(
            'taxonomy' => $listParams[$kparam],
            'field'    => 'term_id',
            'terms'    => explode( ',', $param )
        );
    }
}

$jobposts = get_posts( $jobpostArgs );
$level = 0;
$max_salary = 999999999999;
if ( $getParamsURL['level'] ) {
    $level = $getParamsURL['level'];
}
if ( $getParamsURL['max_salary'] ) {
    $max_salary = $getParamsURL['max_salary'];
}
if ( $jobposts ) {
    foreach ( $jobposts as $kj => $job ) {
        $jobMinSalary = filter_var( get_post_meta( $job->ID, 'level', true ), FILTER_SANITIZE_NUMBER_INT );
        $jobMaxSalary = filter_var( get_post_meta( $job->ID, 'max_salary', true ), FILTER_SANITIZE_NUMBER_INT );
        if ( $jobMinSalary < $level || $jobMaxSalary > $max_salary ) {
            unset($jobposts[$kj]);
        }
    }
}
$jobpostsCount = 0;
if ( $jobposts ) {
    $jobpostsCount = count( $jobposts );
}
?>
<?php get_header(); ?>
<script>
var _tried_site = '<?php echo home_url( $wp->request ); ?>',
    _tried_site_param = '<?php echo $currentSite; ?>',
    _tried_filter_params = ['<?php echo join( "', '", array_keys( $listParams ) ); ?>'];
</script>
<main <?php post_class( 'site-main' ); ?> role="main">
    <div class="main-contain joblist">
        <div class="banner-joblist">
            <div class="wrapper" style="grid-template-columns: unset;">
                <div class="toggle-searchjob">
                    <a href="javascript:void(0)"
                        title="<?php _e( 'Open search job', 'tried' ); ?>"><?php echo $searchKeyword; ?>
                        &#x2022;
                        <span><?php _e( 'Region, location...', 'tried' ); ?></span></a>
                </div>
                <div class="creatalert-job" style="display: none;">
                    <a href="#"
                        title="<?php _e( 'Create Job Alert', 'tried' ); ?>"><?php _e( 'Create Job Alert', 'tried' ); ?></a>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="joblist-totalsort">
                <div class="total-result"><span class="filtertotal"><?php echo $jobpostsCount; ?></span>
                    <?php _e( 'Search jobs', 'tried' ); ?>
                </div>
                <div class="sort-region" style="display: none;">
                    <label for="slct-sort-reigion"><?php _e( 'Sort by', 'tried' ); ?></label>
                    <select id="slct-sort-reigion">
                        <option value="relevance"><?php _e( 'Relevancy', 'tried' ); ?></option>
                        <option value="most_recent"><?php _e( 'Most recent', 'tried' ); ?></option>
                    </select>
                </div>
            </div>
            <div class="joblist-wrapper">
                <div class="jobs-filter">
                    <?php echo do_shortcode( '[tried_filter_dropdown site_url="'.$currentSite.'"]' ); ?>
                </div>
                <div class="jobs-result">
                    <div class="job_listings">
                        <?php
                            if ( !empty( $jobposts ) ) {
                                foreach ($jobposts as $job) {
                                    get_template_part( 'template-parts/jobpost-item/item-list', null, array(
                                        'id' => $job->ID
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
<?php get_footer(); ?>