<?php
/**
 * The template for displaying the single column featured posts.
 * Gets the category for the posts from the theme options. 
 * If no category is selected, displays the latest posts.
 *
 * @package  WellThemes
 * @file     feat-singlecol1.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 */
?>
<?php	
	$sf1_cat_id = wt_get_option('wt_sf_cat1');														//get category id		
	
	if ( $sf1_cat_id == 0 ) {																		//no category is selected, get latest posts
		$post_query1 = 'posts_per_page=1&ignore_sticky_posts=1';									//get the main post
		$post_query2 = 'posts_per_page=3&offset=1&ignore_sticky_posts=1';							//get 3 more posts
	} else {																						//get category posts
		$post_query1 = 'cat='.$sf1_cat_id.'&posts_per_page=1&ignore_sticky_posts=1';				//get  main post
		$post_query2 = 'cat='.$sf1_cat_id.'&posts_per_page=3&offset=1&ignore_sticky_posts=1';		//get 3 more posts
		$sf1_cat_name = get_cat_name($sf1_cat_id);													//get category name
		$sf1_cat_url = get_category_link($sf1_cat_id );												//get category url.
	}	
?>

<div class="category one-half">

	<h3>
		<?php
				if ($sf1_cat_id == 0 ) {									//no category is selected, display text latest.
					 _e('Latest Posts', 'wellthemes');						
				} else {													//display category name and url
					?>
					<a href="<?php echo esc_url( $sf1_cat_url ); ?>" ><?php echo $sf1_cat_name; ?></a>
					<?php
				}						
			?>
	</h3>
	
	<?php query_posts( $post_query1 ); //run first query?>
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>	
				<article class="feat-post">
					<?php if ( has_post_thumbnail() ) {	?>
						<div class="overlay">
							<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'wt-feat-thumb' );?></a>	
						</div>	
					<?php } ?>					
						<h4>								
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'wellthemes'), the_title_attribute('echo=0')); ?>">
							<?php 
								// display only first 60 characters in the title.	
								$short_title = mb_substr(the_title('','',FALSE),0, 60);
								echo $short_title; 
								if (strlen($short_title) > 59){ 
									echo '...'; 
								} 
							?>	
							</a>
						</h4>								
								
						<div class="entry-meta">
							<span class="date"><?php the_time('M j'); ?> </span>
							<?php if ( comments_open() ) : ?>
								<span class="comments"><?php comments_popup_link( __('no comments', 'wellthemes'), __( '1 comment', 'wellthemes'), __('% comments', 'wellthemes')); ?></span>		
							<?php endif; ?>
						</div>
						<p>
							<?php 
								// display only first 120 characters in the excerpt.								
								$excerpt = get_the_excerpt();																
								echo mb_substr($excerpt,0, 120);									
								if (strlen($excerpt) > 119){ 
									echo '...'; 
								} 
							?>
						</p>	
				</article>
				<?php endwhile; ?>
			<?php endif; ?>					
		<?php wp_reset_query();		//reset the query ?>
	
	<div class="more-posts">
		<?php query_posts( $post_query2 ); //run second query?>	
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>	
					<article class="item-post">
						
						<?php if ( has_post_thumbnail() ) {	?>
							<div class="overlay">
								<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('wt-small-thumb', array('title' => ''.get_the_title().'' )); ?></a>
							</div>
						<?php } ?>
						
						<div class="post-right">
							<h5>
								<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'wellthemes'), the_title_attribute('echo=0')); ?>">
									<?php 
										//display only first 50 characters in the title.
										$short_title = mb_substr(the_title('','',FALSE),0,50);
										echo $short_title; 
										if (strlen($short_title) > 49){ 
											echo '...'; 
										} 
									?>	
								</a>							
							</h5>
				
							<div class="entry-meta">
								<span class="date"><?php the_time('M j'); ?></span> 
								<?php if ( comments_open() ) : ?>
									<span class="comments"><?php comments_popup_link( __('no comments', 'wellthemes'), __( '1 comment', 'wellthemes'), __('% comments', 'wellthemes')); ?></span>
								<?php endif; ?>
							</div>
						</div> <!-- /post-right -->
					</article>
				<?php endwhile; ?>
			<?php endif; ?>					
		<?php wp_reset_query();		//reset the query ?>	
	</div>

</div>