<?php
/**
 * FIXME: Edit Title Content
 *
 * FIXME: Edit Description Content
 *
 * Please do not edit this file. This file is part of the Cyber Chimps Framework and all modifications
 * should be made in a child theme.
 * FIXME: POINT USERS TO DOWNLOAD OUR STARTER CHILD THEME AND DOCUMENTATION
 *
 * @category Cyber Chimps Framework
 * @package  Framework
 * @since    1.0
 * @author   CyberChimps
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.cyberchimps.com/
 */

// FIXME: Fix documentation
// Enqueue core scripts and core styles
function cyberchimps_core_scripts() {
	global $post;
	$path = get_template_directory_uri() . '/core/lib/js/';
	
	// Load JS for swipe functionality in slider
	wp_enqueue_script( 'event-swipe-move', $path . 'jquery.event.move.js', array('jquery') );
	wp_enqueue_script( 'event-swipe', $path . 'jquery.event.swipe.js', array('jquery') );
	wp_enqueue_script( 'swipe', $path . 'swipe.js', array('jquery') );
	
	// Load Bootstrap Library Items
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/core/lib/bootstrap/css/bootstrap.min.css', false, '2.0.4' );
	wp_enqueue_style( 'bootstrap-responsive-style', get_template_directory_uri() . '/core/lib/bootstrap/css/bootstrap-responsive.min.css', array('bootstrap-style'), '2.0.4' );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/core/lib/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '2.0.4', true );
	
	// Load Core Stylesheet
	wp_enqueue_style( 'core-style', get_template_directory_uri() . '/core/lib/css/core.css', array('bootstrap-responsive-style', 'bootstrap-style'), '1.0' );
	
	// Load Theme Stylesheet
	wp_enqueue_style( 'style', get_stylesheet_uri(), array('core-style', 'bootstrap-responsive-style', 'bootstrap-style'), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'cyberchimps_core_scripts', 20 );

if ( ! function_exists( 'cyberchimps_posted_on' ) ) :
// FIXME: Fix documentation
//Prints HTML with meta information for the current post-date/time and author.
function cyberchimps_posted_on() {
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'cyberchimps' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'cyberchimps' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;


// FIXME: Fix documentation
// Returns true if a blog has more than 1 category
function cyberchimps_categorized_blog() {
	if ( false === ( $cyberchimps_categorized_transient = get_transient( 'cyberchimps_categorized_transient' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$cyberchimps_categorized_transient = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$cyberchimps_categorized_transient = count( $cyberchimps_categorized_transient );

		set_transient( 'cyberchimps_categorized_transient', $cyberchimps_categorized_transient );
	}

	if ( '1' != $cyberchimps_categorized_transient ) {
		// This blog has more than 1 category so cyberchimps_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so cyberchimps_categorized_blog should return false
		return false;
	}
}

// FIXME: Fix documentation
// Flush out the transients used in cyberchimps_categorized_blog
function cyberchimps_category_transient_flusher() {
	// Remove transient
	delete_transient( 'cyberchimps_categorized_transient' );
}
add_action( 'edit_category', 'cyberchimps_category_transient_flusher' );
add_action( 'save_post', 'cyberchimps_category_transient_flusher' );



// FIXME: Fix documentation
function cyberchimps_default_site_title() {
	global $page, $paged;

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'cyberchimps' ), max( $paged, $page ) );
}
add_filter('wp_title', 'cyberchimps_default_site_title');


// FIXME: Fix documentation
function cyberchimps_seo_compatibility_check() {
	if ( cyberchimps_detect_seo_plugins() ) {
		remove_filter( 'wp_title', 'cyberchimps_default_site_title', 10, 3 );
	}
}
add_action( 'after_setup_theme', 'cyberchimps_seo_compatibility_check', 5 );


// FIXME: Fix documentation
// TODO: Give Genesis/StudioPress Credit
// Detect some SEO Plugin that add constants, classes or functions.
function cyberchimps_detect_seo_plugins() {

	return cyberchimps_detect_plugin(
		// Use this filter to adjust plugin tests.
		apply_filters(
			'cyberchimps_detect_seo_plugins',
			/** Add to this array to add new plugin checks. */
			array(

				// Classes to detect.
				'classes' => array(
					'wpSEO',
					'All_in_One_SEO_Pack',
					'HeadSpace_Plugin',
					'Platinum_SEO_Pack',
				),

				// Functions to detect.
				'functions' => array(),

				// Constants to detect.
				'constants' => array( 'WPSEO_VERSION', ),
			)
		)
	);
}

// TODO: Give Genesis/StudioPress Credit
// FIXME: Fix documentation
function cyberchimps_detect_event_plugins() {
	return cyberchimps_detect_plugin(
		// Use this filter to adjust plugin tests.
		apply_filters(
			'cyberchimps_detect_event_plugins',
			/** Add to this array to add new plugin checks. */
			array(

				// Classes to detect.
				'classes' => array( 'TribeEvents' ),

				// Functions to detect.
				'functions' => array(),

				// Constants to detect.
				'constants' => array(),
			)
		)
	);
}


// FIXME: Fix documentation
// TODO: Give Genesis/StudioPress Credit
// Detect plugin by constant, class or function existence.
function cyberchimps_detect_plugin( $plugins ) {

	/** Check for classes */
	if ( isset( $plugins['classes'] ) ) {
		foreach ( $plugins['classes'] as $name ) {
			if ( class_exists( $name ) )
				return true;
		}
	}

	/** Check for functions */
	if ( isset( $plugins['functions'] ) ) {
		foreach ( $plugins['functions'] as $name ) {
			if ( function_exists( $name ) )
				return true;
		}
	}

	/** Check for constants */
	if ( isset( $plugins['constants'] ) ) {
		foreach ( $plugins['constants'] as $name ) {
			if ( defined( $name ) )
				return true;
		}
	}

	/** No class, function or constant found to exist */
	return false;
}