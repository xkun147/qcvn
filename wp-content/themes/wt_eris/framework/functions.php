<?php

/**
 * Tell WordPress to run max_magazine_setup() when the 'after_setup_theme' hook is run.
 */
 
add_action( 'after_setup_theme', 'max_magazine_setup' );

if ( ! function_exists( 'max_magazine_setup' ) ):

function max_magazine_setup() {

	/**
	 * Load up our required theme files.
	 */
	require( get_template_directory() . '/framework/settings/theme-options.php' );
	require( get_template_directory() . '/framework/settings/option-functions.php' );
	require( get_template_directory() . '/framework/shortcodes/wellthemes-shortcodes.php' );
	require( get_template_directory() . '/framework/shortcodes/shortcodes.php' );
	
	/**
	 * Load our theme widgets
	 */
	require( get_template_directory() . '/framework/widgets/widget_adsblock.php' );
	require( get_template_directory() . '/framework/widgets/widget_adsingle.php' );
	require( get_template_directory() . '/framework/widgets/widget_contact_form.php' );
	require( get_template_directory() . '/framework/widgets/widget_flickr.php' );
	require( get_template_directory() . '/framework/widgets/widget_recent_posts.php' );
	require( get_template_directory() . '/framework/widgets/widget_recent_posts_text.php' );
	require( get_template_directory() . '/framework/widgets/widget_popular_posts.php' );
	require( get_template_directory() . '/framework/widgets/widget_video.php' );
	require( get_template_directory() . '/framework/widgets/widget_twitter.php' );
	require( get_template_directory() . '/framework/widgets/widget_facebook.php' );
	require( get_template_directory() . '/framework/widgets/widget_carousel.php' );
	require( get_template_directory() . '/framework/widgets/widget_social_links.php' );
	require( get_template_directory() . '/framework/widgets/widget_subscribers_count.php' );	
	require( get_template_directory() . '/framework/widgets/widget_pinterest.php' );
	require( get_template_directory() . '/framework/widgets/widget_recent_comments.php' );
	require( get_template_directory() . '/framework/widgets/widget_recent_tags.php' );
	
	/* Add translation support.
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( 'wellthemes', get_template_directory() . '/languages' );
	
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) )
		$content_width = 600;
		
	/** 
	 * Add default posts and comments RSS feed links to <head>.
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * This theme styles the visual editor with editor-style.css to match the theme style.
	 */
	add_editor_style();
	
	/**
	 * Register menus
	 *
	 */
	register_nav_menus( array(
		'primary-menu' => __( 'Primary Menu', 'wellthemes' ),
		'secondary-menu' => __( 'Top Menu', 'wellthemes' )
	) );
	
	/**
	 * Add support for the featured images (also known as post thumbnails).
	 */
	if ( function_exists( 'add_theme_support' ) ) { 
		add_theme_support( 'post-thumbnails' );
	}
	
	/**
	 * Add custom image sizes
	 */
	
	add_image_size( 'wt-slider-image', 480, 330, true );		//featured slider image
	add_image_size( 'wt-feat-thumb', 242, 166, true );			//featured category image	
	add_image_size( 'wt-archive-thumb', 180, 135, true );		//archive/carousel thumbnails
	add_image_size( 'wt-small-thumb', 50, 50, true );			//featured posts/comments thumbnails
	add_image_size( 'wt-medium-thumb', 75, 75, true );			//featured gallery/sidebar widget thumbnails
	
	
	//add_image_size( 'wt-feat-thumb-small', 150, 100, true );		//featured category small thumb
	

}
endif; // max_magazine_setup

/**
 * A safe way of adding JavaScripts to a WordPress generated page.
 */

if (!is_admin()){
    add_action('wp_enqueue_scripts', 'wellthemes_js');
}

if (!function_exists('wellthemes_js')) {

    function wellthemes_js() {
		wp_enqueue_script('wt_hoverIntent', get_template_directory_uri().'/js/hoverIntent.js',array('jquery'));
		wp_enqueue_script('wt_superfish', get_template_directory_uri().'/js/superfish.js',array('hoverIntent'));
		wp_enqueue_script('wt_slider', get_template_directory_uri() . '/js/flexslider-min.js', array('jquery')); 
		wp_enqueue_script('wt_lightbox', get_template_directory_uri() . '/js/lightbox.js', array('jquery')); 		
		wp_enqueue_script('wt_jflickrfeed', get_template_directory_uri() . '/js/jflickrfeed.min.js', array('jquery')); 
		wp_enqueue_script('wt_mobilemenu', get_template_directory_uri() . '/js/jquery.mobilemenu.js', array('jquery'));  
		wp_enqueue_script('wt_jcarousellite', get_template_directory_uri() . '/js/jcarousellite_1.0.1.min.js', array('jquery'));  
		wp_enqueue_script('wt_custom', get_template_directory_uri() . '/js/custom.js', array('jquery')); 		
    }
	
}


/**
 * Register our sidebars and widgetized areas.
 *
 */
 
if ( function_exists('register_sidebar') ) {
			
	register_sidebar( array(
		'name' => __( 'Right Sidebar', 'wellthemes' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Left Sidebar', 'wellthemes' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional widget area for your site footer', 'wellthemes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area', 'wellthemes' ),
		'id' => 'sidebar-3',
		'description' => __( 'Eris theme shared on W P L O C K E R .C O M - An optional widget area for your site footer', 'wellthemes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
}

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own wellthemes_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
if ( ! function_exists( 'wellthemes_comment' ) ) :
function wellthemes_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
		
		<header class="author-info">
			
			<div class="author-avatar">
				<a href="<?php comment_author_url()?>"><?php echo get_avatar( $comment, 45 ); ?></a>
			</div>
			
			<div class="comment-meta"> 
				<div class="comment-author">
					<?php printf( __( '%s', 'wellthemes' ), sprintf( '<cite class="fn cufon">%s</cite>', get_comment_author_link() ) ); ?>
					<?php edit_comment_link( __( 'Edit', 'wellthemes' ), '<span class="edit-link">', '</span>' ); ?>
				</div>
				<div class="comment-time">
					<a class="comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'wellthemes' ), get_comment_date(),  get_comment_time() ); ?></a>
				</div>
			</div><!-- /comment-meta -->
		
		</header> <!-- /author-info -->
		
		<div class="comment-body">
			

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>
		
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<p class="moderation"><?php _e( 'Your comment is awaiting moderation.', 'wellthemes' ); ?></p>
			<?php endif; ?>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'wellthemes' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- /reply -->
		
		</div>
		<!-- /comment-body -->
		
	</article><!-- /comment  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'wellthemes' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'wellthemes' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php	
			break;
	endswitch;
}
endif;	//ends check for wellthemes_comment()



/**
 * Pagination for archive, taxonomy, category, tag and search results pages
 *
 * @global $wp_query http://codex.wordpress.org/Class_Reference/WP_Query
 * @return Prints the HTML for the pagination if a template is $paged
 */
if ( ! function_exists( 'wt_pagination' ) ) :
function wt_pagination() {
	global $wp_query;
 
	$big = 999999999; // This needs to be an unlikely integer
 
	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links
	$paginate_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5
	) );
 
	// Display the pagination if more than one page is found
	if ( $paginate_links ) {
		echo '<div class="pagination">';
		echo $paginate_links;
		echo '</div><!--// end .pagination -->';
	}
}
endif; // ends check for wt_pagination()

/**
 * Author list with avatar description, for the custom page template.
 *
 */
if ( ! function_exists( 'wellthemes_authors_list' ) ) :

	function wellthemes_authors_list() {
		global $wpdb;
		$authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY display_name");
 
		foreach($authors as $author) {
			echo "<div class=\"author\">";
			echo "<div class=\"author-avatar\"><a href=".get_bloginfo('url')."/?author=".$author->ID.">". get_avatar($author->ID, 68)."</a></div>";		
			echo "<div class=\"author-description\"><h4>". get_the_author_meta('display_name', $author->ID)."</h4>";
			echo "<p>".get_the_author_meta('user_description', $author->ID)."<p>";
			echo "<div class=\"author-link\"><a href=".get_bloginfo('url')."/?author=".$author->ID.">Visit&nbsp;". get_the_author_meta('display_name', $author->ID). "'s Profile</a></div></div>";
			echo "</div>";
		}
	}
	
endif; // ends check for wellthemes_authors_list()


if ( ! function_exists( 'wellthemes_feat_gallery' ) ) :

	function wellthemes_feat_gallery($cat=0){

		$query = new WP_Query('cat='.$cat.'&post_status=publish');
		$max_number = 10;
		$size= "thumbnail";		
		$i = 0;		
		echo "<ul>";
		foreach($query->posts as $post){			
			if ( 	$images = get_children(array(
					'post_parent' => $post->ID,
					'post_type' => 'attachment',
					'post_mime_type' => 'image',))
				){
					foreach( $images as $image ) {
						$attachmenturl=wp_get_attachment_url($image->ID);
						$attachmentimage=wp_get_attachment_image( $image->ID, $size );
						
						echo '<li><a href="'.$attachmenturl.'" rel="lightbox[roadtrip]">'.$attachmentimage.'</a></li>';
						
						if (++$i == $max_number) break 2;

					}						
				}					
		}
		echo "</ul>";
	}
	
endif; // ends check for wellthemes_feat_gallery()

if ( ! function_exists( 'wellthemes_top_menu_fallback' ) ) :
	
	function wellthemes_top_menu_fallback() { ?>
		<ul class="menu">
			<?php
				wp_list_pages(array(
					'depth' => 1,			//show only top level pages
					'number' => 5,
					'exclude' => '',
					'title_li' => '',
					'sort_column' => 'post_title',
					'sort_order' => 'ASC',
				));
			?>  
		</ul>
    <?php
	}
	
endif; // ends check for wellthemes_top_menu_fallback()

if ( ! function_exists( 'wellthemes_main_menu_fallback' ) ) :
	
	function wellthemes_main_menu_fallback() { ?>
		<ul class="menu">
			<?php
				wp_list_categories(array(
					'number' => 5,
					'exclude' => '1',		//exclude uncategorized posts
					'title_li' => '',
					'orderby' => 'count',
					'order' => 'DESC'  
				));
			?>  
		</ul>
    <?php
	}

endif; // ends check for wellthemes_main_menu_fallback()

?>