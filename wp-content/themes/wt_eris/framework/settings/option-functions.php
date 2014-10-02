<?php
/**
 * The Theme Option Functions page
 *
 * This page is implemented using the Settings API.
 * 
 * @package  WellThemes
 * @file     option-functions.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 */

 
/**
 * Set custom RSS feed links.
 *
 */
$options = get_option('wt_options');
	
function wt_custom_feed( $output, $feed ) {

	$options = get_option('wt_options');
	$url = $options['wt_rss_url'];	
	
	if ( $url ) {
		$outputarray = array( 'rss' => $url, 'rss2' => $url, 'atom' => $url, 'rdf' => $url, 'comments_rss2' => '' );
		$outputarray[$feed] = $url;
		$output = $outputarray[$feed];
	}
	return $output;
}
add_filter( 'feed_link', 'wt_custom_feed', 1, 2 );

/**
 * Set custom Favicon.
 *
 */
function wt_custom_favicon() {
	$options = get_option('wt_options');
	$favicon_url = $options['wt_favicon'];	
	
    if (!empty($favicon_url)) {
		echo '<link rel="shortcut icon" href="'. $favicon_url. '" />	'. "\n";
	}
}
add_action('wp_head', 'wt_custom_favicon');


/**
 * Set apple touch icon.
 *
 */
function wt_apple_touch() {
	$options = get_option('wt_options');
	$apple_touch = $options['wt_apple_touch'];	
	
    if (!empty($apple_touch)) {
		echo '<link rel="apple-touch-icon" href="'. $apple_touch. '" />	'. "\n";
	}
}
add_action('wp_head', 'wt_apple_touch');

/**
 * Set meta description.
 *
 */
function wt_meta_description() {
    $options = get_option('wt_options');
	$wt_meta_description = $options['wt_meta_description'];
    
	if (!empty($wt_meta_description)) {
		echo '<meta name="description" content=" '. $wt_meta_description .'"  />' . "\n";
	}
}
add_action('wp_head', 'wt_meta_description');


/**
 * Set meta keywords.
 *
 */
function wt_meta_keywords() {
    $options = get_option('wt_options');
	$wt_meta_keywords = $options['wt_meta_keywords'];
    
	if (!empty($wt_meta_keywords)) {
		echo '<meta name="keywords" content=" '. $wt_meta_keywords .'"  />' . "\n";
	}
}
add_action('wp_head', 'wt_meta_keywords');


/**
 * Set Google site verfication code
 *
 */
function wt_google_verification() {
    $options = get_option('wt_options');
	$wt_google_verification = $options['wt_google_verification'];
   
   if (!empty($wt_google_verification)) {
		echo '<meta name="google-site-verification" content="' . $wt_google_verification . '" />' . "\n";
	}
}
add_action('wp_head', 'wt_google_verification');

/**
 * Set Bing site verfication code
 *
 */
function wt_bing_verification() {	
    $options = get_option('wt_options');
	$wt_bing_verification = $options['wt_bing_verification'];	
	
    if (!empty($wt_bing_verification)) {
        echo '<meta name="msvalidate.01" content="' . $wt_bing_verification . '" />' . "\n";
	}
}
add_action('wp_head', 'wt_bing_verification');


/**
 * Add code in the header.
 *
 */
function wt_header_code() {
    $options = get_option('wt_options');
	$wt_header_code = $options['wt_header_code'];
    if (!empty($wt_header_code)) {
        echo $wt_header_code;
	}
}
add_action('wp_head', 'wt_header_code');


/**
 * Add code in the footer.
 *
 */
function wt_footer_code() {
    $options = get_option('wt_options');
	$wt_footer_code = $options['wt_footer_code'];
    if (!empty($wt_footer_code)) {
        echo $wt_footer_code;
	}
}
add_action('wp_footer', 'wt_footer_code');

/**
 * Get Google Fonts
 *
 */ 
function wt_get_google_fonts() {
	require( get_template_directory() . '/framework/settings/google-fonts.php' );
	$google_font_array = json_decode ($google_api_output,true) ;
	$items = $google_font_array['items'];
	
	$fonts_list = array();

	$fontID = 0;
	foreach ($items as $item) {
		$fontID++;
		$variants='';
		$variantCount=0;
		foreach ($item['variants'] as $variant) {
			$variantCount++;
			if ($variantCount>1) { $variants .= '|'; }
			$variants .= $variant;
		}
		$variantText = ' (' . $variantCount . ' Varaints' . ')';
		if ($variantCount <= 1) $variantText = '';
		$fonts_list[ $item['family'] . ':' . $variants ] = $item['family']. $variantText;
	}
	return $fonts_list;
}

function wt_get_font($font_string) {
	if ($font_string) {
		$font_pieces = explode(":", $font_string);			
		$font_name = $font_pieces[0];
	
		return $font_name;
	}
}

function wt_get_bg_images(){
	$bg_images_path = get_stylesheet_directory(). '/images/bg/'; 
	$bg_images_url = get_template_directory_uri().'/images/bg/'; 
	$bg_images = array();

	if ( is_dir($bg_images_path) ) {
		if ($bg_images_dir = opendir($bg_images_path) ) { 
			while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
				if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
					$bg_images[] = $bg_images_url . $bg_images_file;
				}
			}    
		}
	}
	
	return $bg_images;
}

/**
 * Set custom CSS styles
 */ 
function wt_custom_styles(){
	$options = get_option('wt_options');
	$default_bg_img = $options['wt_bg_img'];
	$custom_bg_img = $options['wt_custom_bg'];
	$custom_bg_color = $options['wt_bg_color'];
	
	$wt_bg_style = '';
	
	if ($default_bg_img != 0){
		if( (empty($custom_bg_img)) and (empty($custom_bg_color))){
			$wt_bg_style= 'url('.get_template_directory_uri().'/images/bg/original/pattern'.$default_bg_img.'.png)';
		}
	}
	
	if (!empty ($custom_bg_color)){
		if (empty ($custom_bg_img)){
			$wt_bg_style= $custom_bg_color;
		}		
	}
	
	if (!empty ($custom_bg_img)){
		$wt_bg_style= 'url('.$custom_bg_img.')';
	}
	
	$wt_custom_style = '';
		
	//text styles
	$text_fontsize = $options['wt_text_fontsize'];
	$text_lineheight = $options['wt_text_lineheight'];
	
	$raw_text_style = $options['wt_text_fontstyle'];
	$formatted_text_style = wt_set_font_style($raw_text_style);
	$wt_text_font_string = $options['wt_text_font_name'];
	$wt_text_color = $options['wt_text_color'];   
	
	if ((!empty ($text_fontsize)) or (!empty ($text_style)) or (!empty ($text_lineheight))  or (!empty ($wt_text_font_string))  or (!empty($wt_bg_style)) or (!empty($wt_text_color)) ){
		$wt_custom_style .= "body{\n" ;
		
		if ( !empty ($text_fontsize) ) {
			$wt_custom_style .= "	font-size: " .$text_fontsize. ";\n";
		}
			
		if ( !empty ($formatted_text_style) ) {
			$wt_custom_style .= $formatted_text_style."\n";
		}
			
		if ( !empty ($text_lineheight) ) {
			$wt_custom_style .= "	line-height: " .$text_lineheight. ";\n";
		}
			
		if (!empty($wt_text_font_string)){
			wt_enqueue_font( $wt_text_font_string ) ;
			$font_name = wt_get_font($wt_text_font_string);
			$wt_custom_style .= "	font-family: " .$font_name. ", sans-serif, serif;\n";
		}
		
		if (!empty($wt_text_color) ){
			$wt_custom_style .= "	color: " .$wt_text_color. ";\n";
		}
		
		if (!empty($wt_bg_style) ){
			$wt_custom_style .= "	background: " .$wt_bg_style. ";\n";
		}			
			
		$wt_custom_style .="}\n\n";
	}
	
	//heading styles
	for ($i = 1; $i < 7; $i++){ 
		$raw_font_style = $options['wt_h'.$i.'_fontstyle'];
		$formatted_font_style = wt_set_font_style($raw_font_style);
				
		$font_size = $options['wt_h'.$i.'_fontsize'];
		$font_style = $formatted_font_style;
		$font_lineheight = $options['wt_h'.$i.'_lineheight'];
		$font_marginbottom = $options['wt_h'.$i.'_marginbottom'];
		
		if ((!empty ($font_size)) or (!empty ($font_style)) or (!empty ($font_lineheight)) or (!empty ($font_marginbottom))){
			$wt_custom_style .= "h".$i."{\n" ;
			if ( !empty ($font_size) ) {
				$wt_custom_style .= "	font-size: " .$font_size. ";\n";
			}
			
			if ( !empty ($font_style) ) {
				$wt_custom_style .= $font_style."\n";
			}
				
			if ( !empty ($font_lineheight) ) {
				$wt_custom_style .= "	line-height: " .$font_lineheight. ";\n";
			}
			
			if ( !empty ($font_marginbottom) ) {
				$wt_custom_style .= "	margin-bottom: " .$font_marginbottom. ";\n";
			}				
				
			$wt_custom_style .="}\n\n";	
		}
	}	
		
	//headings font and color	
	$wt_headings_font_string = $options['wt_headings_font_name'];
	$wt_headings_color = $options['wt_headings_color'];
		
	if ((!empty($wt_headings_font_string)) or (!empty($wt_headings_color))){
		$wt_custom_style .= "h1, h2, h3, h4, h5, h6 {\n";
		
		if (!empty($wt_headings_font_string)){
			wt_enqueue_font( $wt_headings_font_string ) ;
			$font_name = wt_get_font($wt_headings_font_string);
			$wt_custom_style .= "    font-family: ".$font_name.", sans-serif, serif;\n";	
		}
		
		if (!empty($wt_headings_color)){
			$wt_custom_style .= "    color: ".$wt_headings_color.";\n";	
		}		
		
		$wt_custom_style .= "}\n\n";
	}
	
	//links color
	$wt_links_color = $options['wt_links_color'];	
	if (!empty($wt_links_color)){
		$wt_custom_style .= "a:link {\n    color: ".$wt_links_color.";\n}\n\n";	
		$wt_custom_style .= "a:visited {\n    color: ".$wt_links_color.";\n}\n\n";		
	}
	
	//links hover color
	$wt_links_hover_color = $options['wt_links_hover_color'];
	if (!empty($wt_links_hover_color)){
		$wt_custom_style .= "a:hover, \n .entry-meta a:hover {\n    color: ".$wt_links_hover_color.";\n}\n\n";	
	}
		
	//footer headings color
	$wt_footer_headings_color = $options['wt_footer_headings_color'];
	if (!empty($wt_footer_headings_color)){
		$wt_custom_style .= "#footer h3, #footer h4, #footer h5, #footer h6 {\n    color: ".$wt_footer_headings_color.";\n}\n\n";	
	}
	
	//footer text color	
	$wt_footer_text_color = $options['wt_footer_text_color'];	
	if (!empty($wt_footer_text_color)){
		$wt_custom_style .= "#footer {\n    color: ".$wt_footer_text_color.";\n}\n\n";	
	}	
	
	//custom css field
	$wt_custom_css_field = $options['wt_custom_css'];
	if (!empty($wt_custom_css_field)){
		$wt_custom_style .= $wt_custom_css_field;	
	}
	
	
	//custom color schemes
	
	//set primary color
	$wt_primary_color = $options['wt_primary_color'];
	
	if (!empty($wt_primary_color)){
		$wt_custom_style .= "#main-menu ul li a:hover, #main-menu li.current-cat > a,\n #main-menu ul li.current-menu-ancestor, \n #main-menu ul li.current_page_ancestor, \n #main-menu ul > li.current-menu-item { \n    background: ".$wt_primary_color." \n}\n\n";		
		$wt_custom_style .= "#wt-slider .slider-text h2{\n    background: ".$wt_primary_color." \n}\n";
		$wt_custom_style .= ".overlay, \n .gallery-overlay, \n .widget-overlay, \n #feat-carousel .carousel-nav a.prev, \n #feat-carousel .carousel-nav a.next, \n .widget_calendar thead > tr > th {\n    background-color: ".$wt_primary_color." \n}\n\n";
		$wt_custom_style .= "#comments .reply, \n #respond input[type=submit], \n #content .pagination a:hover, \n #content .pagination .current, \n .widget_tags a.button, \n .tagcloud a, \n .entry-footer .entry-tags a, \n .widget_polls-widget .wp-polls .pollbar,\n .widget_polls-widget .wp-polls input.Buttons, \n .button {\n    background: ".$wt_primary_color." \n}\n\n";
		$wt_custom_style .= ".widget_polls-widget .wp-polls .pollbar{\n    border: 1px solid ".$wt_primary_color." \n}\n";		
	}
	
	//set secondary color
	$wt_second_color = $options['wt_second_color'];
	if (!empty($wt_second_color)){
		$wt_custom_style .= "#main-menu, \n #wt-slider .slider-text p, \n .widget_polls-widget .wp-polls a, \n #footer {\n    background-color: ".$wt_second_color." \n}\n\n";
	}
	
	$wt_custom_css_output = "\n<!-- Custom CSS Styles -->\n<style type=\"text/css\"> \n" . $wt_custom_style . " \n</style>\n<!-- /Custom CSS Styles -->\n\n";
	echo $wt_custom_css_output;
}
add_action('wp_head', 'wt_custom_styles');


/**
 * Set font styles
 */ 
function wt_set_font_style($fontstyle){
	$stack = '';
		
	switch ( $fontstyle ) {

		case "normal":
			$stack .= "";
		break;
		case "italic":
			$stack .= "    font-style: italic;";
		break;
		case 'bold':
			$stack .= "    font-weight: bold;";
		break;
		case 'bold-italic':
			$stack .= "    font-style: italic;\n    font-weight: bold;";
		break;
	}
	return $stack;
}

/**
 * Include Google fonts
 */ 
function wt_enqueue_font($wt_text_font_string){

	$font_pieces = explode(":", $wt_text_font_string);
	$font_name = $font_pieces[0];
	$font_name = str_replace (" ","+", $font_pieces[0] );
				
	$font_variants = $font_pieces[1];
	$font_variants = str_replace ("|",",", $font_pieces[1] );

	wp_enqueue_style( $font_name , 'http://fonts.googleapis.com/css?family='.$font_name . ':' . $font_variants );
}

?>