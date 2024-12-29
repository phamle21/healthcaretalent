<?php 
/* Template Name: Job Seeker */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-job_seeker-page' );
wp_enqueue_script( 'tried-job_search-page' );

global $post;
$top_banner = get_post_meta( $post->ID, 'top_banner', true );

$form_action = 'job-seekers';
$have_suggest = true;

$posttype = 'jobpost';
$jobpostArgs = array(
    'post_type' => $posttype,
    'orderby' => 'date',
    'order'=> 'DESC', 
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'tax_query' => array()
);

$sortLayouts = array(
    'latest' => __( 'Latest', 'tried' ),
    'oldest' => __( 'Oldest', 'tried' )
);
$sortActive = 'latest';
$htmlSortLayout = '';

$layoutActive = 'list';
$fullURL = home_url( $form_action );
$listLayoutURL = $fullURL;
$gridLayoutURL = $fullURL;
$sortLayoutURL = $fullURL;

if ( isset( $_GET ) && !empty( $_GET ) ) {
    $fullURL .= '/?' . http_build_query( $_GET );
    if ( isset( $_GET['layout'] ) && $_GET['layout'] == 'grid' ) {
        $layoutActive = 'grid';
    }

    if ( strpos( $fullURL, 'layout=grid' ) ) {
        $listLayoutURL = str_replace( 'layout=grid', 'layout=list', $fullURL );
    } else {
        $listLayoutURL = $fullURL . '&layout=list';
    }

    if ( strpos( $fullURL, 'layout=list' ) ) {
        $gridLayoutURL = str_replace( 'layout=list', 'layout=grid', $fullURL );
    } else {
        $gridLayoutURL = $fullURL . '&layout=grid';
    }

    if ( isset( $_GET['sort'] ) && in_array( $_GET['sort'], array_keys( $sortLayouts ) ) ) {
        $sortActive = $_GET['sort'];
    }

    if ( !empty( $sortLayouts ) ) {
        foreach ( $sortLayouts as $ksg => $sortGet ) {
            $newHTMLSortLayout = '';
            if ( strpos( $fullURL, 'sort='.$_GET['sort'] ) ) {
                $newHTMLSortLayout = str_replace( 'sort='.$_GET['sort'], 'sort='.$ksg, $fullURL );
            } else {
                $newHTMLSortLayout = $fullURL . '&sort=' . $ksg;
            }
            $htmlSortLayout .= '<a href="'.$newHTMLSortLayout.'" class="'.( $sortActive == $ksg ? 'active' : '' ).'" title="'.$sortGet.'">'.$sortGet.'</a>';
        }
    }
} else {
    $listLayoutURL = $fullURL . '/?layout=list';
    $gridLayoutURL = $fullURL . '/?layout=grid';

    if ( !empty( $sortLayouts ) ) {
        foreach ( $sortLayouts as $ks => $sort ) {
            $htmlSortLayout .= '<a href="'.$fullURL . '/?sort='.$ks.'" title="'.$sort.'">'.$sort.'</a>';
        }
    }
}

$listParams = array(
    'location' => 'jobpost_location',
    'category' => 'jobpost_category',
    'sector' => 'jobpost_job_type',
    'title' => 'jobpost_tag',
    'level' => 'jobpost_level'
);

$getParamsURL = array();
if ( !empty( $_GET ) ) {
    $getParamsURL = array_intersect_key( $_GET, $listParams );
}
if ( $getParamsURL ) {
    $currentSite .= '?'.htmlspecialchars( http_build_query( $getParamsURL ) );
    $jobpostArgs['tax_query']['relation'] = 'AND';
    foreach ( $getParamsURL as $kparam => $param ) {
        if ( !$param ) continue;
        if ( $kparam == 'min_salary' || $kparam == 'max_salary' ) continue;
        $jobpostArgs['tax_query'][] =  array(
            'taxonomy' => $listParams[$kparam],
            'field'    => 'term_id',
            'terms'    => explode( ',', $param )
        );
    }
}

if ( isset( $_GET['search_keyword'] ) && !empty( $_GET['search_keyword'] ) ) {
    $jobpostArgs['s'] = $_GET['search_keyword'];
}
if ( isset( $_GET['search_location'] ) && !empty( $_GET['search_location'] ) ) {
	$jobLocations = apply_filters( 'tried_all_taxonomy', 'jobpost_location' );
    $slugSearchLocation = convert_slug( convertStrLatin( $_GET['search_location'] ) );
    if ( $jobLocations ) {
        foreach ( $jobLocations as $location ) {
            if ( $slugSearchLocation == $location->slug ) {
                $jobpostArgs['tax_query'][] =  array(
                    'taxonomy' => 'jobpost_location',
                    'field'    => 'term_id',
                    'terms'    => $location->term_id
                );
            }
        }
    }
}
if ( isset( $_GET['search_level'] ) && !empty( $_GET['search_level'] ) ) {
    $jobpostArgs['tax_query'][] =  array(
        'taxonomy' => 'jobpost_level',
        'field'    => 'term_id',
        'terms'    => $_GET['search_level']
    );
}
if ( isset( $_GET['search_function'] ) && !empty( $_GET['search_function'] ) ) {
    $jobpostArgs['tax_query'][] =  array(
        'taxonomy' => 'jobpost_job_type',
        'field'    => 'term_id',
        'terms'    => $_GET['search_function']
    );
}
if ( isset( $_GET['search_category'] ) && !empty( $_GET['search_category'] ) ) {
    $jobpostArgs['tax_query'][] =  array(
        'taxonomy' => 'jobpost_category',
        'field'    => 'term_id',
        'terms'    => $_GET['search_category']
    );
}
if ( isset( $_GET['search_tag'] ) && !empty( $_GET['search_tag'] ) ) {
    $jobpostArgs['tax_query'][] =  array(
        'taxonomy' => 'jobpost_tag',
        'field'    => 'term_id',
        'terms'    => $_GET['search_tag']
    );
}

if ( isset( $_GET['sort'] ) && !empty( $_GET['sort'] ) ) {
    switch ( $_GET['sort'] ) {
        case 'oldest':
            $jobpostArgs['order'] = 'ASC';
            break;
        default:
            $jobpostArgs['order'] = 'DESC';
            break;
    }
}

$jobposts = new WP_Query( $jobpostArgs );
$jobpostsCount = 0;
if ( $jobposts ) {
    $jobpostsCount = $jobposts->found_posts;
}

get_header();
?>

<main <?php post_class( 'site-main' ); ?>>
    <div class="main-contain jobseeker">
        <div class="banner-jobseeker" <?php echo isset( $top_banner ) && !empty( $top_banner ) ? 'style="background-image: url('.$top_banner.');"' : ''; ?>>
            <div class="wrapper <?php echo !empty( $company_logo ) ? 'is-logo' : ''; ?>">
                <div class="joblist-headup">
                    <a href="<?php echo home_url(); ?>" title="<?php _e( 'Homepage', 'tried' ); ?>"
                        class="backtohome"><?php _e( 'Back to Homepage', 'tried' ); ?></a>
                    <h3 class="title"><?php wp_title( false ); ?></h3>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="section-jobseeker_filter" id="jobseeker_filter">
                <div class="jobpost-filter">
                    <?php echo do_shortcode( "[tried_filter form_action='{$form_action}' have_suggest='{$have_suggest}']" ); ?>
                </div>
            </div>

            <div class="section-jobseeker_sortlayout" id="jobseeker_sortlayout">
                <div class="jobseeker-sortlayout">
                    <div class="total-result">
                        <?php
                            printf(
                                '%s <span class="filtertotal">%s</span> %s',
                                __( 'All', 'tried' ),
                                $jobpostsCount,
                                __( 'jobs found', 'tried' )
                            );
                        ?>
                    </div>
                    <div class="sort-layout">
                        <div class="sort-contain">
                            <label><?php _e( 'Sort by', 'tried' ); ?></label>
                            <div class="slct-sortlayout">
                                <span><?php echo $sortLayouts[$sortActive]; ?></span>
                                <?php
                                    if ( !empty( $sortLayouts ) ) {
                                        echo '<div><span>'.$htmlSortLayout.'</span></div>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="layout-contain">
                            <a href="<?php echo $listLayoutURL; ?>"
                                class="list-layout <?php echo $layoutActive == 'list' ? 'active': ''; ?>"
                                title="<?php _e( 'Job list layout', 'tried' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M10 6H16M10 14H16M10 10H22M10 18H22M3 10H5C5.55228 10 6 9.55228 6 9V7C6 6.44772 5.55228 6 5 6H3C2.44772 6 2 6.44772 2 7V9C2 9.55228 2.44772 10 3 10ZM3 18H5C5.55228 18 6 17.5523 6 17V15C6 14.4477 5.55228 14 5 14H3C2.44772 14 2 14.4477 2 15V17C2 17.5523 2.44772 18 3 18Z"
                                        stroke="#0E0F14" stroke-linecap="round" />
                                </svg>
                            </a>
                            <a href="<?php echo $gridLayoutURL; ?>"
                                class="grid-layout <?php echo $layoutActive == 'grid' ? 'active': ''; ?>"
                                title="<?php _e( 'Job list layout', 'tried' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M2 4C2 2.89543 2.89543 2 4 2H8C9.10457 2 10 2.89543 10 4V8C10 9.10457 9.10457 10 8 10H4C2.89543 10 2 9.10457 2 8V4Z"
                                        stroke="#0E0F14" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M14 4C14 2.89543 14.8954 2 16 2H20C21.1046 2 22 2.89543 22 4V8C22 9.10457 21.1046 10 20 10H16C14.8954 10 14 9.10457 14 8V4Z"
                                        stroke="#0E0F14" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M2 16C2 14.8954 2.89543 14 4 14H8C9.10457 14 10 14.8954 10 16V20C10 21.1046 9.10457 22 8 22H4C2.89543 22 2 21.1046 2 20V16Z"
                                        stroke="#0E0F14" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M14 16C14 14.8954 14.8954 14 16 14H20C21.1046 14 22 14.8954 22 16V20C22 21.1046 21.1046 22 20 22H16C14.8954 22 14 21.1046 14 20V16Z"
                                        stroke="#0E0F14" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-jobseeker_jobs" id="jobseeker_jobs">
                <div class="jobposts <?php echo $layoutActive; ?>">
                    <?php
                        if ( $jobposts->have_posts() ) {
                            while ( $jobposts->have_posts() ) {
                                $jobposts->the_post();
                                get_template_part( 'template-parts/jobpost-item/item-'.$layoutActive, null, array(
                                    'id' => get_the_ID()
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
</main>
<?php get_footer(); ?>