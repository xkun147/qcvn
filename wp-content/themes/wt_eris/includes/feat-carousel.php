<?php
/**
 * The template for displaying the carousel posts.
 * Gets the category for the posts from the theme options. 
 * If no category is selected, displays the latest posts.
 *
 *
 * @package  WellThemes
 * @file     footer.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 *
 */
?>
<?php
	$carousel_cat_id = wt_get_option('wt_carousel_category');							//get category id	
	if ( $carousel_cat_id == 0 ) {
		$post_query = 'posts_per_page=10&ignore_sticky_posts=1';
	} else {
		$post_query = 'cat='.$carousel_cat_id.'&posts_per_page=10&ignore_sticky_posts=1';
	}
?>

<div id="feat-carousel">

	<div class="carousel-nav">
		<a class="prev" href="#">Previous</a>	
		<a class="next" href="#">Next</a>
	</div>
	
	
	<div class="carousel-posts">	
		<ul>
			<?php query_posts( $post_query ); if( have_posts() ) : while( have_posts() ) : the_post(); ?>
			
			<li>
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="thumbnail overlay">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'wellthemes'), the_title_attribute('echo=0')); ?>">
							<?php the_post_thumbnail( 'wt-archive-thumb' ); ?>
						</a>
					</div>
				<?php } ?>	
				
				<div class="wrap">
					<h5> 
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'wellthemes'), the_title_attribute('echo=0')); ?>">
						<?php 
							// display only first 40 characters in the title.	
							$short_title = mb_substr(the_title('','',FALSE),0,40);
							echo $short_title; 
							if (strlen($short_title) > 39){ 
								echo '...'; 
							} 
						?>	
						</a>
					</h5>				
				</div><!-- wrap -->
			</li>
			
			<?php endwhile; endif;?>
			<?php wp_reset_query();?>
		</ul>				
	</div>
		
</div><!-- /carousel -->