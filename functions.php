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
	add_image_size( 'featured-projects', 450, 242, FALSE );
	add_image_size( 'featured-page', 819, 715, FALSE );	
	
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
	//add_theme_support( 'genesis-footer-widgets', 3 );

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
	add_action( 'wp_enqueue_scripts', 'gs_enqueue_scripts', 1 );
		//Disable all emoji's
	function disable_wp_emojicons() {

	  // all actions related to emojis
	  remove_action( 'admin_print_styles', 'print_emoji_styles' );
	  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	  remove_action( 'wp_print_styles', 'print_emoji_styles' );
	  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	}
	add_action( 'init', 'disable_wp_emojicons' );
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
    $inside = sprintf( '<a href="'.home_url('/').'" title="%s"><img alt="" src="' . get_stylesheet_directory_uri() . '/images/logo.png" /></a>', esc_attr( get_bloginfo( 'name' ) ), get_bloginfo( 'name' ) );
    return sprintf( '<%1$s class="site-title">%2$s</%1$s>', $wrap, $inside );
}


// Register Sidebars
function gs_register_sidebars() {
	$sidebars = array(
		// array(
		// 	'id'			=> 'home-top',
		// 	'name'			=> __( 'Home Top', CHILD_DOMAIN ),
		// 	'description'	=> __( 'This is the top homepage section.', CHILD_DOMAIN ),
		// ),
		// array(
		// 	'id'			=> 'home-middle-01',
		// 	'name'			=> __( 'Home Left Middle', CHILD_DOMAIN ),
		// 	'description'	=> __( 'This is the homepage left section.', CHILD_DOMAIN ),
		// ),
		// array(
		// 	'id'			=> 'home-middle-02',
		// 	'name'			=> __( 'Home Middle Middle', CHILD_DOMAIN ),
		// 	'description'	=> __( 'This is the homepage middle section.', CHILD_DOMAIN ),
		// ),
		// array(
		// 	'id'			=> 'home-middle-03',
		// 	'name'			=> __( 'Home Right Middle', CHILD_DOMAIN ),
		// 	'description'	=> __( 'This is the homepage right section.', CHILD_DOMAIN ),
		// ),
		array(
			'id'			=> 'static-section-2',
			'name'			=> __( 'Static section 2 Area Under Main Slider', CHILD_DOMAIN ),
			'description'	=> __( 'This is the section for static content under Slider.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'featured-projects',
			'name'			=> __( 'Featured Projects', CHILD_DOMAIN ),
			'description'	=> __( 'Use featured posts to showcase your Featured Projects.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'static-section-3',
			'name'			=> __( 'Static Section 3', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up after Featured Projects on Home Page.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'footer-call-action',
			'name'			=> __( 'Call to Action Footer', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up before the footer.Default: Call to Action.', CHILD_DOMAIN ),
		),		
		array(
			'id'			=> 'testimonial-slider-area',
			'name'			=> __( 'testimonial Slider Area', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up before the footer.', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'j-s-letter',
			'name'			=> __( 'Joyce and Steves Letter', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up with the letter background and the Title of Joyce and Steve. Home Page Only', CHILD_DOMAIN ),
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

// Add Widget Area Before Footer

add_action('genesis_before_footer', 'gs_do_before_footer');
function gs_do_before_footer() {
 	if(is_front_page()){
 		genesis_widget_area( 
            'static-section-2', 
                array(
                        'before' => '<div id="static-section-2-area"><div class="static-section-2 widget-area">', 
                        'after' => '</div></div>',
                ) 
        ); 		
 		genesis_widget_area( 
            'featured-projects', 
                array(
                        'before' => '<div id="featured-projects-area"><div class="featured-projects widget-area">', 
                        'after' => '</div></div>',
                ) 
        );
 		genesis_widget_area( 
            'static-section-3', 
                array(
                        'before' => '<div class="clearfix"></div><div id="static-section-3-area"><div class="static-section-3 widget-area">', 
                        'after' => '</div></div>',
                ) 
        );        
 		genesis_widget_area( 
            'j-s-letter', 
                array(
                        'before' => '<div id="j-s-letter-area"><div class="j-s-letter widget-area"><h3 class="header-title">A Letter from Joyce and Steve</h3>', 
                        'after' => '<img id="sig" src="'.get_stylesheet_directory_uri().'/images/joyse-steve-signatures.png" /></div></div>',
                ) 
        );
	}
 	genesis_widget_area( 
                'testimonial-slider-area', 
                array(
                        'before' => '<div id="testimonial-slider-area"><div class="testimonial-slider-area widget-area">', 
                        'after' => '</div></div>',
                ) 
        );
 	genesis_widget_area( 
                'footer-call-action', 
                array(
                        'before' => '<div id="footer-call-action"><div class="footer-call-action widget-area">', 
                        'after' => '</div></div>',
                ) 
        ); 	
 	
 }
//SLIDER FOR TESTIMONIALS
add_shortcode('testimonial-slider','generate_testimonial_slider');
function generate_testimonial_slider(){
    $args = array(
        'post_type' => 'testimonial',
    	'posts_per_page' => 6
    );
    $i = 0;
    $query = new WP_Query( $args );
    $quote_icon_url = get_stylesheet_directory_uri().'/images/right-side-quote.png';
    $posts = '<div class="wrap">
    
    <div id="testimonial-slider" class="carousel slide" data-interval="3000" data-ride="carousel">

	    <div class="carousel-inner" role="listbox">';
    if($query->have_posts()):while($query->have_posts()):$query->the_post();
            $post_id = get_the_ID();
            $content = get_the_content();
            $companyname = types_render_field('cname', array('id' => $post_id, 'show_name' => false, 'output' => 'raw'));
            $fnamelname = types_render_field('fname-lname', array('id' => $post_id, 'show_name' => false, 'output' => 'raw'));

			if($i==0){
				$posts .='<div class="item active">';
			}
			else{
				$posts .='<div class="item">';
			}            
            if(!empty($content)){
	            $posts .='            
			    	   <img src="'.$quote_icon_url.'" alt="Testimonial">
			    	   <div class="carousel-caption">
			        	
				        <p class="excerpt">'.$content.'</p>';
				        if(!empty($fnamelname)){
				        	$posts .='<p class="testimonial-flname">'.$fnamelname.'</p>';
				        }
				        if(!empty($fnamelname)){
				        	$posts .='<p class="testimonial-comapny-name">'.$companyname.'</p>';
				        }
			    $posts.='</div></div>';
			}
            $i++;
        endwhile;
        wp_reset_postdata();
    endif;
    return $posts;
}
//SLIDER FOR FEATURED PROJECTS
add_shortcode('featured-projects','generate_featured_projects');
function generate_featured_projects(){
    $args = array(
        'post_type' => 'projects',
    	'posts_per_page' => 12,
		'category_name' => 'featured');
    $i = 0;
    $posts='
    	<div id="project-carousel" class="carousel slide" data-ride="carousel">
        <h4 class="widget-title widgettitle">Featured Projects</h4>
        <div class="carousel-inner">';
    $query = new WP_Query( $args );
    if($query->have_posts()):while($query->have_posts()):$query->the_post();
            $post_id = get_the_ID();
			$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'featured-projects', true);
			$featured_image = '<img src="'.$thumb_url[0].'">';
            $hover_text = types_render_field('hover-text', array('id' => $post_id, 'show_name' => false, 'output' => 'raw'));
            if($i==0){
				$posts .= '<div class="item active">';
            }
            if($i==4 || $i==8){
				$posts .= '</div><div class="item">';
            }
            
            if($i%2 == 0){
            	$posts .='<div><div class="first one-half project-item">'.$featured_image;
		        if(!empty($hover_text)){
					$posts .='<div class="hover-text">'.$hover_text.'</div>';
				}
            	$posts .='</div></div>';
            }
            else{
				$posts .='<div class="one-half project-item">'.$featured_image;
		        if(!empty($hover_text)){
					$posts .='<div class="hover-text">'.$hover_text.'</div>';
				}
				$posts .='</div><div class="clearfix"></div>';
            }
	        if($i==11){
				$posts .= '</div>';
            }
            $i++;
        endwhile;
        wp_reset_postdata();
    endif;
    $posts .= '</div><div class="view-more-link"><a href="./featured-projects/">View More</a></div></div>';
    return $posts;
}
//Short code for Learn more link goes to about page//
add_shortcode('learn-more','generate_read_more');
function generate_read_more(){
	return '<div class="learn-more"><a class="read-more-link" href="./about/" >Learn More</a></div>';
}