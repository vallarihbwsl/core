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

// Set options function
function cyberchimps_option( $name = false, $subname = false ){
	$options = get_option( 'cyberchimps_options' );
	if( $name ) {
		$value = $options[$name];
		return $value;
	}
}

// FIXME: Fix documentation
// Enqueue core scripts and core styles
function cyberchimps_core_scripts() {
	global $post;
	$path = get_template_directory_uri() . '/cyberchimps/lib/js/';
	
	// Load JS for slimbox
	wp_enqueue_script( 'slimbox', get_template_directory_uri() . '/cyberchimps/lib/js/jquery.slimbox.js', array( 'jquery' ), true );

	// Load library for jcarousel
	wp_enqueue_script( 'jcarousel', get_template_directory_uri() . '/cyberchimps/lib/js/jquery.jcarousel.min.js', array( 'jquery' ), true );

	// Load Custom JS
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/cyberchimps/lib/js/custom.js', array( 'jquery' ), true );
	
	// Load JS for swipe functionality in slider
	wp_enqueue_script( 'event-swipe-move', $path . 'jquery.event.move.js', array('jquery') );
	wp_enqueue_script( 'event-swipe', $path . 'jquery.event.swipe.js', array('jquery') );
	wp_enqueue_script( 'swipe', $path . 'swipe.js', array('jquery') );
	
	// Load Bootstrap Library Items
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/cyberchimps/lib/bootstrap/css/bootstrap.min.css', false, '2.0.4' );
	wp_enqueue_style( 'bootstrap-responsive-style', get_template_directory_uri() . '/cyberchimps/lib/bootstrap/css/bootstrap-responsive.min.css', array('bootstrap-style'), '2.0.4' );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/cyberchimps/lib/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '2.0.4', true );
	
	// Load Core Stylesheet
	wp_enqueue_style( 'core-style', get_template_directory_uri() . '/cyberchimps/lib/css/core.css', array('bootstrap-responsive-style', 'bootstrap-style'), '1.0' );
	
	// Load Theme Stylesheet
	wp_enqueue_style( 'style', get_stylesheet_uri(), array('core-style', 'bootstrap-responsive-style', 'bootstrap-style'), '1.0' );
	
	// Add thumbnail size
	if ( function_exists( 'add_image_size' ) ) { 
        add_image_size( 'featured-thumb', 100, 80, true);
        add_image_size( 'headline-thumb', 200, 225, true);
    } 
	
	// add javascript for comments
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'cyberchimps_core_scripts', 20 );

function cyberchimps_create_layout() {
	global $post;
	
	if ( is_single() ) {
		$layout_type = cyberchimps_get_option( 'single_post_sidebar_options', 'right_sidebar' );
		
	} elseif ( is_home() ) {
		$layout_type = cyberchimps_get_option( 'sidebar_images', 'right_sidebar' );
	
	} elseif ( is_page() ) {
		// TODO: Change so that option is not saved as an array
		$page_sidebar = get_post_meta( $post->ID, 'cyberchimps_page_sidebar' );
		$layout_type = ( isset( $page_sidebar[0] ) ) ? $page_sidebar[0] : 'right_sidebar';
				
	} elseif ( is_archive() ) {
		$layout_type = cyberchimps_get_option( 'archive_sidebar_options', 'right_sidebar' );
			
	} elseif ( is_search() ) {
		$layout_type = cyberchimps_get_option( 'search_sidebar_options', 'right_sidebar' );	
	
	} elseif ( is_404() ) {
		$layout_type = cyberchimps_get_option( 'error_sidebar_options', 'right_sidebar' );
	
	} else {
		$layout_type = apply_filters( 'cyberchimps_default_layout', 'right_sidebar' );
	}
	
	cyberchimps_get_layout($layout_type);
}
add_action('wp', 'cyberchimps_create_layout');

function cyberchimps_get_layout( $layout_type ) {
	
	$layout_type = ( $layout_type ) ? $layout_type : 'right_sidebar';
	
		switch($layout_type) {
			case 'full_width' :
				add_filter( 'cyberchimps_content_class', 'cyberchimps_class_span12');
			break;
			case 'right_sidebar' :
				add_action( 'cyberchimps_after_content_container', 'cyberchimps_add_sidebar_right');
				add_filter( 'cyberchimps_content_class', 'cyberchimps_class_span9');
				add_filter( 'cyberchimps_sidebar_right_class', 'cyberchimps_class_span3');
			break;
			case 'left_sidebar' :
				add_action( 'cyberchimps_before_content_container', 'cyberchimps_add_sidebar_left');
				add_filter( 'cyberchimps_content_class', 'cyberchimps_class_span9');
				add_filter( 'cyberchimps_sidebar_left_class', 'cyberchimps_class_span3');
			break;
			case 'content_middle' :
				add_action( 'cyberchimps_before_content_container', 'cyberchimps_add_sidebar_left');
				add_action( 'cyberchimps_after_content_container', 'cyberchimps_add_sidebar_right');
				add_filter( 'cyberchimps_content_class', 'cyberchimps_class_span6');
				add_filter( 'cyberchimps_sidebar_left_class', 'cyberchimps_class_span3');
				add_filter( 'cyberchimps_sidebar_right_class', 'cyberchimps_class_span3');
			break;
			case 'left_right_sidebar' :
				add_action( 'cyberchimps_after_content_container', 'cyberchimps_add_sidebar_left');
				add_action( 'cyberchimps_after_content_container', 'cyberchimps_add_sidebar_right');
				add_filter( 'cyberchimps_content_class', 'cyberchimps_class_span6');
				add_filter( 'cyberchimps_sidebar_left_class', 'cyberchimps_class_span3');
				add_filter( 'cyberchimps_sidebar_right_class', 'cyberchimps_class_span3');
			break;
		}
}

// FIXME: Fix documentation
class cyberchimps_Walker extends Walker_Nav_Menu {
	
	// FIXME: Fix documentation
    function start_lvl( &$output, $depth ) {
		//In a child UL, add the 'dropdown-menu' class
		if( $depth == 0 ) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
		} else {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul>\n";
		}
	}
	
	// FIXME: Fix documentation
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$li_attributes = '';
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : ( array ) $item->classes;

		//Add class and attribute to LI element that contains a submenu UL.
		if ( $args->has_children && $depth < 1 ){
			$classes[] 		= 'dropdown';
			$li_attributes .= 'data-dropdown="dropdown"';
		}
		$classes[] = 'menu-item-' . $item->ID;
		//If we are on the current page, add the active class to that menu item.
		$classes[] = ($item->current) ? 'active' : '';

		//Make sure you still add all of the WordPress classes.
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';
		//Add attributes to link element.
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ($args->has_children && $depth < 1) ? ' class="dropdown-toggle"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= ($args->has_children && $depth < 1) ? ' <b class="caret"></b> ' : ''; 
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	// FIXME: Fix documentation
	//Overwrite display_element function to add has_children attribute. Not needed in >= Wordpress 3.4
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];
		
		//display this element
		if ( is_array( $args[0] ) ) 
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) ) 
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
}

// FIXME: Fix documentation	
// Sets fallback menu for 1 level. Could use preg_split to have children displayed too
function cyberchimps_fallback_menu() {
	$args = array(
		'depth'        => 1,
		'show_date'    => '',
		'date_format'  => '',
		'child_of'     => 0,
		'exclude'      => '',
		'include'      => '',
		'title_li'     => '',
		'echo'         => 0,
		'authors'      => '',
		'sort_column'  => 'menu_order, post_title',
		'link_before'  => '',
		'link_after'   => '',
		'walker'       => '',
		'post_type'    => 'page',
		'post_status'  => 'publish' 
	);
	$pages = wp_list_pages( $args );
	$prepend = '<ul id="menu-menu" class="nav">';
	$append = '</ul>';
	echo $prepend.$pages.$append;
}


if ( ! function_exists( 'cyberchimps_posted_on' ) ) :
// FIXME: Fix documentation
//Prints HTML with meta information for the current post-date/time and author.
function cyberchimps_posted_on() {
	
	if( is_single() ) {
		$show_date = ( cyberchimps_option( 'single_post_byline_date' ) ) ? cyberchimps_option( 'single_post_byline_date' ) : false;
		$show_author = ( cyberchimps_option( 'single_post_byline_author' ) ) ? cyberchimps_option( 'single_post_byline_author' ) : false; 
	}
	elseif( is_archive() ) {
		$show_date = ( cyberchimps_option( 'archive_post_byline_date' ) ) ? cyberchimps_option( 'archive_post_byline_date' ) : false;  
		$show_author = ( cyberchimps_option( 'archive_post_byline_author' ) ) ? cyberchimps_option( 'archive_post_byline_author' ) : false;
	}
	else {
		$show_date = ( cyberchimps_option( 'post_byline_date' ) ) ? cyberchimps_option( 'post_byline_date' ) : false; 
		$show_author = ( cyberchimps_option( 'post_byline_author' ) ) ? cyberchimps_option( 'post_byline_author' ) : false; 
	}
	
	$posted_on = sprintf( __( '%8$s<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="byline">%9$s<span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'cyberchimps' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		( $show_date ) ? esc_html( get_the_date() ) : '',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'cyberchimps' ), get_the_author() ) ),
		( $show_author ) ? esc_html( get_the_author() ) : '',
		( $show_date ) ? 'Posted on ' : '',
		( $show_author ) ? ' by ' : ''
	);
	apply_filters( 'cyberchimps_posted_on', $posted_on );
	echo $posted_on;
}
endif;

//add meta entry category to single post, archive and blog list if set in options
function cyberchimps_posted_in() {
	global $post;

	if( is_single() ) {
		$show = ( cyberchimps_option( 'single_post_byline_categories' ) ) ? cyberchimps_option( 'single_post_byline_categories' ) : false; 
	}
	elseif( is_archive() ) {
		$show = ( cyberchimps_option( 'archive_post_byline_categories' ) ) ? cyberchimps_option( 'archive_post_byline_categories' ) : false;  
	}
	else {
		$show = ( cyberchimps_option( 'post_byline_categories' ) ) ? cyberchimps_option( 'post_byline_categories' ) : false;  
	}
	if( $show ):
				$categories_list = get_the_category_list( __( ', ', 'cyberchimps' ) );
				if ( $categories_list ) :
				$cats = sprintf( __( 'Posted in %1$s', 'cyberchimps' ), $categories_list );
			?>
			<span class="cat-links">
				<?php echo apply_filters( 'cyberchimps_post_categories', $cats ); ?>
			</span>
      <span class="sep"> <?php echo apply_filters( 'cyberchimps_entry_meta_sep', '|' ); ?> </span>
	<?php endif;
	endif;
}

//add meta entry tags to single post, archive and blog list if set in options
function cyberchimps_post_tags() {
	global $post;
	
	if( is_single() ) {
		$show = ( cyberchimps_option( 'single_post_byline_tags' ) ) ? cyberchimps_option( 'single_post_byline_tags' ) : false; 
	}
	elseif( is_archive() ) {
		$show = ( cyberchimps_option( 'archive_post_byline_tags' ) ) ? cyberchimps_option( 'archive_post_byline_tags' ) : false;  
	}
	else {
		$show = ( cyberchimps_option( 'post_byline_tags' ) ) ? cyberchimps_option( 'post_byline_tags' ) : false;  
	}
	if( $show ):
	$tags_list = get_the_tag_list( '', __( ', ', 'cyberchimps' ) );
				if ( $tags_list ) :
				$tags = sprintf( __( 'Tags: %1$s', 'cyberchimps' ), $tags_list );
			?>
			<span class="tag-links">
				<?php echo apply_filters( 'cyberchimps_post_tags', $tags ); ?>
			</span>
      <span class="sep"> <?php echo apply_filters( 'cyberchimps_entry_meta_sep', '|' ); ?> </span>
			<?php endif; // End if $tags_list
	endif;
}

//add meta entry comments to single post, archive and blog list if set in options
function cyberchimps_post_comments() {
	global $post;
	
	if( is_single() ) {
		$show = ( cyberchimps_option( 'single_post_byline_comments' ) ) ? cyberchimps_option( 'single_post_byline_comments' ) : false; 
	}
	elseif( is_archive() ) {
		$show = ( cyberchimps_option( 'archive_post_byline_comments' ) ) ? cyberchimps_option( 'archive_post_byline_comments' ) : false;  
	}
	else {
		$show = ( cyberchimps_option( 'post_byline_comments' ) ) ? cyberchimps_option( 'post_byline_comments' ) : false;  
	}
	if( $show ):
		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'cyberchimps' ), __( '1 Comment', 'cyberchimps' ), __( '% Comments', 'cyberchimps' ) ); ?></span>
      <span class="sep"> <?php echo apply_filters( 'cyberchimps_entry_meta_sep', '|' ); ?> </span>
    <?php endif;
	endif;
}

// add featured image to single post, archive and blog page if set in options
function cyberchimps_featured_image() {
	global $post;
	
	if( is_single() ) {
		$show = ( cyberchimps_option( 'single_post_featured_images' ) ) ? cyberchimps_option( 'single_post_featured_images' ) : false; 
	}
	elseif( is_archive() ) {
		$show = ( cyberchimps_option( 'archive_featured_images' ) ) ? cyberchimps_option( 'archive_featured_images' ) : false;  
	}
	else {
		$show = ( cyberchimps_option( 'post_featured_images' ) ) ? cyberchimps_option( 'post_featured_images' ) : false;  
	}
	if( $show ):
		if( has_post_thumbnail() ): ?>
    <div class="featured-image">
      <?php the_post_thumbnail( apply_filters( 'cyberchimps_post_thumbnail_size', 'thumbnail' ) ); ?>
    </div>
<?php endif;
		endif;
}

// add breadcrumbs to single posts and archive pages if set in options
function cyberchimps_breadcrumbs() {
	global $post;
	
	if( is_single() ) {
		$show = ( cyberchimps_option( 'single_post_breadcrumbs' ) ) ? cyberchimps_option( 'single_post_breadcrumbs' ) : false; 
	}
	elseif( is_archive() ) {
		$show = ( cyberchimps_option( 'archive_breadcrumbs' ) ) ? cyberchimps_option( 'archive_breadcrumbs' ) : false;  
	}
	if( isset( $show ) ):
		do_action( 'breadcrumbs' );
	endif;
}
add_action( 'cyberchimps_before_container', 'cyberchimps_breadcrumbs' );

function cyberchimps_post_format_icon() {
	global $post;
	
	$format = get_post_format( $post->ID );
	if( $format == '' ) {
		$format = 'default'; 
	}
	
	if( is_single() ) {
		$show = ( cyberchimps_option( 'single_post_format_icons' ) ) ? cyberchimps_option( 'single_post_format_icons' ) : false; 
	}
	elseif( is_archive() ) {
		$show = ( cyberchimps_option( 'archive_format_icons' ) ) ? cyberchimps_option( 'archive_format_icons' ) : false;  
	}
	else {
		$show = ( cyberchimps_option( 'post_format_icons' ) ) ? cyberchimps_option( 'post_format_icons' ) : false;  
	}
	if( $show ):
	?>
	
	<div class="postformats"><!--begin format icon-->
		<img src="<?php echo get_template_directory_uri(); ?>/images/formats/<?php echo $format; ?>.png" alt="formats" />
	</div><!--end format-icon-->
<?php	
	endif;
}

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

// Set read more link for recent post element
function cyberchimps_recent_post_excerpt_more($more) {

	global $custom_excerpt, $post;
    
   		if ($custom_excerpt == 'recent') {
    		$linktext = 'Continue Reading';
    	}
    	
	return '&hellip;
			</p>
			<div class="more-link">
				<span class="continue-arrow"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/continue.png"></span><a href="'. get_permalink($post->ID) . '">  '.$linktext.'</a>
			</div>';
}

// Set read more link for featured post element
function cyberchimps_featured_post_excerpt_more($more) {
	global $post;
	return '&hellip;</p></span><a href="'. get_permalink($post->ID) . '">Read More...</a>';
}

// Set length of the excerpt
function cyberchimps_featured_post_length( $length ) {
	return 70;
}

// For magazine wide post
function cyberchimps_magazine_post_wide( $length ) {
	return 130;
}

// more text for search results excerpt
function cyberchimps_search_excerpt_more( $more ){
	global $post;
	if( cyberchimps_option( 'search_post_read_more' ) != '' ){
		$more = '<p><a href="'. get_permalink($post->ID) . '">'.cyberchimps_option( 'search_post_read_more' ).'</a></p>';
		return $more;
	}
	else {
		$more = '<p><a href="'. get_permalink($post->ID) . '">Read More...</a></p>';
		return $more;
	}
}

// excerpt length for search results
function cyberchimps_search_excerpt_length( $length ){
	global $post;
	if( cyberchimps_option( 'search_post_excerpt_length' ) != '' ) {
		$length = cyberchimps_option( 'search_post_excerpt_length' );
		return $length;
	}
	else {
		$length = 55;
		return $length;
	}
}

//For blog posts
function cyberchimps_blog_excerpt_more( $more ){
	global $post;
	if( cyberchimps_option( 'blog_read_more_text' ) != '' ){
		$more = '<p><a href="'. get_permalink($post->ID) . '">'.cyberchimps_option( 'blog_read_more_text' ).'</a></p>';
		return $more;
	}
	else {
		$more = '<p><a href="'. get_permalink($post->ID) . '">Read More...</a></p>';
		return $more;
	}
}
if( cyberchimps_option( 'post_excerpts' ) ){
	add_filter( 'excerpt_more', 'cyberchimps_blog_excerpt_more', 999 );
}

function cyberchimps_blog_excerpt_length( $length ) {
	global $post;
	if( cyberchimps_option( 'blog_excerpt_length' ) != '' ) {
		$length = cyberchimps_option( 'blog_excerpt_length' );
		return $length;
	}
	else {
		$length = 55;
		return $length;
	}
}
if( cyberchimps_option( 'post_excerpts' ) ){
	add_filter( 'excerpt_length', 'cyberchimps_blog_excerpt_length', 999 );
}

/*	gets post views */
function cyberchimps_getPostViews($postID){ 
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}

/*	Sets post views	*/
function cyberchimps_setPostViews($postID) { 
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/* To correct issue: adjacent_posts_rel_link_wp_head causes meta to be updated multiple times */
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Set up half slide for iFeature pro slider, adds it before post/page content
function cyberchimps_half_slider() {
	global $post;
	if( is_page() ) {
		$page_section_order = get_post_meta($post->ID, 'cyberchimps_page_section_order' , true);
		//if page_section_order is empty sets page as default
		$page_section_order = ( $page_section_order == '' ) ? array( 'page_section' ) : $page_section_order;
		if( in_array( 'page_slider', $page_section_order, true ) ) {
			$slider_size = get_post_meta( $post->ID, 'cyberchimps_slider_size', true );
			if( $slider_size == 'half' ) {
				do_action( 'page_slider' );
			}
		}
	}
	else {
		$blog_section_order = cyberchimps_get_option( 'blog_section_order' );
		//select default in case options are empty
		$blog_section_order = ( $blog_section_order == '' ) ? array( 'blog_post_page' ) : $blog_section_order;
		if( in_array( 'page_slider', $blog_section_order, true ) ) {
			$slider_size = cyberchimps_get_option( 'blog_slider_size' );
			if( $slider_size == 'half' ) {
				do_action( 'page_slider' );
			}
		}
	}
}
add_action( 'cyberchimps_before_content', 'cyberchimps_half_slider' );

// Modal welcome note
function cyberchimps_modal_welcome_note() { 
	if( cyberchimps_option( 'modal_welcome_note_display' ) == 1 ): ?>
  <div class="modal" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
      <h3 id="myModalLabel">Welcome</h3>
    </div>
    <div class="modal-body">
      	<?php printf( __( '
					<p>This is the beta of the CyberChimps WordPress Theme Framework.</p>
					
					<p><b>This WordPress Theme is not for use on a live production website!</b></p>
					
					<p>We are still actively developing this framework, and this release is simply for testing purposes. If you would like to get involved we have opened sourced the free version of our framework at <a href="https://github.com/cyberchimps/cyberchimpslite" target="_blank">https://github.com/cyberchimps/cyberchimpslite</a>.</p>
					
					<p>If you find something that is not working as you think it should, please <a href="https://github.com/cyberchimps/cyberchimpslite/issues/new" target="_blank">report the issue to us</a>, or if you are beta testing the Pro version please post your bugs on Basecamp.
					
					<p>Thank you for trying the new CyberChimps Theme Framework.</p>
					
					<p>A Professional WordPress Theme</p>', 'cyberchimps' ),
					apply_filters( 'cyberchimps_current_theme_name', 'Cyberchimps' ),
					apply_filters( 'cyberchimps_upgrade_link', 'http://cyberchimps.com' ),
					apply_filters( 'cyberchimps_upgrade_pro_title', __( 'Pro', 'cyberchimps' ) ),
					apply_filters( 'cyberchimps_documentation', 'http://cyberchimps.com' ),
					apply_filters( 'cyberchimps_support_forum', 'http://cyberchimps.com' )
					);					
		?>
    </div>
    <div class="modal-footer">
      <input type="submit" id="welcomeModalSave" class="btn btn-primary" name="update" value="<?php esc_attr_e( 'Close', 'cyberchimps' ); ?>" />
    </div>
  </div>
<?php
	endif;
}
add_action( 'cyberchimps_options_form_start', 'cyberchimps_modal_welcome_note' );

//Help Page
function cyberchimps_options_help_header() {
	$text = __( 'Response', 'cyberchimps' );
	return $text;
}
function cyberchimps_options_help_sub_header(){
	$text = __( 'Response Professional Responsive WordPress Theme', 'cyberchimps' );
	return $text;
}
function cyberchimps_options_help_text() {
	$text = '';
	$instruction_img = get_template_directory_uri().'/cyberchimps/options/lib/images/document.png';
	$support_img = get_template_directory_uri().'/cyberchimps/options/lib/images/questionsupport.png';
	$text .= '<div class="cc_help_section">
						<div class="row-fluid"><div class="span3">
							<a href="'.apply_filters( 'cyberchimps_documentation', 'http://cyberchimps.com' ).'" title="CyberChimps Instructions">
								<img src="'.$instruction_img.'" alt="CyberChimps Instructions" />
								<div class="cc_help_caption"><p>'.__( 'Instructions', 'cyberchimps' ).'</p></div>
							</a>
						</div>
						<div class="span3">
							<a href="'.apply_filters( 'cyberchimps_support_forum', 'http://cyberchimps.com' ).'" title="CyberChimps Support">
								<img src="'.$support_img.'" alt="CyberChimps Help" />
								<div class="cc_help_caption"><p>'.__( 'Support', 'cyberchimps' ).'</p></div>
							</a>
						</div>
						</div>
						<div class="span6">
						<div class="cc_help_upgrade_bar">'. sprintf( __( 'Upgrade to %1$s', 'cyberchimps' ), apply_filters( 'cyberchimps_upgrade_pro_title', 'CyberChimps Pro' ) ) .'</div>
						</div>
						</div>
						<div class="clear"></div>';
	$text .= sprintf( __( '<p>If you want even more amazing new features <a href="%1$s" title="%2$s">%2$s</a> which includes a Custom Features Slider, Product Element, Image Carousel, Widgetized Boxes, Callout Section, expanded typography and many more powerful new features. Please visit <a href="cyberchimps.com" title="CyberChimps">CyberChimps.com</a> to learn more!</p>', 'cyberchimps' ),
	apply_filters( 'cyberchimps_upgrade_link', 'http://cyberchimps.com' ),
	apply_filters( 'cyberchimps_upgrade_pro_title', 'CyberChimps Pro' )
	);
	return $text;
}
add_filter( 'cyberchimps_help_heading', 'cyberchimps_options_help_header' );
add_filter( 'cyberchimps_help_sub_heading', 'cyberchimps_options_help_sub_header' );
add_filter( 'cyberchimps_help_description', 'cyberchimps_options_help_text' );

// Hide preview and view on custom post types
function cyberchimps_posttype_admin_css() {
    global $post_type;
    if($post_type == 'custom_slides' || $post_type == 'boxes' || $post_type == 'featured_posts' || $post_type == 'portfolio_images') {
    echo '<style type="text/css">#view-post-btn,#post-preview{display: none;}</style>';
    }
}
add_action('admin_head', 'cyberchimps_posttype_admin_css');

// funationality for responsive toggle
function cyberchimps_responsive_stylesheet() {
	if( cyberchimps_get_option( 'responsive_design' ) ){
		wp_enqueue_style( 'cyberchimps_responsive', get_template_directory_uri() . '/cyberchimps/lib/bootstrap/css/cyberchimps-responsive.min.css', array('bootstrap-responsive-style', 'bootstrap-style'), '1.0' );
	}
	else {
		wp_dequeue_style( 'cyberchimps_responsive' );
	}
}
add_action( 'wp_enqueue_scripts', 'cyberchimps_responsive_stylesheet', 25 );
?>