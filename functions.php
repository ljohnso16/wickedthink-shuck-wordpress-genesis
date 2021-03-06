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
	add_image_size( 'key-team-members', 238, 329, FALSE );
	add_image_size( 'archived-projects', 197, 253, true );	
	add_image_size( 'projects-reel', 850, 509, true );	
	
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
    $inside = sprintf( '<a href="'.home_url('/').'" title="%s"><img alt="Shuck Communities" src="' . get_stylesheet_directory_uri() . '/images/logo.png" /></a>', esc_attr( get_bloginfo( 'name' ) ), get_bloginfo( 'name' ) );
    return sprintf( '<%1$s class="site-title">%2$s</%1$s>', $wrap, $inside );
}


// Register Sidebars
function gs_register_sidebars() {
	$sidebars = array(

		array(
			'id'			=> 'featured-projects',
			'name'			=> __( 'Featured Projects', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up as Featured Projects on Home Page Only. Use Short Code: [featured-projects]', CHILD_DOMAIN ),
		),
		array(
			'id'			=> 'footer-call-action',
			'name'			=> __( 'Call to Action Footer', CHILD_DOMAIN ),
			'description'	=> __( 'This will show up before the footer.Default: Call to Action.', CHILD_DOMAIN ),
		)		
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
   function new_excerpt_more($more) {
		global $post;
		return '<a href="'. get_permalink($post->ID) . '" class="clearfix">' . 'Read More' . '</a>';
   }
   add_filter('excerpt_more', 'new_excerpt_more');

 add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$location = '<span class="footer-address">2 N. Cascade Avenue, Ste. 1280, Colorado Springs, CO 80903 </span>';
	$creds = $location . '<span class="footer-copyright">Copyright [footer_copyright] Shuck Communities&trade;. <a href="#">Privacy Statement</a></span>';
	return $creds;
}

// Add Widget Areas

add_action('genesis_before_footer', 'gs_do_before_footer');
function gs_do_before_footer() {
	$post_id = get_the_ID();
 	if(is_front_page()){		
 		genesis_widget_area( 
	        'featured-projects', 
	        array(
	                'before' => '<div id="project-carousel" class="carousel slide" data-ride="carousel">', 
	                'after' => '</div>',
	        ) 
	    );        
	}
	$staticsection1 = types_render_field('static-content-area-1', array('id' => $post_id, 'show_name' => false, 'output' => 'raw'));	
	if(!empty($staticsection1)){
		echo '<div id="static-section-1-area"><div class="area-wrap">'.$staticsection1.'<div class="clearfix"></div></div></div>';
	}	
	$staticsection2 = types_render_field('static-content-area-2-blueprints', array('id' => $post_id, 'show_name' => false, 'output' => 'raw'));	
	if(!empty($staticsection2)){
		echo '<div class="" id="j-s-letter-area"><div class="j-s-letter">'.$staticsection2.'</div></div>';
	}    
	$lowerwidgetarea = types_render_field('lower-widget-area', array('id' => $post_id, 'show_name' => false, 'output' => 'raw'));	
	if(!empty($lowerwidgetarea)){
		echo '<div class="lower-widget-area">'.$lowerwidgetarea.'</div>';
	}		
 	genesis_widget_area( 
	    'footer-call-action', 
		    array(
		            'before' => '<div id="footer-call-action"><div class="footer-call-action widget-area">', 
		            'after' => '</div></div>',
		    ) 
        ); 	
 	
 }
add_action( 'genesis_after_header', 'shuck_header_sliders' );
function shuck_header_sliders() {
    $post_id = get_the_ID();
	$ourshortcode = types_render_field('solil-shortcode', array('id' => $post_id, 'show_name' => false, 'output' => 'raw'));	
	if(!empty($ourshortcode)){
		echo $ourshortcode;
	}
	else
		return;

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
    $posts = '
	<div id="testimonial-slider-area"><div class="testimonial-slider-area widget-area">
    
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
			    	   <div class="clearfix"></div>
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
        $posts.='</div></div></div></div>';
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
    	
        
        <div class="carousel-inner">';
    $query = new WP_Query( $args );
    if($query->have_posts()):while($query->have_posts()):$query->the_post();
            $post_id = get_the_ID();
			$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'featured-projects', true);
			
            $hover_text = types_render_field('hover-text', array('id' => $post_id, 'show_name' => false, 'output' => 'raw'));
            $featured_image = '<img src="'.$thumb_url[0].'" alt="'.$hover_text.'">';
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
    $posts .= '</div><div class="view-more-link"><a href="./featured-projects/">View More</a></div>';
    return $posts;
}
//Short code for Learn more link goes to about page//
add_shortcode('sol-cap','generate_sol_cap');
function generate_sol_cap(){
	return '
		<div class="soliloquy-caption">
			<div class="sol-slide-in">Shuck Communities...</div>
			<div class="sol-slide-down"><p>The experiance you need for your next development project.</p></div>
			<div class="contact-btn"><button type="button" class="btn btn-secondary sol-btn" href="http://schuck.staging.wpengine.com/contact/">Contact Us Today</button></div>
		</div>';
}

/* Slide to Animate */

add_shortcode('learn-more','generate_read_more');
function generate_read_more(){
	return '<div class="learn-more"><a class="read-more-link" href="./about/" >Learn More</a></div>';
}

/*  Key Team Members Widget  */
add_shortcode('key-team-members','generate_key_team_members_widget');
function generate_key_team_members_widget(){
    $args = array(
        'post_type' 		=> 'member',
    	'posts_per_page'    =>  6,
    	'order' 			=>  'ASC'
    );
    $i = 0;
    $query = new WP_Query( $args );
    
    if(empty($query->have_posts())){
		return '<div class="wrap"><p>No Posts</p></div>';
    }
    $posts = '
	<div id="team-members"><div class="team-members-area widget-area">
	<h4>Key Team Members</h4>
    <div class="row">
    <div class="first one-third team-member">';
    if($query->have_posts()):while($query->have_posts()):$query->the_post();
            $post_id = get_the_ID();		
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'key-team-members',true );
			
            $member_name = get_the_title($post_id);
            $featured_image = '<img src="'.$thumbnail[0].'" alt="'.$member_name.'">';
            $position_title = types_render_field('title', array('id' => $post_id, 'show_name' => false, 'output' => 'raw'));
            $bio = get_the_content();
			if($i==3) {
				$posts .= '<div class="row">
							<div class="first one-third team-member">';
			}
			elseif($i>0 && $i!=3){
				$posts .= '<div class="one-third team-member">';	
			}
			$posts .=
				'<a href="#" data-toggle="modal" class="bio-link" data-target="#bio-0'.$i.'"><div class="pic">'.$featured_image.'</div></a>
				<div class="name">'.$member_name.'</div>
				<div class="position-title">'.$position_title.'</div>
				<div class="read-bio-container"><a href="#" class="read-bio" data-toggle="modal" data-target="#bio-0'.$i.'">Read Bio</a></div>';
			$posts .= '
						<div class="modal fade" id="bio-0'.$i.'" tabindex="-1" role="dialog" aria-labelledby="bio-0'.$i.'Label" aria-hidden="true">
						  <div class="modal-dialog modal-lg">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="bio-0'.$i.'Label">'.$member_name.' Bio</h4>
						      </div>
						      <div class="modal-body">
						        '.$bio.'
						      </div>
						      <div class="modal-footer">
						      </div>
						    </div>
						  </div>
						</div>';
			$posts .= '</div>';
			if($i==2) {
				$posts .= '<div class="clearfix"></div></div>';
			}

            $i++;
        endwhile;
        $posts .= '<div class="clearfix"></div></div></div></div>';
        wp_reset_postdata();
    endif;

    return $posts;
}

add_shortcode('archived-projects','generate_archived_projects');
function generate_archived_projects(){
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;	
	$query_args = array(
		'post_type' => 'projects',
		'category_name' => 'archived',
		'posts_per_page' => 3,
		'paged' => $paged
	);
	$the_query = new WP_Query( $query_args );

	$max = $the_query->max_num_pages;
    wp_enqueue_script( 'ajax-pagination',  CHILD_JS . '/ajax-pagination.js', array( 'jquery' ), '1.0', true );
    wp_localize_script(
		'ajax-pagination',
		'passedvar',
		array(
			'startPage' => $paged,
			'maxPages' => $max,
			'nextLink' => next_posts($max, false)
		)
	);

	$posts = '
					<div class="archived-projects-area widget-area" id="archived-projects-area">
					<h4 class="widget-title widgettitle">Archived Projects</h4>';
	if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); // run the loop 
		$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'archived-projects', true);
		$featured_image = '<img src="'.$thumb_url[0].'" alt="'.get_the_title(get_the_ID()).'">';

		$posts .= '<article class="archived-project">';
		$posts .= '<div class="alignleft">'.$featured_image.'</div>';
		$posts .= '<div class="alignright"><h3> '.get_the_title(get_the_ID()).' </h3>';
		$posts .= '<div class="author"> by <span>'.get_the_author().'</span></div>';
		$posts .= '<div class="date">'.get_the_date('F j, Y', get_the_ID()).'</div>';
		$posts .= '<div class="excerpt">'.get_the_excerpt().'</div>';

		$posts .= '</div><div class="clearfix"></div><div class="border"></div><div class="clearfix"></div>';

		$posts .= '</article>';
	endwhile;
	$posts .= '</div><div id="load-more-link"></div>';
	endif;
	return $posts;
}

//General SLIDER FOR PROJECTS
add_shortcode('projects-slider','generate_projects_slider');
function generate_projects_slider(){
    $args = array(
        'post_type' => 'projects',
    	'posts_per_page' => 12,
		'category_name' => 'project-reel');
    $i = 0;
    $posts='<div class="featured-projects-slider">
        <div id="projects-slider" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">';
    $query = new WP_Query( $args );
    if($query->have_posts()):while($query->have_posts()):$query->the_post();
            $post_id = get_the_ID();
			$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'projects-reels', true);
			$featured_image = '<img src="'.$thumb_url[0].'" alt="'.get_the_title($post_id).'">';
            $mycontent = get_the_content();
			if($i==0){
				$posts .= '<div class="item active">';
			}
			else{
				$posts .= '<div class="item">';				
			}
			$posts .= '
							<div class="project-wrap clearfix">
							<div class="pull-right">													
							<div class="col-md-5"><h2>'.get_the_title($post_id).'</h2><p>'.$mycontent.'</p></div>
							<div class="col-md-7 no-padding">'.$featured_image.'</div>
							</div></div>
					</div>';	
            $i++;
        endwhile;
        wp_reset_postdata();
    endif;
    $posts .= ' <div class="clearfix"></div></div>
    <a class="left carousel-control" href="#projects-slider" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#projects-slider" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  </div>';
    return $posts;
}