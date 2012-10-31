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

// TODO This would be better if we rename the option keys at the form so these functions can automate adding the styles to the header

// adds styles to header created from functions at the bottom
 function cyberchimps_css_styles() {
	$body_styles = cyberchimps_body_styles(); 
  $link_styles = cyberchimps_link_styles();
	$container_styles = cyberchimps_layout_styles();?>
  
  <style type="text/css" media="all">
	<?php if ( !empty( $body_styles ) ) : ?>
  body {
    	<?php foreach( $body_styles as $key => $body_style ): ?>
      	<?php echo $key; ?>: <?php echo $body_style; ?>;     
    	<?php endforeach; ?>
  }
  <?php endif; ?>
  <?php if ( !empty( $link_styles ) ) : ?>
  	<?php foreach( $link_styles as $key2 => $link_style ): ?>
  <?php echo $key2; ?>{
    color: <?php echo $link_style; ?>;
  }
  <?php endforeach; ?>
  <?php endif; ?>
  <?php if ( !empty( $container_styles ) ) : ?>
  .container {
    <?php foreach( $container_styles as $key3 => $container_style ): ?>
    <?php echo $key3; ?>: <?php echo $container_style; ?>px;
    <?php endforeach; ?>
  }
  <?php endif; ?>
  </style>
<?php
	return;
}
add_action( 'wp_head', 'cyberchimps_css_styles', 10 );

// creates body_styles array from options
function cyberchimps_body_styles() {
	$body_styles = array();
	if ( cyberchimps_get_option( 'background_colorpicker' ) ) {
		$body_styles['background-color'] = cyberchimps_get_option( 'background_colorpicker' );
	}
	if ( cyberchimps_get_option( 'text_colorpicker' ) ) {
		$body_styles['color'] = cyberchimps_get_option( 'text_colorpicker' );
	}
	if ( cyberchimps_get_option( 'typography_options' ) ) {
		$typography_options = cyberchimps_get_option( 'typography_options' );
		// changes terminology for typography to css elements
		foreach( $typography_options as $option => $value ) {
			if( $option == 'size' ) { $option = 'font-size'; }
			if( $option == 'face' ) { $option = 'font-family'; }
			if( $option == 'style' ) { $option = 'font-weight'; }
			if( $value != '' ) {
				$body_styles[$option] = $value;
			}
		}
	}
	
	// Set font-family if google font is on
	$google_font_toggle = cyberchimps_get_option( 'google_font' );
	$google_font = cyberchimps_get_option( 'google_font_field' );
	
	if( $google_font_toggle == "1" && $google_font != "" ) {
		$body_styles['font-family'] = $google_font;
		wp_register_style( 'google-font', 'http://fonts.googleapis.com/css?family='.$google_font );
		wp_enqueue_style( 'google-font' );
	}	
		
	if ( cyberchimps_get_option( 'select_background' ) && cyberchimps_get_option( 'select_background' ) != 'none' ) {
		$body_styles['background-image'] = 'url( "'.get_template_directory_uri().'/cyberchimps/lib/images/backgrounds/'.cyberchimps_get_option( 'select_background' ).'.jpg" )';
	}
	
	// Apply custom background image
	if( cyberchimps_get_option( 'custom_background' ) == 1 && cyberchimps_get_option( 'custom_background_image' ) != "" ) {
		$body_styles['background-image'] = 'url( "'.cyberchimps_get_option( 'custom_background_image' ).'" )';
		$body_styles['background-position'] = cyberchimps_get_option( 'background_image_position' );
		$body_styles['background-repeat'] = cyberchimps_get_option( 'background_image_repeat' );
		$body_styles['background-attachment'] = cyberchimps_get_option( 'background_image_attachment' );
	}
	
	return $body_styles;
}

// creates link color array for just a tag
function cyberchimps_link_styles() {
	$link_styles = array();
	if ( cyberchimps_get_option( 'link_colorpicker' ) ) {
		$link_styles['a'] = cyberchimps_get_option( 'link_colorpicker' );
	}
	if ( cyberchimps_get_option( 'link_hover_colorpicker' ) ) {
		$link_styles['a:hover'] = cyberchimps_get_option( 'link_hover_colorpicker' );
	}
	
	return $link_styles;
}

// creates width for main container of website
function cyberchimps_layout_styles() {
	$container_styles = array();
	if ( cyberchimps_get_option( 'max_width' ) ) {
		$width = intval( cyberchimps_get_option( 'max_width' ) );
		$key = ( cyberchimps_get_option( 'responsive_design' ) ) ? 'max-width' : 'width';
		if ( $width < 400 || empty( $width ) ) { 
			$container_styles[$key] = 1020;
		}
		else {
			$container_styles[$key] = $width;
		}
	}
	
	return $container_styles;
}

// add favicon
function cyberchimps_favicon() {
	if( cyberchimps_get_option( 'custom_favicon' ) ) :
	$favicon = cyberchimps_get_option( 'favicon_uploader' );
	if( $favicon != '' ):?>		
		<link rel="shortcut icon" href="<?php echo stripslashes( $favicon ); ?>" type="image/x-icon" />
  <?php endif;
	endif;	
}
add_action( 'wp_head', 'cyberchimps_favicon', 2 );
add_action( 'admin_head', 'cyberchimps_favicon', 2  );

// add apple touch icon
function cyberchimps_apple() {
	if( cyberchimps_get_option( 'custom_apple' ) ) :
	$apple = cyberchimps_get_option( 'apple_touch_uploader' );
	if( $apple != '' ): ?>
  	<link rel="apple-touch-icon" href="<?php echo stripslashes( $apple ); ?>" />
  <?php endif;
	endif;
}
add_action( 'wp_head', 'cyberchimps_apple', 2 );

// add styles for skin selection
function cyberchimps_skin_styles() {
	$skin = cyberchimps_get_option( 'cyberchimps_skin_color' );
	if( $skin != 'default' ) {
			wp_enqueue_style( 'skin-style', get_stylesheet_directory_uri() . '/inc/css/skins/'.$skin.'.css', array('style'), '1.0' );	
	}
}
add_action( 'wp_enqueue_scripts', 'cyberchimps_skin_styles', 21 );

/* Seeting custom css according to the supplied css from theme option */
function cyberchimps_custom_css() {	
	$custom = cyberchimps_get_option( 'custom_css' );
	echo '<style type="text/css">' . "\n";
	echo  $custom  . "\n";
	echo '</style>' . "\n";
}
add_action ( 'wp_head', 'cyberchimps_custom_css' );

/**
* Add link to theme options in Admin bar.
*/ 
function cyberchimps_admin_link() {
	global $wp_admin_bar;

	$wp_admin_bar->add_menu( array( 
								'id'	 => 'cyberchimps',
								'title'	 => 'Cyberchimps Options',
								'href'	 => admin_url('themes.php?page=cyberchimps-theme-options')  
								  ) ); 
}
add_action( 'admin_bar_menu', 'cyberchimps_admin_link', 113 );
?>