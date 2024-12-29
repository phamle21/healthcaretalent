<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_another_jobsearch extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_another_jobsearch', 'Tried Another Jobsearch',
			array(
				'classname' => 'widget_another_jobsearch',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
        $defaults = array(
            'show_location' => '', 'location_title' => __( 'Jobs by Location', 'tried' ),
            'show_category' => '', 'category_title' => __( 'Jobs by Category', 'tried' ),
            'show_sector' => '', 'sector_title' => __( 'Jobs by Function', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
        
        wp_enqueue_script( 'tried-job_search-page' );
        
		$location_title = $instance['location_title'];
		$show_location = $instance['show_location'];

		$category_title = $instance['category_title'];
		$show_category = $instance['show_category'];

		$sector_title = $instance['sector_title'];
		$show_sector = $instance['show_sector'];

        $listOptionFunctions = array(
            'pharma' => __( 'Pharma', 'tried' ),
            'healthcare-services' => __( 'Healthcare Services', 'tried' )
        );

        $jobCats = apply_filters( 'tried_all_taxonomy', 'jobpost_category' );

        $jobSectors = apply_filters( 'tried_all_taxonomy', 'jobpost_job_type' );
        $sectorPriorities = array();
        foreach ( $jobSectors as $js ) {
            $functiontype = get_term_meta( $js->term_id, 'joblocation_functiontype', true );
            $argsSector = array( $js->term_id, $js->name );
            if ( $functiontype ) {
                $sectorPriorities[$functiontype][] = $argsSector;
            }
        }

        $jobLocations = apply_filters( 'tried_all_taxonomy', 'jobpost_location' );
        $locationNormals = array();
        $locationRegions = array();
        $locationPriorities = array();
        foreach ( $jobLocations as $jl ) {
            $order = get_term_meta( $jl->term_id, 'joblocation_order', true );
            $isregion = get_term_meta( $jl->term_id, 'joblocation_isregion', true );
            $argsLocation = array( $jl->term_id, $jl->name );
            if ( !empty( $isregion ) ) {
                array_push( $locationRegions, $argsLocation );
            } else if ( !empty( $order ) ) {
                $locationPriorities[$order] = $argsLocation;
            } else {
                array_push( $locationNormals, $argsLocation );
            }
        }
        ksort($locationPriorities);
        foreach ( $locationNormals as $l ) {
            $locationPriorities[] = $l;
        }
		echo $args['before_widget'];
		?>
<section id="section-<?php echo $args['widget_id']; ?>" class="section-another_jobsearch">
    <div class="jobsearch_nav-block">
        <div class="section-wrapper margin-auto">
            <h4 class="title"><?php _e( 'Search jobs by', 'tried' ); ?></h4>
            <div class="contain">
                <?php
                    if ( $show_location ) {
                        echo '<a href="#jobsearch-location">'.__( 'Location', 'tried' ).'</a>';
                    }
                    if ( $show_category ) {
                        echo '<a href="#jobsearch-category">'.__( 'Category', 'tried' ).'</a>';
                    }
                    if ( $show_sector ) {
                        echo '<a href="#jobsearch-sector">'.__( 'Function', 'tried' ).'</a>';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="jobsearch_list-block">
        <?php if ( $show_location ) { ?>
        <div id="jobsearch-location" class="jobsearch-item">
            <div class="section-wrapper margin-auto">
                <h4 class="title"><?php echo $location_title; ?></h4>
                <div class="contain">
                    <div data-locationtitle="<?php _e( 'Region', 'tried' ); ?>">
                        <ul class="location region">
                            <?php
                                if ( $locationRegions ) {
                                    foreach ( $locationRegions as $locationRegion ) {
                                        printf(
                                            '<li><a href="%s" title="%s">%s</a></li>',
                                            get_site_url().'/job-filter?location='.$locationRegion[0], $locationRegion[1], $locationRegion[1]
                                        );
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div data-locationtitle="<?php _e( 'Vietname', 'tried' ); ?>">
                        <ul class="location">
                            <?php
                                if ( $locationPriorities ) {
                                    foreach ( $locationPriorities as $jlocationPrioritie ) {
                                        printf(
                                            '<li><a href="%s" title="%s">%s</a></li>',
                                            get_site_url().'/job-filter?location='.$jlocationPrioritie[0], $jlocationPrioritie[1], $jlocationPrioritie[1]
                                        );
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="jobsearch-actcollapse">
                    <a href="javascript:void(0)" title="<?php _e( 'Show more/show less', 'tried' ); ?>"></a>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if ( $show_category ) { ?>
        <div id="jobsearch-category" class="jobsearch-item">
            <div class="section-wrapper margin-auto">
                <h4 class="title"><?php echo $category_title; ?></h4>
                <div class="contain">
                    <ul>
                        <?php
						if ( $jobCats ) {
							foreach ( $jobCats as $jcat ) {
								printf(
									'<li><a href="%s" title="%s">%s</a></li>',
									get_site_url().'/job-filter?category='.$jcat->term_id, $jcat->name, $jcat->name
								);
							}
						}
					?>
                    </ul>
                </div>
                <div class="jobsearch-actcollapse">
                    <a href="javascript:void(0)" title="<?php _e( 'Show more/show less', 'tried' ); ?>"></a>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if ( $show_sector ) { ?>
        <div id="jobsearch-sector" class="jobsearch-item">
            <div class="section-wrapper margin-auto">
                <h4 class="title"><?php echo $sector_title; ?></h4>
                <div class="contain">
                    <div class="col-function">
                        <div class="tabfunction-head"><?php echo $listOptionFunctions['pharma']; ?></div>
                        <ul>
                            <?php
                                if ( isset( $sectorPriorities['pharma'] ) ) {
                                    foreach ( $sectorPriorities['pharma'] as $jsectorp ) {
                                        printf(
                                            '<li><a href="%s" title="%s">%s</a></li>',
                                            get_site_url().'/job-filter?sector='.$jsectorp[0], $jsectorp[1], $jsectorp[1]
                                        );
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="col-function">
                        <div class="tabfunction-head"><?php echo $listOptionFunctions['healthcare-services']; ?></div>
                        <ul>
                            <?php
                                if ( isset( $sectorPriorities['healthcare-services'] ) ) {
                                    foreach ( $sectorPriorities['healthcare-services'] as $jsectorhs ) {
                                        printf(
                                            '<li><a href="%s" title="%s">%s</a></li>',
                                            get_site_url().'/job-filter?sector='.$jsectorhs[0], $jsectorhs[1], $jsectorhs[1]
                                        );
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="jobsearch-actcollapse">
                    <a href="javascript:void(0)" title="<?php _e( 'Show more/show less', 'tried' ); ?>"></a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
<?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['location_title'] = ($new_instance['location_title']);
		$instance['show_location'] = ($new_instance['show_location']);

		$instance['category_title'] = ($new_instance['category_title']);
		$instance['show_category'] = ($new_instance['show_category']);
        
		$instance['sector_title'] = ($new_instance['sector_title']);
		$instance['show_sector'] = ($new_instance['show_sector']);
        return $instance;
    }

    function form($instance) {
        $defaults = array(
            'show_location' => '', 'location_title' => __( 'Jobs by Location', 'tried' ),
            'show_category' => '', 'category_title' => __( 'Jobs by Category', 'tried' ),
            'show_sector' => '', 'sector_title' => __( 'Jobs by Function', 'tried' )
        );
        $instance = wp_parse_args($instance, $defaults);
		?>
<h4><?php _e( 'Job Location', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('show_location')); ?>"><?php esc_html_e('Show job-location', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['show_location']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('show_location')); ?>"
        id="<?php echo esc_attr($this->get_field_id('show_location')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('location_title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['location_title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('location_title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('location_title')); ?>" />
</p>
<h4><?php _e( 'Job Category', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('show_category')); ?>"><?php esc_html_e('Show job-category', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['show_category']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('show_category')); ?>"
        id="<?php echo esc_attr($this->get_field_id('show_category')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('category_title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['category_title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('category_title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('category_title')); ?>" />
</p>
<h4><?php _e( 'Job Function', 'tried' ); ?></h4>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('show_sector')); ?>"><?php esc_html_e('Show job-sector', ''); ?></label>
    <input class="widefat" type="checkbox" value="true" <?php echo $instance['show_sector']?'checked':''; ?>
        name="<?php echo esc_attr($this->get_field_name('show_sector')); ?>"
        id="<?php echo esc_attr($this->get_field_id('show_sector')); ?>" />
</p>
<p>
    <label for="<?php echo esc_attr($this->get_field_id('sector_title')); ?>"><?php esc_html_e('Title', ''); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['sector_title']); ?>"
        name="<?php echo esc_attr($this->get_field_name('sector_title')); ?>"
        id="<?php echo esc_attr($this->get_field_id('sector_title')); ?>" />
</p>
<?php
    }
}