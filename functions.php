<?php

$theme_version = '1.0.0';

	/**
	 * Include Theme Customizer
	 *
	 * @since v1.0
	 */
	$theme_customizer = get_template_directory() . '/inc/customizer.php';
	if ( is_readable( $theme_customizer ) ) {
		require_once $theme_customizer;
	}


	/**
	 * Include Support for wordpress.com-specific functions.
	 * 
	 * @since v1.0
	 */
	$theme_wordpresscom = get_template_directory() . '/inc/wordpresscom.php';
	if ( is_readable( $theme_wordpresscom ) ) {
		require_once $theme_wordpresscom;
	}


	/**
	 * Set the content width based on the theme's design and stylesheet
	 *
	 * @since v1.0
	 */
	if ( ! isset( $content_width ) ) {
		$content_width = 800;
	}


	/**
	 * General Theme Settings
	 *
	 * @since v1.0
	 */
	if ( ! function_exists( 'rosewood_setup' ) ) :
		function rosewood_setup() {

			// Make theme available for translation: Translations can be filed in the /languages/ directory
			load_theme_textdomain( 'my-theme', get_template_directory() . '/languages' );

			// Theme Support
			add_theme_support( 'title-tag' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'html5', array(
				'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
			) );
			
			//Post thumbnails size
			set_post_thumbnail_size(1200, 9999);
			
			// Custom image sizes
			add_image_size( 'rosewood_preview-image', 600, 9999 );

			// Add support for Block Styles.
			add_theme_support( 'wp-block-styles' );
			// Add support for full and wide align images.
			add_theme_support( 'align-wide' );
			// Add support for editor styles.
			add_theme_support( 'editor-styles' );
			// Enqueue editor styles.
			add_editor_style( 'style-editor.css' );

			// Date/Time Format
			$theme_dateformat = get_option( 'date_format' );
			$theme_timeformat = 'H:i';

			// Default Attachment Display Settings
			update_option( 'image_default_align', 'none' );
			update_option( 'image_default_link_type', 'none' );
			update_option( 'image_default_size', 'large' );

			// Custom CSS-Styles of Wordpress Gallery
			add_filter( 'use_default_gallery_style', '__return_false' );

		}
		add_action( 'after_setup_theme', 'rosewood_setup' );
	endif;

	/**
	 * Included files
	 *
	 * @since v1.0
	 */

	// Handle Customizer settings
	require get_template_directory() . '/inc/wp-customize.php';
	
	// Google Hooks GA - FUTURE function
	//require get_template_directory() . '/inc/google.php';


	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 *
	 * @since v2.2
	 */
	if ( ! function_exists( 'wp_body_open' ) ) :
		function wp_body_open() {
			/**
			 * Triggered after the opening <body> tag.
			 *
			 * @since v2.2
			 */
			do_action( 'wp_body_open' );
		}
	endif;


	/**
	 * Add new User fields to Userprofile
	 *
	 * @since v1.0
	 */
	if ( ! function_exists( 'themes_starter_add_user_fields' ) ) :
		function themes_starter_add_user_fields( $fields ) {
			// Add new fields
			$fields['facebook_profile'] = 'Facebook URL';
			$fields['twitter_profile'] = 'Twitter URL';
			$fields['linkedin_profile'] = 'LinkedIn URL';
			$fields['xing_profile'] = 'Xing URL';
			$fields['github_profile'] = 'GitHub URL';

			return $fields;
		}
		add_filter( 'user_contactmethods', 'themes_starter_add_user_fields' ); // get_user_meta( $user->ID, 'facebook_profile', true );
	endif;


	/**
	 * Test if a page is a blog page
	 * if ( is_blog() ) { ... }
	 *
	 * @since v1.0
	 */
	function is_blog() {
		global $post;
		$posttype = get_post_type( $post );
		
		return ( ( is_archive() || is_author() || is_category() || is_home() || is_single() || ( is_tag() && ( 'post' === $posttype ) ) ) ? true : false );
	}


	/**
	 * Get the page number
	 *
	 * @since v1.0
	 */
	function get_page_number() {
		if ( get_query_var( 'paged' ) ) {
			print ' | ' . __( 'Page ' , 'my-theme') . get_query_var( 'paged' );
		}
	}


	/**
	 * Disable comments for Media (Image-Post, Jetpack-Carousel, etc.)
	 *
	 * @since v1.0
	 */
	function themes_starter_filter_media_comment_status( $open, $post_id = null ) {
		$media_post = get_post( $post_id );
		if ( 'attachment' === $media_post->post_type ) {
			return false;
		}
		return $open;
	}
	add_filter( 'comments_open', 'themes_starter_filter_media_comment_status', 10, 2 );

	/**
	 * Add Advanced Custom Fields Option page
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 * Remove comments from code if you want to use it
	 *
	 * @since v1.0
	 */

	// if( function_exists('acf_add_options_page') ) {
	
	// 	acf_add_options_page(array(
	// 		'icon_url'		=> 'dashicons-feedback',
	// 		'page_title' 	=> 'Site Options',
	// 		'menu_title'	=> 'Site Options',
	// 		'menu_slug' 	=> 'site-options',
	// 		'capability'	=> 'edit_posts',
	// 		'redirect'		=> false
	// 	));

	// }

	/**
	 * Style Edit buttons as badges: http://getbootstrap.com/components/#badges
	 *
	 * @since v1.0
	 */
	function themes_starter_custom_edit_post_link( $output ) {
		$output = str_replace( 'class="post-edit-link"', 'class="post-edit-link badge badge-secondary"', $output );
		return $output;
	}
	add_filter( 'edit_post_link', 'themes_starter_custom_edit_post_link' );


	/**
	 * Responsive oEmbed filter: http://getbootstrap.com/components/#responsive-embed
	 *
	 * @since v1.0
	 */
	function themes_starter_oembed_filter( $html ) {
		$return = '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
		return $return;
	}
	add_filter( 'embed_oembed_html', 'themes_starter_oembed_filter', 10, 4 );


	if ( ! function_exists( 'themes_starter_content_nav' ) ) :
		/**
		 * Display a navigation to next/previous pages when applicable
		 *
		 * @since v1.0
		 */
		function themes_starter_content_nav( $nav_id ) {
			global $wp_query;

			if ( $wp_query->max_num_pages > 1 ) : ?>
				<div id="<?php echo $nav_id; ?>" class="d-flex mb-4 justify-content-between">
					<div><?php next_posts_link( '<span aria-hidden="true">&larr;</span> ' . __( 'Older posts', 'my-theme' ) ); ?></div>
					<div><?php previous_posts_link( __( 'Newer posts', 'my-theme' ) . ' <span aria-hidden="true">&rarr;</span>' ); ?></div>
				</div><!-- /.d-flex -->
			<?php
			else :
				echo '<div class="clearfix"></div>';
			endif;
		}

		// Add Class
		function posts_link_attributes() {
			return 'class="btn btn-secondary"';
		}
		add_filter( 'next_posts_link_attributes', 'posts_link_attributes' );
		add_filter( 'previous_posts_link_attributes', 'posts_link_attributes' );

	endif; // content navigation


	/**
	 * Modify Next/Previous Post output
	 *
	 * @since v2.0
	 */
	function post_link_attributes( $output ) {
		$class = 'class="btn btn-outline-secondary"';
		return str_replace( '<a href=', '<a ' . $class . ' href=', $output );
	}
	add_filter( 'next_post_link', 'post_link_attributes' );
	add_filter( 'previous_post_link', 'post_link_attributes' );


	/**
	 * Init Widget areas in Sidebar
	 *
	 * @since v1.0
	 */
	function themes_starter_widgets_init() {
		// Area 1
		register_sidebar( array(
			'name' => 'Primary Widget Area (Sidebar)',
			'id' => 'primary_widget_area',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

		// Area 2
		register_sidebar( array(
			'name' => 'Secondary Widget Area (Header Navigation)',
			'id' => 'secondary_widget_area',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

		// Area 3
		register_sidebar( array(
			'name' => 'Third Widget Area (Footer)',
			'id' => 'third_widget_area',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
	add_action( 'widgets_init', 'themes_starter_widgets_init' );


	if ( ! function_exists( 'themes_starter_article_posted_on' ) ) :
		/**
		 * "Theme posted on" pattern
		 * 
		 * @since v1.0
		 */
		function themes_starter_article_posted_on() {
			global $theme_dateformat, $theme_timeformat;

			printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'my-theme' ),
				esc_url( get_the_permalink() ),
				esc_attr( get_the_date( $theme_dateformat ) . ' - ' . get_the_time( $theme_timeformat ) ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date( $theme_dateformat ) . ' - ' . get_the_time( $theme_timeformat ) ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'my-theme' ), get_the_author() ) ),
				get_the_author()
			);

		}
	endif;


	/**
	 * Template for Password protected post form
	 * 
	 * @since v1.0
	 */
	function themes_starter_password_form() {
		global $post;
		$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );

		$output = '<div class="row">';
			$output .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
			$output .= '<h4 class="col-md-12 alert alert-warning">' . __( 'This content is password protected. To view it please enter your password below.', 'my-theme' ) . '</h4>';
				$output .= '<div class="col-md-6">';
					$output .= '<div class="input-group">';
						$output .= '<input type="password" name="post_password" id="' . $label . '" placeholder="' . __( 'Password', 'my-theme' ) . '" class="form-control" />';
						$output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr( __( 'Submit', 'my-theme' ) ) . '" /></div>';
					$output .= '</div><!-- /.input-group -->';
				$output .= '</div><!-- /.col -->';
			$output .= '</form>';
		$output .= '</div><!-- /.row -->';
		return $output;
	}
	add_filter( 'the_password_form', 'themes_starter_password_form' );


	if ( ! function_exists( 'themes_starter_comment' ) ) :
		/**
		 * Style Reply link
		 *
		 * @since v1.0
		 */
		function themes_starter_replace_reply_link_class( $class ) {
			$output = str_replace( "class='comment-reply-link", "class='comment-reply-link btn btn-outline-secondary", $class );
			return $output;
		}
		add_filter( 'comment_reply_link', 'themes_starter_replace_reply_link_class' );

		/**
		 * Template for comments and pingbacks:
		 * add function to comments.php ... wp_list_comments( array( 'callback' => 'themes_starter_comment' ) );
		 *
		 * @since v1.0
		 */
		function themes_starter_comment( $comment, $args, $depth ) {
			global $theme_dateformat, $theme_timeformat;

			$GLOBALS['comment'] = $comment;
			switch ( $comment->comment_type ) :
				case 'pingback' :
				case 'trackback' :
			?>
			<li class="post pingback">
				<p><?php _e( 'Pingback:', 'my-theme' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'my-theme' ), '<span class="edit-link">', '</span>' ); ?></p>
			<?php
					break;
				default :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment">
					<footer class="comment-meta">
						<div class="comment-author vcard">
							<?php
								$avatar_size = 136;
								if ( '0' !== $comment->comment_parent ) {
									$avatar_size = 68;
								}
								echo get_avatar( $comment, $avatar_size );

								/* translators: 1: comment author, 2: date and time */
								printf( __( '%1$s, %2$s', 'my-theme' ),
									sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
									sprintf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
										esc_url( get_comment_link( $comment->comment_ID ) ),
										get_comment_time( 'c' ),
										/* translators: 1: date, 2: time */
										//sprintf( __( '%1$s - %2$s', 'my-theme' ), get_comment_time( $theme_dateformat ), get_comment_time( $theme_timeformat ) )
										sprintf( __( '%1$s ago', 'my-theme' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) )
									)
								);
							?>

							<?php edit_comment_link( __( 'Edit', 'my-theme' ), '<span class="edit-link">', '</span>' ); ?>
						</div><!-- .comment-author .vcard -->

						<?php if ( '0' === $comment->comment_approved ) : ?>
							<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'my-theme' ); ?></em>
							<br />
						<?php endif; ?>

					</footer>

					<div class="comment-content"><?php comment_text(); ?></div>

					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'my-theme' ) . ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- .reply -->
				</article><!-- #comment-## -->

			<?php
					break;
			endswitch;

		}

		/**
		 * Custom Comment form
		 *
		 * @since v1.0
		 * @since v1.1: Added 'submit_button' and 'submit_field'
		 * @since v2.0.2: Added '$consent' and 'cookies'
		 */
		function themes_starter_custom_commentform( $args = array(), $post_id = null ) {
			if ( null === $post_id ) {
				$post_id = get_the_ID();
			}

			$commenter = wp_get_current_commenter();
			$user = wp_get_current_user();
			$user_identity = $user->exists() ? $user->display_name : '';

			$args = wp_parse_args( $args );

			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true' required" : '' );
			$consent  = ( empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"' );
			$fields = array(
				'author'  => '<div class="form-group"><label for="author">' . __( 'Name', 'my-theme' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>' . 
							'<input type="text" id="author" name="author" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' /></div>',
				'email'   => '<div class="form-group"><label for="email">' . __( 'Email', 'my-theme' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>' . 
							'<input type="email" id="email" name="email" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) . '"' . $aria_req . ' /></div>',
				'url'     => '',
				'cookies' => '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> ' .
							 '<label for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment.', 'my-theme' ) . '</label></p>',
			);

			$fields = apply_filters( 'comment_form_default_fields', $fields );
			$defaults = array(
				'fields'               => $fields,
				'comment_field'        => '<div class="form-group"><textarea id="comment" name="comment" class="form-control" aria-required="true" required placeholder="' . __( 'Comment', 'my-theme' ) . ( $req ? '*' : '' ) . '"></textarea></div>',
				/** This filter is documented in wp-includes/link-template.php */
				'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'my-theme' ), wp_login_url( apply_filters( 'the_permalink', get_the_permalink( get_the_ID() ) ) ) ) . '</p>',
				/** This filter is documented in wp-includes/link-template.php */
				'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'my-theme' ), get_edit_user_link(), $user->display_name, wp_logout_url( apply_filters( 'the_permalink', get_the_permalink( get_the_ID() ) ) ) ) . '</p>',
				'comment_notes_before' => '',
				'comment_notes_after'  => '<p class="small comment-notes">' . __( 'Your Email address will not be published.', 'my-theme' ) . '</p>',
				'id_form'              => 'commentform',
				'id_submit'            => 'submit',
				'class_submit'         => 'btn btn-primary',
				'name_submit'          => 'submit',
				'title_reply'          => '',
				'title_reply_to'       => __( 'Leave a Reply to %s', 'my-theme' ),
				'cancel_reply_link'    => __( 'Cancel reply', 'my-theme' ),
				'label_submit'         => __( 'Post Comment', 'my-theme' ),
				'submit_button'        => '<input type="submit" id="%2$s" name="%1$s" class="%3$s" value="%4$s" />',
				'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
				'format'               => 'html5',
			);

			return $defaults;

		}
		add_filter( 'comment_form_defaults', 'themes_starter_custom_commentform' );

	endif;


	/**
	 * Nav menus
	 *
	 * @since v1.0
	 */
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus( array(
			'main-menu' => 'Main Navigation Menu',
			'social-menu' => 'Social Links'
		) );
	}

	// Custom Nav Walker: wp_bootstrap4_navwalker()
	$custom_walker = get_template_directory() . '/inc/wp_bootstrap_navwalker.php';
	if ( is_readable( $custom_walker ) ) {
		require_once $custom_walker;
	}

	$custom_walker_footer = get_template_directory() . '/inc/wp_bootstrap_navwalker_footer.php';
	if ( is_readable( $custom_walker_footer ) ) {
		require_once $custom_walker_footer;
	}


	/**
	 * Loading All CSS Stylesheets and Javascript Files
	 *
	 * @since v1.0
	 */
	function themes_starter_scripts_loader() {
		global $theme_version;

		// 1. Styles
		wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', false, $theme_version, 'all' );
		// wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.min.css', false, $theme_version, 'all' );
		wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/build/app.min.css', false, $theme_version, 'all' ); // main.scss: Compiled Framework source + custom styles
		
		if ( is_rtl() ) {
			wp_enqueue_style( 'rtl', get_template_directory_uri() . '/assets/css/rtl.min.css', false, $theme_version, 'all' );
		}

		// 2. Scripts
		wp_enqueue_script( 'jquery',  'https://code.jquery.com/jquery-3.6.0.min.js', false, $theme_version, true );
		wp_enqueue_script('masonry');
		wp_enqueue_script( 'mainjs', get_template_directory_uri() . '/assets/build/app.min.js', false, $theme_version, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'themes_starter_scripts_loader' );


	/**
	 * Filter post class
	 *
	 * @since v1.0
	 */

	if ( ! function_exists( 'rosewood_post_classes' ) ) {
		function rosewood_post_classes( $classes ) {
	
			// Class indicating presence/lack of post thumbnail
			$classes[] = ( has_post_thumbnail() ? 'has-thumbnail' : 'missing-thumbnail' );
	
			// Class indicating lack of title
			if ( ! get_the_title() ) $classes[] = 'no-title';
	
			return $classes;
		}
	}
	add_action( 'post_class', 'rosewood_post_classes' );

	/**
	 * Filter body class
	 *
	 * @since v1.0
	 */
	if ( ! function_exists( 'rosewood_body_classes' ) ) {
		function rosewood_body_classes( $classes ) {
	
			// Check whether we're in the customizer preview
			if ( is_customize_preview() ) {
				$classes[] = 'customizer-preview';
			}
	
			// Hide social buttons
			if ( get_theme_mod( 'rosewood_hide_social' ) ) {
				$classes[] = 'hide-social';
			}
	
			// White bg class
			if ( get_theme_mod( 'rosewood_accent_color' ) == '#ffffff' && ( ! get_background_color() || get_background_color() == 'ffffff' ) ) {
				$classes[] = 'white-bg';
			}
	
			// Check whether the custom backgrounds are both set to the same thing
			if ( get_theme_mod( 'rosewood_accent_color' ) && get_background_color() && ltrim( get_theme_mod( 'rosewood_accent_color' ), '#' ) == get_background_color() ) {
				$classes[] = 'same-custom-bgs';
			}
	
			// Dark sidebar text
			if ( get_theme_mod( 'rosewood_dark_sidebar_text' ) ) {
				$classes[] = 'dark';
			}
	
			// Add short class for resume page template
			if ( is_page_template( 'resume-page-template.php' ) ) {
				$classes[] = 'resume-template';
			}
	
			// Add short class for full width page template
			if ( is_page_template( 'full-width-page-template.php' ) ) {
				$classes[] = 'full-width-template';
			}
	
			return $classes;
		}
	} // End if().
	add_action( 'body_class', 'rosewood_body_classes' );

	/**
	 * Filter no-js class
	 *
	 * @since v1.0
	 */

	if ( ! function_exists( 'rosewood_has_js' ) ) {
		function rosewood_has_js() {
			?>
			<script>jQuery( 'html' ).removeClass( 'no-js' ).addClass( 'js' );</script>
			<?php
		}
	}
	add_action( 'wp_head', 'rosewood_has_js' );

	/**
	 * Ajax search results
	 *
	 * @since v1.0
	 */

	if ( ! function_exists( 'rosewood_ajax_results' ) ) {
		function rosewood_ajax_results() {
	
			$string = json_decode( stripslashes( $_POST['query_data'] ), true );
	
			if ( $string ) :
	
				$args = array(
					's'					=> $string,
					'posts_per_page'	=> 5,
					'post_status'		=> 'publish',
				);
	
				$ajax_query = new WP_Query( $args );
	
				if ( $ajax_query->have_posts() ) {
	
					?>
	
					<p class="results-title"><?php _e( 'Search Results', 'rosewood' ); ?></p>
	
					<ul>
	
						<?php
	
						// Custom loop
						while ( $ajax_query->have_posts() ) :
	
							$ajax_query->the_post();
	
							// Load the appropriate content template
							get_template_part( 'content-mobile-search' );
	
						// End the loop
						endwhile;
	
						?>
	
					</ul>
	
					<?php if ( $ajax_query->max_num_pages > 1 ) : ?>
	
						<a class="show-all" href="<?php echo esc_url( home_url( '?s=' . $string ) ); ?>"><?php _e( 'Show all', 'rosewood' ); ?></a>
	
					<?php endif; ?>
	
					<?php
	
				} else {
	
					echo '<p class="no-results-message">' . __( 'We could not find anything that matches your search query. Please try again.', 'rosewood' ) . '</p>';
	
				} // End if().
	
			endif; // End if().
	
			die();
		}
	} // End if().
	add_action( 'wp_ajax_nopriv_ajax_pagination', 'rosewood_ajax_results' );
	add_action( 'wp_ajax_ajax_pagination', 'rosewood_ajax_results' );
	
	/**
	 * Get and output archive type
	 *
	 * @since v1.0
	 */

	
if ( ! function_exists( 'rosewood_get_archive_type' ) ) {
	function rosewood_get_archive_type() {
		if ( is_category() ) {
			$type = __( 'Category', 'rosewood' );
		} elseif ( is_tag() ) {
			$type = __( 'Tag', 'rosewood' );
		} elseif ( is_author() ) {
			$type = __( 'Author', 'rosewood' );
		} elseif ( is_year() ) {
			$type = __( 'Year', 'rosewood' );
		} elseif ( is_month() ) {
			$type = __( 'Month', 'rosewood' );
		} elseif ( is_day() ) {
			$type = __( 'Date', 'rosewood' );
		} elseif ( is_post_type_archive() ) {
			$type = __( 'Post Type', 'rosewood' );
		} elseif ( is_tax() ) {
			$term = get_queried_object();
			$taxonomy = $term->taxonomy;
			$taxonomy_labels = get_taxonomy_labels( get_taxonomy( $taxonomy ) );
			$type = $taxonomy_labels->name;
		} else if ( is_search() ) {
			$type = __( 'Search Results', 'rosewood' );
		} else if ( is_home() && get_theme_mod( 'rosewood_home_title' ) ) {
			$type = __( 'Introduction', 'rosewood' );
		} else {
			$type = __( 'Archives', 'rosewood' );
		}

		return $type;
	}
}


if ( ! function_exists( 'rosewood_the_archive_type' ) ) {
	function rosewood_the_archive_type() {
		$type = rosewood_get_archive_type();

		echo $type;
	}
}

	/**
	 * Filter archive title
	 *
	 * @since v1.0
	 */

	if ( ! function_exists( 'rosewood_remove_archive_title_prefix' ) ) :
	function rosewood_remove_archive_title_prefix( $title ) {

		// A duplicate of the core archive title conditional, but without the prefix.
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '#', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_year() ) {
			$title = get_the_date( 'Y' );
		} elseif ( is_month() ) {
			$title = get_the_date( 'F Y' );
		} elseif ( is_day() ) {
			$title = get_the_date( get_option( 'date_format' ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Aside', 'post format archive title', 'rosewood' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title', 'rosewood' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title', 'rosewood' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title', 'rosewood' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title', 'rosewood' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title', 'rosewood' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title', 'rosewood' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title', 'rosewood' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title', 'rosewood' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		} elseif ( is_home() ) {
			if ( get_theme_mod( 'rosewood_home_title' ) ) {
				$title = get_theme_mod( 'rosewood_home_title' );
			} elseif ( get_option( 'page_for_posts' ) ) {
				$title = get_the_title( get_option( 'page_for_posts' ) );
			} else {
				$title = '';
			}
		} elseif ( is_search() ) {
			$title = '&ldquo;' . get_search_query() . '&rdquo;';
		} else {
			$title = __( 'Archives', 'rosewood' );
		}

		return $title;

	}
	add_filter( 'get_the_archive_title', 'rosewood_remove_archive_title_prefix' );
endif;


/**
	 * Filter archive description
	 *
	 * @since v1.0
	 */

if ( ! function_exists( 'rosewood_filter_archive_description' ) ) :
	function rosewood_filter_archive_description( $description ) {
		
		// On search, show a string describing the results of the search.
		if ( is_search() ) {
			global $wp_query;
			if ( $wp_query->found_posts ) {
				/* Translators: %s = Number of results */
				$description = sprintf( _x( 'We found %s matching your search query.', 'Translators: %s = the number of search results', 'rosewood' ), $wp_query->found_posts . ' ' . ( 1 == $wp_query->found_posts ? __( 'result', 'rosewood' ) : __( 'results', 'rosewood' ) ) );
			} else {
				/* Translators: %s = the search query */
				$description = sprintf( _x( 'We could not find any results for the search query "%s". You can try again through the form below.', 'Translators: %s = the search query', 'rosewood' ), get_search_query() );
			}
		}

		return $description;

	}
	add_filter( 'get_the_archive_description', 'rosewood_filter_archive_description' );
endif;


/**
	 * Pre get posts
	 *
	 * @since v1.0
	 */

if ( ! function_exists( 'rosewood_sort_search_posts_by_date' ) ) {
	function rosewood_sort_search_posts_by_date( $query ) {

		// In search, order results by date
		if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
			$query->set( 'orderby', 'date' );
		}

	}
}
add_action( 'pre_get_posts', 'rosewood_sort_search_posts_by_date' );


/**
	 * Comment output
	 *
	 * @since v1.0
	 */

if ( ! function_exists( 'rosewood_comment' ) ) :
	function rosewood_comment( $comment, $args, $depth ) {

		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				global $post;
				?>

				<div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<?php _e( 'Pingback:', 'rosewood' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'rosewood' ) ); ?>

				<?php

				break;

			default :
				global $post;
				?>
				<div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

					<div id="comment-<?php comment_ID(); ?>">

						<header class="comment-meta">

							<span class="comment-author">
								<cite>
									<?php echo get_comment_author_link(); ?>
								</cite>

								<?php
								if ( $comment->user_id === $post->post_author ) {
									echo '<span class="comment-by-post-author"> (' . __( 'Author', 'rosewood' ) . ')</span>';
								}
								?>
							</span>

							<span class="comment-date">
								<a class="comment-date-link" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>" title="<?php echo get_comment_date() . ' ' . __( 'at', 'rosewood' ) . ' ' . get_comment_time(); ?>"><?php echo get_comment_date( get_option( 'date_format' ) ); ?></a>
							</span>

							<?php
							comment_reply_link( array(
								'after'			=> '</span>',
								'before'		=> '<span class="comment-reply">',
								'depth'			=> $depth,
								'max_depth' 	=> $args['max_depth'],
								'reply_text' 	=> __( 'Reply', 'rosewood' ),
							) );
							?>

						</header>

						<div class="comment-content entry-content">

							<?php comment_text(); ?>

						</div><!-- .comment-content -->

						<div class="comment-actions">
							<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'rosewood' ); ?></p>
							<?php endif; ?>
						</div><!-- .comment-actions -->

					</div><!-- .comment -->

			<?php
			break;
		endswitch;

	}
endif; // End if().


/**
	 * Admin notices
	 *
	 * @since v1.0
	 */

if ( ! function_exists( 'rosewood_admin_notices' ) ) :
	function rosewood_admin_notices() {

		// Show notice about posts per page on theme activation, if the setting isn't set already
		if ( isset( $_GET['activated'] ) && true == $_GET['activated'] && 'rosewood' == get_option( 'template' ) && get_option( 'posts_per_page' ) < 999 ) : ?>

			<div class="notice notice-info is-dismissible">
				<?php /* Translators: %1$1s = opening link to the demo site, %2$2s = closing link tag, %3$3s = link to the reading options, %4$4s = closing link tag */ ?>
				<p><?php printf( _x( 'To make rosewood display like the %1$1sdemo site%2$2s, with all posts listed on archive pages, you need to change the "Blog pages show at most" setting in %3$3sSettings > Reading%4$4s to a value exceeding the number of posts on your site.', 'Translators: %1$1s = opening link to the demo site, %2$2s = closing link tag, %3$3s = link to the reading options, %4$4s = closing link tag', 'rosewood' ), '<a href="#">', '</a>', '<a href="' . admin_url( 'options-reading.php' ) . '">', '</a>' ); ?></p>
			</div>

			<?php
		endif;

	}
	add_action( 'rosewood_admin_notices', 'showAdminMessages' );
endif;


/**
	 * Specific block editor support
	 *
	 * @since v1.0
	 */

if ( ! function_exists( 'rosewood_add_block_editor_features' ) ) :
	function rosewood_add_block_editor_features() {

		/* Block Editor Features ------------- */

		add_theme_support( 'align-wide' );

		/* Block Editor Palette -------------- */

		add_theme_support( 'editor-color-palette', array(
			array(
				'name' 	=> _x( 'Black', 'Name of the black color in the Gutenberg palette', 'rosewood' ),
				'slug' 	=> 'black',
				'color' => '#121212',
			),
			array(
				'name' 	=> _x( 'Dark Gray', 'Name of the dark gray color in the Gutenberg palette', 'rosewood' ),
				'slug' 	=> 'dark-gray',
				'color' => '#333',
			),
			array(
				'name' 	=> _x( 'Medium Gray', 'Name of the medium gray color in the Gutenberg palette', 'rosewood' ),
				'slug' 	=> 'medium-gray',
				'color' => '#555',
			),
			array(
				'name' 	=> _x( 'Light Gray', 'Name of the light gray color in the Gutenberg palette', 'rosewood' ),
				'slug' 	=> 'light-gray',
				'color' => '#777',
			),
			array(
				'name' 	=> _x( 'White', 'Name of the white color in the Gutenberg palette', 'rosewood' ),
				'slug' 	=> 'white',
				'color' => '#fff',
			),
		) );

		/* Block Editor Font Sizes ----------- */

		add_theme_support( 'editor-font-sizes', array(
			array(
				'name' 		=> _x( 'Small', 'Name of the small font size in Gutenberg', 'rosewood' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the Gutenberg editor.', 'rosewood' ),
				'size' 		=> 16,
				'slug' 		=> 'small',
			),
			array(
				'name' 		=> _x( 'Normal', 'Name of the regular font size in Gutenberg', 'rosewood' ),
				'shortName' => _x( 'N', 'Short name of the regular font size in the Gutenberg editor.', 'rosewood' ),
				'size' 		=> 18,
				'slug' 		=> 'normal',
			),
			array(
				'name' 		=> _x( 'Large', 'Name of the large font size in Gutenberg', 'rosewood' ),
				'shortName' => _x( 'L', 'Short name of the large font size in the Gutenberg editor.', 'rosewood' ),
				'size' 		=> 24,
				'slug' 		=> 'large',
			),
			array(
				'name' 		=> _x( 'Larger', 'Name of the larger font size in Gutenberg', 'rosewood' ),
				'shortName' => _x( 'XL', 'Short name of the larger font size in the Gutenberg editor.', 'rosewood' ),
				'size' 		=> 28,
				'slug' 		=> 'larger',
			),
		) );

	}
	add_action( 'after_setup_theme', 'rosewood_add_block_editor_features' );
endif;


/**
	 * block editor styles
	 *
	 * @since v1.0
	 */

if ( ! function_exists( 'rosewood_block_editor_styles' ) ) :
	function rosewood_block_editor_styles() {

		$dependencies = array();
		$theme_version = wp_get_theme( 'rosewood' )->get( 'Version' );

		/**
		 * Translators: If there are characters in your language that are not
		 * supported by the theme fonts, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$google_fonts = _x( 'on', 'Google Fonts: on or off', 'rosewood' );

		if ( 'off' !== $google_fonts ) {

			// Register Google Fonts
			wp_register_style( 'rosewood-block-editor-styles-font', '//fonts.googleapis.com/css?family=Archivo:400,400i,600,600i,700,700i&amp;subset=latin-ext', false, 1.0, 'all' );
			$dependencies[] = 'rosewood-block-editor-styles-font';

		}

		// Enqueue the editor styles
		wp_enqueue_style( 'rosewood-block-editor-styles', get_theme_file_uri( '/assets/css/rosewood-block-editor-styles.css' ), $dependencies, $theme_version, 'all' );

	}
	add_action( 'enqueue_block_editor_assets', 'rosewood_block_editor_styles', 1 );
endif;