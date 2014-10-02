<?php
/**
 * The template for displaying the featured category posts on homepage.
 * Gets the category for the posts from the theme options. 
 * If no category is selected, does not display.
 *
 * @package  WellThemes
 * @file     feat-gallery.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 */
?>
<?php
	$gallery_cat_id = wt_get_option('wt_gallery_category');							//get category id		
	$query = new WP_Query(array( 'showposts' => '-1', 'post_type' => 'post', 'cat' => $gallery_cat_id));
	$max_number = 12;
	$size= "thumbnail";			
?>
<section id="feat-gallery">
	<h3 class="title">Gallery</h3>
	<div class="gallery-images">
		<ul>
		
		<?php		
			$i = 0;		
			foreach($query->posts as $post){			
				if ( 	$images = get_children(array(
						'post_parent' => $post->ID,					
						'post_mime_type' => 'image',))
					){
					
						foreach( $images as $image ) {
							$attachment_url = wp_get_attachment_url($image->ID);
							$attachment_image = wp_get_attachment_image( $image->ID, $size );						
							echo '<li><div class="gallery-overlay"><a class="attachment-wt-medium-thumb" href="'.$attachment_url.'" rel="lightbox[featured-gallery]">'.$attachment_image.'</a></div></li>';						
							if (++$i == $max_number) break 2;
						}					
					}					
				}
		?>
		</ul>
	</div>
	
</section>

