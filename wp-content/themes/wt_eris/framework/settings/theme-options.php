<?php
/**
 * The Theme Options page
 *
 * This page is implemented using the Settings API
 * http://codex.wordpress.org/Settings_API
 * 
 * @package  WellThemes
 * @file     theme-options.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 */

 /**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 *
 */

function wt_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style('thickbox');
	wp_enqueue_style( 'wt_theme_options', get_template_directory_uri() . '/framework/settings/css/theme-options.css', false, '1.0' );
	wp_enqueue_script( 'wt_theme_options', get_template_directory_uri() . '/framework/settings/js/theme-options.js', array( 'jquery' ), '1.0' );
	wp_enqueue_script( 'wt_colorpicker', get_template_directory_uri() . '/framework/settings/js/colorpicker.js', array( 'jquery' ), '1.0' );
	wp_enqueue_script('thickbox');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('wt_upload', get_template_directory_uri() .'/framework/settings/js/upload.js', array('jquery','media-upload','thickbox'));
}
add_action( 'admin_print_styles-appearance_page_wt-options', 'wt_admin_enqueue_scripts' );

global $pagenow;



if( ( 'themes.php' == $pagenow ) && ( isset( $_GET['activated'] ) && ( $_GET['activated'] == 'true' ) ) ) :
	/**
	* Set default options on activation
	*/
	function wt_init_options() {
		$options = get_option( 'wt_options' );
		if ( false === $options ) {
			$options = wt_default_options();  
		}
		update_option( 'wt_options', $options );
	}
	add_action( 'after_setup_theme', 'wt_init_options', 9 );
endif;

/**
 * Register the theme options setting
 */
function wt_register_settings() {
	register_setting( 'wt_options', 'wt_options', 'wt_validate_options' );	
}
add_action( 'admin_init', 'wt_register_settings' );

/**
 * Register the options page
 */
function wt_theme_add_page() {
	add_theme_page( __( 'Theme Options', 'wellthemes' ), __( 'Theme Options', 'wellthemes' ), 'edit_theme_options', 'wt-options', 'wt_theme_options_page' );
}
add_action( 'admin_menu', 'wt_theme_add_page');


 /**
* Set default variables
*/


/**
 * Output the options page
 */
function wt_theme_options_page() { 
?>
	<div id="wt-admin"> 		
			<div class="header">	
				<div class="main">
					<div class="left">
						<h2><?php echo _e('Theme Options', 'wellthemes'); ?></h2>
					</div>	
				
					<div class="theme-info">		
						<h3><?php _e('Eris Theme', 'wellthemes'); ?></h3>			
						<ul>
							<li class="support">
								<a href="<?php echo esc_url(__('http://forums.wellthemes.com/', 'wellthemes')); ?>" title="<?php _e('Theme Support', 'wellthemes'); ?>" target="_blank"><?php printf(__('Theme Support', 'wellthemes')); ?></a>
							</li>										
						</ul>
					</div>
				</div>
				<!-- <div class="subheader">
					
				</div> -->
			
			</div><!-- /header -->			
			
		<div class="options-wrap">
			
			<div class="tabs">
				<ul>
					<li class="general first"><a href="#tab1"><?php echo _e('General', 'wellthemes'); ?></a></li>
					<li class="home"><a href="#tab2"><?php echo _e('Hompepage', 'wellthemes'); ?></a></li>
					<li class="posts"><a href="#tab3"><?php echo _e('Posts and Archives', 'wellthemes'); ?></a></li>
					<li class="styles"><a href="#tab4"><?php echo _e('Styles', 'wellthemes'); ?></a></li>
					<li class="typography"><a href="#tab5"><?php echo _e('Typography', 'wellthemes'); ?></a></li>
					<li class="seo"><a href="#tab6"><?php echo _e('SEO', 'wellthemes'); ?></a></li>
					<li class="footer"><a href="#tab7"><?php echo _e('Header and Footer', 'wellthemes'); ?></a></li>
					<li class="reset"><a href="#tab8"><?php echo _e('Reset', 'wellthemes'); ?></a></li>
				</ul>                           
			</div><!-- /subheader -->
					
			<div class="options-form">			
									
					<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
						<div class="updated fade"><p><?php _e('Theme settings updated successfully', 'wellthemes'); ?></p></div>
					<?php endif; ?>
				
					<form action="options.php" method="post">
						
						<?php settings_fields( 'wt_options' ); ?>
						<?php $options = get_option('wt_options'); ?>		
			
						<div class="tab_content">
							<div id="tab1" class="tab_block">
								<h2><?php _e('General Settings', 'wellthemes'); ?></h2>
								
								<div class="fields_wrap">
								
									<div class="field infobox">
										<p><strong>Uploading Images</strong></p>
										You can specify the complete URLs for the logo and other images or you can upload the image. Please read the documentation for the image uploading instructions.
									</div>
									
									<h3><?php _e('Header Settings', 'wellthemes'); ?></h3>								
																											
									<div class="field">
										<label for="wt_logo_url">Upload logo</label>
										<input id="wt_options[wt_logo_url]" class="upload_image" type="text" name="wt_options[wt_logo_url]" value="<?php echo esc_attr($options['wt_logo_url']); ?>" />
                                        
										<input class="upload_image_button" id="wt_logo_upload_button" type="button" value="Upload" />
										<span class="description long updesc">Upload a logo image or specify path. Max width: 300px. Max height: 190px.</span> 
									</div>	
									
									<div class="field">
										<label for="wt_favicon">Upload Favicon</label>
										<input id="wt_options[wt_favicon]" class="upload_image" type="text" name="wt_options[wt_favicon]" value="<?php echo esc_attr($options['wt_favicon']); ?>" />
                                        <input class="upload_image_button" id="wt_favicon_button" type="button" value="Upload" />
										<span class="description updesc long">Upload your 16x16 px favicon or specify path.</span> 
									</div>	
									
									<div class="field">
										<label for="wt_apple_touch">Apple Touch Icon</label>
										<input id="wt_options[wt_apple_touch]" class="upload_image" type="text" name="wt_options[wt_apple_touch]" value="<?php echo esc_attr($options['wt_apple_touch']); ?>" />
                                        <input class="upload_image_button" id="wt_apple_touch_button" type="button" value="Upload" />
										<span class="description updesc">Upload your 114px by 114px icon..</span> 
									</div>	
									
									<div class="field">
										<label for="wt_options[wt_rss_url]"><?php _e('Custom RSS URL', 'wellthemes'); ?></label>
										<input id="wt_options[wt_rss_url]" name="wt_options[wt_rss_url]" type="text" value="<?php echo esc_attr($options['wt_rss_url']); ?>" />
										<span class="description long"><?php _e( 'Enter full URL of RSS Feeds link starting with <strong>http:// </strong>. Leave blank to use default RSS Feeds.', 'wellthemes' ); ?></span>
									</div>
						
									<h3><?php _e('Social Media Profiles', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_twitter_url]"><?php _e('Twitter Account', 'wellthemes'); ?></label>
										<input id="wt_options[wt_twitter_url]" name="wt_options[wt_twitter_url]" type="text" value="<?php echo esc_attr($options['wt_twitter_url']); ?>" />
										<span class="description"><?php _e( 'Enter full URL of your twitter profile. Leave blank if you don\'t want to display.', 'wellthemes' ); ?></span>
									</div>
									
									<div class="field">
										<label for="wt_options[wt_fb_url]"><?php _e('Facebook Account', 'wellthemes'); ?></label>
										<input id="wt_options[wt_fb_url]" name="wt_options[wt_fb_url]" type="text" value="<?php echo esc_attr($options['wt_fb_url']); ?>" />
										<span class="description"><?php _e( 'Enter full URL of your Facebook profile. Leave blank if you don\'t want to display.', 'wellthemes' ); ?></span>
									</div>
									
									<div class="field">
										<label for="wt_options[wt_contact_url]"><?php _e('Contact Page URL', 'wellthemes'); ?></label>
										<input id="wt_options[wt_contact_url]" name="wt_options[wt_contact_url]" type="text" value="<?php echo esc_attr($options['wt_contact_url']); ?>" />
										<span class="description"><?php _e( 'Enter full URL of your contact page. Leave blank if you don\'t want to display.', 'wellthemes' ); ?></span>
									</div>									
									
									<h3><?php _e('Contact Form', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_contact_email]"><?php _e('Email Address', 'wellthemes'); ?></label>
										<input id="wt_options[wt_contact_email]" name="wt_options[wt_contact_email]" type="text" value="<?php echo esc_attr($options['wt_contact_email']); ?>" />
										<span class="description long"><?php _e( 'Enter the email address where you wish to receive the contact form messages.', 'wellthemes' ); ?></span>
									</div>	
									
									<div class="field">
										<label for="wt_options[wt_contact_subject]"><?php _e('Email Subject', 'wellthemes'); ?></label>
										<input id="wt_options[wt_contact_subject]" name="wt_options[wt_contact_subject]" type="text" value="<?php echo esc_attr($options['wt_contact_subject']); ?>" />
										<span class="description"><?php _e( 'Enter the subject of the email.', 'wellthemes' ); ?></span>
									</div>
								</div> <!-- /fields-wrap -->								
								
							</div><!-- /tab_block -->
							
							<div id="tab2" class="tab_block">
								<h2><?php _e('Homepage Settings', 'wellthemes'); ?></h2>
																						
								<div class="fields_wrap">
									
									<div class="field infobox">
										<p><strong>Featured Images</strong></p>
										The slider and featured categories use Post Featured images. Please read the theme documentation to learn how to upload the post featured images.
									</div>
								
									<h3><?php _e('Top Header Bar', 'wellthemes'); ?></h3>
									<div class="field">
										<label for="wt_options[wt_header_top]"><?php _e('Enable Top Header Bar', 'wellthemes'); ?></label>
										<input id="wt_options[wt_header_top]" name="wt_options[wt_header_top]" type="checkbox" value="1" <?php isset($options['wt_header_top']) ? checked( '1', $options['wt_header_top'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check to enable the top hearder bar.', 'wellthemes' ); ?></span>					
									</div>
									
									<h3><?php _e('Carousel Settings', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_show_carousel]"><?php _e('Enable Carousel', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_carousel]" name="wt_options[wt_show_carousel]" type="checkbox" value="1" <?php isset($options['wt_show_carousel']) ? checked( '1', $options['wt_show_carousel'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check to enable the carousel on homepage.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">														
										<label for="wt_options[wt_carousel_category]"><?php _e('Carousel Category', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_carousel_category" name="wt_options[wt_carousel_category]">
													<option <?php selected( 0 == $options['wt_carousel_category'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
													<?php foreach( $categories as $category ) : ?>
														<option <?php selected( $category->term_id == $options['wt_carousel_category'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>											
										<span class="description slcdesc long"><?php _e( 'Select the category for the carousel. Select <strong>none</strong> to show latest posts.', 'wellthemes' ); ?></span>				
									</div>
									
									<h3><?php _e('Slider Settings', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_show_slider]"><?php _e('Enable Slider', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_slider]" name="wt_options[wt_show_slider]" type="checkbox" value="1" <?php isset($options['wt_show_slider']) ? checked( '1', $options['wt_show_slider'] ) : checked('0', '1'); ?> />							
										<span class="description chkdesc"><?php _e( 'Check to enable the slider on homepage.', 'wellthemes' ); ?></span>
									</div>
									
									<div class="field">														
										<label for="wt_options[wt_slider_category]"><?php _e('Slider Category', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_slider_category" name="wt_options[wt_slider_category]">
													<option <?php selected( 0 == $options['wt_slider_category'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
														<?php foreach( $categories as $category ) : ?>
															<option <?php selected( $category->term_id == $options['wt_slider_category'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
														<?php endforeach; ?>
												</select>
											 </div>	
											<span class="description slcdesc long"><?php _e( 'Select the category for the slider. Select <strong>none</strong> to show latest posts.', 'wellthemes' ); ?></span>					
									</div>
									
									<h3><?php _e('Single Column Featured Categories Settings', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_show_sf_cats]"><?php _e('Enable Single Column Featured Cateogories', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_sf_cats]" name="wt_options[wt_show_sf_cats]" type="checkbox" value="1" <?php isset($options['wt_show_sf_cats']) ? checked( '1', $options['wt_show_sf_cats'] ) : checked('0', '1'); ?> />							
										<span class="description chkdesc"><?php _e( 'Check to enable the slider on homepage.', 'wellthemes' ); ?></span>
									</div>
									
									<div class="field">														
										<label for="wt_options[wt_sf_cat1]"><?php _e('Left Category', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_sf_cat1" name="wt_options[wt_sf_cat1]">
													<option <?php selected( 0 == $options['wt_sf_cat1'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
														<?php foreach( $categories as $category ) : ?>
															<option <?php selected( $category->term_id == $options['wt_sf_cat1'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
														<?php endforeach; ?>
												</select>	
											</div>											
											<span class="description slcdesc long"><?php _e( 'Select the left side category. Select <strong>none</strong> to show latest posts.', 'wellthemes' ); ?></span>
									</div>
									
									<div class="field">														
										<label for="wt_options[wt_sf_cat2]"><?php _e('Right Category', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_sf_cat2" name="wt_options[wt_sf_cat2]">
													<option <?php selected( 0 == $options['wt_sf_cat2'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
														<?php foreach( $categories as $category ) : ?>
															<option <?php selected( $category->term_id == $options['wt_sf_cat2'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
														<?php endforeach; ?>
												</select>
											</div>												
											<span class="description slcdesc long"><?php _e( 'Select the right side category. Select <strong>none</strong> to show latest posts.', 'wellthemes' ); ?></span>				
									</div>								
									
									
									<h3><?php _e('Featured Categories Settings', 'wellthemes'); ?></h3>
									
									<div class="field">														
										<label for="wt_options[wt_feat_cat1]"><?php _e('Featured Category 1', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_feat_cat1" name="wt_options[wt_feat_cat1]">
													<option <?php selected( 0 == $options['wt_feat_cat1'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
													<?php foreach( $categories as $category ) : ?>
														<option <?php selected( $category->term_id == $options['wt_feat_cat1'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<span class="description slcdesc"><?php _e( 'Select the first featured category. Select <strong>none</strong> to hide.', 'wellthemes' ); ?></span>			
									</div>
									
									<div class="field">														
										<label for="wt_options[wt_feat_cat2]"><?php _e('Featured Category 2', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_feat_cat2" name="wt_options[wt_feat_cat2]">
													<option <?php selected( 0 == $options['wt_feat_cat2'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
													<?php foreach( $categories as $category ) : ?>
														<option <?php selected( $category->term_id == $options['wt_feat_cat2'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>												
											<span class="description slcdesc"><?php _e( 'Select the second featured category. Select <strong>none</strong> to hide.', 'wellthemes' ); ?></span>
									</div>
									
									<div class="field">														
										<label for="wt_options[wt_feat_cat3]"><?php _e('Featured Category 3', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_feat_cat3" name="wt_options[wt_feat_cat3]">
													<option <?php selected( 0 == $options['wt_feat_cat3'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
													<?php foreach( $categories as $category ) : ?>
														<option <?php selected( $category->term_id == $options['wt_feat_cat3'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
													<?php endforeach; ?>
												</select>	
											</div>											
											<span class="description slcdesc"><?php _e( 'Select the third featured category. Select <strong>none</strong> to hide.', 'wellthemes' ); ?></span>
									</div>
									
									<div class="field">														
										<label for="wt_options[wt_feat_cat4]"><?php _e('Featured Category 4', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_feat_cat4" name="wt_options[wt_feat_cat4]">
													<option <?php selected( 0 == $options['wt_feat_cat4'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
													<?php foreach( $categories as $category ) : ?>
													<option <?php selected( $category->term_id == $options['wt_feat_cat4'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>												
											<span class="description slcdesc"><?php _e( 'Select the forth featured category. Select <strong>none</strong> to hide.', 'wellthemes' ); ?></span>			
									</div>
									
									<div class="field">														
										<label for="wt_options[wt_feat_cat5]"><?php _e('Featured Category 5', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_feat_cat5" name="wt_options[wt_feat_cat5]">
													<option <?php selected( 0 == $options['wt_feat_cat5'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
													<?php foreach( $categories as $category ) : ?>
														<option <?php selected( $category->term_id == $options['wt_feat_cat5'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
													<?php endforeach; ?>
												</select>	
											</div>											
											<span class="description slcdesc"><?php _e( 'Select the fifth featured category. Select <strong>none</strong> to hide.', 'wellthemes' ); ?></span>
									</div>
									
									<h3><?php _e('Featured Image Gallery', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_show_feat_gallery]"><?php _e('Enable Gallery', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_feat_gallery]" name="wt_options[wt_show_feat_gallery]" type="checkbox" value="1" <?php isset($options['wt_show_feat_gallery']) ? checked( '1', $options['wt_show_feat_gallery'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check to enable the featured image gallery on homepage.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">														
										<label for="wt_options[wt_gallery_category]"><?php _e('Gallery Category', 'wellthemes'); ?></label>
										<?php 
											$categories = get_categories( array( 'hide_empty' => 1, 'hierarchical' => 0 ) );  ?>
											<div class="select-wrap wide">
												<select id="wt_gallery_category" name="wt_options[wt_gallery_category]">
													<option <?php selected( 0 == $options['wt_gallery_category'] ); ?> value="0"><?php _e( '--none--', 'wellthemes' ); ?></option>
													<?php foreach( $categories as $category ) : ?>
														<option <?php selected( $category->term_id == $options['wt_gallery_category'] ); ?> value="<?php echo $category->term_id; ?>"><?php echo $category->cat_name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>												
											<span class="description slcdesc long"><?php _e( 'Select the category for the gallery. Select <strong>none</strong> to show images from latest posts.', 'wellthemes' ); ?></span>				
									</div>
									
									
									<h3><?php _e('Latest Posts', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_show_other_posts]"><?php _e('Enable Posts List', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_other_posts]" name="wt_options[wt_show_other_posts]" type="checkbox" value="1" <?php isset($options['wt_show_other_posts']) ? checked( '1', $options['wt_show_other_posts'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check to enable the latest posts list on homepage.', 'wellthemes' ); ?></span>					
									</div>															
									
								</div> <!-- /fields-wrap -->								
								
							</div><!-- /tab_block -->
							
							<div id="tab3" class="tab_block">		
								<h2><?php _e('Posts and Archive Settings', 'wellthemes'); ?></h2>	
								
								<div class="fields_wrap">
								
									<div class="field infobox">
										<p><strong>Settings for single posts, pages, images and archives</strong></p>
										You can adjust single posts, pages images and archive settings.
									</div>
									
									<h3><?php _e('Post Settings', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_show_author_info]"><?php _e('Show Author Information', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_author_info]" name="wt_options[wt_show_author_info]" type="checkbox" value="1" <?php isset($options['wt_show_author_info']) ? checked( '1', $options['wt_show_author_info'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display author information below single posts.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_show_related_posts]"><?php _e('Show Related Posts', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_related_posts]" name="wt_options[wt_show_related_posts]" type="checkbox" value="1" <?php isset($options['wt_show_related_posts']) ? checked( '1', $options['wt_show_related_posts'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display related posts below single posts.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_show_post_social]"><?php _e('Show Social Media', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_post_social]" name="wt_options[wt_show_post_social]" type="checkbox" value="1" <?php isset($options['wt_show_post_social']) ? checked( '1', $options['wt_show_post_social'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display social media below single posts.', 'wellthemes' ); ?></span>					
									</div>
									
									<h3><?php _e('Page Settings', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_show_page_author_info]"><?php _e('Show Author Information', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_page_author_info]" name="wt_options[wt_show_page_author_info]" type="checkbox" value="1" <?php isset($options['wt_show_page_author_info']) ? checked( '1', $options['wt_show_page_author_info'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display author information on pages.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_show_page_meta]"><?php _e('Enable Post Meta on Pages', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_page_meta]" name="wt_options[wt_show_page_meta]" type="checkbox" value="1" <?php isset($options['wt_show_page_meta']) ? checked( '1', $options['wt_show_page_meta'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display post meta data on pages.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_show_page_comments]"><?php _e('Enable Comments on Pages', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_page_comments]" name="wt_options[wt_show_page_comments]" type="checkbox" value="1" <?php isset($options['wt_show_page_comments']) ? checked( '1', $options['wt_show_page_comments'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to enable comments on the pages.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_show_page_social]"><?php _e('Show Social Media on Pages', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_page_social]" name="wt_options[wt_show_page_social]" type="checkbox" value="1" <?php isset($options['wt_show_page_social']) ? checked( '1', $options['wt_show_page_social'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display social media on pages.', 'wellthemes' ); ?></span>					
									</div>
									
									<h3><?php _e('Images Settings', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_show_img_meta]"><?php _e('Enable Post Meta on Images', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_img_meta]" name="wt_options[wt_show_img_meta]" type="checkbox" value="1" <?php isset($options['wt_show_img_meta']) ? checked( '1', $options['wt_show_img_meta'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display post meta data on image pages.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_show_img_comments]"><?php _e('Enable Comments on Images', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_img_comments]" name="wt_options[wt_show_img_comments]" type="checkbox" value="1" <?php isset($options['wt_show_img_comments']) ? checked( '1', $options['wt_show_img_comments'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to enable comments on the image pages.', 'wellthemes' ); ?></span>					
									</div>	

									<div class="field">
										<label for="wt_options[wt_show_img_social]"><?php _e('Show Social Media on Images', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_img_social]" name="wt_options[wt_show_img_social]" type="checkbox" value="1" <?php isset($options['wt_show_img_social']) ? checked( '1', $options['wt_show_img_social'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display social media on Images.', 'wellthemes' ); ?></span>					
									</div>									
									
									<h3><?php _e('Archive Settings', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_show_archive_cat_info]"><?php _e('Display Category Description', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_archive_cat_info]" name="wt_options[wt_show_archive_cat_info]" type="checkbox" value="1" <?php isset($options['wt_show_archive_cat_info']) ? checked( '1', $options['wt_show_archive_cat_info'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display category description in archive.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_show_archive_tag_info]"><?php _e('Display Tag Description', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_archive_tag_info]" name="wt_options[wt_show_archive_tag_info]" type="checkbox" value="1" <?php isset($options['wt_show_archive_tag_info']) ? checked( '1', $options['wt_show_archive_tag_info'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display tag information in archive.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_show_archive_author_info]"><?php _e('Display Author Description', 'wellthemes'); ?></label>
										<input id="wt_options[wt_show_archive_author_info]" name="wt_options[wt_show_archive_author_info]" type="checkbox" value="1" <?php isset($options['wt_show_archive_author_info']) ? checked( '1', $options['wt_show_archive_author_info'] ) : checked('0', '1'); ?> />
										<span class="description chkdesc"><?php _e( 'Check if you want to display author informationin archive.', 'wellthemes' ); ?></span>					
									</div>
									
								</div> <!-- /fields-wrap -->
																
							</div><!-- /tab_block -->
							
							<div id="tab4" class="tab_block">
								<h2><?php _e('Styles', 'wellthemes'); ?></h2>
								
								<div class="fields_wrap">
								
									<div class="field infobox">
										<p><strong>Select Background</strong></p>
										You can use default background images, upload custom background image or you can use background color. Please select only one option and leave other background fields empty.
									</div>
									
									<h3><?php _e('Default Background Images', 'wellthemes'); ?></h3>
																		
									<?php if ((isset($options['wt_custom_bg'])) and (!empty($options['wt_custom_bg'])) ){ 
												if ((isset($options['wt_bg_color'])) and (!empty($options['wt_bg_color'])) ){ ?>
													<div class="field warningbox">
														<p><strong>Please Note</strong></p>
															You have selected multiple background image options, therefore your custom background image is being used. Please select only one type of background you would like to use, and empty other background option fields.
													</div>									
											<?php } 
										} 	?>																										
									<ul id="wt-bg-default-pattern" class="bg-images">
										<?php for($i=0 ; $i<=54 ; $i++ ){ ?>
											<li>
												<input id="wt_bg_img_<?php echo $i ?>"  name="wt_options[wt_bg_img]" type="radio" value="<?php echo $i ?>" <?php isset($options['wt_bg_img']) ? checked( $i, $options['wt_bg_img'] ) : checked('0', '1'); ?> />
												<a class="checkbox-select" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/bg/pattern<?php echo $i ?>.png" /></a>
											</li>
										<?php } ?>
									</ul>
									
									<h3><?php _e('Upload Custom Backgroud', 'wellthemes'); ?></h3>									
									<div class="field">										
										<label for="wt_custom_bg">Background Image</label>
										<input id="wt_options[wt_custom_bg]" class="upload_image" type="text" name="wt_options[wt_custom_bg]" value="<?php echo esc_attr($options['wt_custom_bg']); ?>" />
                                        
										<input class="upload_image_button" id="wt_bg_upload_button" type="button" value="Upload" />
										<span class="description updesc">Upload a custom image.</span>
									</div>
									
									<h3><?php _e('Use Background Color', 'wellthemes'); ?></h3>	
									<div class="field">
										<label><?php _e('Background Color', 'wellthemes'); ?></label>
										<div id="wt_bg_color_selector" class="color-pic"><div style="background-color:<?php echo $options['wt_bg_color'] ; ?>"></div></div>
										<input style="width:80px; margin-right:5px;"  name="wt_options[wt_bg_color]" id="wt_bg_color" type="text" value="<?php echo $options['wt_bg_color'] ; ?>" />
										<span class="description chkdesc"><?php _e( 'Select background color.', 'wellthemes' ); ?></span>
									</div>										
									
									<h3><?php _e('Theme Color Schemes', 'wellthemes'); ?></h3>
																	
									<div class="field">
										<label><?php _e('Primary Color', 'wellthemes'); ?></label>
										<div id="wt_primary_color_selector" class="color-pic"><div style="background-color:<?php echo $options['wt_primary_color'] ; ?>"></div></div>
										<input style="width:80px; margin-right:5px;"  name="wt_options[wt_primary_color]" id="wt_primary_color" type="text" value="<?php echo $options['wt_primary_color'] ; ?>" />
										<span class="description chkdesc"><?php _e( 'Select primary color for the theme.', 'wellthemes' ); ?></span>
									</div>
									
									<div class="field">
										<label><?php _e('Secondary Color', 'wellthemes'); ?></label>
										<div id="wt_second_color_selector" class="color-pic"><div style="background-color:<?php echo $options['wt_second_color'] ; ?>"></div></div>
										<input style="width:80px; margin-right:5px;"  name="wt_options[wt_second_color]" id="wt_second_color" type="text" value="<?php echo $options['wt_second_color'] ; ?>" />
										<span class="description chkdesc"><?php _e( 'Select secondary color for the theme.', 'wellthemes' ); ?></span>
									</div>
									
									<h3><?php _e('Custom CSS Styles', 'wellthemes'); ?></h3>	
									<div class="field">
										<label for="wt_options[wt_custom_css]"><?php _e('CSS Code', 'wellthemes'); ?></label>
										<textarea id="wt_options[wt_custom_css]" class="textarea" cols="50" rows="30" name="wt_options[wt_custom_css]"><?php echo esc_attr($options['wt_custom_css']); ?></textarea>
										<span class="description long"><?php _e( 'You can enter custom CSS code. It will overwrite the default style.', 'wellthemes' ); ?></span>							
									</div>										
								</div>
															
							</div>	<!-- /tab_block -->		
							
							<div id="tab5" class="tab_block">
								<h2><?php _e('Typography', 'wellthemes'); ?></h2>
									
									<div class="fields_wrap">									
									
										<div class="field infobox">
											<p><strong>Adjust your font styles</strong></p>
											You can use your custom fonts styles. If you want to use the default theme fonts, leave the fields empty. <br />
											From left to right: Font size, Font style, Line height, Margin Bottom	
										</div>
									
										<h3><?php _e('Headings', 'wellthemes'); ?></h3>
										
										<div class="field">
											<label><?php _e('Heading 1', 'wellthemes'); ?></label>
											
											<div class="select-wrap narrow">
												<select id="wt_h1_fontsize" name="wt_options[wt_h1_fontsize]">
													<option value="" <?php selected( $options['wt_h1_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['wt_h1_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											</div>
											
											<div class="select-wrap narrow120">
												<select id="wt_h1_fontstyle" name="wt_options[wt_h1_fontstyle]">
													<option value="" <?php selected( $options['wt_h1_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['wt_h1_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['wt_h1_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['wt_h1_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['wt_h1_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
											</div>											
											
											<div class="select-wrap narrow">											
												<select id="wt_h1_lineheight" name="wt_options[wt_h1_lineheight]">											
													<option value="" <?php selected( $options['wt_h1_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['wt_h1_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											</div>
											
											<div class="select-wrap narrow">
												<select id="wt_h1_marginbottom" name="wt_options[wt_h1_marginbottom]">
													<option value="" <?php selected( $options['wt_h1_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['wt_h1_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>
											</div>
											
											<span class="description fontdesc"><?php _e( 'Select font style for Heading 1.', 'wellthemes' ); ?></span>
											
										</div><!-- /field-->
										
										<div class="field">
											<label><?php _e('Heading 2', 'wellthemes'); ?></label>
											
											<div class="select-wrap narrow">
												<select id="wt_h2_fontsize" name="wt_options[wt_h2_fontsize]">
													<option value="" <?php selected( $options['wt_h2_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['wt_h2_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											</div>
											
											<div class="select-wrap narrow120">
												<select id="wt_h2_fontstyle" name="wt_options[wt_h2_fontstyle]">
													<option value="" <?php selected( $options['wt_h2_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['wt_h2_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['wt_h2_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['wt_h2_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['wt_h2_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
											</div>											
											
											<div class="select-wrap narrow">											
												<select id="wt_h2_lineheight" name="wt_options[wt_h2_lineheight]">											
													<option value="" <?php selected( $options['wt_h2_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['wt_h2_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											</div>
											
											<div class="select-wrap narrow">
												<select id="wt_h2_marginbottom" name="wt_options[wt_h2_marginbottom]">
													<option value="" <?php selected( $options['wt_h2_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['wt_h2_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>
											</div>										
											
											<span class="description fontdesc"><?php _e( 'Select font style for Heading 2.', 'wellthemes' ); ?></span>
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Heading 3', 'wellthemes'); ?></label>
											
											<div class="select-wrap narrow">
												<select id="wt_h3_fontsize" name="wt_options[wt_h3_fontsize]">
													<option value="" <?php selected( $options['wt_h3_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['wt_h3_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											</div>
											
											<div class="select-wrap narrow120">
												<select id="wt_h3_fontstyle" name="wt_options[wt_h3_fontstyle]">
													<option value="" <?php selected( $options['wt_h3_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['wt_h3_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['wt_h3_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['wt_h3_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['wt_h3_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
											</div>											
											
											<div class="select-wrap narrow">											
												<select id="wt_h3_lineheight" name="wt_options[wt_h3_lineheight]">											
													<option value="" <?php selected( $options['wt_h3_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['wt_h3_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											</div>
											
											<div class="select-wrap narrow">
												<select id="wt_h3_marginbottom" name="wt_options[wt_h3_marginbottom]">
													<option value="" <?php selected( $options['wt_h3_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['wt_h3_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>
											</div>	
											
											<span class="description fontdesc"><?php _e( 'Select font style for Heading 3.', 'wellthemes' ); ?></span>
										</div><!-- /feild -->
										
										<div class="field">
											<label><?php _e('Heading 4', 'wellthemes'); ?></label>
											
											<div class="select-wrap narrow">
												<select id="wt_h4_fontsize" name="wt_options[wt_h4_fontsize]">
													<option value="" <?php selected( $options['wt_h4_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['wt_h4_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											</div>
											
											<div class="select-wrap narrow120">
												<select id="wt_h4_fontstyle" name="wt_options[wt_h4_fontstyle]">
													<option value="" <?php selected( $options['wt_h4_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['wt_h4_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['wt_h4_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['wt_h4_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['wt_h4_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
											</div>											
											
											<div class="select-wrap narrow">											
												<select id="wt_h4_lineheight" name="wt_options[wt_h4_lineheight]">											
													<option value="" <?php selected( $options['wt_h4_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['wt_h4_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											</div>
											
											<div class="select-wrap narrow">
												<select id="wt_h4_marginbottom" name="wt_options[wt_h4_marginbottom]">
													<option value="" <?php selected( $options['wt_h4_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['wt_h4_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>
											</div>										
											<span class="description fontdesc"><?php _e( 'Select font style for Heading 4.', 'wellthemes' ); ?></span>
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Heading 5', 'wellthemes'); ?></label>
											
											<div class="select-wrap narrow">
												<select id="wt_h5_fontsize" name="wt_options[wt_h5_fontsize]">
													<option value="" <?php selected( $options['wt_h5_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['wt_h5_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											</div>
											
											<div class="select-wrap narrow120">
												<select id="wt_h5_fontstyle" name="wt_options[wt_h5_fontstyle]">
													<option value="" <?php selected( $options['wt_h5_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['wt_h5_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['wt_h5_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['wt_h5_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['wt_h5_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
											</div>											
											
											<div class="select-wrap narrow">											
												<select id="wt_h5_lineheight" name="wt_options[wt_h5_lineheight]">											
													<option value="" <?php selected( $options['wt_h5_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['wt_h5_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											</div>
											
											<div class="select-wrap narrow">
												<select id="wt_h5_marginbottom" name="wt_options[wt_h5_marginbottom]">
													<option value="" <?php selected( $options['wt_h5_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['wt_h5_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>
											</div>										
											
											<span class="description fontdesc"><?php _e( 'Select font style for Heading 5.', 'wellthemes' ); ?></span>
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Heading 6', 'wellthemes'); ?></label>
											
											<div class="select-wrap narrow">
												<select id="wt_h6_fontsize" name="wt_options[wt_h6_fontsize]">
													<option value="" <?php selected( $options['wt_h6_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['wt_h6_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											</div>
											
											<div class="select-wrap narrow120">
												<select id="wt_h6_fontstyle" name="wt_options[wt_h6_fontstyle]">
													<option value="" <?php selected( $options['wt_h6_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['wt_h6_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['wt_h6_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['wt_h6_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['wt_h6_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
											</div>											
											
											<div class="select-wrap narrow">											
												<select id="wt_h6_lineheight" name="wt_options[wt_h6_lineheight]">											
													<option value="" <?php selected( $options['wt_h6_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['wt_h6_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											</div>
											
											<div class="select-wrap narrow">
												<select id="wt_h6_marginbottom" name="wt_options[wt_h6_marginbottom]">
													<option value="" <?php selected( $options['wt_h6_marginbottom'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $margin_bottom = $i.'px'; ?>
														<option value="<?php echo $margin_bottom; ?>" <?php selected( $margin_bottom == $options['wt_h6_marginbottom'] ); ?>><?php echo $margin_bottom; ?> </option>
													<?php } ?>
												</select>
											</div>										
											
											<span class="description fontdesc"><?php _e( 'Select font style for Heading 6.', 'wellthemes' ); ?></span>
										</div><!-- /field -->
										
										<h3><?php _e('Text Font Styles', 'wellthemes'); ?></h3>
										
										<div class="field">
											<label><?php _e('Text', 'wellthemes'); ?></label>
											
											<div class="select-wrap narrow">
												<select id="wt_text_fontsize" name="wt_options[wt_text_fontsize]">
													<option value="" <?php selected( $options['wt_text_fontsize'] == '');?>></option>	
													<?php for ($i = 10; $i < 41; $i++){ $font_size = $i.'px'; ?>
														<option value="<?php echo $font_size; ?>" <?php selected( $font_size == $options['wt_text_fontsize'] ); ?>><?php echo $font_size; ?></option>'; 
													<?php	}	?>										
												</select>
											</div>
											
											<div class="select-wrap narrow120">
												<select id="wt_text_fontstyle" name="wt_options[wt_text_fontstyle]">
													<option value="" <?php selected( $options['wt_text_fontstyle'] == '');?>></option>	
													<option value="normal" <?php selected( $options['wt_text_fontstyle'] == 'normal');?>>Normal</option>	
													<option value="italic" <?php selected( $options['wt_text_fontstyle'] == 'italic');?>>Italic</option>	
													<option value="bold" <?php selected( $options['wt_text_fontstyle'] == 'bold');?>>Bold</option>											
													<option value="bold-italic" <?php selected( $options['wt_text_fontstyle'] == 'bold-italic');?>>Bold Italic</option>
												</select>
											</div>											
											
											<div class="select-wrap narrow">											
												<select id="wt_text_lineheight" name="wt_options[wt_text_lineheight]">											
													<option value="" <?php selected( $options['wt_text_lineheight'] == '');?>></option>
													<?php for ($i = 10; $i < 55; $i+=5){ $line_height = $i.'px'; ?>
														<option value="<?php echo $line_height; ?>" <?php selected( $line_height == $options['wt_text_lineheight'] ); ?>><?php echo $line_height; ?> </option>
													<?php } ?>
												</select>
											</div>
											
											<span class="description txtfontdesc long"><?php _e( 'Select font style for the text. From left to right: Font Size, Font Style, Line Height', 'wellthemes' ); ?></span>
											
										</div><!-- /field-->
										
										<h3><?php _e('Font', 'wellthemes'); ?></h3>
										<?php $fonts_list= wt_get_google_fonts(); ?>
										<div class="field">
											<label><?php _e('Headings Font', 'wellthemes'); ?></label>
											<div class="select-wrap wide">
												<select id="wt_headings_font_name" name="wt_options[wt_headings_font_name]">
													<option <?php selected( "" == $options['wt_headings_font_name'] ); ?> value=""></option>
													<?php foreach( $fonts_list as $font => $font_name ){ ?>
														<option <?php selected( $font == $options['wt_headings_font_name'] ); ?> value="<?php echo $font; ?>"><?php echo $font_name ?></option>	
													<?php } ?>
												</select>
											</div>
											<span class="description slcdesc"><?php _e( 'Select font for Headings.', 'wellthemes' ); ?></span>
										</div><!-- /field -->
										
										<div class="field">
											<label><?php _e('Text Font', 'wellthemes'); ?></label>
											<div class="select-wrap wide">
												<select id="wt_text_font_name" name="wt_options[wt_text_font_name]">
													<option <?php selected( "" == $options['wt_text_font_name'] ); ?> value=""></option>
													<?php foreach( $fonts_list as $font => $font_name ){ ?>
													<option <?php selected( $font == $options['wt_text_font_name'] ); ?> value="<?php echo $font; ?>"><?php echo $font_name; ?></option>	
													<?php } ?>
												</select>
											</div>
											<span class="description slcdesc"><?php _e( 'Select font for Text.', 'wellthemes' ); ?></span>
										</div><!-- /field -->
										
										<h3><?php _e('Color Schemes', 'wellthemes'); ?></h3>
										
										<div class="field">
											<label><?php _e('Headings Color', 'wellthemes'); ?></label>
											<div id="wt_headings_color_selector" class="color-pic"><div style="background-color:<?php echo $options['wt_headings_color'] ; ?>"></div></div>
											<input style="width:80px; margin-right:5px;"  name="wt_options[wt_headings_color]" id="wt_headings_color" type="text" value="<?php echo $options['wt_headings_color'] ; ?>" />
											<span class="description chkdesc"><?php _e( 'Select the headings color.', 'wellthemes' ); ?></span>
										</div>
										
										<div class="field">
											<label><?php _e('Text Color', 'wellthemes'); ?></label>
											<div id="wt_text_color_selector" class="color-pic"><div style="background-color:<?php echo $options['wt_text_color'] ; ?>"></div></div>
											<input style="width:80px; margin-right:5px;"  name="wt_options[wt_text_color]" id="wt_text_color" type="text" value="<?php echo $options['wt_text_color'] ; ?>" />
											<span class="description chkdesc"><?php _e( 'Select the text color.', 'wellthemes' ); ?></span>
										</div>									
										
										<div class="field">
											<label><?php _e('Links Color', 'wellthemes'); ?></label>
											<div id="wt_links_color_selector" class="color-pic"><div style="background-color:<?php echo $options['wt_links_color'] ; ?>"></div></div>
											<input style="width:80px; margin-right:5px;"  name="wt_options[wt_links_color]" id="wt_links_color" type="text" value="<?php echo $options['wt_links_color'] ; ?>" />
											<span class="description chkdesc"><?php _e( 'Select the links color.', 'wellthemes' ); ?></span>
										</div>
										
										<div class="field">
											<label><?php _e('Links Hover Color', 'wellthemes'); ?></label>
											<div id="wt_links_hover_color_selector" class="color-pic"><div style="background-color:<?php echo $options['wt_links_hover_color'] ; ?>"></div></div>
											<input style="width:80px; margin-right:5px;"  name="wt_options[wt_links_hover_color]" id="wt_links_hover_color" type="text" value="<?php echo $options['wt_links_hover_color'] ; ?>" />
											<span class="description chkdesc"><?php _e( 'Select links hover color.', 'wellthemes' ); ?></span>
										</div>			
																													
										<div class="field">
											<label><?php _e('Footer Headings Color', 'wellthemes'); ?></label>
											<div id="wt_footer_headings_color_selector" class="color-pic"><div style="background-color:<?php echo $options['wt_footer_headings_color'] ; ?>"></div></div>
											<input style="width:80px; margin-right:5px;"  name="wt_options[wt_footer_headings_color]" id="wt_footer_headings_color" type="text" value="<?php echo $options['wt_footer_headings_color'] ; ?>" />
											<span class="description chkdesc"><?php _e( 'Select the footer headings color.', 'wellthemes' ); ?></span>
										</div>
										
										<div class="field">
											<label><?php _e('Footer Text Color', 'wellthemes'); ?></label>
											<div id="wt_footer_text_color_selector" class="color-pic"><div style="background-color:<?php echo $options['wt_footer_text_color'] ; ?>"></div></div>
											<input style="width:80px; margin-right:5px;"  name="wt_options[wt_footer_text_color]" id="wt_footer_text_color" type="text" value="<?php echo $options['wt_footer_text_color'] ; ?>" />
											<span class="description chkdesc"><?php _e( 'Select the footer text color.', 'wellthemes' ); ?></span>
										</div>									
									</div><!-- /fields_wrap -->	
																	
							</div><!-- /tab_block -->								
							
							<div id="tab6" class="tab_block">
								<h2><?php _e('SEO Settings', 'wellthemes'); ?></h2>
									
									<div class="fields_wrap">
									
										<div class="field infobox">
											<p><strong>Site Verification</strong></p>
											You can improve your search rankings by verifying your website with Bing and Google.
											Please read the theme documentation for step by step instructions on how to find Google and Bing site verification IDs.
										</div>
										
									<h3><?php _e('Default Meta Settings', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_meta_keywords]"><?php _e('Default Meta Keywords', 'wellthemes'); ?></label>
										<textarea id="wt_options[wt_meta_keywords]" class="textarea"  name="wt_options[wt_meta_keywords]"><?php echo esc_attr($options['wt_meta_keywords']); ?></textarea>
										<span class="description"><?php _e( 'Add default meta keywords. Separate keywords with commas.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_meta_description]"><?php _e('Default Meta Description', 'wellthemes'); ?></label>
										<textarea id="wt_options[wt_meta_description]" class="textarea" name="wt_options[wt_meta_description]"><?php echo esc_attr($options['wt_meta_description']); ?></textarea>
										<span class="description"><?php _e( 'Add default meta description.', 'wellthemes' ); ?></span>					
									</div>
									
									<h3><?php _e('Site Verification', 'wellthemes'); ?></h3>
									
									<div class="field">
										<label for="wt_options[wt_google_verification]"><?php _e('Google Site Verification', 'wellthemes'); ?></label>
										<input id="wt_options[wt_google_verification]" type="text" name="wt_options[wt_google_verification]" value="<?php echo esc_attr($options['wt_google_verification']); ?>" />
										<span class="description"><?php _e( 'Enter your ID only.', 'wellthemes' ); ?></span>
									</div>
									
									<div class="field">
										<label for="wt_options[wt_bing_verification]"><?php _e('Bing Site Verification', 'wellthemes'); ?></label>
										<input id="wt_options[wt_bing_verification]" type="text" name="wt_options[wt_bing_verification]" value="<?php echo esc_attr($options['wt_bing_verification']); ?>" />
										<span class="description"><?php _e( 'Enter the ID only. It will be verified by <strong>Yahoo</strong> as well.','wellthemes' ); ?></span>
									</div>
									
									</div> <!-- /fields-wrap -->
									
							</div>	<!-- /tab_block -->	
							
							<div id="tab7" class="tab_block">
								<h2><?php _e('Header and Footer Settings', 'wellthemes'); ?></h2>
									<div class="fields_wrap">
									
									<div class="field infobox">
										<p><strong>Using Site Analytics Codes</strong></p>
											You can use site analytics codes in the header of footer.
									</div>
									
									<h3><?php _e('Header Settings', 'wellthemes'); ?></h3>
									<div class="field">
										<label for="wt_options[wt_header_ad468]"><?php _e('Header 468px Ad Code.', 'wellthemes'); ?></label>
										<textarea id="wt_options[wt_header_ad468]" class="textarea" name="wt_options[wt_header_ad468]"><?php echo esc_attr($options['wt_header_ad468']); ?></textarea>
										<span class="description"><?php _e( 'Enter the code the header ad.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_header_code]"><?php _e('Other Header Code.', 'wellthemes'); ?></label>
										<textarea id="wt_options[wt_header_code]" class="textarea" name="wt_options[wt_header_code]"><?php echo esc_attr($options['wt_header_code']); ?></textarea>
										<span class="description"><?php _e( 'You can add any code eg. Google Analytics. It will appear in <strong>head</strong> section.', 'wellthemes' ); ?></span>		
									</div>
									
									<h3><?php _e('Footer Settings', 'wellthemes'); ?></h3>									
									<div class="field">
										<label for="wt_options[wt_footer_text_left]"><?php _e('Footer Left Text.', 'wellthemes'); ?></label>
										<textarea id="wt_options[wt_footer_text_left]" class="textarea" name="wt_options[wt_footer_text_left]"><?php echo esc_attr($options['wt_footer_text_left']); ?></textarea>
										<span class="description"><?php _e( 'Enter the footer left side text.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_footer_text_right]"><?php _e('Footer Right Text.', 'wellthemes'); ?></label>
										<textarea id="wt_options[wt_footer_text_right]" class="textarea" name="wt_options[wt_footer_text_right]"><?php echo esc_attr($options['wt_footer_text_right']); ?></textarea>
										<span class="description"><?php _e( 'Enter the footer right side text.', 'wellthemes' ); ?></span>					
									</div>
									
									<div class="field">
										<label for="wt_options[wt_footer_code]"><?php _e('Footer Code', 'wellthemes'); ?></label>
										<textarea id="wt_options[wt_footer_code]" class="textarea" name="wt_options[wt_footer_code]"><?php echo esc_attr($options['wt_footer_code']); ?></textarea>
										<span class="description"><?php _e( 'You can add any code eg. Google Analytics. It will appear in <strong>footer</strong> section.', 'wellthemes' ); ?></span>
									</div>
									
									</div> <!-- /fields-wrap -->
									
									
							</div>	<!-- /tab_block -->	
							
							<div id="tab8" class="tab_block">
								<h2><?php _e('Reset Theme Settings', 'wellthemes'); ?></h2>
									<div class="fields_wrap">
										<div class="field warningbox">
											<p><strong>Please Note</strong></p>
												You will lose all your theme settings and theme will restore default settings.
										</div>
													
										<div class="field">
											<p class="reset-info"> If you want to reset the theme settings. </p>
											<input type="submit" name="wt_options[reset]" class="button-primary" value="<?php _e( 'Reset Settings', 'wellthemes' ); ?>" />
										</div>
									</div>	<!-- /fields_wrap -->	
							</div>	<!-- /tab_block -->	
					
						</div> <!-- /option_blocks -->			
						
					
		
			</div> <!-- /options-form -->
		</div> <!-- /options-wrap -->
		<div class="options-footer">
			<input type="submit" name="wt_options[submit]" class="button-primary" value="<?php _e( 'Save Settings', 'wellthemes' ); ?>" />
		</div>
		</form>
	</div> <!-- /wt-admin -->
	<?php
}

/**
 * Return default array of options
 */
function wt_default_options() {
	$options = array(
		'wt_logo_url' => get_template_directory_uri().'/images/logo.png',	
		'wt_favicon' => '',
		'wt_apple_touch' => '',
		'wt_rss_url' => '',
		'wt_twitter_url' => '',
		'wt_fb_url' => '',
		'wt_contact_url' => '',
		'wt_contact_email' => '',	
		'wt_contact_subject' => '',	
		'wt_header_top' => 1,			
		'wt_show_carousel' => 1,
		'wt_carousel_category' => 0,
		'wt_show_slider' => 1,		
		'wt_slider_category' => 0,
		'wt_show_sf_cats' => 1,
		'wt_sf_cat1' => 0,
		'wt_sf_cat2' => 0,
		'wt_feat_cat1' => 0,
		'wt_feat_cat2' => 0,
		'wt_feat_cat3' => 0,
		'wt_feat_cat4' => 0,
		'wt_feat_cat5' => 0,
		'wt_show_feat_gallery' => 1,	
		'wt_gallery_category' => 0,		
		'wt_show_other_posts' => 1,
		'wt_show_author_info' => 1,
		'wt_show_related_posts' => 1,
		'wt_show_post_social' => 1,	
		'wt_show_page_author_info' => 0,		
		'wt_show_page_meta' => 0,	
		'wt_show_page_comments' => 1,
		'wt_show_page_social' => 1,
		'wt_show_img_meta' => 1,
		'wt_show_img_comments' => 1,
		'wt_show_img_social' => 1,
		'wt_show_archive_cat_info' => 1,
		'wt_show_archive_tag_info' => 1,
		'wt_show_archive_author_info' => 1,
		'wt_bg_img' => 0,		
		'wt_custom_bg' => '',	
		'wt_bg_color' => '',
		'wt_primary_color' => '',	
		'wt_second_color' => '',		
		'wt_h1_fontsize' => '',
		'wt_h2_fontsize' => '',
		'wt_h3_fontsize' => '',	
		'wt_h4_fontsize' => '',	
		'wt_h5_fontsize' => '',	
		'wt_h6_fontsize' => '',	
		'wt_text_fontsize' => '',	
		'wt_h1_fontstyle' => '',
		'wt_h2_fontstyle' => '',
		'wt_h3_fontstyle' => '',
		'wt_h4_fontstyle' => '',
		'wt_h5_fontstyle' => '',
		'wt_h6_fontstyle' => '',	
		'wt_text_fontstyle' => '',
		'wt_h1_lineheight' => '',
		'wt_h2_lineheight' => '',
		'wt_h3_lineheight' => '',
		'wt_h4_lineheight' => '',
		'wt_h5_lineheight' => '',
		'wt_h6_lineheight' => '',
		'wt_text_lineheight' => '',
		'wt_h1_marginbottom' => '',	
		'wt_h2_marginbottom' => '',	
		'wt_h3_marginbottom' => '',	
		'wt_h4_marginbottom' => '',	
		'wt_h5_marginbottom' => '',	
		'wt_h6_marginbottom' => '',	
		'wt_text_font_name' => '',
		'wt_headings_font_name' => '',
		'wt_headings_color' => '',	
		'wt_text_color' => '',
		'wt_links_color' => '',
		'wt_links_hover_color' => '',		
		'wt_footer_headings_color' => '',
		'wt_footer_text_color' => '',			
		'wt_custom_css' => '',
		'wt_meta_keywords' => '',
		'wt_meta_description' => '',
		'wt_google_verification' => '',
		'wt_bing_verification' => '',	
		'wt_header_ad468' => '<a href='.get_site_url().'><img src='.get_template_directory_uri().'/images/ad468.png /></a>',
		'wt_header_code' => '',
		'wt_footer_text_left' => '&copy;'. date('Y') . ' '. get_bloginfo('name'),
		'wt_footer_text_right' => 'Designed by <a href="http://wellthemes.com">WellThemes.com</a>',
		'wt_footer_code' => ''		
	);
	return $options;
}

/**
 * Sanitize and validate options
 */
function wt_validate_options( $input ) {
	$submit = ( ! empty( $input['submit'] ) ? true : false );
	$reset = ( ! empty( $input['reset'] ) ? true : false );
	if( $submit ) :	
		
		$input['wt_logo_url'] = esc_url_raw($input['wt_logo_url']);
		$input['wt_favicon'] = esc_url_raw($input['wt_favicon']);
		$input['wt_apple_touch'] = esc_url_raw($input['wt_apple_touch']);		
		$input['wt_custom_bg'] = esc_url_raw($input['wt_custom_bg']);
		$input['wt_rss_url'] = esc_url_raw($input['wt_rss_url']);
		$input['wt_twitter_url'] = esc_url_raw($input['wt_twitter_url']);
		$input['wt_fb_url'] = esc_url_raw($input['wt_fb_url']);
		$input['wt_contact_url'] = esc_url_raw($input['wt_contact_url']);
		$input['wt_contact_email'] = wp_filter_nohtml_kses($input['wt_contact_email']);
		$input['wt_contact_subject'] = wp_kses_stripslashes($input['wt_contact_subject']);
		$input['wt_text_color'] = wp_filter_nohtml_kses($input['wt_text_color']);
		$input['wt_links_hover_color'] = wp_filter_nohtml_kses($input['wt_links_hover_color']);
		$input['wt_footer_headings_color'] = wp_filter_nohtml_kses($input['wt_footer_headings_color']);
		$input['wt_footer_text_color'] = wp_filter_nohtml_kses($input['wt_footer_text_color']);			
		$input['wt_bg_color'] = wp_filter_nohtml_kses($input['wt_bg_color']);
		$input['wt_primary_color'] = wp_filter_nohtml_kses($input['wt_primary_color']);	
		$input['wt_second_color'] = wp_filter_nohtml_kses($input['wt_second_color']);			
		$input['wt_custom_css'] = wp_kses_stripslashes($input['wt_custom_css']);
		$input['wt_meta_keywords'] = wp_filter_post_kses($input['wt_meta_keywords']);
		$input['wt_meta_description'] = wp_filter_post_kses($input['wt_meta_description']);
		$input['wt_google_verification'] = wp_filter_post_kses($input['wt_google_verification']);
		$input['wt_bing_verification'] = wp_filter_post_kses($input['wt_bing_verification']);
		$input['wt_header_ad468'] = wp_kses_stripslashes($input['wt_header_ad468']);
		$input['wt_header_code'] = wp_kses_stripslashes($input['wt_header_code']);
		$input['wt_footer_text_left'] = wp_kses_stripslashes($input['wt_footer_text_left']);
		$input['wt_footer_text_right'] = wp_kses_stripslashes($input['wt_footer_text_right']);
		$input['wt_footer_code'] = wp_kses_stripslashes($input['wt_footer_code']);
		
		if ( ! isset( $input['wt_header_top'] ) )
			$input['wt_header_top'] = null;
		$input['wt_header_top'] = ( $input['wt_header_top'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_slider'] ) )
			$input['wt_show_slider'] = null;
		$input['wt_show_slider'] = ( $input['wt_show_slider'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['wt_show_sf_cats'] ) )
			$input['wt_show_sf_cats'] = null;
		$input['wt_show_sf_cats'] = ( $input['wt_show_sf_cats'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['wt_show_carousel'] ) )
			$input['wt_show_carousel'] = null;
		$input['wt_show_carousel'] = ( $input['wt_show_carousel'] == 1 ? 1 : 0 );

		if ( ! isset( $input['wt_show_feat_gallery'] ) )
			$input['wt_show_feat_gallery'] = null;
		$input['wt_show_feat_gallery'] = ( $input['wt_show_feat_gallery'] == 1 ? 1 : 0 );		
		
		if ( ! isset( $input['wt_show_other_posts'] ) )
			$input['wt_show_other_posts'] = null;
		$input['wt_show_other_posts'] = ( $input['wt_show_other_posts'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_author_info'] ) )
			$input['wt_show_author_info'] = null;
		$input['wt_show_author_info'] = ( $input['wt_show_author_info'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_related_posts'] ) )
			$input['wt_show_related_posts'] = null;
		$input['wt_show_related_posts'] = ( $input['wt_show_related_posts'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_post_social'] ) )
			$input['wt_show_post_social'] = null;
		$input['wt_show_post_social'] = ( $input['wt_show_post_social'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_page_author_info'] ) )
			$input['wt_show_page_author_info'] = null;
		$input['wt_show_page_author_info'] = ( $input['wt_show_page_author_info'] == 1 ? 1 : 0 );	
				
		if ( ! isset( $input['wt_show_page_meta'] ) )
			$input['wt_show_page_meta'] = null;
		$input['wt_show_page_meta'] = ( $input['wt_show_page_meta'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_page_comments'] ) )
			$input['wt_show_page_comments'] = null;
		$input['wt_show_page_comments'] = ( $input['wt_show_page_comments'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_page_social'] ) )
			$input['wt_show_page_social'] = null;
		$input['wt_show_page_social'] = ( $input['wt_show_page_social'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_img_meta'] ) )
			$input['wt_show_img_meta'] = null;
		$input['wt_show_img_meta'] = ( $input['wt_show_img_meta'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_img_comments'] ) )
			$input['wt_show_img_comments'] = null;
		$input['wt_show_img_comments'] = ( $input['wt_show_img_comments'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_img_social'] ) )
			$input['wt_show_img_social'] = null;
		$input['wt_show_img_social'] = ( $input['wt_show_img_social'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_archive_cat_info'] ) )
			$input['wt_show_archive_cat_info'] = null;
		$input['wt_show_archive_cat_info'] = ( $input['wt_show_archive_cat_info'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_archive_tag_info'] ) )
			$input['wt_show_archive_tag_info'] = null;
		$input['wt_show_archive_tag_info'] = ( $input['wt_show_archive_tag_info'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['wt_show_archive_author_info'] ) )
			$input['wt_show_archive_author_info'] = null;
		$input['wt_show_archive_author_info'] = ( $input['wt_show_archive_author_info'] == 1 ? 1 : 0 );		
		
		$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 0 ) );
		$cat_ids = array();
		foreach( $categories as $category )
			$cat_ids[] = $category->term_id;
						
		if( !in_array( $input['wt_carousel_category'], $cat_ids ) && ( $input['wt_carousel_category'] != 0 ) )
			$input['wt_carousel_category'] = $options['wt_carousel_category'];
			
		if( !in_array( $input['wt_slider_category'], $cat_ids ) && ( $input['wt_slider_category'] != 0 ) )
			$input['wt_slider_category'] = $options['wt_slider_category'];
		
		if( !in_array( $input['wt_sf_cat1'], $cat_ids ) && ( $input['wt_sf_cat1'] != 0 ) )
			$input['wt_sf_cat1'] = $options['wt_sf_cat1'];
			
		if( !in_array( $input['wt_sf_cat2'], $cat_ids ) && ( $input['wt_sf_cat2'] != 0 ) )
			$input['wt_sf_cat2'] = $options['wt_sf_cat2'];
			
		if( !in_array( $input['wt_feat_cat1'], $cat_ids ) && ( $input['wt_feat_cat1'] != 0 ) )
			$input['wt_feat_cat1'] = $options['wt_feat_cat1'];
			
		if( !in_array( $input['wt_feat_cat2'], $cat_ids ) && ( $input['wt_feat_cat2'] != 0 ) )
			$input['wt_feat_cat2'] = $options['wt_feat_cat2'];
		
		if( !in_array( $input['wt_feat_cat3'], $cat_ids ) && ( $input['wt_feat_cat3'] != 0 ) )
			$input['wt_feat_cat3'] = $options['wt_feat_cat3'];
			
		if( !in_array( $input['wt_feat_cat4'], $cat_ids ) && ( $input['wt_feat_cat4'] != 0 ) )
			$input['wt_feat_cat4'] = $options['wt_feat_cat4'];
			
		if( !in_array( $input['wt_feat_cat5'], $cat_ids ) && ( $input['wt_feat_cat5'] != 0 ) )
			$input['wt_feat_cat5'] = $options['wt_feat_cat5'];
						
		if( !in_array( $input['wt_gallery_category'], $cat_ids ) && ( $input['wt_gallery_category'] != 0 ) )
			$input['wt_gallery_category'] = $options['wt_gallery_category'];			
					
		return $input;
		
	elseif( $reset ) :
		$input = wt_default_options();
		return $input;
		
	endif;
}

if ( ! function_exists( 'wt_get_option' ) ) :
/**
 * Used to output theme options is an elegant way
 * @uses get_option() To retrieve the options array
 */
function wt_get_option( $option ) {
	$options = get_option( 'wt_options', wt_default_options() );
	return $options[ $option ];
}
endif;