<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_filter( 'archive_template', 'tried_archive_template', 20 );
function tried_archive_template( $template ) {
    if ( get_queried_object()->name == 'jobpost' ) {
        $template = get_template_directory() . '/page-templates/jobpost-filter.php';
    }
    return $template;
}


//  This action for 'Add New User' screen
add_action( 'user_new_form', 'tried_register_savejobs_profile_fields' );
//  This actions for 'User Profile' screen
add_action( 'show_user_profile', 'tried_register_savejobs_profile_fields' );
add_action( 'edit_user_profile', 'tried_register_savejobs_profile_fields' );
function tried_register_savejobs_profile_fields( $user ) {
    if ( !current_user_can( 'administrator', $user->ID ) ) return false;
    $savejobs = get_the_author_meta( 'savejobs', $user->ID );
    ?>
<h2><?php _e('Yêu thích', 'tried'); ?></h2>
<table class="form-table" role="presentation">
    <tbody>
        <tr class="user-facebook-wrap">
            <th><label for="user-savejobs"><?php _e('Saved Jobs', 'tried'); ?></label></th>
            <td>
                <select class="select2 regular-text" name="savejobs[]" id="user-savejobs" multiple>
                    <?php
						if ( $savejobs ) {
							foreach( $savejobs as $sj ) {
								printf( '<option value="%s">%s</option>', $sj, $sj );
							}
						}
					?>
                </select>
            </td>
        </tr>
    </tbody>
</table>
<?php
}

//  This action save 'Add New User'
// add_action( 'user_register', 'tried_save_savejobs_profile_register' );
// function tried_save_savejobs_profile_register( $user_id ) {
// 	$metas = array(
// 		'savejobs'
// 	);
// 	if ( !empty( $metas ) ) {
// 		foreach ( $metas as $meta ) {
// 			if ( isset( $_POST[$meta] ) ) {
// 				update_user_meta( $user_id, $meta, $_POST[$meta] );
// 			}
// 		}
// 	}
// }

//  This actions save 'User Profile'
// add_action( 'personal_options_update', 'tried_save_savejobs_profile_fields' );
// add_action( 'edit_user_profile_update', 'tried_save_savejobs_profile_fields' );
// function tried_save_savejobs_profile_fields( $user_id ) {
// 		$metas = array(
// 			'savejobs'
// 		);
// 		if ( !empty( $metas ) ) {
// 			foreach ( $metas as $meta ) {
// 				if ( isset( $_POST[$meta] ) ) {
// 					update_user_meta( $user_id, $meta, $_POST[$meta] );
// 				}
// 			}
// 		}
// }

add_action( 'wp_ajax_tried_jobpost_update_savejobs', 'ajx_tried_jobpost_update_savejobs' );
add_action( 'wp_ajax_nopriv_tried_jobpost_update_savejobs', 'ajx_tried_jobpost_update_savejobs' );
function ajx_tried_jobpost_update_savejobs() {
	$message = array(
		'code' => 400,
		'content' => 'Sorry, the current session has an error.',
        'result' => ''
	);
	if ( !is_user_logged_in() ) {
        $message['code'] = 301;
        $message['content'] = __( '<strong>Fail:</strong> Some error appeared.', 'tried' );
        $message['result'] = esc_url( add_query_arg( 'block', 'dashboard', home_url( 'account' ) ) );
    } else {
        if ( isset( $_GET['job_id'] ) && !empty( $_GET['job_id'] ) && is_numeric( $_GET['job_id'] ) ) {
            $savejobs = get_the_author_meta( 'savejobs', get_current_user_id() );
            if ( $savejobs == '' || $savejobs == null ) {
                $savejobs = array();
            }
            $keyFindSaveJob = array_search( $_GET['job_id'], $savejobs );
            if ( $keyFindSaveJob !== false || ( isset( $_GET['func'] ) && $_GET['func'] == 'remove' && $keyFindSaveJob !== false ) ) {
                unset($savejobs[$keyFindSaveJob]);
            } else {
                array_push( $savejobs, $_GET['job_id'] );
            }
            update_user_meta( get_current_user_id(), 'savejobs', $savejobs );
            $message['code'] = 200;
            $message['content'] = __( "<strong>Success:</strong> Save Jobs's updated!", 'tried' );

            $newSaveJobs = get_the_author_meta( 'savejobs', get_current_user_id(), true );
            $message['result'] = array_values( $newSaveJobs ) ?? $newSaveJobs;
        } else {
            $message['content'] = __( '<strong>Fail:</strong> Some error appeared.', 'tried' );
        }
    }
    wp_send_json( $message );
}

add_action( 'init', 'tried_jobpost_init' );
function tried_jobpost_init() {
    remove_post_type_support( 'jobpost', 'excerpt' );
    remove_post_type_support( 'jobpost', 'comments' );
}



add_filter( 'proccess_jobrequired_form_errors', 'ft_proccess_jobrequired_form', 10, 2 );
function ft_proccess_jobrequired_form( $verify, $args ) {
    $requiredFields = array(
        'cus_fullname' => array(
            'required' => __( 'Full Name field is required.', 'tried' )
        ),
        'cus_company' => array(
            'required' => __( 'Company field is required.', 'tried' )
        ),
        'cus_email' => array(
            'required' => __( 'Email field is required.', 'tried' )
        ),
        'cus_telephone' => array(
            'required' => __( 'Telephone field is required.', 'tried' )
        ),
        'job_title' => array(
            'required' => __( 'Job Title field is required.', 'tried' )
        )
    );
    // $uploadFields = array(
    //     'job_sector' => array(
    //         'required' => __( 'Sector field is required.', 'tried' )
    //     ),
    //     'job_location' => array(
    //         'required' => __( 'Location field is required.', 'tried' )
    //     ),
    //     'job_uploadfile' => array(
    //         'required' => __( 'Sector field is required.', 'tried' )
    //     )
    // );
    
	global $errors;
	if (! is_wp_error($errors)) $errors = new WP_Error();
	if( isset( $verify['action'] ) && wp_verify_nonce( $verify['action'], $verify['name'] ) ) {
        if ( $requiredFields ) {
            foreach ( $requiredFields as $kfield => $field ) {
                if ( isset( $args[$kfield] ) && empty( $args[$kfield] ) ) {
                    $errors->add( $kfield.'_required', $field['required'] );
                }
            }
        }
	} else {
		$errors->add( 'failded', __( 'đã phát hiện một lỗi phát sinh.', 'tried' ) );
	}
    
	return $errors;
}

add_filter( 'post_jobrequired_form', 'act_post_jobrequired_form', 10, 2 );
function act_post_jobrequired_form( $form, $args ) {
	$errors = apply_filters( 'proccess_jobrequired_form_errors', array(
		'action' => $args['tried-jobpostform-nonce'],
		'name' => 'tried-jobpostform'
	), $args );
	$message = array(
		'notify' => 'warning',
		'content' => __( 'Sorry, the current session has an error.', 'tried' ),
        'parameters' => $args
	);
	if ( is_wp_error( $errors ) && !empty( $errors->get_error_messages() ) ) {
		$message['content'] = __( '<strong>Fail:</strong>', 'tried' ).'<ul><li>'.implode('</li><li>', $errors->get_error_messages()).'</li></ul>';
	} else {
        $jobrequired_id = wp_insert_post( array(
            'post_title' => wp_generate_uuid4() . '-' . current_time( 'timestamp' ), 
            'post_type' => 'jobrequired',
            'post_status' => 'publish',
            'post_author' => -1
        ), true );
        
		if ( is_wp_error( $jobrequired_id ) ) {
			$message['content'] = __( '<strong>Fail:</strong>', 'tried' ).'<ul><li>'.implode('</li><li>', $set_password->get_error_messages()).'</li></ul>';
		} else  {
            update_post_meta( $jobrequired_id, 'cus_fullname', $args['cus_fullname'] );
            update_post_meta( $jobrequired_id, 'cus_telephone', $args['cus_telephone'] );
            update_post_meta( $jobrequired_id, 'cus_email', $args['cus_email'] );
            update_post_meta( $jobrequired_id, 'cus_company', $args['cus_company'] );
            update_post_meta( $jobrequired_id, 'job_title', $args['job_title'] );

            $jobrequiredCat = 'request-a-call-back';
            if ( isset( $args['jobrequired_cat'] ) && $args['jobrequired_cat'] == 'upload' ) {
                update_post_meta( $jobrequired_id, 'job_sector', $args['job_sector'] );
                update_post_meta( $jobrequired_id, 'job_location', $args['job_location'] );
                $jobrequiredCat = 'upload-a-job-description';
                $attachment = isset( $_FILES['job_uploadfile'] ) ? $_FILES['job_uploadfile']: '';

                if ( $attachment ) {
                    if ( ! function_exists( 'wp_handle_upload' ) ) include ABSPATH . 'wp-admin/includes/file.php';
                    if ( ! function_exists( 'wp_crop_image' ) ) include ABSPATH . 'wp-admin/includes/image.php';

                    $mimes              = array();
                    $allowed_mime_types = get_allowed_mime_types();
                    $alowed_types       = array( 'pdf', 'doc', 'docx');
                    foreach ( $alowed_types as $allowed_type ) {
                        if ( isset( $allowed_mime_types[ $allowed_type ] ) ) {
                            $mimes[ $allowed_type ] = $allowed_mime_types[ $allowed_type ];
                        }
                    }
                    $movefile = wp_handle_upload( $attachment, array(
                        'test_form'                => false,
                        'mimes'                    => $mimes
                    ) );
                    if ( $movefile && ! isset( $movefile['error'] ) ) {
                        $image_url = $attachment;
                        $upload_dir = wp_upload_dir();
                        $image_data = file_get_contents( $image_url );
                        $filename = basename( $upload_dir );

                        if ( wp_mkdir_p( $upload_dir['path'] ) ) {
                            $file = $upload_dir['path'] . '/' . $filename;
                        } else {
                            $file = $upload_dir['basedir'] . '/' . $filename;
                        }

                        file_put_contents( $file, $image_data );
                        $wp_filetype = wp_check_filetype( $filename, null );

                        $attachment = array(
                            'post_mime_type' => $wp_filetype['type'],
                            'post_title' => sanitize_file_name( $filename ),
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );

                        $attach_id = wp_insert_attachment( $attachment, $movefile['file'] );
                        if ( !is_wp_error( $attach_id ) ) {
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                            wp_update_attachment_metadata( $attach_id, $attach_data );
                            update_post_meta( $jobrequired_id, 'job_cv', $attach_id );
                        }
                    }
                }
            } else {
                update_post_meta( $jobrequired_id, 'job_tag', $args['job_tag'] );
                
                $jobrequiredOption = 'hire';
                if ( isset( $args['jobrequired_option'] ) ) {
                    $jobrequiredOption = $args['jobrequired_option'];
                }
                $isSetJobOption = wp_set_object_terms( $jobrequired_id, $jobrequiredOption, 'jobrequired_option' );
                if ( $isSetJobOption ) {
                    wp_remove_object_terms( $jobrequired_id, 'unknown', 'jobrequired_option' );
                }
            }
            
            $isSetJobCat = wp_set_object_terms( $jobrequired_id, $jobrequiredCat, 'jobrequired_cat' );
            if ( $isSetJobCat ) {
                wp_remove_object_terms( $jobrequired_id, 'unknown', 'jobrequired_cat' );
            }

			$message['notify'] = 'success';
			$message['content'] = __( '<strong>Success:</strong> Information has been recorded.', 'tried' );
		}
    }
	return $message;
}

function sendMail($args) {
            //php mailer variables
            $email = 'trietnguyen197@gmail.com';
            $message = $args['cus_email'].' sent upload cv form';
            $to = 'trieto852vn@gmail.com';
            $subject = "Upload and request job";
            $headers = 'From: '. $args['email'] . "\r\n" . 'Reply-To: ' . $args['email'] . "\r\n";

            //Here put your Validation and send mail
            $sent = wp_mail( $to, $subject, strip_tags( $message ), $headers );
}

add_shortcode( 'tried_request_callback_form', 'sc_tried_request_callback_form' );
function sc_tried_request_callback_form( $atts ) {
    ob_start();
	$atts = shortcode_atts( array(), $atts );
    
	$jobTitles = apply_filters( 'tried_all_taxonomy', 'jobpost_tag' );
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = apply_filters( 'post_jobrequired_form', 'request_callback', $_POST );
        if ( isset( $message['parameters'] ) && $message['notify'] != 'success' ) {
            foreach ( array_keys( $atts ) as $k ) {
                if ( !isset( $message['parameters'][$k] ) ) continue;
                $atts[$k] = $message['parameters'][$k];
            }
        }
        printf(
            '<div class="message %s">%s</div>',
            $message['notify'], $message['content']
        );
    }
	?>
<form class="request_callback-form" action="" method="post">
    <?php wp_nonce_field( 'tried-jobpostform', 'tried-jobpostform-nonce' ); ?>
    <input type="hidden" name="jobrequired_cat" value="request" />
    <div class="form-field">
        <label for="request_callback-fullname"><?php _e( 'Full Name', 'tried' ); ?></label>
        <input type="text" name="cus_fullname" id="request_callback-fullname" value="" />
    </div>
    <div class="form-field">
        <label for="request_callback-jobtitle"><?php _e( 'Job Title', 'tried' ); ?></label>
        <input type="text" name="job_title" id="request_callback-jobtitle" value="" />
    </div>
    <div class="form-field">
        <label for="request_callback-email"><?php _e( 'Email', 'tried' ); ?></label>
        <input type="text" name="cus_email" id="request_callback-email" value="" />
    </div>
    <div class="form-field">
        <label for="request_callback-company"><?php _e( 'Company', 'tried' ); ?></label>
        <input type="text" name="cus_company" id="request_callback-company" value="" />
    </div>
    <div class="form-field">
        <label for="request_callback-telephone"><?php _e( 'Telephone', 'tried' ); ?></label>
        <input type="text" name="cus_telephone" id="request_callback-telephone" value="" />
    </div>
    <div class="form-field">
        <label for="request_callback-option"><?php _e( 'Select an option', 'tried' ); ?></label>
        <select name="jobrequired_option" id="request_callback-option">
            <option value="" selected="selected"></option>
            <option value="hire"><?php _e( "I'm looking to hire", 'tried' ); ?></option>
            <option value="job"><?php _e( "I'm looking for a job", 'tried' ); ?></option>
        </select>
    </div>
    <div class="form-field">
        <label for="request_callback-tag"><?php _e( 'Function of the position looked for', 'tried' ); ?></label>
        <select name="job_tag" id="request_callback-tag">
            <option value="" selected="selected"></option>
            <?php
				if ( $jobTitles ) {
					foreach ( $jobTitles as $jtitle ) {
						printf(
							'<option value="%s">%s</option>',
							$jtitle->term_id, $jtitle->name
						);
					}
				}
            ?>
        </select>
    </div>
    <div class="form-submit">
        <button type="submit"><?php _e( 'Submit', 'tried' ); ?></button>
    </div>
</form>
<?php
    $result = ob_get_contents();
    ob_end_clean();
    if ( $message['notify'] == 'success' ) {
        sendMail( $message['parameters']['cus_email'] );
    }
    return $result;
}

add_shortcode( 'tried_upload_job_description_form', 'sc_tried_upload_job_description_form' );
function sc_tried_upload_job_description_form( $atts ) {
    ob_start();
	$atts = shortcode_atts( array(
        'cus_fullname' => '',
        'cus_company' => '',
        'job_title' => '',
        'cus_email' => '',
        'cus_telephone' => '',
        'job_sector' => '',
        'job_location' => ''
    ), $atts );
    wp_enqueue_script( 'tried-job_apply' );

    $jobSectors = apply_filters( 'tried_all_taxonomy', 'jobpost_job_type' );
	$jobLocations = apply_filters( 'tried_all_taxonomy', 'jobpost_location' );
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = apply_filters( 'post_jobrequired_form', 'upload_description', $_POST );
        if ( isset( $message['parameters'] ) && $message['notify'] != 'success' ) {
            foreach ( array_keys( $atts ) as $k ) {
                if ( !isset( $message['parameters'][$k] ) ) continue;
                $atts[$k] = $message['parameters'][$k];
            }
        }
        printf(
            '<div class="message %s">%s</div>',
            $message['notify'], $message['content']
        );
    }
	?>
<form id="upload_description" class="upload_job_description-form" action="" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field( 'tried-jobpostform', 'tried-jobpostform-nonce' ); ?>
    <input type="hidden" name="jobrequired_cat" value="upload" />
    <div class="form-field">
        <label for="upload_job_description-fullname"><?php _e( 'Full Name', 'tried' ); ?></label>
        <input type="text" name="cus_fullname" id="upload_job_description-fullname"
            value="<?php echo $atts['cus_fullname']; ?>" />
    </div>
    <div class="form-field">
        <label for="upload_job_description-company"><?php _e( 'Company', 'tried' ); ?></label>
        <input type="text" name="cus_company" id="upload_job_description-company"
            value="<?php echo $atts['cus_company']; ?>" />
    </div>
    <div class="form-field">
        <label for="upload_job_description-jobtitle"><?php _e( 'Job Title', 'tried' ); ?></label>
        <input type="text" name="job_title" id="upload_job_description-jobtitle"
            value="<?php echo $atts['job_title']; ?>" />
    </div>
    <div class="form-field">
        <label for="upload_job_description-email"><?php _e( 'Email', 'tried' ); ?></label>
        <input type="text" name="cus_email" id="upload_job_description-email"
            value="<?php echo $atts['cus_email']; ?>" />
    </div>
    <div class="form-field">
        <label for="upload_job_description-telephone"><?php _e( 'Telephone', 'tried' ); ?></label>
        <input type="text" name="cus_telephone" id="upload_job_description-telephone"
            value="<?php echo $atts['cus_telephone']; ?>" />
    </div>
    <div class="form-field">
        <label for="upload_job_description-sector"><?php _e( 'Function of Job', 'tried' ); ?></label>
        <select name="job_sector" id="upload_job_description-sector">
            <option value="" selected="selected">-- <?php _e( 'Select', 'tried' ); ?> --</option>
            <?php
				if ( $jobSectors ) {
					foreach ( $jobSectors as $jsector ) {
						printf(
                            '<option value="%s" %s>%s</option>',
                            $jsector->term_id, selected( $jsector->term_id, $atts['job_sector'] ), $jsector->name
                        );
					}
				}
            ?>
        </select>
    </div>
    <div class="form-field">
        <label for="upload_job_description-location"><?php _e( 'Location', 'tried' ); ?></label>
        <select name="job_location" id="upload_job_description-location">
            <option value="" selected="selected">-- <?php _e( 'Select', 'tried' ); ?> --</option>
            <?php
				if ( $jobLocations ) {
					foreach ( $jobLocations as $jlocation ) {
						printf(
                            '<option value="%s" %s>%s</option>',
                            $jlocation->term_id, selected( $jlocation->term_id, $atts['job_location'] ), $jlocation->name
                        );
					}
				}
            ?>
        </select>
    </div>
    <div class="form-field upload-file">
        <label><?php _e( 'Upload File', 'tried' ); ?></label>
        <div class="uploadfile-list">
            <div class="files-choosed"></div>
            <a href="javascript:void(0)"
                title="<?php _e( 'Upload File', 'tried' ); ?>"><?php _e( 'Upload File', 'tried' ); ?></a>
            <div class="uploadfile-wrapper" style="display: none;">
                <label for="upload_job_description-uploadfile"><?php _e( 'Upload File', 'tried' ); ?></label>
                <input type="file" accept=".<?php echo join( ',.', array( 'pdf', 'doc', 'docx') ); ?>"
                    id="upload_job_description-uploadfile" style="display:none;" name="job_uploadfile">
            </div>
        </div>
    </div>
    <div class="form-submit">
        <button type="submit"><?php _e( 'Submit', 'tried' ); ?></button>
    </div>
</form>
<?php
    $result = ob_get_contents();
    ob_end_clean();
    if ( $message['notify'] == 'success' ) {
        sendMail( $message['parameters']['cus_email'] );
    }
    return $result;
}

add_shortcode( 'tried_filter_dropdown', 'sc_tried_filter_dropdown' );
function sc_tried_filter_dropdown( $atts ) {
    ob_start();
	$atts = shortcode_atts(
		array(
            'form_action' => 'jobs',
			'have_suggest' => true,
			'filter_salary' => true
		),
		$atts
	);
	
	$jobCats = apply_filters( 'tried_all_taxonomy', 'jobpost_category' );
	$jobLocations = apply_filters( 'tried_all_taxonomy', 'jobpost_location' );
	$jobSectors = apply_filters( 'tried_all_taxonomy', 'jobpost_job_type' );
	$jobTitles = apply_filters( 'tried_all_taxonomy', 'jobpost_tag' );
	?>
<div id="job_dropdown_filters" class="job_dropdown_filters">
    <div class="togglefilter_jobs">
        <div class="togglefilter_jobs-item head">
            <h4><?php _e( 'Filter', 'tried' ); ?></h4>
            <a class="filterdropdown-reset" href="javascript:void(0)"
                title="<?php _e( 'Reset filter', 'tried' ); ?>"><?php _e( 'Reset', 'tried' ); ?></a>
        </div>
        <div class="togglefilter_jobs-item">
            <a href="javascript:void(0)" title="<?php _e( 'Location', 'tried' ); ?>"
                data-role="location"><?php _e( 'Location', 'tried' ); ?><span class="filterselected"></span></a>
            <div class="togglefilter-context" style="display: none;">
                <ul style="display: grid;">
                    <?php
						if ( $jobLocations ) {
							foreach ( $jobLocations as $jlocation ) {
                                $isregion = get_term_meta( $jlocation->term_id, 'joblocation_isregion', true );
                                $order = get_term_meta( $jlocation->term_id, 'joblocation_order', true );
                                $priority = 9999;
                                if ( $order ) {
                                    $priority = 100 + $order;
                                }
                                if ( $isregion ) {
                                    $priority = 1;
                                }
								printf(
									'<li style="order: %s"><span class="filterdropdown" data-tax="location" data-value="%s"><span>%s</span><span>%s</span></span></li>',
                                    $priority, $jlocation->term_id, $jlocation->name, $jlocation->count
								);
							}
						}
					?>
                </ul>
                <a href="javascript:void(0)" class="togglefilter-showmore"
                    title="<?php _e( 'Show more/show less', 'tried' ); ?>" style="display: none;"></a>
            </div>
        </div>
        <div class="togglefilter_jobs-item">
            <a href="javascript:void(0)" title="<?php _e( 'Category', 'tried' ); ?>"
                data-role="category"><?php _e( 'Category', 'tried' ); ?><span class="filterselected"></span></a>
            <div class="togglefilter-context" style="display: none;">
                <ul>
                    <?php
						if ( $jobCats ) {
							foreach ( $jobCats as $jcat ) {
								printf(
									'<li><span class="filterdropdown" data-tax="category" data-value="%s"><span>%s</span><span>%s</span></span></li>',
									$jcat->term_id, $jcat->name, $jcat->count
								);
							}
						}
					?>
                </ul>
                <a href="javascript:void(0)" class="togglefilter-showmore"
                    title="<?php _e( 'Show more/show less', 'tried' ); ?>" style="display: none;"></a>
            </div>
        </div>
        <div class="togglefilter_jobs-item">
            <a href="javascript:void(0)" title="<?php _e( 'Function', 'tried' ); ?>"
                data-role="sector"><?php _e( 'Function', 'tried' ); ?><span class="filterselected"></span></a>
            <div class="togglefilter-context" style="display: none;">
                <ul>
                    <?php
						if ( $jobSectors ) {
							foreach ( $jobSectors as $jsector ) {
								printf(
									'<li><span class="filterdropdown" data-tax="sector" data-value="%s"><span>%s</span><span>%s</span></span></li>',
									$jsector->term_id, $jsector->name, $jsector->count
								);
							}
						}
					?>
                </ul>
                <a href="javascript:void(0)" class="togglefilter-showmore"
                    title="<?php _e( 'Show more/show less', 'tried' ); ?>" style="display: none;"></a>
            </div>
        </div>
        <div class="togglefilter_jobs-item">
            <a href="javascript:void(0)" title="<?php _e( 'Title job', 'tried' ); ?>"
                data-role="title"><?php _e( 'Title job', 'tried' ); ?><span class="filterselected"></span></a>
            <div class="togglefilter-context" style="display: none;">
                <ul>
                    <?php
						if ( $jobTitles ) {
							foreach ( $jobTitles as $jtitle ) {
								printf(
									'<li><span class="filterdropdown" data-tax="title" data-value="%s"><span>%s</span><span>%s</span></span></li>',
									$jtitle->term_id, $jtitle->name, $jtitle->count
								);
							}
                        }
					?>
                </ul>
                <a href="javascript:void(0)" class="togglefilter-showmore"
                    title="<?php _e( 'Show more/show less', 'tried' ); ?>" style="display: none;"></a>
            </div>
        </div>
        <div class="togglefilter_jobs-item none-toggle">
            <a href="javascript:void(0)"
                title="<?php _e( 'Monthly salary (USD)', 'tried' ); ?>"><?php _e( 'Monthly salary (USD)', 'tried' ); ?></a>
            <div class="togglefilter-context year-salary-region">
                <div class="slct-salary search_level">
                    <label for="search_level"><?php _e( 'Min Salary', 'tried' ); ?></label>
                    <select name="level" id="search_level">
                        <option value=""><?php _e( 'Max Salary', 'tried' ); ?></option>
                        <?php
                            $salaries = array(
                                '0' => '0',
                                '25000' => '25k',
                                '50000' => '50k',
                                '75000' => '75k',
                                '100000' => '100k',
                                '125000' => '125k',
                                '150000' => '150k',
                                '175000' => '175k',
                                '200000' => '200k',
                                '225000' => '225k',
                                '250000' => '250k',
                                '275000' => '275k',
                                '300000' => '300k',
                                '400000' => '400k',
                                '500000' => '500k'
                            );
                            foreach ( $salaries as $ksalary => $salary ) {
                                printf(
                                    '<option value="%s">%s</option>',
                                    $ksalary, $salary
                                );
                            }
                        ?>
                    </select>
                </div>
                <div class="slct-salary search_max_salary">
                    <label for="search_level"><?php _e( 'Max Salary', 'tried' ); ?></label>
                    <select name="max_salary" id="search_function">
                        <option value=""><?php _e( 'Max Salary', 'tried' ); ?></option>
                        <?php
                            $salaries = array(
                                '0' => '0',
                                '25000' => '25k',
                                '50000' => '50k',
                                '75000' => '75k',
                                '100000' => '100k',
                                '125000' => '125k',
                                '150000' => '150k',
                                '175000' => '175k',
                                '200000' => '200k',
                                '225000' => '225k',
                                '250000' => '250k',
                                '275000' => '275k',
                                '300000' => '300k',
                                '400000' => '400k',
                                '500000' => '500k'
                            );
                            foreach ( $salaries as $ksalary => $salary ) {
                                printf(
                                    '<option value="%s">%s</option>',
                                    $ksalary, $salary
                                );
                            }
                        ?>
                    </select>
                </div>
                <div class="submit_salary">
                    <button type="button"
                        class="salary_filter"><?php esc_attr_e( 'Filter Salary', 'wp-job-manager' ); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}



add_shortcode( 'tried_filter_head', 'sc_tried_filter_head' );
function sc_tried_filter_head( $atts ) {
    ob_start();
	$atts = shortcode_atts(
		array(),
		$atts
	);
	
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
    
    $getSearchKeyword = '';
    if ( isset( $_GET['search_keyword'] ) ) {
        $getSearchKeyword = $_GET['search_keyword'];
    }
    $getSearchLocation = '';
    if ( isset( $_GET['search_location'] ) ) {
        $getSearchLocation = $_GET['search_location'];
    }
	?>
<div id="job_filter_head" class="job_filter_head">
    <form class="job_filters head" action="job-seekers" method="get">
        <div class="mainfilter_jobs">
            <div class="search_keywords">
                <input type="text" name="search_keyword" id="search_keywords"
                    placeholder="<?php esc_attr_e( 'Job title', 'tried' ); ?>"
                    value="<?php echo $getSearchKeyword; ?>" />
            </div>
            <div class="search_location">
                <select name="search_location" id="search_location" style="border-color: #e3e5e9;">
                    <option value=""><?php _e( 'Region, location...', 'tried' ); ?></option>
                    <?php
                    foreach ( $locationPriorities as $jlocationPrioritie ) {
                        printf(
                            '<option value="%s" %s>%s</option>',
                            $jlocationPrioritie[1], selected( $getSearchLocation, $jlocationPrioritie[1] ), $jlocationPrioritie[1]
                        );
                    }
                ?>
                </select>
            </div>
            <div class="search_submit">
                <input type="submit" value="<?php esc_attr_e( 'Search', 'wp-job-manager' ); ?>">
            </div>
            <div class="cancel_submit">
                <a href="javascript:void(0)"
                    title="<?php esc_attr_e( 'Cancel', 'tried' ); ?>"><?php esc_attr_e( 'Cancel', 'tried' ); ?></a>
            </div>
        </div>
    </form>
</div>
<?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}



add_shortcode( 'tried_filter', 'sc_tried_filter' );
function sc_tried_filter( $atts ) {
    ob_start();
	$atts = shortcode_atts(
		array(
            'form_action' => 'job-seekers',
			'have_suggest' => true,
			'filter_salary' => true
		),
		$atts
	);
	
	$jobCats = apply_filters( 'tried_all_taxonomy', 'jobpost_category' );
	$jobSectors = apply_filters( 'tried_all_taxonomy', 'jobpost_job_type' );
	$jobTitles = apply_filters( 'tried_all_taxonomy', 'jobpost_tag' );
	$jobLocations = apply_filters( 'tried_all_taxonomy', 'jobpost_location' );
	$jobLevels = apply_filters( 'tried_all_taxonomy', 'jobpost_level' );

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

    $getSearchKeyword = '';
    if ( isset( $_GET['search_keyword'] ) ) {
        $getSearchKeyword = $_GET['search_keyword'];
    }
    $getSearchLocation = '';
    if ( isset( $_GET['search_location'] ) ) {
        $getSearchLocation = $_GET['search_location'];
    }
    $getSearchLevel = '';
    if ( isset( $_GET['search_level'] ) ) {
        $getSearchLevel = $_GET['search_level'];
    }
    $getSearchFunction = '';
    if ( isset( $_GET['search_function'] ) ) {
        $getSearchFunction = $_GET['search_function'];
    }
	?>
<form class="job_filters" action="<?php echo $atts['form_action']; ?>" method="get">
    <div class="mainfilter_jobs">
        <div class="search_keywords">
            <input type="text" name="search_keyword" id="search_keywords"
                placeholder="<?php esc_attr_e( 'Job title', 'tried' ); ?>" value="<?php echo $getSearchKeyword; ?>" />
        </div>

        <div class="search_location">
            <select name="search_location" id="search_location">
                <option value=""><?php _e( 'Location', 'tried' ); ?></option>
                <?php
                    foreach ( $locationPriorities as $jlocationPrioritie ) {
                        printf(
                            '<option value="%s" %s>%s</option>',
                            $jlocationPrioritie[1], selected( $getSearchLocation, $jlocationPrioritie[1] ), $jlocationPrioritie[1]
                        );
                    }
                ?>
            </select>
        </div>

        <?php if ( $atts['filter_salary'] ) { ?>
        <div class="search_level">
            <select name="search_level" id="search_level">
                <option value=""><?php _e( 'Level', 'tried' ); ?></option>
                <?php
					if ( $jobLevels ) {
						foreach ( $jobLevels as $level ) {
							printf( 
								'<option value="%s" %s>%s</option>',
								$level->term_id, selected( $getSearchLevel, $level->term_id ), $level->name
							);
						}
					}
				?>
            </select>
        </div>
        <div class="search_function">
            <select name="search_function" id="search_function">
                <option value=""><?php _e( 'Function', 'tried' ); ?></option>
                <?php
					if ( $jobSectors ) {
						foreach ( $jobSectors as $sector ) {
							printf( 
								'<option value="%s" %s>%s</option>',
								$sector->term_id, selected( $getSearchFunction, $sector->term_id ), $sector->name
							);
						}
					}
				?>
            </select>
        </div>
        <?php } ?>
        <div class="search_submit">
            <input type="submit" value="<?php esc_attr_e( 'Search', 'wp-job-manager' ); ?>">
        </div>
    </div>
    <?php if ( $atts['have_suggest'] ) { ?>
    <div class="actionfilter_jobs">
        <ul class="actionbtns_filters">
            <li>
                <a href="javascript:void(0)" data-roleid="category"
                    title="<?php _e( 'Browse jobs by Category', 'tried' ); ?>"><?php _e( 'Browse jobs by Category', 'tried' ); ?></a>
            </li>
            <li>
                <a href="javascript:void(0)" data-roleid="title"
                    title="<?php _e( 'Browse jobs by Title', 'tried' ); ?>"><?php _e( 'Browse jobs by Title', 'tried' ); ?></a>
            </li>
        </ul>
    </div>
    <div class="togglefilter_jobs">
        <div class="togglefilter_jobs-item" data-toggleid="category">
            <div>
                <ul>
                    <?php
						if ( $jobCats ) {
							foreach ( $jobCats as $cat ) {
								printf( 
									'<li><a href="%s" title="%s">%s</a></li>',
									urldecode( home_url( 'job-seekers' ).'/?search_category='.$cat->term_id ), $cat->name, $cat->name
								);
							}
						}
					?>
                </ul>
            </div>
        </div>
        <div class="togglefilter_jobs-item" data-toggleid="title">
            <div>
                <ul>
                    <?php
						if ( $jobTitles ) {
							foreach ( $jobTitles as $title ) {
								printf( 
									'<li><a href="%s" title="%s">%s</a></li>',
									urldecode( home_url( 'job-seekers' ).'/?search_tag='.$title->term_id ), $title->name, $title->name
								);
							}
						}
					?>
                </ul>
            </div>
        </div>
    </div>
    <?php } ?>
</form>
<?php
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}




// Custom User's Resume CV
add_action( 'show_user_profile', 'tried_profile_resume_fields' );
add_action( 'edit_user_profile', 'tried_profile_resume_fields' );
function tried_profile_resume_fields( $user ) {
	$resumeCV = get_the_author_meta( 'resume_cv', $user->ID );
	?>
<h2><?php _e( 'Resume CV', 'tried' ); ?></h2>
<div id="tried_container_resume_cv">
    <table class="form-table">
        <tr>
            <th><label><?php _e( 'List CVs', 'tried' ); ?></label></th>
            <td></td>
        </tr>
    </table>
</div>
<?php
}

add_action( 'personal_options_update', 'tried_save_profile_resume_meta' );
add_action( 'edit_user_profile_update', 'tried_save_profile_resume_meta' );
function tried_save_profile_resume_meta( $user_id ) {
    // update_user_meta( $user_id, 'resume_cv', '' );
}

// update info
function process_update_resume_info_form( $user_id, $args ) {
	$message = array(
		'notify' => 'warning',
		'content' => __( 'Sorry, the current session has an error.', 'tried' ),
        'parameters' => $args
	);
	if ( is_user_logged_in() ) {

        $resumeCV = !empty( get_the_author_meta( 'resume_cv', $user_id ) ) ? get_the_author_meta( 'resume_cv', $user_id ) : array();
        if ( count( $resumeCV ) < 3 ) {
            update_user_meta( $user_id, 'resume_ethnicity', $args['resume_ethnicity'] );
            update_user_meta( $user_id, 'resume_veteran', $args['resume_veteran'] );
            update_user_meta( $user_id, 'resume_disabilitie', $args['resume_disabilitie'] );

            if ( isset( $args['resume_uploadfile'] ) ) {
                $attachment = isset( $_FILES['resume_cv'] ) ? $_FILES['resume_cv'] : '';
                if ( $attachment ) {
                    if ( ! function_exists( 'wp_handle_upload' ) ) include ABSPATH . 'wp-admin/includes/file.php';
                    if ( ! function_exists( 'wp_crop_image' ) ) include ABSPATH . 'wp-admin/includes/image.php';
    
                    $mimes              = array();
                    $allowed_mime_types = get_allowed_mime_types();
                    $alowed_types       = array( 'pdf', 'doc', 'docx');
                    foreach ( $alowed_types as $allowed_type ) {
                        if ( isset( $allowed_mime_types[ $allowed_type ] ) ) {
                            $mimes[ $allowed_type ] = $allowed_mime_types[ $allowed_type ];
                        }
                    }
                    $movefile = wp_handle_upload( $attachment, array(
                        'test_form' => false,
                        'mimes' => $mimes
                    ) );
                    if ( $movefile && ! isset( $movefile['error'] ) ) {
                        $image_url = $attachment;
                        $upload_dir = wp_upload_dir();
                        $image_data = file_get_contents( $image_url );
                        $filename = basename( $upload_dir );
    
                        if ( wp_mkdir_p( $upload_dir['path'] ) ) {
                            $file = $upload_dir['path'] . '/' . $filename;
                        } else {
                            $file = $upload_dir['basedir'] . '/' . $filename;
                        }
    
                        file_put_contents( $file, $image_data );
                        $wp_filetype = wp_check_filetype( $filename, null );
    
                        $attachment = array(
                            'post_mime_type' => $wp_filetype['type'],
                            'post_title' => sanitize_file_name( $filename ),
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );
    
                        $attach_id = wp_insert_attachment( $attachment, $movefile['file'] );
                        if ( !is_wp_error( $attach_id ) ) {
                            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                            wp_update_attachment_metadata( $attach_id, $attach_data );
                            array_push( $resumeCV, $attach_id );
                            update_user_meta( $user_id, 'resume_cv', $resumeCV );
                        }
                    }
                }
            }
            $message['notify'] = 'success';
            $message['content'] = __( 'Your resume is updated!', 'tried' );
        } else {
            $message['content'] = __( 'The CV archive list is full.', 'tried' );
        }
	}
	return $message;
}


add_action( 'wp_ajax_tried_profile_update_cv', 'ajx_tried_profile_update_cv' );
add_action( 'wp_ajax_nopriv_tried_profile_update_cv', 'ajx_tried_profile_update_cv' );
function ajx_tried_profile_update_cv() {
	$message = array(
		'code' => 400,
		'content' => 'Sorry, the current session has an error.',
        'result' => ''
	);
	if ( !is_user_logged_in() ) {
        $message['code'] = 403;
        $message['content'] = __( '<strong>Thất bại:</strong> bạn cần đăng nhập.', 'tried' );
    } else {
        if ( isset( $_GET['cv_id'] ) && !empty( $_GET['cv_id'] ) && is_numeric( $_GET['cv_id'] ) ) {
            $resumeCV = get_the_author_meta( 'resume_cv', get_current_user_id() ) ?? array();

            if ( $resumeCV && ( $index = array_search( $_GET['cv_id'], $resumeCV ) ) !== false ) {
                unset( $resumeCV[$index] );
            }
            update_user_meta( get_current_user_id(), 'resume_cv', $resumeCV );
            $message['code'] = 200;
            $message['content'] = __( "<strong>Success:</strong> Save Jobs's updated!", 'tried' );
            $message['result'] = array_values( $resumeCV ) ?? $resumeCV;
        } else {
            $message['content'] = __( '<strong>Fail:</strong> Some error appeared.', 'tried' );
        }
    }
    wp_send_json( $message );
}



// Get all term's in a given taxonomy
add_filter( 'tried_all_taxonomy', 'ft_tried_all_taxonomy' );
function ft_tried_all_taxonomy( $taxonomy ) {
    global $wpdb;
    $query = $wpdb->prepare(
        "SELECT * from $wpdb->terms AS t
        INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
        WHERE tt.taxonomy IN('%s') ORDER BY t.name ASC",
        $taxonomy
    );
    $results = $wpdb->get_results( $query );
    return $results;
}

// Get all posttype of a taxonomy
add_filter( 'tried_all_posttype_of_taxonomy', 'ft_tried_all_posttype_of_taxonomy', 10, 3 );
function ft_tried_all_posttype_of_taxonomy( $term_id, $taxonomy, $posttype ) {
    global $wpdb;
    $query = $wpdb->prepare(
        "SELECT p.ID, p.post_name, t.term_id, t.name as clientName 
		FROM wp_posts AS p
		INNER JOIN wp_term_relationships AS tr ON ( p.ID = tr.object_id)
		INNER JOIN wp_term_taxonomy AS tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
		INNER JOIN wp_terms AS t ON (t.term_id = tt.term_id)
		WHERE   p.post_status = 'publish' 
			AND p.post_type = '%s'
			AND tt.taxonomy = '%s'
			AND t.term_id = %s
		ORDER BY p.post_date DESC",
		$posttype,
        $taxonomy,
		$term_id
    );
    $results = $wpdb->get_results( $query );
    return $results;
}



// taxonomy
add_action( 'jobpost_location_add_form_fields', 'tried_add_jobpost_location_fields', 10, 2 );
function tried_add_jobpost_location_fields( $taxonomy ) {
	// $image = get_theme_file_uri( "/assets/img/placeholder.png" );
	if (false) {
	?>
<div class="form-field term-image tried-media-wrapper">
    <label for="san-pham_cat_image"><?php _e( 'Hình ảnh', '' ); ?></label>
    <input type="hidden" name="san-pham_cat_image" id="san-pham_cat_image" class="tried-media-input"
        value="<?php echo $image; ?>" />
    <img class="tried-media-result" src="<?php echo $image; ?>" alt="" width="100" height="100">
    <p><a href="javascript:void(0)" class="tried-media-button button button-secondary"><?php _e('Upload Image'); ?></a>
    </p>
</div>
<?php
	}
	?>
<div class="form-field term-order">
    <label for="joblocation_order"><?php _e( 'Order', 'tried' ); ?></label>
    <input type="number" name="joblocation_order" id="joblocation_order" value=""
        placeholder="<?php _e( 'Enter order', 'tried' ); ?>" />
</div>
<div class="form-field term-isregion">
    <label for="joblocation_isregion"><?php _e( 'Region', 'tried' ); ?></label>
    <input type="checkbox" name="joblocation_isregion" id="joblocation_isregion" value="isregion" />
    <?php _e( 'This is region?', 'tried' ); ?>
</div>
<?php
}

add_action( 'created_jobpost_location','tried_created_jobpost_location_fields', 10, 2 );
function tried_created_jobpost_location_fields( $term_id, $tt_id ) {
	// add_term_meta( $term_id, 'san-pham_cat_image', $_POST['san-pham_cat_image'], true );
	add_term_meta( $term_id, 'joblocation_order', $_POST['joblocation_order'], true );
	add_term_meta( $term_id, 'joblocation_isregion', $_POST['joblocation_isregion'], true );
}

add_action( 'jobpost_location_edit_form_fields','tried_jobpost_location_edit_form_fields', 10, 2 );
function tried_jobpost_location_edit_form_fields( $term, $taxonomy ) {
	// $image = get_theme_file_uri( "/assets/img/placeholder.png" );
	// if (!empty(get_term_meta( $term->term_id, 'san-pham_cat_image', true ))) {
	// 	$image = get_term_meta( $term->term_id, 'san-pham_cat_image', true );
	// }
	$order = get_term_meta( $term->term_id, 'joblocation_order', true );
	$isregion = get_term_meta( $term->term_id, 'joblocation_isregion', true );
	if (false) {
	?>
<tr class="form-field term-image tried-media-wrapper">
    <th scope="row">
        <label for="san-pham_cat_image"><?php _e( 'Order', 'tried' ); ?></label>
    </th>
    <td>
        <input type="hidden" name="san-pham_cat_image" id="san-pham_cat_image" class="tried-media-input"
            value="<?php echo $image; ?>" />
        <img class="tried-media-result" src="<?php echo $image; ?>" alt="" width="100" height="100">
        <p><a href="javascript:void(0)"
                class="tried-media-button button button-secondary"><?php _e('Upload Image'); ?></a></p>
    </td>
</tr>
<?php } ?>
<tr class="form-field term-order">
    <th scope="row">
        <label for="joblocation_order"><?php _e( 'Order', 'tried' ); ?></label>
    </th>
    <td>
        <input type="number" name="joblocation_order" id="joblocation_order" value="<?php echo $order; ?>" />
    </td>
</tr>
<tr class="form-field term-isregion">
    <th scope="row">
        <label for="joblocation_isregion"><?php _e( 'Region', 'tried' ); ?></label>
    </th>
    <td>
        <input type="checkbox" name="joblocation_isregion" id="joblocation_isregion" value="isregion"
            <?php echo checked( $isregion, 'isregion' ); ?> /> <?php _e( 'This is region?', 'tried' ); ?>
    </td>
</tr>
<?php
}

add_action( 'edited_jobpost_location','tried_edited_jobpost_location', 10, 2 );
function tried_edited_jobpost_location( $term_id, $tt_id ) {
	// $image = '';
	// if( isset( $_POST['san-pham_cat_image'] ) && '' !== $_POST['san-pham_cat_image'] ){
	// 	$image = $_POST['san-pham_cat_image'];
	// }
	// update_term_meta( $term_id, 'san-pham_cat_image', $image );
	update_term_meta( $term_id, 'joblocation_order', $_POST['joblocation_order'] );
	update_term_meta( $term_id, 'joblocation_isregion', $_POST['joblocation_isregion'] );
}




add_action( 'jobpost_job_type_add_form_fields', 'tried_add_jobpost_job_type_fields', 10, 2 );
function tried_add_jobpost_job_type_fields( $taxonomy ) {
    $listOptionFunctions = array(
        'pharma' => __( 'Pharma', 'tried' ),
        'healthcare-services' => __( 'Healthcare Services', 'tried' )
    );
	?>
<div class="form-field term-functiontype">
    <label for="joblocation_functiontype"><?php _e( 'Function type', 'tried' ); ?></label>
    <select name="joblocation_functiontype" id="joblocation_functiontype">
        <?php
            foreach ( $listOptionFunctions as $koption => $option) {
                printf( '<option value="%s">%s</option>', $koption, $option );
            }
        ?>
    </select>
</div>
<?php
}

add_action( 'created_jobpost_job_type','tried_created_jobpost_job_type_fields', 10, 2 );
function tried_created_jobpost_job_type_fields( $term_id, $tt_id ) {
	add_term_meta( $term_id, 'joblocation_functiontype', $_POST['joblocation_functiontype'], true );
}

add_action( 'jobpost_job_type_edit_form_fields','tried_jobpost_job_type_edit_form_fields', 10, 2 );
function tried_jobpost_job_type_edit_form_fields( $term, $taxonomy ) {
    $listOptionFunctions = array(
        'pharma' => __( 'Pharma', 'tried' ),
        'healthcare-services' => __( 'Healthcare Services', 'tried' )
    );
	$functiontype = get_term_meta( $term->term_id, 'joblocation_functiontype', true );
	?>
<tr class="form-field term-isregion">
    <th scope="row">
        <label for="joblocation_isregion"><?php _e( 'Function type', 'tried' ); ?></label>
    </th>
    <td>
        <select name="joblocation_functiontype" id="joblocation_functiontype">
            <?php
                foreach ( $listOptionFunctions as $koption => $option) {
                    printf( '<option value="%s" %s>%s</option>', $koption, selected( $functiontype, $koption ), $option );
                }
            ?>
        </select>
    </td>
</tr>
<?php
}

add_action( 'edited_jobpost_job_type','tried_edited_jobpost_job_type', 10, 2 );
function tried_edited_jobpost_job_type( $term_id, $tt_id ) {
	update_term_meta( $term_id, 'joblocation_functiontype', $_POST['joblocation_functiontype'] );
}