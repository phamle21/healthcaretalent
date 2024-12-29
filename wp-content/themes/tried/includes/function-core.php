<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// -------------------------------------------------------------

if ( ! function_exists( 'tried_the_breadcrumbs' ) ) {
	/**
	 * Breadcrumbs
	 * return void
	 */
	function tried_the_breadcrumbs() {

		global $post;
		global $wp_query;

		$before = '<li class="current">';
		$after  = '</li>';

		if ( ! is_home() && ! is_front_page() || is_paged() || $wp_query->is_posts_page ) {
			echo '<ul id="tried-breadcrumbs" class="breadcrumbs" aria-label="breadcrumbs">';
			echo '<li><a class="home" href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'hd' ) . '</a></li>';

			/**
			 * @todo viết thêm cho trường hợp taxonomy
			 */
			if ( is_category() || is_tax() ) {
				$cat_obj   = $wp_query->get_queried_object();
				$thisCat   = get_category( $cat_obj->term_id );
				$parentCat = false;
				if ( isset( $thisCat->parent ) ) {
					$parentCat = get_category( $thisCat->parent );
				}

				if ( isset( $thisCat->parent ) && 0 != $thisCat->parent ) {
					if ( ! is_wp_error( $cat_code = get_category_parents( $parentCat->term_id, true, '' ) ) ) {
						$cat_code = str_replace( '<a', '<li><a', $cat_code );
						echo $cat_code = str_replace( '</a>', '</a></li>', $cat_code );
					}
				}
				echo $before . single_cat_title( '', false ) . $after;
			} elseif ( is_archive() ) {
				$post_type = get_post_type_object( get_post_type() );
				$title = $post_type->labels->singular_name;
				if (get_post_type() != 'post') {
					global $wp_query;
					if ($wp_query->query['post_type'] == 'dich-vu') {
						$title = 'Dịch vụ';
					}
				}
				echo $before . $title  . $after;
			} elseif ( is_day() ) {
				echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
				echo '<li><a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a></li>';
				echo $before . get_the_time( 'd' ) . $after;
			} elseif ( is_month() ) {
				echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
				echo $before . get_the_time( 'F' ) . $after;
			} elseif ( is_year() ) {
				echo $before . get_the_time( 'Y' ) . $after;
			} elseif ( is_single() && ! is_attachment() ) {
				if ( 'post' != get_post_type() ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;
					if ( ! is_bool( $slug ) ) {
						echo '<li><a href="' . get_base_url() . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></span>';
					}

					echo $before . get_the_title() . $after;
				} else {
					$cat = primary_term( $post );
					if ( ! empty( $cat ) ) {
						if ( ! is_wp_error( $cat_code = get_category_parents( $cat->term_id, true, '' ) ) ) {
							$cat_code = str_replace( '<a', '<li><a', $cat_code );
							echo $cat_code = str_replace( '</a>', '</a></li>', $cat_code );
						}
					}

					echo $before . get_the_title() . $after;
				}
			} elseif ( ( is_page() && ! $post->post_parent ) || ( function_exists( 'bp_current_component' ) && bp_current_component() ) ) {
				echo $before . get_the_title() . $after;
			} elseif ( is_search() ) {
				echo $before;
				printf( __( 'Search Results for: %s', 'hd' ), get_search_query() );
				echo $after;
			} elseif ( ! is_single() && ! is_page() && 'post' != get_post_type() ) {
				$post_type = get_post_type_object( get_post_type() );
				// echo $before . $post_type->labels->singular_name . $after;
			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				echo '<li><a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a></li>';
				echo $before . get_the_title() . $after;
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = [];

				while ( $parent_id ) {
					$page          = get_post( $parent_id );
					$breadcrumbs[] = '<li><a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>';
					$parent_id     = $page->post_parent;
				}

				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) {
					echo $crumb;
				}

				echo $before . get_the_title() . $after;
			} elseif ( is_tag() ) {
				echo $before;
				printf( __( 'Tag Archives: %s', 'hd' ), single_tag_title( '', false ) );
				echo $after;
			} elseif ( is_author() ) {
				global $author;

				$userdata = get_userdata( $author );
				echo $before;
				echo $userdata->display_name;
				echo $after;
			} elseif ( $wp_query->is_posts_page ) {
				$posts_page_title = get_the_title( get_option( 'page_for_posts', true ) );
				echo $before . $posts_page_title . $after;
			} elseif ( is_404() ) {
				echo $before;
				__( 'Not Found', 'hd' );
				echo $after;
			}
			if ( get_query_var( 'paged' ) ) {
				echo '<li class="paged">';
				if ( is_category() || is_tax() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}
				echo __( 'page', 'hd' ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_tax() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ')';
				}
				echo $after;
			}

			echo '</ul>';
		}
		// reset
		wp_reset_query();
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'pagination_links' ) ) {
	/**
	 * @param bool $echo
	 *
	 * @return string|null
	 */
	function pagination_links( $echo = true ) {
		global $wp_query;
		if ( $wp_query->max_num_pages > 1 ) {

			// This needs to be an unlikely integer
			$big = 999999999;

			// For more options and info view the docs for paginate_links()
			// http://codex.wordpress.org/Function_Reference/paginate_links
			$paginate_links = paginate_links(
				apply_filters(
					'wp_pagination_args',
					[
						'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
						'current'   => max( 1, get_query_var( 'paged' ) ),
						'total'     => $wp_query->max_num_pages,
						'end_size'  => 3,
						'mid_size'  => 3,
						'prev_next' => true,
						'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path d="M25.1 247.5l117.8-116c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L64.7 256l102.2 100.4c4.7 4.7 4.7 12.3 0 17l-7.1 7.1c-4.7 4.7-12.3 4.7-17 0L25 264.5c-4.6-4.7-4.6-12.3.1-17z"/></svg>',
						'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path d="M166.9 264.5l-117.8 116c-4.7 4.7-12.3 4.7-17 0l-7.1-7.1c-4.7-4.7-4.7-12.3 0-17L127.3 256 25.1 155.6c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0l117.8 116c4.6 4.7 4.6 12.3-.1 17z"/></svg>',
						'type'      => 'list',
					]
				)
			);

			$paginate_links = str_replace( "<ul class='page-numbers'>", '<ul class="pagination">', $paginate_links );
			$paginate_links = str_replace( '<li><span class="page-numbers dots">&hellip;</span></li>', '<li class="ellipsis"></li>', $paginate_links );
			$paginate_links = str_replace( '<li><span aria-current="page" class="page-numbers current">', '<li class="current"><span aria-current="page" class="show-for-sr">You\'re on page </span>', $paginate_links );
			$paginate_links = str_replace( '</span></li>', '</li>', $paginate_links );
			$paginate_links = preg_replace( '/\s*page-numbers\s*/', '', $paginate_links );
			$paginate_links = preg_replace( '/\s*class=""/', '', $paginate_links );

			// Display the pagination if more than one page is found.
			if ( $paginate_links ) {
				$paginate_links = '<nav aria-label="Pagination">' . $paginate_links . '</nav>';
				if ( $echo ) {
					echo $paginate_links;
				} else {
					return $paginate_links;
				}
			}
		}

		return null;
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'get_base_url' ) ) {
	/**
	 * @param string $uri
	 * @param bool $relative relative path. Default empty
	 *
	 * @return string|string[]|null
	 */
	function get_base_url( string $uri = '', bool $relative = false ) {

		if ( empty( $uri ) ) {
			$uri = '/';
		}

		if ( $uri && is_string( $uri ) ) {
			$uri = '/' . trim( $uri, '/' ) . '/';
		}
		$base_url = esc_url( home_url( '/' ) );
		//$base_url = esc_url( site_url( '/' ) );
		$base_url = rtrim( $base_url, '/' );
		if ( $relative == true ) {
			$base_url = preg_replace( '(https?://)', '//', $base_url );
		}

		$current_lg = get_lang();
		$tmp        = $current_lg;

		// polylang plugin
		if ( function_exists( 'pll_default_language' ) ) {
			$tmp = strtolower( substr( pll_default_language(), 0, 2 ) );
		}
		if ( strcmp( $tmp, $current_lg ) !== 0 ) {
			return $base_url . '/' . $current_lg . $uri;
		}

		return $base_url . $uri;
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'get_lang' ) ) {
	/**
	 * Get lang code
	 * @return string
	 */
	function get_lang() {
		return strtolower( substr( get_locale(), 0, 2 ) );
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'primary_term' ) ) {
	/**
	 * @param null $post
	 * @param string $taxonomy
	 *
	 * @return array|bool|int|mixed|object|WP_Error|WP_Term|null
	 */
	function primary_term( $post = null, $taxonomy = '' ) {
		$post = get_post( $post );
		$ID   = is_numeric( $post ) ? $post : $post->ID;

		if ( empty( $taxonomy ) ) {
			$post_type  = get_post_type( $ID );
			$taxonomies = get_object_taxonomies( $post_type );
			if ( isset( $taxonomies[0] ) ) {
				if ( 'product_type' == $taxonomies[0] && isset( $taxonomies[2] ) ) {
					$taxonomy = $taxonomies[2];
				}
			}
		}

		if ( empty( $taxonomy ) ) {
			$taxonomy = 'category';
		}

		// Rank Math SEO
		// https://vi.wordpress.org/plugins/seo-by-rank-math/
		$primary_term_id = get_post_meta( get_the_ID(), 'rank_math_primary_' . $taxonomy, true );
		if ( $primary_term_id ) {
			$term = get_term( $primary_term_id, $taxonomy );
			if ( $term ) {
				return $term;
			}
		}

		// Default, first category
		$post_terms = get_the_terms( $post, $taxonomy );
		if ( is_array( $post_terms ) ) {
			return $post_terms[0];
		}

		return false;
	}
}

// -------------------------------------------------------------

if ( ! function_exists( 'w_post_term' ) ) {
	/**
	 * @param $post
	 * @param string $taxonomy
	 * @param string $wrapper_open
	 * @param string $wrapper_close
	 *
	 * @return string|null
	 */
	function w_post_term( $post, $taxonomy = '', $wrapper_open = '<div class="cat">', $wrapper_close = '</div>' ) {
		if ( empty( $taxonomy ) ) {
			$taxonomy = 'category';
		}

		$link       = '';
		$post_terms = get_the_terms( $post, $taxonomy );

		if ( $post_terms ) {
			foreach ( $post_terms as $term ) {
				if ( $term ) {
					$link .= '<a href="' . esc_url( get_term_link( $term, $taxonomy ) ) . '" title="' . esc_attr( $term->name ) . '">' . $term->name . '</a>';
				}
			}

			if ( $wrapper_open && $wrapper_close ) {
				$link = $wrapper_open . $link . $wrapper_close;
			}
		}

		return $link;
	}
}

// ------------------------------------------------------

if ( ! function_exists( 'str_contains' ) ) {
	/**
	 * @param string $haystack
	 * @param string $needle
	 *
	 * @return bool
	 */
	function str_contains( string $haystack, string $needle ): bool {
		return '' === $needle || false !== strpos( $haystack, $needle );
	}
}

// ------------------------------------------------------

if ( ! function_exists( 'style_loader_tag' ) ) {
	/**
	 * @param array $arr_styles [ $handle ]
	 * @param string $html
	 * @param string $handle
	 *
	 * @return array|string|string[]|null
	 */
	function style_loader_tag( array $arr_styles, string $html, string $handle ) {
		foreach ( $arr_styles as $style ) {
			if ( str_contains( $handle, $style ) ) {
				return preg_replace( '/media=\'all\'/', 'media=\'print\' onload=\'this.media="all"\'', $html );
			}
		}

		return $html;
	}
}

// -------------------------------------------------------------

// comment off
add_filter( 'wp_insert_post_data', function ( $data ) {
	if ( $data['post_status'] == 'auto-draft' ) {
		$data['comment_status'] = 0;
		$data['ping_status']    = 0;
	}

	return $data;
}, 10, 1 );

// ------------------------------------------------------

if ( ! function_exists( 'script_loader_tag' ) ) {
	/**
	 * @param array $arr_parsed [ $handle: $value ] -- $value[ 'defer', 'delay' ]
	 * @param string $tag
	 * @param string $handle
	 * @param string $src
	 *
	 * @return array|string|string[]|null
	 */
	function script_loader_tag( array $arr_parsed, string $tag, string $handle, string $src ) {
		if ( ! is_admin() ) {
			foreach ( $arr_parsed as $str => $value ) {
				if ( str_contains( $handle, $str ) ) {
					if ( 'defer' === $value ) {
						//$tag = '<script defer type=\'text/javascript\' src=\'' . $src . '\'></script>';
						$tag = preg_replace( '/\s+defer\s+/', ' ', $tag );
						$tag = preg_replace( '/\s+src=/', ' defer src=', $tag );
					} elseif ( 'delay' === $value ) {
						$tag = preg_replace( '/\s+defer\s+/', ' ', $tag );
						$tag = preg_replace( '/\s+src=/', ' defer data-type=\'lazy\' data-src=', $tag );
					}
				}
			}
		}

		return $tag;
	}
}

// -------------------------------------------------------------
add_filter('admin_init', 'register_add_setting_fields');
function register_add_setting_fields() {
    register_setting('general', 'add_phone_button', 'esc_attr');
    add_settings_field('add_phone_button', '<label for="add_phone_button">'.__('Button telephone' , 'add_phone_button' ).'</label>' , 'print_add_phone_setting_field', 'general');
}
function print_add_phone_setting_field() {
	printf(
		'<input type="text" id="add_phone_button" name="add_phone_button" value="%s" placeholder="%s"/>',
		get_option( 'add_phone_button', '' ),
		__( 'Enter telephone', 'tried' )
	);
}
add_action('wp_footer', 'tried_wp_footer');
function tried_wp_footer() {
    $phone = get_option( 'add_phone_button', '' );
}


add_filter( 'admin_init', 'register_add_setting_theme_fields', 11 );
function register_add_setting_theme_fields() {
    register_setting( 'general', 'add_setting_mainmaxwidth', 'esc_attr');
    add_settings_field( 'add_setting_mainmaxwidth', '<label for="add_setting_mainmaxwidth">'.__( 'Max width' , 'add_setting_mainmaxwidth' ).'</label>' , 'print_add_mainmaxwidth_setting_field', 'general' );

    register_setting( 'general', 'add_setting_mainthemecolor', 'esc_attr');
    add_settings_field( 'add_setting_mainthemecolor', '<label for="add_setting_mainthemecolor">'.__( 'Main theme color' , 'add_setting_maincolor' ).'</label>' , 'print_add_mainthemecolor_setting_field', 'general' );

    register_setting( 'general', 'add_setting_primarythemecolor', 'esc_attr');
    add_settings_field( 'add_setting_primarythemecolor', '<label for="add_setting_primarythemecolor">'.__( 'Primary theme color' , 'add_setting_primarythemecolor' ).'</label>' , 'print_add_primarythemecolor_setting_field', 'general' );
	
    register_setting( 'general', 'add_setting_primarybtncolor', 'esc_attr');
    add_settings_field( 'add_setting_primarybtncolor', '<label for="add_setting_primarybtncolor">'.__( 'Primary button color' , 'add_setting_primarybtncolor' ).'</label>' , 'print_add_primarybtncolor_setting_field', 'general' );

    register_setting( 'general', 'add_setting_secondbtncolor', 'esc_attr');
    add_settings_field( 'add_setting_secondbtncolor', '<label for="add_setting_secondbtncolor">'.__( 'Second button color' , 'add_setting_secondbtncolor' ).'</label>' , 'print_add_secondbtncolor_setting_field', 'general' );

    register_setting( 'general', 'add_setting_popuphomepage', 'esc_attr');
    add_settings_field( 'add_setting_popuphomepage', '<label for="add_setting_popuphomepage">'.__( 'Popup homepage' , 'add_setting_popuphomepage' ).'</label>' , 'print_add_popuphomepage_setting_field', 'general' );
    register_setting( 'general', 'add_setting_popuphomepage_link', 'esc_attr');
    add_settings_field( 'add_setting_popuphomepage_link', '<label for="add_setting_poadd_setting_popuphomepage_linkpuphomepage">'.__( 'Popup homepage(link)' , 'add_setting_popuphomepage_link' ).'</label>' , 'print_add_popuphomepage_link_setting_field', 'general' );

    register_setting( 'general', 'add_setting_register_event_form', 'esc_attr');
    add_settings_field( 'add_setting_register_event_form', '<label for="add_setting_add_setting_register_event_form">'.__( 'Register Event Form' , 'add_setting_register_event_form' ).'</label>' , 'print_add_register_event_form_setting_field', 'general' );


	// register_setting('general', 'add_privacy_policy_page_field', 'esc_attr');
    // add_settings_field('add_privacy_policy_page_field', '<label for="add_privacy_policy_page_field">'.__('Trang Privacy Policy' , 'add_privacy_policy_page_field' ).'</label>' , 'print_add_privacy_policy_page_field', 'general');
    // register_setting('general', 'add_term_conditions_page_field', 'esc_attr');
    // add_settings_field('add_term_conditions_page_field', '<label for="add_term_conditions_page_field">'.__('Trang Terms & Conditions' , 'add_term_conditions_page_field' ).'</label>' , 'print_add_term_conditions_page_field', 'general');
}
function print_add_mainmaxwidth_setting_field() {
	printf(
		'<input type="text" id="add_setting_mainmaxwidth" name="add_setting_mainmaxwidth" value="%s" placeholder="%s"/>',
		get_option( 'add_setting_mainmaxwidth', '' ),
		__( 'Enter max width(px)', 'tried' )
	);
}
function print_add_mainthemecolor_setting_field() {
	printf(
		'<input type="text" id="add_setting_mainthemecolor" name="add_setting_mainthemecolor" value="%s" placeholder="%s"/>',
		get_option( 'add_setting_mainthemecolor', '' ),
		__( 'Enter theme color', 'tried' )
	);
}
function print_add_primarythemecolor_setting_field() {
	printf(
		'<input type="text" id="add_setting_primarythemecolor" name="add_setting_primarythemecolor" value="%s" placeholder="%s"/>',
		get_option( 'add_setting_primarythemecolor', '' ),
		__( 'Enter primary theme color', 'tried' )
	);
}
function print_add_primarybtncolor_setting_field() {
	printf(
		'<input type="text" id="add_setting_primarybtncolor" name="add_setting_primarybtncolor" value="%s" placeholder="%s"/>',
		get_option( 'add_setting_primarybtncolor', '' ),
		__( 'Enter primary button color', 'tried' )
	);
}
function print_add_secondbtncolor_setting_field() {
	printf(
		'<input type="text" id="add_setting_secondbtncolor" name="add_setting_secondbtncolor" value="%s" placeholder="%s"/>',
		get_option( 'add_setting_secondbtncolor', '' ),
		__( 'Enter second button color', 'tried' )
	);
}

function print_add_register_event_form_setting_field() {
	$register_event_form = get_option( 'add_setting_register_event_form', '' );
	$cf7 = get_posts(array(
		'post_type'     => 'wpcf7_contact_form',
		'numberposts'   => -1
	));
	if (!empty($cf7)) {
	?>
<select id="add_setting_add_setting_register_event_form" class="widefat" name="add_setting_register_event_form">
    <?php
			foreach ($cf7 as $it_7) {
        		printf(
					'<option value="%s" %s>%s</option>',
        			$it_7->ID,
					selected($it_7->ID, $register_event_form),
					$it_7->post_title
        		);
        	}
        ?>
</select>
<?php
}
}

function print_add_popuphomepage_setting_field() {
	$upload_url = get_option( 'add_setting_popuphomepage', '' );
	?>
<div id="current_img">
    <?php if ( $upload_url ): ?>
    <img class="tried-current-img" src="<?php echo esc_url( $upload_url ); ?>" />
    <div class="edit_options uploaded">
        <a class="remove_img" href="javascript:void(0)"><?php _e( 'Remove', 'tried' ); ?></a>
        <a class="edit_img" href="<?php echo esc_url( $upload_edit_url ); ?>"
            target="_blank"><?php _e( 'Edit', 'tried' ); ?></a>
    </div>
    <?php else : ?>
    <img class="tried-current-img placeholder"
        src="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>" />
    <?php endif; ?>
</div>
<!-- Select an option: Upload to WPMU or External URL -->
<div id="tried_options">
    <label for="upload_option"><input type="radio" id="upload_option" name="img_option" value="upload" class="tog"
            checked> <?php _e( 'Media basic', 'tried' ); ?></label>
</div>
<!-- Hold the value here if this is a WPMU image -->
<div id="tried_upload">
    <input class="hidden" type="hidden" name="add_setting_popuphomepage_placeholder_meta" id="tried_placeholder_meta"
        value="<?php echo get_theme_file_uri( "/assets/img/placeholder.png" ); ?>" />
    <input class="hidden" type="hidden" name="add_setting_popuphomepage" id="tried_upload_meta"
        value="<?php echo esc_url_raw( $upload_url ); ?>" />
    <input class="hidden" type="hidden" name="add_setting_popuphomepage_edit_meta" id="tried_upload_edit_meta"
        value="<?php echo esc_url_raw( $upload_edit_url ); ?>" />
    <input id="uploadimage" type='button' class="tried_wpmu_button button-primary"
        value="<?php _e( 'Upload', 'tried' ); ?>" />
</div>
<!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
<div id="tried_external" style="display: none;">
    <input class="regular-text" type="text" name="tried_meta" id="tried_meta"
        value="<?php echo esc_url_raw( $avatar_url ); ?>" />
</div>
<?php
}
function print_add_popuphomepage_link_setting_field() {
	printf(
		'<input type="text" id="add_setting_popuphomepage_link" name="add_setting_popuphomepage_link" value="%s" placeholder="%s"/>',
		get_option( 'add_setting_popuphomepage_link', '' ),
		__( 'Enter Popup homepage link', 'tried' )
	);
}




// function print_add_privacy_policy_page_field() {
// 	$privacy_policy_page = get_option( 'add_privacy_policy_page_field', '' );
// 	$pages = get_pages();
// 	if (!empty($pages)) {
// 		echo '<select id="add_setting_add_privacy_policy_page_field" class="widefat" name="add_privacy_policy_page_field">';
// 				foreach ($pages as $page) {
// 					printf(
// 						'<option value="%s" %s>%s</option>',
// 						$page->ID,
// 						selected($page->ID, $privacy_policy_page),
// 						$page->post_title
// 					);
// 				}
// 		echo '</select>';
// 	}
// }

// function print_add_term_conditions_page_field() {
// 	$term_conditions_page = get_option( 'add_term_conditions_page_field', '' );
// 	$pages = get_pages();
// 	if (!empty($pages)) {
// 		echo '<select id="add_setting_add_term_conditions_page_field" class="widefat" name="add_term_conditions_page_field">';
// 				foreach ($pages as $page) {
// 					printf(
// 						'<option value="%s" %s>%s</option>',
// 						$page->ID,
// 						selected($page->ID, $term_conditions_page),
// 						$page->post_title
// 					);
// 				}
// 		echo '</select>';
// 	}
// }




add_filter( 'get_the_archive_title', 'ft_get_the_archive_title', 10, 1 ); 
function ft_get_the_archive_title( $title ) { 
	if ( is_category() ) {    
		$title = single_cat_title( '', false );    
	} elseif ( is_tag() ) {    
		$title = single_tag_title( '', false );    
	} elseif ( is_author() ) {    
		$title = '<span class="vcard">' . get_the_author() . '</span>' ;    
	} elseif ( is_tax() ) { //for custom post types
		$title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title( '', false );
	}
    return $title; 
}


// -------------------------------------------------------------
/*
* Search only by title
*/
// add_filter( 'posts_search', 'search_by_title_only', 500, 2 );
// function search_by_title_only($search, &$wp_query) {
// 	global $wpdb;
// 	if(empty($search)) return $search; // skip processing - no search term in query
// 	$q = $wp_query->query_vars;
// 	$n = !empty($q['exact']) ? '' : '%';
// 	$search =
// 	$searchand = '';
// 	foreach ((array)$q['search_terms'] as $term) {
// 		$term = esc_sql($wpdb->esc_like($term));
// 		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
// 		$searchand = ' AND ';
// 	}
// 	if (!empty($search)) {
// 		$search = " AND ({$search}) ";
// 		if (!is_user_logged_in()) $search .= " AND ($wpdb->posts.post_password = '') ";
// 	}
// 	return $search;
// }

add_filter( 'upload_dir', 'tried_change_upload_dir' );
function tried_change_upload_dir( $args ) {
    // Get the current post_id
    $id = ( isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : '' );

    if( $id ) {    
       // Set the new path depends on current post_type
		$newdir = '/' . date( 'Y' ) .'/' . date( 'm' ) . '/' . get_post_type( $id );
		$args['path']    = str_replace( $args['subdir'], '', $args['path'] ); //remove default subdir
		$args['url']     = str_replace( $args['subdir'], '', $args['url'] );      
		$args['subdir']  = $newdir;
		$args['path']   .= $newdir; 
		$args['url']    .= $newdir; 
    }
    return $args;
}