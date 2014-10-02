<?php
/**
 * The template for displaying the featured category posts on homepage.
 * Gets the category for the posts from the theme options. 
 * If no category is selected, does not display.
 *
 * @package  WellThemes
 * @file     feat-cat5.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 *
 */
?>
<?php
	$feat_cat5_id = wt_get_option('wt_feat_cat5');											//get category id														
	$post_query1 = 'cat='.$feat_cat5_id.'&posts_per_page=1&ignore_sticky_posts=1';				//get  main post
	$post_query2 = 'cat='.$feat_cat5_id.'&posts_per_page=4&offset=1&ignore_sticky_posts=1';	//get 4 more posts
	$feat_cat5_name = get_cat_name($feat_cat5_id);											//get category name
	$feat_cat5_url = get_category_link($feat_cat5_id );										//get category url.	
?>

<section class="feat-cat">
	<header class="cat-header">
		<h3><a href="<?php echo esc_url( $feat_cat5_url ); ?>" ><?php echo $feat_cat5_name; ?></a></h3>
	</header>
	
	<article class="one-half">
	<?php query_posts( $post_query1 ); //run first query ?>	
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>	
				
				<?php if ( has_post_thumbnail() ) {	?>
					<div class="overlay">
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'wt-feat-thumb' ); ?></a>
					</div>
				<?php } ?>
				
				<div class="wrap">
					<header class="entry-header">
						<h4>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'wellthemes'), the_title_attribute('echo=0')); ?>">
								<?php 
									//display only first 60 characters in the title.	
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
					</header>					
					<p>
						<?php 
							//display only first 140 characters in the excerpt.								
							$excerpt = get_the_excerpt();																
							echo mb_substr($excerpt,0, 140);									
							if (strlen($excerpt) > 139){ 
								echo '...'; 
							} 
						?>
					</p>	
				</div>
				
			<?php endwhile; ?>
		<?php endif; ?>					
	<?php wp_reset_query();		//reset the query ?>
	</article> <!-- left -->

	<div class="one-half last-col">
		<?php query_posts( $post_query2 ); //run first query ?>	
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>	
					
					<article class="item-post">
						<?php if ( has_post_thumbnail() ) {	?>
							<div class="overlay">
								<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('wt-small-thumb', array('title' => ''.get_the_title().'' )); ?></a>
							</div>
						<?php } ?>
						
						<div class="post-right">
							<header>
								<h5>
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'wellthemes'), the_title_attribute('echo=0')); ?>">
									<?php 
										//display only first 45 characters in the title.	
										$short_title = mb_substr(the_title('','',FALSE),0, 45);
										echo $short_title; 
										if (strlen($short_title) > 44){ 
											echo '...'; 
										} 
									?>	
									</a>
								</h5>
								<div class="entry-meta">
									<span class="date"><?php the_time('M j'); ?> </span>
									<?php if ( comments_open() ) : ?>
										<span class="comments"><?php comments_popup_link( __('no comments', 'wellthemes'), __( '1 comment', 'wellthemes'), __('% comments', 'wellthemes')); ?></span>	
									<?php endif; ?>
								</div>
							</header>
						</div>
					</article>
					
				<?php endwhile; ?>
			<?php endif; ?>					
		<?php wp_reset_query();		//reset the query ?>
	</div>
	
</section><!-- /category -->