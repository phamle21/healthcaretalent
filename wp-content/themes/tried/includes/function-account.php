<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/** register form */
if( !function_exists('tried_register_form') ) {
	add_shortcode('tried_register_form', 'sc_tried_register_form');
	function sc_tried_register_form() {
		ob_start();
		global $wp;
		$message = false;
		wp_enqueue_style( 'tried-register_form-block' );
		if (is_user_logged_in()) {
			echo '<p>'.__("Bạn đã đăng nhập rồi.", 'tried').'</p>';
		} else {
			$valFullname = '';
			$valUsername = '';
			$valPhone = '';

			if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
				if ( isset( $_POST['fullname'] ) ) $valFullname = $_POST['fullname'];
				if ( isset( $_POST['username'] ) ) $valUsername = $_POST['username'];
				if ( isset( $_POST['phone'] ) ) $valPhone = $_POST['phone'];
				
				$message = process_register_form( $_POST );
			}
		?>
<div id="register_form-block">
    <div class="form-wrapper">
        <div class="formcol-item">
            <h4 class="formtitle"><?php _e( 'Sign up for free', 'tried' ); ?></h4>
            <?php
					if ( $_SERVER['REQUEST_METHOD'] === 'POST' && $message ) {
						printf(
							'<div class="message %s">%s</div>',
							$message['notify'], $message['content']
						);
					}
			?>
            <form class="register_form" method="post"
                action="<?php echo add_query_arg( 'form', 'register', home_url( $wp->request ) ); ?>">
                <?php wp_nonce_field( 'tried-accountform', 'tried-accountform-nonce' ); ?>
                <input type="hidden" name="is_register" value="true">
                <div class="col-field fullname">
                    <label for="user-fullname"><?php _e( 'Full name', 'tried' ) ?></label>
                    <input type="text" name="fullname" id="user-fullname" value="<?php echo $valFullname; ?>"
                        placeholder="<?php _e( 'Your name', 'tried' ); ?>">
                </div>
                <div class="col-field username">
                    <label for="user-username"><?php _e( 'Email address', 'tried' ) ?><span class="formhelp"
                            style="display: none;"></span></label>
                    <input type="text" name="username" id="user-username" value="<?php echo $valUsername; ?>"
                        placeholder="<?php _e( 'Your email', 'tried' ); ?>">
                </div>
                <div class="col-field phone">
                    <label for="user-phone"><?php _e( 'Phone', 'tried' ) ?><span class="formhelp"
                            style="display: none;"></span></label>
                    <input type="text" name="phone" id="user-phone" value="<?php echo $valPhone; ?>"
                        placeholder="<?php _e( 'Your phone', 'tried' ); ?>">
                </div>
                <div class="col-field password">
                    <label for="user-password"><?php _e('Password', 'tried'); ?><span class="formhelp"
                            style="display: none;"></span></label>
                    <input type="password" name="password" id="user-password" value=""
                        placeholder="<?php _e( 'Your password', 'tried' ); ?>">
                </div>
                <div class="col-field remember">
                    <input type="checkbox" name="rememberme" id="remember" value="">
                    <label for="remember"><?php _e( 'I agree to the privacy policy', 'tried' ); ?></label>
                </div>
                <div class="col-field submit">
                    <button type="submit"><?php _e( 'Submit', 'tried' ); ?></button>
                </div>
                <div class="col-field">
                    <?php
							printf(
								'<div class="linksignaccount text-center">Already have an account? <a href="%s" title="%s">%s</a></div>',
								esc_url( add_query_arg( 'form', 'sign-in', home_url( $wp->request ) ) ),
								__( 'Create an account', 'tried' ),
								__( 'Sign in', 'tried' )
							);
						?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
		}
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}

	add_shortcode( 'tried_register_form_fields', 'sc_tried_register_form_fields' );
	function sc_tried_register_form_fields( $atts, $contents = null ) {
		$args = shortcode_atts(array(
			'phone' => ''
		), $atts);
		?>
<?php if ( false ) { ?>
<div class="col-field company">
    <label for="user-company"><?php _e( 'Company', 'tried' ) ?>:</label>
    <input type="text" name="company" id="user-company"
        value="<?php echo esc_attr( stripslashes( $args['company'] ) ); ?>">
</div>
<div class="col-field address">
    <label for="label"><?php _e( 'Address', 'tried' ) ?><span class="required">*</span>:</label>
    <textarea name="address" id="user-address" cols="30"
        rows="2"><?php echo esc_attr( stripslashes( $args['address'] ) ); ?></textarea>
</div>
<?php } ?>
<div class="col-field phone">
    <label for="user-phone"><?php _e( 'Telephone', 'tried' ) ?><span class="required">*</span>:</label>
    <input type="text" name="phone" id="user-phone" value="<?php echo esc_attr( stripslashes( $args['phone'] ) ); ?>"
        placeholder="<?php _e( 'Enter Telephone', 'tried' ); ?>">
</div>
<?php
	}

	function process_register_form($args) {
		global $wp;
		$fullname = sanitize_text_field($args['fullname']);
		$username = sanitize_user($args['username']);
		$phone = sanitize_text_field($args['phone']);
		$password = sanitize_text_field($args['password']);
		$errors = apply_filters( 'registration_errors', $fullname, $username, $password, $phone );
		$message = array(
			'notify' => 'warning',
			'content' => 'Sorry, the current session has an error.'
		);
		if( !is_user_logged_in() && isset( $args['tried-accountform-nonce'] ) && wp_verify_nonce($args['tried-accountform-nonce'], 'tried-accountform') ) {
			if ( is_wp_error( $errors ) && !empty( $errors->get_error_messages() ) ) {
				$message['content'] = '<ul><li>'.implode('</li><li>', $errors->get_error_messages()).'</li></ul>';
			} else {
				$email = 'info@temp.com';
				if ( validate_string_to_email( $username ) ) {
					$email = $username;
				}
				$user_id = wp_create_user( $username, $password, $email );
				if ( !$user_id || is_wp_error( $user_id ) ) {
					$message = array(
						'notify' => 'fail',
						'content' => $user_id->get_error_message()
					);
				} else {
					$capability = 'member';
					$prefix_uid = 'M';
					$userinfo = array(
						'ID' => $user_id,
						'first_name' => ucwords($fullname),
						'role' => $capability
					);
					$uid = $prefix_uid.current_time('timestamp');
					update_user_meta( $user_id, 'uid', $uid );
					wp_update_user( $userinfo );
					$message['notify'] = 'success';
					$message['content'] = 'The account <span style="color: #2f802f;">"'.$username.'"</span> is created. <a href="'.esc_url( add_query_arg( 'form', 'login', home_url( $wp->request ) ) ).'" title="'.__('Login Now!', 'tried').'">'.__('Login Now!', 'tried').'</a>';
				}
			}
		}
		return $message;
	}
	
	add_filter( 'registration_errors', 'ft_registration_errors', 10, 4 );
	function ft_registration_errors( $fullname, $username, $password, $phone ) {
		global $errors;
		if ( !is_wp_error( $errors ) ) $errors = new WP_Error();
		if ( empty( $fullname ) ) {
			$errors->add( 'phone_error', __( 'Fullname is required.', 'tried' ) );
		}
		if ( empty( $username ) ) {
			$errors->add( 'email_errors', __( 'Email is required.', 'tried' ) );
		} elseif ( !validate_string_to_email( $_POST['username'] ) ) {
			$errors->add( 'email_errors', __( 'Email is not incorrect format.', 'tried' ) );
		}
		if ( empty( $phone ) ) {
			$errors->add( 'phone_errors', __( 'Phone is required.', 'tried' ) );
		} elseif ( strlen( $phone ) < 9 || strlen( $phone ) > 11 ) {
			$errors->add( 'password_errors', __( 'Phone is minimum 9 characters and maximum 11 characters.', 'tried' ) );
		}
		if ( empty( $password ) ) {
			$errors->add( 'password_errors', __( 'Password is required.', 'tried' ) );
		} elseif ( strlen( $password ) < 8 || strlen( $password ) > 20 ) {
			$errors->add( 'password_errors', __( 'Password is minimum 8 characters and maximum 20 characters.', 'tried' ) );
		}
		return $errors;
	}

    //  This action for 'Add New User' screen
    add_action( 'user_new_form', 'tried_register_profile_fields' );
    //  This actions for 'User Profile' screen
    add_action( 'show_user_profile', 'tried_register_profile_fields' );
    add_action( 'edit_user_profile', 'tried_register_profile_fields' );
    function tried_register_profile_fields( $user ) {
		$user_id = get_current_user_id();
        // if ( !current_user_can( 'administrator', $user_id ) ) return false;
		if ( isset( $_GET['user_id'] ) && is_numeric( $_GET['user_id'] ) ) $user_id = $_GET['user_id'];
        ?>
<h2><?php _e('Thông tin cá nhân', 'tried'); ?></h2>
<table class="form-table" role="presentation">
    <tbody>
        <tr class="user-phone-wrap">
            <th><label for="user-phone"><?php _e('Phone', 'tried'); ?></label></th>
            <td><input type="text" class="regular-text" name="phone" id="user-phone"
                    value="<?php echo esc_attr( get_the_author_meta( 'phone', $user_id ) ); ?>" /></td>
        </tr>
        <tr class="user-company-wrap">
            <th><label for="user-company"><?php _e('Công ty', 'tried'); ?></label></th>
            <td><input type="text" class="regular-text" name="company" id="user-company"
                    value="<?php echo esc_attr( get_the_author_meta( 'company', $user_id ) ); ?>" /></td>
        </tr>
        <tr class="user-address-wrap">
            <th><label for="user-address"><?php _e('Địa chỉ', 'tried'); ?></label></th>
            <td><textarea class="regular-text" name="address" id="user-address" cols="30"
                    rows="2"><?php echo esc_attr( get_the_author_meta( 'address', $user_id ) ); ?></textarea>
            </td>
        </tr>
    </tbody>
</table>
<h2><?php _e('Mạng xã hội', 'tried'); ?></h2>
<table class="form-table" role="presentation">
    <tbody>
        <tr class="user-facebook-wrap">
            <th><label for="user-facebook"><?php _e('Facebook', 'tried'); ?></label></th>
            <td><input type="text" class="regular-text" name="facebook" id="user-facebook"
                    value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user_id ) ); ?>" /></td>
        </tr>
        <tr class="user-twitter-wrap">
            <th><label for="user-twitter"><?php _e('Twitter', 'tried'); ?></label></th>
            <td><input type="text" class="regular-text" name="twitter" id="user-twitter"
                    value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user_id ) ); ?>" /></td>
        </tr>
        <tr class="user-skype-wrap">
            <th><label for="user-skype"><?php _e('Skype', 'tried'); ?></label></th>
            <td><input type="text" class="regular-text" name="skype" id="user-skype"
                    value="<?php echo esc_attr( get_the_author_meta( 'skype', $user_id ) ); ?>" /></td>
        </tr>
        <tr class="user-instagram-wrap">
            <th><label for="user-instagram"><?php _e('Instagram', 'tried'); ?></label></th>
            <td><input type="text" class="regular-text" name="instagram" id="user-instagram"
                    value="<?php echo esc_attr( get_the_author_meta( 'instagram', $user_id ) ); ?>" /></td>
        </tr>
    </tbody>
</table>
<?php
	}

    //  This action save 'Add New User'
    add_action( 'user_register', 'tried_save_profile_register' );
	function tried_save_profile_register( $user_id ) {
		$metas = array(
			'company', 'address', 'phone', 'department', 'facebook', 'skype', 'twitter', 'instagram'
		);
		if ( !empty( $metas ) ) {
			foreach ( $metas as $meta ) {
				if ( isset( $_POST[$meta] ) ) {
					update_user_meta( $user_id, $meta, $_POST[$meta] );
				}
			}
		}
	}

    //  This actions save 'User Profile'
    add_action( 'personal_options_update', 'tried_save_profile_fields' );
    add_action( 'edit_user_profile_update', 'tried_save_profile_fields' );
    function tried_save_profile_fields( $user_id ) {
		$metas = array(
			'company', 'address', 'phone', 'department', 'facebook', 'skype', 'twitter', 'instagram'
		);
		if ( !empty( $metas ) ) {
			foreach ( $metas as $meta ) {
				if ( isset( $_POST[$meta] ) ) {
					update_user_meta( $user_id, $meta, $_POST[$meta] );
				}
			}
		}
    }
}

/** login form */
if( !function_exists( 'tried_login_form' ) ) {
	add_shortcode( 'tried_login_form', 'sc_tried_login_form' );
	function sc_tried_login_form( $atts = array(), $content = null ) {
		ob_start();
		wp_enqueue_style( 'tried-login_form-block' );
		global $wp;
		$args = shortcode_atts( 
			array(
				'redirect_to' => ''
			),
		$atts );
		$message = false;
		if (is_user_logged_in()) {
			echo '<p>'.__("Bạn đã đăng nhập rồi.", 'tried').'</p>';
		} else {
			$valUsername = '';
			if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
				if ( isset( $_GET['usr'] ) ) $valUsername = $_GET['usr'];
				
				$message = array();
				if ( isset( $_GET['log'] ) ) {
					if ( $_GET['log'] == 1 ) {
						$message[] = __( 'Username is required.', 'tried' );
					}
					if ( $_GET['log'] == 2 ) {
						$message[] = __( 'Username does not exist.', 'tried' );
					}
					if ( $_GET['log'] == 3 ) {
						$message[] = __( 'Password is required.', 'tried' );
					}
					if ( $_GET['log'] == 4 ) {
						$message[] = __( 'Password is minimum 8 characters and maximum 20 characters.', 'tried' );
					}
					if ( $_GET['log'] == 5 ) {
						$message[] = __( 'Incorrect username and password.', 'tried' );
					}
				}
			}

			$redirectTo = home_url();
			if ( isset( $atts['redirect_to'] ) && !empty( $atts['redirect_to'] ) ) {
				$redirectTo = $atts['redirect_to'];
			}
		?>
<div id="login_form-block">
    <div class="form-wrapper">
        <div class="formcol-item">
            <h4 class="formtitle"><?php _e( 'Sign in', 'tried' ); ?></h4>
            <?php
				if ( $_SERVER['REQUEST_METHOD'] === 'GET' && $message ) {
					printf( '<div class="message warning">%s</div>', '<ul><li>'.implode( '</li><li>', $message ) . '</li></ul>' );
				}
			?>
            <form class="login_form" method="post" action="<?php echo wp_login_url(); ?>">
                <?php wp_nonce_field( 'tried-accountform', 'tried-accountform-nonce' ); ?>
                <input type="hidden" name="redirect_to" value="<?php echo $redirectTo; ?>">
                <div class="col-field username">
                    <label for="user_name"><?php _e( 'Email address', 'tried' ) ?><span class="formhelp"
                            style="display: none;"></span></label>
                    <input type="text" name="log" id="user_name" value="<?php echo $valUsername; ?>"
                        placeholder="<?php _e( 'Your email', 'tried' ); ?>">
                </div>
                <div class="col-field password">
                    <label for="user_pass"><?php _e( 'Password', 'tried'); ?><span class="formhelp"
                            style="display: none;"></span></label>
                    <input type="password" name="pwd" id="user_pass" autocomplete="current-password" value=""
                        placeholder="<?php _e( 'Your password', 'tried' ); ?>">
                </div>
                <?php if ( false ) : ?>
                <div class="col-field remember">
                    <input type="checkbox" name="rememberme" id="remember" value="true">
                    <label for="remember"><?php _e( 'Stay Signed in', 'tried' ); ?></label>
                </div>
                <?php endif; ?>
                <div class="col-field submit">
                    <button type="submit" name="wp-submit"><?php _e( 'Submit', 'tried' ); ?></button>
                </div>
                <?php if ( false ) : ?>
                <div class="col-inlineor"><span><?php _e( 'Or', 'tried' ); ?></span></div>
                <div class="col-field">
                    <div class="linkanothers">
                        <a rel="nofollow"
                            href=""
                            title="<?php _e( 'Sign in with LinkedIn', 'tried' ); ?>"><i class="fab fa-linkedin-in"
                                style="color: #0079ba;"></i><?php _e( 'Sign in with LinkedIn', 'tried' ); ?></a>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-field">
                    <?php
							printf(
								'<div class="linksignaccount text-center">%s <a href="%s" title="%s">%s</a></div>',
								__( "Don't have an account?", 'tried' ),
								esc_url( add_query_arg( 'form', 'register', home_url( 'account' ) ) ),
								__( 'Create an account', 'tried' ),
								__( 'Sign up', 'tried' )
							);
						?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
		}
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}

	add_action( 'after_setup_theme', 'tried_login_user' );
	function tried_login_user() {
		if ( !is_user_logged_in() && !isset( $_POST['is_register'] )
			&& isset( $_POST['tried-accountform-nonce'] ) && wp_verify_nonce($_POST['tried-accountform-nonce'], 'tried-accountform') ) {
			$username = $_POST['log'];
			$password = $_POST['pwd'];
			$remember = true;
	
			$errors = array();
			if ( empty( $username ) ) {
				$errors[] = 1;
			} elseif ( !username_exists( $username ) ) {
				$errors[] = 2;
			} elseif ( empty( $password ) ) {
				$errors[] = 3;
			} elseif ( strlen( $password ) < 8 || strlen( $password ) > 20 ) {
				$errors[] = 4;
			}

			if ( $errors ) {
				wp_redirect( home_url( '/account?usr=' . $username . '&log=' . implode( ',', $errors ) ) );
				exit();
			} else {
				$creds = array(
					'user_login' => $username,
					'user_password' => $password,
					'remember' => $remember
				);
				$user = wp_signon( $creds, false );
				if ( is_wp_error( $user ) ) {
					error_log( $user->get_error_message() );
					wp_redirect( home_url( '/account?usr=' . $username . '&log=5' ) );
					exit();
				}
			}
		}
	}
}

// change password
function process_change_password_form( $user_id, $args ) {
	$errors = apply_filters( 'change_password_errors', $errors, $user_id, array(
		'action' => $_POST['tried-accountform-nonce'],
		'name' => 'tried-accountform'
	), $args['currentpassword'], $args['newpassword'] );
	$message = array(
		'notify' => 'warning',
		'content' => 'Sorry, the current session has an error.'
	);
	if ( is_wp_error($errors) && !empty($errors->get_error_messages()) ) {
		$message = array(
			'notify' => 'warning',
			'content' => __( '<strong>Fail:</strong>', 'tried' ).'<ul><li>'.implode('</li><li>', $errors->get_error_messages()).'</li></ul>'
		);
	} else {
		$set_password = wp_set_password( $args['newpassword'], $user_id );
		if ( is_wp_error( $set_password ) ) {
			$message = array(
				'notify' => 'warning',
				'content' => __( '<strong>Fail:</strong>', 'tried' ).'<ul><li>'.implode('</li><li>', $set_password->get_error_messages()).'</li></ul>'
			);
		} else  {
			$message = array(
				'notify' => 'success',
				'content' => __( '<strong>Success:</strong> Account password updated.', 'tried' )
			);
		}
	}
	return $message;
}

add_filter( 'change_password_errors', 'ft_change_password_errors', 10, 5 );
function ft_change_password_errors( $errors, $user_id, $verify, $currentpassword, $newpassword ) {
	global $errors;
	if (! is_wp_error($errors)) $errors = new WP_Error();
	if( isset( $verify['action'] ) && wp_verify_nonce( $verify['action'], $verify['name'] ) ) {
		if ( empty($currentpassword) ) {
			$errors->add( 'currentpassword_errors', __( 'Current Password field is required.', 'tried' ) );
		} else {
			$user_data = get_user_by('id', $user_id);
			if ( !wp_check_password( $currentpassword, $user_data->user_pass, $user_id) ) {
				$errors->add( 'checkpassword_errors', __( 'Mật khẩu hiện tại không chính xác.', 'tried' ) );
			} else {
				if ( empty($newpassword) ) {
					$errors->add( 'newpassword_errors', __( 'New Password field is required.', 'tried' ) );
				}
			}
		}
	} else {
		$errors->add( 'failded_errors', __( 'đã phát hiện một lỗi phát sinh.', 'tried' ) );
	}
	return $errors;
}

// update info
function process_update_info_form( $user_id, $args ) {
	$errors = apply_filters( 'update_info_errors', $errors, $user_id, array(
		'action' => $_POST['tried-accountform-nonce'],
		'name' => 'tried-accountform'
	), $args );
	$message = array(
		'notify' => 'warning',
		'content' => __( 'Sorry, the current session has an error.', 'tried' ),
        'parameters' => $args
	);
	if ( is_wp_error($errors) && !empty($errors->get_error_messages()) ) {
		$message['content'] = __( '<strong>Fail:</strong>', 'tried' ).'<ul><li>'.implode('</li><li>', $errors->get_error_messages()).'</li></ul>';
	} else {
		wp_update_user( array(
			'ID' => $user_id,
			'display_name' => $args['fullname'],
			'user_email' => $args['email']
		) );
		update_user_meta( $user_id, 'phone', $_POST['phone'] );
		// update_user_meta( $user_id, 'company', $args['company'] );
		// update_user_meta( $user_id, 'address', $args['address'] );
		// update_user_meta( $user_id, 'facebook', $args['facebook'] );
		// update_user_meta( $user_id, 'twitter', $args['twitter'] );
		// update_user_meta( $user_id, 'skype', $args['skype'] );
		// update_user_meta( $user_id, 'instagram', $args['instagram'] );
		$message['notify'] = 'success';
		$message['content'] = __( '<strong>Success:</strong> Thông tin tài khoản đã được cập nhật.', 'tried' );
	}
	return $message;
}

add_filter( 'update_info_errors', 'ft_update_info_errors', 10, 4 );
function ft_update_info_errors( $errors, $user_id, $verify, $args ) {
	global $errors;
	if (! is_wp_error($errors)) $errors = new WP_Error();
	if( isset( $verify['action'] ) && wp_verify_nonce( $verify['action'], $verify['name'] ) ) {
		if ( empty( $args['password'] ) ) {
			$errors->add( 'password_errors', __( 'Password field is required.', 'tried' ) );
		} else {
			$user_data = get_user_by( 'id', $user_id );
			if ( !wp_check_password( $args['password'], $user_data->user_pass, $user_id ) ) {
				$errors->add( 'password_errors', __( 'Mật khẩu không chính xác.', 'tried' ) );
			} else {
				if ( empty($args['fullname']) ) {
					$errors->add( 'fullname_errors', __( 'Họ và tên không được để trống.', 'tried' ) );
				}
				if ( empty($args['phone']) ) {
					$errors->add( 'phone_errors', __( 'Số điện thoại không được để trống.', 'tried' ) );
				}
				// if ( empty($args['address']) ) {
				// 	$errors->add( 'address_errors', __( 'Địa chỉ không được để trống.', 'tried' ) );
				// }
				if ( empty($args['email']) ) {
					$errors->add( 'email_errors', __( 'Email không được để trống.', 'tried' ) );
				} elseif ( !validate_string_to_email( $args['email'] ) ) {
					$errors->add( 'email_errors', __( 'Email không đúng định dạng.', 'tried' ) );
				}
			}
		}
	} else {
		$errors->add( 'failded_errors', __( 'đã phát hiện một lỗi phát sinh.', 'tried' ) );
	}
	return $errors;
}


// Custom User's avatar
add_action( 'show_user_profile', 'tried_profile_img_fields' );
add_action( 'edit_user_profile', 'tried_profile_img_fields' );
function tried_profile_img_fields( $user ) {
	// if ( ! current_user_can( 'upload_files' ) ) return;
	$upload_url      = get_the_author_meta( 'tried_upload_meta', $user->ID );
	$upload_edit_url = get_the_author_meta( 'tried_upload_edit_meta', $user->ID );
	$button_text     = $upload_url ? 'Change Current Image' : 'Upload New Image';
	if ( $upload_url ) {
		$upload_edit_url = get_site_url() . $upload_edit_url;
	}
	$avatar = get_avatar_url( $user->ID );
	if ( !empty( $avatar ) ) {
		$avatar_url = $avatar;
	}
	?>
<h2><?php _e( 'Hình ảnh đại diện', 'tried' ); ?></h2>
<div id="tried_container">
    <table class="form-table">
        <tr>
            <th><label for="tried_meta"><?php _e( 'Profile Photo', 'tried' ); ?></label></th>
            <td>
                <!-- Outputs the image after save -->
                <div id="current_img">
                    <?php if ( $upload_url ): ?>
                    <img class="tried-current-img" src="<?php echo esc_url( $upload_url ); ?>" />
                    <div class="edit_options uploaded">
                        <a class="remove_img" href="javascript:void(0)"><?php _e( 'Xóa', 'tried' ); ?></a>
                        <a class="edit_img" href="<?php echo esc_url( $upload_edit_url ); ?>"
                            target="_blank"><?php _e( 'Chỉnh sửa', 'tried' ); ?></a>
                    </div>
                    <?php elseif ( $avatar_url ) : ?>
                    <img class="tried-current-img" src="<?php echo esc_url( $avatar_url ); ?>" />
                    <div class="edit_options single">
                        <a class="remove_img" href="javascript:void(0)"><?php _e( 'Remove', 'tried' ); ?></a>
                    </div>
                    <?php else : ?>
                    <img class="tried-current-img placeholder"
                        src="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>" />
                    <?php endif; ?>
                </div>
                <!-- Select an option: Upload to WPMU or External URL -->
                <div id="tried_options">
                    <label for="upload_option"><input type="radio" id="upload_option" name="img_option" value="upload"
                            class="tog" checked>
                        <?php _e( 'Upload New Image', 'tried' ); ?></label>
                    <label for="external_option"><input type="radio" id="external_option" name="img_option"
                            value="external" class="tog">
                        <?php _e( 'Use External URL', 'tried' ); ?></label>
                </div>
                <!-- Hold the value here if this is a WPMU image -->
                <div id="tried_upload">
                    <input class="hidden" type="hidden" name="tried_placeholder_meta" id="tried_placeholder_meta"
                        value="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>" />
                    <input class="hidden" type="hidden" name="tried_upload_meta" id="tried_upload_meta"
                        value="<?php echo esc_url_raw( $upload_url ); ?>" />
                    <input class="hidden" type="hidden" name="tried_upload_edit_meta" id="tried_upload_edit_meta"
                        value="<?php echo esc_url_raw( $upload_edit_url ); ?>" />
                    <input id="uploadimage" type='button' class="tried_wpmu_button button-primary"
                        value="<?php _e( esc_attr( $button_text ), 'tried' ); ?>" />
                </div>
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <div id="tried_external" style="display: none;">
                    <input class="regular-text" type="text" name="tried_meta" id="tried_meta"
                        value="<?php echo esc_url_raw( $avatar_url ); ?>" />
                </div>
                <!-- Outputs the save button -->
                <p class="description">
                    <?php _e( 'Update Profile to save your changes.', 'tried' ); ?>
                </p>
            </td>
        </tr>
    </table>
</div>
<?php
	// Enqueue the WordPress Media Uploader.
	wp_enqueue_media();
}

add_action( 'personal_options_update', 'tried_save_img_meta' );
add_action( 'edit_user_profile_update', 'tried_save_img_meta' );
function tried_save_img_meta( $user_id ) {
	// if ( ! current_user_can( 'upload_files', $user_id ) ) return;
	$values = array(
		// String value. Empty in this case.
		'tried_meta' => filter_input( INPUT_POST, 'tried_meta', FILTER_SANITIZE_STRING ),
		// File path, e.g., http://3five.dev/wp-content/plugins/tried/img/placeholder.gif.
		'tried_upload_meta' => filter_input( INPUT_POST, 'tried_upload_meta', FILTER_SANITIZE_URL ),
		// Edit path, e.g., /wp-admin/post.php?post=32&action=edit&image-editor.
		'tried_upload_edit_meta' => filter_input( INPUT_POST, 'tried_upload_edit_meta', FILTER_SANITIZE_URL ),
	);
	foreach ( $values as $key => $value ) {
		update_user_meta( $user_id, $key, $value );
	}
}

add_filter( 'get_avatar', 'tried_avatar', 1, 5 );
function tried_avatar( $avatar, $identifier, $size, $alt ) {
	if ( $user = tried_get_user_by_id_or_email( $identifier ) ) {
		if ( $custom_avatar = get_tried_meta( $user->ID, 'thumbnail' ) ) {
			return "<img alt='{$alt}' src='{$custom_avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		}
		if ( $attachment_upload_url = esc_url( get_the_author_meta( 'tried_upload_meta', $user->ID ) ) ) {
			return "<img alt='{$alt}' src='{$attachment_upload_url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		}
	}
	return $identifier;
}

function get_tried_meta( $user_id, $size = 'thumbnail' ) {
	global $post;
	if ( ! $user_id || ! is_numeric( $user_id ) ) {
		$user_id = $post->post_author;
	}
	// Check first for a custom uploaded image.
	$attachment_upload_url = esc_url( get_the_author_meta( 'tried_upload_meta', $user_id ) );
	if ( $attachment_upload_url ) {
		// Grabs the id from the URL using the WordPress function attachment_url_to_postid @since 4.0.0.
		$attachment_id = attachment_url_to_postid( $attachment_upload_url );
		// Retrieve the thumbnail size of our image. Should return an array with first index value containing the URL.
		$image_thumb = wp_get_attachment_image_src( $attachment_id, $size );
		return isset( $image_thumb[0] ) ? $image_thumb[0] : '';
	}
	// Finally, check for image from an external URL. If none exists, return an empty string.
	$attachment_ext_url = esc_url( get_the_author_meta( 'tried_meta', $user_id ) );
	return $attachment_ext_url ? $attachment_ext_url : '';
}

function tried_get_user_by_id_or_email( $identifier ) {
	// If an integer is passed.
	if ( is_numeric( $identifier ) ) {
		return get_user_by( 'id', (int) $identifier );
	}
	// If the WP_User object is passed.
	if ( is_object( $identifier ) && property_exists( $identifier, 'ID' ) ) {
		return get_user_by( 'id', (int) $identifier->ID );
	}
	// If the WP_Comment object is passed.
	if ( is_object( $identifier ) && property_exists( $identifier, 'user_id' ) ) {
		return get_user_by( 'id', (int) $identifier->user_id );
	}
	return get_user_by( 'email', $identifier );
}

add_action( 'tried_account_avatar', 'act_tried_account_avatar' );
function act_tried_account_avatar() {
    if (is_user_logged_in()) {
    $upload_url      = get_the_author_meta( 'tried_upload_meta', $current_user->ID );
    $upload_edit_url = get_the_author_meta( 'tried_upload_edit_meta', $current_user->ID );
    $button_text     = $upload_url ? 'Change Current Image' : 'Upload New Image';
    if ( $upload_url ) {
        $upload_edit_url = get_site_url() . $upload_edit_url;
    }
    $avatar = get_avatar_url( $current_user->ID );
    if ( !empty( $avatar ) ) {
        $avatar_url = $avatar;
    }
    $key_avatarupload = wp_generate_uuid4();
?>
<div class="avatar-user avatar-upload <?php echo $key_avatarupload; ?>">
    <div class="avatar-edit">
        <input type="hidden" name="avatar_url" value="" data-attachment=""
            data-placeholder="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>" />
        <a class="avatar-browse" href="javascript:void(0)" id="file-browse"
            data-order="<?php echo $key_avatarupload; ?>"></a>
    </div>
    <?php if ( $upload_url ): ?>
    <div class="avatar-preview" style="background-image: url(<?php echo esc_url( $upload_url ); ?>);"></div>
    <?php elseif ( $avatar_url ) : ?>
    <div class="avatar-preview" style="background-image: url(<?php echo esc_url( $avatar_url ); ?>);"></div>
    <?php else : ?>
    <div class="avatar-preview"
        style="background-image: url(<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>);">
    </div>
    <?php endif; ?>
</div>
<?php
}
}


// Allows the use of email logins
add_action( 'wp_authenticate', 'optional_email_address_login', 1, 2 );
function optional_email_address_login( $username, $password ) {
	$user = get_user_by( 'email', $username );
	if ( !empty( $user->user_login ) ) {
		$username = $user->user_login;
	}
}

// Redirect after logout
add_action('wp_logout','tried_redirect_after_logout');
function tried_redirect_after_logout() {
	wp_safe_redirect( home_url() );
	exit();
}

// Hook the appropriate WordPress action
// add_action('init', 'prevent_wp_login');
// function prevent_wp_login() {
//     // WP tracks the current page - global the variable to access it
//     global $pagenow;
//     // Check if a $_GET['action'] is set, and if so, load it into $action variable
//     $action = (isset($_GET['action'])) ? $_GET['action'] : '';
//     // Check if we're on the login page, and ensure the action is not 'logout'
//     if( $pagenow == 'wp-login.php' && ( ! $action || ( $action && ! in_array($action, array('logout', 'lostpassword', 'rp', 'resetpass'))))) {
//         // Load the home page url
//         $page = home_url( 'account' );
//         // Redirect to the home page
//         wp_redirect($page);
//         // Stop execution to prevent the page loading for any reason
//         exit();
//     }
// }