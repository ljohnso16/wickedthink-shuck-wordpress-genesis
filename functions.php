<?php

/**
 * Custom amendments for the theme.
 *
 * @category   Genesis_Sandbox
 * @package    Functions
 * @subpackage Functions
 * @author     Travis Smith and Jonathan Perez
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://surefirewebservices.com/
 * @since      1.1.0
 */

// Initialize Sandbox ** DON'T REMOVE **
require_once( get_stylesheet_directory() . '/lib/init.php');

add_action( 'genesis_setup', 'gs_theme_setup', 15 );

//Theme Set Up Function
function gs_theme_setup() {
	
	//Enable HTML5 Support
	add_theme_support( 'html5' );

	//Enable Post Navigation
	add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

	/** 
	 * 01 Set width of oEmbed
	 * genesis_content_width() will be applied; Filters the content width based on the user selected layout.
	 *
	 * @see genesis_content_width()
	 * @param integer $default Default width
	 * @param integer $small Small width
	 * @param integer $large Large width
	 */
	$content_width = apply_filters( 'content_width', 600, 430, 920 );
	
	//Custom Image Sizes
	add_image_size( 'featured-image', 225, 160, TRUE );
	
	// Enable Custom Background
	//add_theme_support( 'custom-background' );

	// Enable Custom Header
	add_theme_support('genesis-custom-header',array(
		'width' => 521,
		'height' => 66
	));
	// Add support for structural wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'nav',
		'subnav',
		'inner',
		'footer-widgets',
		'footer'
	) );

	/**
	 * 07 Footer Widgets
	 * Add support for 3-column footer widgets
	 * Change 3 for support of up to 6 footer widgets (automatically styled for layout)
	 */
	add_theme_support( 'genesis-footer-widgets', 3 );

	/**
	 * 08 Genesis Menus
	 * Genesis Sandbox comes with 4 navigation systems built-in ready.
	 * Delete any menu systems that you do not wish to use.
	 */
	add_theme_support(
		'genesis-menus', 
		array(
			'primary'   => __( 'Primary Navigation Menu', CHILD_DOMAIN ), 
		//	'secondary' => __( 'Secondary Navigation Menu', CHILD_DOMAIN ),
			'footer'    => __( 'Footer Navigation Menu', CHILD_DOMAIN ),
			'mobile'    => __( 'Mobile Navigation Menu', CHILD_DOMAIN ),
		)
	);
	
	// Add Mobile Navigation
	add_action( 'genesis_before', 'gs_mobile_navigation', 5 );
	
	//Enqueue Sandbox Scripts
	add_action( 'wp_enqueue_scripts', 'gs_enqueue_scripts' );
	
	/**
	 * 13 Editor Styles
	 * Takes a stylesheet string or an array of stylesheets.
	 * Default: editor-style.css 
	 */
	//add_editor_style();
	
	
	// Register Sidebars
	gs_register_sidebars();

	//* Reposition the primary navigation menu
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_header', 'genesis_do_nav', 12 );
	add_filter( 'genesis_seo_title', 'child_header_title', 10, 3 );

	add_action('genesis_footer', 'smb_footer', 5);
	function smb_footer() {
		add_footer_logo();
		footer_menu();
	}
	


	
} // End of Set Up Function

//* Modify the header URL - HTML5 Version
function child_header_title( $title, $inside, $wrap ) {
    $inside = sprintf( '<a href="http://example.com/" title="%s"><img alt="" src="' . get_stylesheet_directory_uri() . '/images/logo.png" /></a>', esc_attr( get_bloginfo( 'name' ) ), get_bloginfo( 'name' ) );
    return sprintf( '<%1$s class="site-title">%2$s</%1$s>', $wrap, $inside );
}


// Register Sidebars
function gs_register_sidebars() {
	$sidebars = array(
		array(
			'id'			=> 'home-top',
			'name'			=> __( 'Home Top', CHILD_DOMAIN ),
			'description'	=> __( 'This is the top homepage section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-01',
			'name'			=> __( 'Home Left Middle', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage left section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-02',
			'name'			=> __( 'Home Middle Middle', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage middle section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-middle-03',
			'name'			=> __( 'Home Right Middle', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage right section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'home-bottom',
			'name'			=> __( 'Home Bottom', CHILD_DOMAIN ),
			'description'	=> __( 'This is the homepage right section.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'portfolio',
			'name'			=> __( 'Portfolio', CHILD_DOMAIN ),
			'description'	=> __( 'Use featured posts to showcase your portfolio.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'after-post',
			'name'			=> __( 'After Post', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up after every post.', CHILD_DOMAIN ),
		),
	);
	
	foreach ( $sidebars as $sidebar )
		genesis_register_sidebar( $sidebar );
}

/**
 * Enqueue and Register Scripts - Twitter Bootstrap, Font-Awesome, and Common.
 */
require_once('lib/scripts.php');

/**
 * Add navigation menu 
 * Required for each registered menu.
 * 
 * @uses gs_navigation() Sandbox Navigation Helper Function in gs-functions.php.
 */

//Add Mobile Menu
function gs_mobile_navigation() {
	
	$mobile_menu_args = array(
		'echo' => true,
	);
	
	gs_navigation( 'mobile', $mobile_menu_args );
}
function add_footer_logo(){
	$footer_logo = '<a href="/" class="footer-logo"><img alt="" src="' . get_stylesheet_directory_uri() . '/images/logo-footer.png" /></a>';
	echo $footer_logo;
}
// Add footer menu
function footer_menu() {
	$footer_menu_args = array(
		'echo' => true,
	);
	gs_navigation( 'footer', $footer_menu_args );
}
// Add Widget Area After Post
add_action('genesis_after_entry', 'gs_do_after_entry');
function gs_do_after_entry() {
 	if ( is_single() ) {
 	genesis_widget_area( 
                'after-post', 
                array(
                        'before' => '<aside id="after-post" class="after-post"><div class="home-widget widget-area">', 
                        'after' => '</div></aside><!-- end #home-left -->',
                ) 
        );
 }
 }
 add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$location = '<span class="footer-address">2 N. Cascade Avenue, Ste. 1280, Colorado Springs, CO 80903 </span>';
	$creds = $location . '<span class="footer-copyright">Copyright [footer_copyright] Shuck Communities&trade;. <a href="#">Privacy Statement</a></span>';
	return $creds;
}