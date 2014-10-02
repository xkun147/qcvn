<?php
/**
 * The template for displaying the featured slider on homepage.
 * Gets the category for the posts from the theme options. 
 * If no category is selected, displays the latest posts.
 *
 * @package  WellThemes
 * @file     feat-gallery.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 * 
 **/
	$slider_cat_id = wt_get_option('wt_slider_category');		//get category id
	$post_query = 'cat='.$slider_cat_id.'&posts_per_page=5';	
?>

<div id="wt-slider">
	<ul class="slides">
		<?php query_posts( $post_query ); ?>
			<?php if( have_posts() ) : ?>
				<?php while( have_posts() ) : the_post(); ?>
					
					<?php
						 if ( has_post_thumbnail()) { ?>
							<li>
								<a href="<?php the_permalink(); ?>" >
									<?php the_post_thumbnail( 'wt-slider-image', array('title' => '') ); ?>
								</a>
			
								<div class="slider-text">
									<h2><a href="<?php the_permalink(); ?>" >
										<?php $short_title = mb_substr(the_title('','',FALSE),0,30); ?>
										<?php echo $short_title; if (strlen($short_title) > 29){ echo '...'; } ?></a>
									</h2>
									<div class="clearfix"></div>
									<p>
									<?php 
										$excerpt = get_the_excerpt();																
										echo mb_substr($excerpt,0, 65);									
										if (strlen($excerpt) > 64){ 
											echo '...'; 
										} 
									?>
									</p>
								</div>									
							</li>
						<?php } ?>
				<?php endwhile; ?>
			<?php endif;?>
		<?php wp_reset_query();?>				
	</ul>
</div>