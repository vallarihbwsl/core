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

function cyberchimps_header_section_order() {
	$header_section = cyberchimps_get_option('header_section_order');
	$header_section = ( $header_section == '' ) ? array( 'cyberchimps_header_content' ) : $header_section;
	if ( is_array( $header_section ) ) {
		foreach( $header_section as $func ) {
			do_action($func);
		}
	}
}
add_action('cyberchimps_header', 'cyberchimps_header_section_order');

// Logo/Icons header element.
function cyberchimps_logo_icons() { ?>
	<header class="row-fluid">
		<div class="span7">
			<?php if (function_exists('cyberchimps_header_logo') ) {
				cyberchimps_header_logo();
			} ?>
		</div>	
	
		<div id="register" class="span5">
			<?php if (function_exists('cyberchimps_header_social_icons') ) {
				cyberchimps_header_social_icons();
			} ?>
		</div>
	</header>
<?php }
add_action('cyberchimps_header_content', 'cyberchimps_logo_icons');

// Logo/Search header element.
function cyberchimps_logo_searchform() { ?>
	<header class="row-fluid">
		<div class="span7">
			<?php if (function_exists('cyberchimps_header_logo') ) {
				cyberchimps_header_logo();
			} ?>
		</div>	
	
		<div id="search" class="span5">
			<?php 
				get_search_form( true );
			 ?>
		</div>
	</header>
<?php }
add_action('cyberchimps_logo_search', 'cyberchimps_logo_searchform');

// Description/Icons header element.
function cyberchimps_description_icons() { ?>
	<header class="row-fluid">
		<div class="span7">
			<h1 class="site-description"><?php bloginfo( 'description' ); ?></h1>
		</div>	
	
		<div id ="register" class="span5">
			<?php if (function_exists('cyberchimps_header_social_icons') ) {
				cyberchimps_header_social_icons();
			} ?>
		</div>
	</header>
<?php }
add_action('cyberchimps_description_icons', 'cyberchimps_description_icons');

// Logo and Contact
function cyberchimps_sitename_contact() {?>
	<header class="row-fluid">
		<div class="span7">
			<?php if (function_exists('cyberchimps_header_logo') ) {
				cyberchimps_header_logo();
			} ?>
		</div>	
	
		<div id ="register" class="span5">
			<?php if (function_exists('cyberchimps_contact_info') ) {
				echo cyberchimps_contact_info();
			} ?>
		</div>
	</header>
<?php }
add_action('cyberchimps_sitename_contact', 'cyberchimps_sitename_contact');

// Logo and Description
function cyberchimps_logo_description() {?>
	<header class="row-fluid">
		<div class="span7">
			<?php if (function_exists('cyberchimps_header_logo') ) {
				cyberchimps_header_logo();
			} ?>
		</div>	
	
		<div id ="description" class="span5">
			<?php if (function_exists('cyberchimps_description') ) {
				echo cyberchimps_description();
			} ?>
		</div>
	</header>
<?php }
add_action( 'cyberchimps_logo_description', 'cyberchimps_logo_description' );

// Defines action for header elelment "Logo"
function cyberchimps_logo() {?>
	<header class="row-fluid">
		<div class="span7">
			<?php if (function_exists('cyberchimps_header_logo') ) {
				cyberchimps_header_logo();
			} ?>
		</div>	
	</header>
<?php }
add_action( 'cyberchimps_logo', 'cyberchimps_logo' );

// Header left content (sitename or logo)
function cyberchimps_header_logo() {
	 
	$url = ( cyberchimps_get_option( 'custom_logo_url_link' ) != '' ) ? cyberchimps_get_option( 'custom_logo_url_link' ) : home_url();
	if ( cyberchimps_get_option('custom_logo') == '1') {
		$logo = cyberchimps_get_option('custom_logo_uploader');
	?>
		<div id="logo">
			<a href="<?php echo $url; ?>" title="<?php echo get_bloginfo( 'name' ); ?>"><img src="<?php echo stripslashes($logo); ?>" alt="logo"></a>
		</div>
	<?php } else {
		if ( function_exists('cyberchimps_header_site_title') ) {
			cyberchimps_header_site_title();
		}
	}					 
}

function cyberchimps_header_site_title() { ?>	
	<hgroup>
		<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
	</hgroup>
<?php }


// Social icons
function cyberchimps_header_social_icons() {
	
	$folder = ( cyberchimps_get_option('theme_backgrounds') ) ? cyberchimps_get_option('theme_backgrounds') : 'default';
	
	$twitter_display = cyberchimps_get_option( 'social_twitter', 'checked' );
	$facebook_display = cyberchimps_get_option( 'social_facebook', 'checked' );
	$google_display = cyberchimps_get_option( 'social_google', 'checked' );
	$flickr_display = cyberchimps_get_option('social_flickr');
	$pinterest_display = cyberchimps_get_option('social_pinterest');
	$linkedin_display = cyberchimps_get_option('social_linkedin');
	$youtube_display = cyberchimps_get_option('social_youtube');
	$googlemaps_display = cyberchimps_get_option('social_googlemaps');
	$email_display = cyberchimps_get_option('social_email');
	$rss_display = cyberchimps_get_option('social_rss');
	
	$output = '';
	
	if ( !empty($twitter_display) ) {
		$twitter_url = cyberchimps_get_option('twitter_url');
		$output .= '<a href="'.esc_attr($twitter_url).'" target="_blank"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/twitter.png" alt="Twitter" /></a>';
	}
	
	if ( !empty($facebook_display) ) {
		$facebook_url = cyberchimps_get_option('facebook_url');
		$output .= '<a href="'.esc_attr($facebook_url).'" target="_blank"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/facebook.png" alt="Facebook" /></a>';
	}
	
	if ( !empty($google_display) ) {
		$google_url = cyberchimps_get_option('google_url');
		$output .= '<a href="'.esc_attr($google_url).'" target="_blank"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/gplus.png" alt="Google" /></a>';
	}
	
	if ( !empty($flickr_display) ) {
		$flickr_url = cyberchimps_get_option('flickr_url');
		$output .= '<a href="'.esc_attr($flickr_url).'" target="_blank"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/flickr.png" alt="Flickr" /></a>';
	}
	
	if ( !empty($pinterest_display) ) {
		$pinterest_url = cyberchimps_get_option('pinterest_url');
		$output .= '<a href="'.esc_attr($pinterest_url).'" target="_blank"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/pinterest.png" alt="Pinterest" /></a>';
	}
	
	if ( !empty($linkedin_display) ) {
		$linkedin_url = cyberchimps_get_option('linkedin_url');
		$output .= '<a href="'.esc_attr($linkedin_url).'" target="_blank"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/linkedin.png" alt="LinkedIn" /></a>';
	}
	
	if ( !empty($youtube_display) ) {
		$youtube_url = cyberchimps_get_option('youtube_url');
		$output .= '<a href="'.esc_attr($youtube_url).'" target="_blank"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/youtube.png" alt="YouTube" /></a>';
	}
	
	if ( !empty($googlemaps_display) ) {
		$googlemaps_url = cyberchimps_get_option('googlemaps_url');
		$output .= '<a href="'.esc_attr($googlemaps_url).'" target="_blank"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/googlemaps.png" alt="Google Maps" /></a>';
	}
	
	if ( !empty($email_display) ) {
		$email_url = cyberchimps_get_option('email_url');
		$output .= '<a href="mailto:'.esc_attr($email_url).'"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/email.png" alt="Email" /></a>';
	}
	
	if ( !empty($rss_display) ) {
		//bloginfo('rss2_url')
		$rss_url = cyberchimps_get_option('rss_url');
		$output .= '<a href="'.esc_attr($rss_url).'" target="_blank"><img src="'. get_template_directory_uri() .'/cyberchimps/lib/images/social/'.$folder.'/rss.png" alt="RSS" /></a>';
	}
	?>
	
	<div id="social">
		<div class="icons">
			<?php echo $output; ?>
		</div>
	</div>
	
<?php }

// Navigation
function cyberchimps_navigation() { ?>
	<div class="container">
		<div class="row">
			<div class="twelve columns" id="menu">
				<div id="nav" class="twelve columns">
					<?php wp_nav_menu( array( 
						'theme_location' => 'header-menu', // Setting up the location for the main-menu, Main Navigation.
						'fallback_cb' => 'cyberchimps_menu_fallback', //if wp_nav_menu is unavailable, WordPress displays wp_page_menu function, which displays the pages of your blog.
						'items_wrap' => '<ul id="nav_menu">%3$s</ul>',
					)); ?>
				</div>
			</div>
		</div>
	</div>
 <?php
}

// Custom HTML header element.
function cyberchimps_custom_header_element_content() { ?>
	<header class="row-fluid">
		<div class="span7">
			<?php echo stripslashes( cyberchimps_get_option( 'custom_header_element' ) ); ?>
		</div>
	</header>
<?php }

// Sitename/Register
function cyberchimps_logo_register_content() {
global $current_user; ?>
	<header class="row-fluid">
		<div class="span7">
			<?php if (function_exists('cyberchimps_header_logo') ) {
				cyberchimps_header_logo();
			} ?>
		</div>	

		<div id ="register" class="span5">
    <div class="register">
			<?php if(!is_user_logged_in()) :?>
				<?php wp_loginout(); ?> <?php wp_meta(); ?> |<?php wp_register(); ?>
			<?php else :?>
				Welcome back <strong><?php global $current_user; get_currentuserinfo(); echo ($current_user->user_login); ?></strong> | <?php wp_loginout(); ?>
			<?php endif;?>
    </div>
		</div>
	</header>
<?php }
add_action( 'cyberchimps_sitename_register', 'cyberchimps_logo_register_content' );

// Full-Width Logo
function cyberchimps_banner_content() {

	// Getting banner options
	$banner = cyberchimps_get_option( 'header_banner_image' );
	$default = get_template_directory_uri() . apply_filters( 'cyberchimps_banner_img', '/cyberchimps/lib/images/banner.jpg' );
	$url = cyberchimps_get_option( 'header_banner_url' );
?>	
	<div class="twelve columns">
		<div id="banner">
			<?php if ($banner != ""):?>
				<a href="<?php echo $url; ?>"><img src="<?php echo $banner; ?>" alt="logo"></a>
			<?php endif; ?>
			<?php if ($banner == ""):?>
				<a href="<?php echo $url; ?>"><img src="<?php echo $default; ?>" alt="logo"></a>
			<?php endif; ?>
		</div>		
	</div>
<?php
}

add_action( 'cyberchimps_banner', 'cyberchimps_banner_content' );

//contact info
function cyberchimps_contact_info() {
	$contact = cyberchimps_get_option('contact_details'); ?>
  
  <div class="contact_details">
		<p><?php echo $contact; ?></p>
  </div>
<?php } 

//description
function cyberchimps_description() {
	$description = get_bloginfo( 'description' );?>
  <div class="blog_description">
  	<p><?php echo $description; ?></p>
  </div>
<?php 
}
?>