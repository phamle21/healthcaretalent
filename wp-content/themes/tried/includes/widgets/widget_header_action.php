<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_header_action extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_header_action', 'Tried Header Action',
			array(
				'classname' => 'widget_header_action',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

	function widget( $args, $instance ) {
        $defaults = array(
            'findjob' => '',
            'account' => ''
        );
        $instance = wp_parse_args($instance, $defaults);

		global $current_user;
		wp_get_current_user();
        
		$findjob = $instance['findjob'];
		$account = $instance['account'];

        // $savejobsMeta = get_the_author_meta( 'savejobs', $current_user->ID );
		echo $args['before_widget'];
		?>
<section id="widget-<?php echo $args['widget_id']; ?>" class="section-header-action">
    <div class="section-wrapper">
        <?php
            if ( !empty( $findjob ) ) {
                printf(
                    '<div class="findjob-block">
                        <a href="%s" title="%s"><span>%s</span></a>
                    </div>',
                    esc_url( get_site_url() . '/' . $findjob ),
                    __( 'Job search', 'tried' ),
                    __('Job Search', 'tried')
                );
            }
            // if ( !empty( $savejob ) ) {
            //     printf( 
            //         '<div class="savejob-block">
            //             <a href="%s" title="%s"><span>%s</span><i class="count">%s</i></a>
            //         </div>',
            //         esc_url( get_site_url().'/'.$savejob ),
            //         __( 'Save jobs', 'tried' ),
            //         __('Save jobs', 'tried'),
            //         !empty( $savejobsMeta )?count( $savejobsMeta ):'0'
            //     );
            // }
        ?>
        <?php if ( !empty( $account ) ) : ?>
        <div class="account-block <?php echo is_user_logged_in()?'logged':''; ?>">
            <?php
				$titleAccount = __( 'Sign In/Up', 'tried' );
                $navAccount = '';
                $accountLink = add_query_arg( 'block', 'dashboard', home_url( $account ) );
				if ( is_user_logged_in() ) {
					$titleAccount = $current_user->user_login;
					$navAccount = '<div class="account-nav">
                        <h4>'.__( 'My Account', 'tried' ).'</h4>
						<ul>
                            <li><a href="'.esc_url( add_query_arg( 'block', 'dashboard', get_site_url().'/'.$account ) ).'" title="'.__( 'Dashboard', 'tried' ).'">'.__( 'Dashboard', 'tried' ).'</a></li>
							<li><a href="'.esc_url( add_query_arg( 'block', 'savejob', get_site_url().'/'.$account ) ).'" title="'.__( 'Saved Jobs', 'tried' ).'">'.__( 'Saved Jobs', 'tried' ).'</a></li>
							<li style="display: none;"><a href="'.esc_url( add_query_arg( 'block', 'applied-jobs', get_site_url().'/'.$account ) ).'" title="'.__( 'Applied Jobs', 'tried' ).'">'.__( 'Applied Jobs', 'tried' ).'</a></li>
							<li><a href="'.esc_url( add_query_arg( 'block', 'profile-detail', get_site_url().'/'.$account ) ).'" title="'.__( 'My Profile', 'tried' ).'">'.__( 'My Profile', 'tried' ).'</a></li>
                            <li><a href="'.esc_url( add_query_arg( array( 'block' => 'change-password' ), get_site_url().'/'.$account ) ).'" title="'.__( 'Change password', 'tried' ).'">'.__( 'Change password', 'tried' ).'</a></li>
							<li><a href="'.wp_logout_url().'" title="'.__( 'Logout', 'tried' ).'">'.__( 'Logout', 'tried' ).'</a></li>
						</ul>
					</div>';
				}
				printf( '<a href="%s" title="%s" style="width: 100px; text-align: center; line-height: 20px;"><span style="margin-top: 8px; width: 95px;padding-right: 0;">%s</span></a>%s', $accountLink, $titleAccount, $titleAccount, $navAccount );
			?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
        $instance = array();
		$instance['findjob'] = $new_instance['findjob'];
		$instance['account'] = $new_instance['account'];
		return $instance;
	}
	
	function form( $instance ) {
        $defaults = array(
            'findjob' => '',
            'account' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        ?>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('findjob')); ?>"><?php esc_html_e('Tìm việc(liên kết)', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['findjob']); ?>"
        name="<?php echo esc_attr($this->get_field_name('findjob')); ?>"
        id="<?php echo esc_attr($this->get_field_id('findjob')); ?>" />
</p>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_id('account')); ?>"><?php esc_html_e('Tài khoản(liên kết)', 'tried'); ?></label>
    <input class="widefat" type="text" value="<?php echo esc_attr($instance['account']); ?>"
        name="<?php echo esc_attr($this->get_field_name('account')); ?>"
        id="<?php echo esc_attr($this->get_field_id('account')); ?>" />
</p>
<?php
	}
}