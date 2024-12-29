<?php 
/* Template Name: Account - Dashboard */
defined('ABSPATH') || exit;

wp_enqueue_style( 'tried-account_dashboard-block' );

$root = 'account';
$savejobsMeta = get_the_author_meta( 'savejobs', get_current_user_id() );
?>
<div id="dashboard_account-block">
    <div class="dashboards">
        <div class="dashboard-item">
            <h4 class="dashboardtitle"><?php _e( 'My Jobs', 'tried' ); ?></h4>
            <div class="listsections">
                <div class="listsection-item">
                    <a href="<?php echo esc_url( add_query_arg( 'block', 'savejob', home_url( $root ) ) ); ?>"
                        title="Saved Jobs"></a>
                    <div class="box-contain">
                        <span><img src="<?php echo get_theme_file_uri( '/assets/img/tried-istarblue.svg' ); ?>"
                                alt="" /></span>
                        <h5>Saved Jobs</h5>
                        <p>You have <?php echo count( $savejobsMeta ); ?> saved jobs</p>
                    </div>
                </div>
                <div class="listsection-item">
                    <a href="#" title="Applied jobs"></a>
                    <div class="box-contain">
                        <span><img src="<?php echo get_theme_file_uri( '/assets/img/tried-istick.svg' ); ?>"
                                alt="" /></span>
                        <h5>Applied jobs</h5>
                        <p>View jobs you've recently applied for</p>
                    </div>
                </div>
                <?php if (false) { ?>
                <div class="listsection-item">
                    <a href="#" title="Searches & Alerts"></a>
                    <div class="box-contain">
                        <span><img src="<?php echo get_theme_file_uri( '/assets/img/tried-ibell.svg' ); ?>"
                                alt="" /></span>
                        <h5>Searches & Alerts</h5>
                        <p>Manage your recent searches and job alerts</p>
                    </div>
                </div>
                <div class="listsection-item highlight">
                    <a href="#" title="Uncompleted Applications"></a>
                    <div class="box-contain">
                        <span><img src="<?php echo get_theme_file_uri( '/assets/img/tried-ichevronright.svg' ); ?>"
                                alt="" /></span>
                        <h5>Uncompleted Applications</h5>
                        <p>Complete your Construction Superintendent Ground up Public Works Daly City job application
                            now.</p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="dashboard-item">
            <h4 class="dashboardtitle"><?php _e( 'My profile and Settings', 'tried' ); ?></h4>
            <div class="listsections">
                <div class="listsection-item">
                    <a href="<?php echo esc_url( add_query_arg( 'block', 'profile-detail', home_url( $root ) ) ); ?>"
                        title="Saved Jobs"></a>
                    <div class="box-contain">
                        <span><img src="<?php echo get_theme_file_uri( '/assets/img/tried-iuserblue.svg' ); ?>"
                                alt="" /></span>
                        <h5>Personal Details</h5>
                        <p>Keep your contact details and your CV up to date</p>
                    </div>
                </div>
                <?php if (false) { ?>
                <div class="listsection-item">
                    <a href="<?php echo esc_url( add_query_arg( 'block', 'my-cv', home_url( $root ) ) ); ?>"
                        title="Saved Jobs"></a>
                    <div class="box-contain">
                        <span><img src="<?php echo get_theme_file_uri( '/assets/img/tried-idocumentblue.svg' ); ?>"
                                alt="" /></span>
                        <h5>My CV</h5>
                        <p>Upload up to 3 CVs</p>
                    </div>
                </div>
                <?php } ?>
                <div class="listsection-item">
                    <a href="<?php echo esc_url( add_query_arg( 'block', 'change-password', home_url( $root ) ) ); ?>"
                        title="Saved Jobs"></a>
                    <div class="box-contain">
                        <span><img src="<?php echo get_theme_file_uri( '/assets/img/tried-ilockblue.svg' ); ?>"
                                alt="" /></span>
                        <h5>Account Settings</h5>
                        <p>Update your password and manage account</p>
                    </div>
                </div>
                <div class="listsection-item logout-mobile">
                    <a href="wp_logout_url()"
                        title="<?php _e( 'Logout', 'tried' ); ?>"><?php _e( 'Logout', 'tried' ); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>