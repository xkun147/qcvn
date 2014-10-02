<?php
/**
 * The template for displaying content in the archive and search results template
 *
 * @package  WellThemes
 * @file     content-excerpt.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('wt-archive-thumb', array('title' => ''.get_the_title().'' )); ?></a>
	
	<div class="post-right">
	
		<header class="entry-header">
			<h2 class="entry-title">
				
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'wellthemes'), the_title_attribute('echo=0')); ?>">
					<?php 
						//display only first 70 characters in the title.	
						$short_title = mb_substr(the_title('','',FALSE),0, 70);
						echo $short_title; 
						if (strlen($short_title) > 69){ 
							echo '...'; 
						} 
					?>	
				</a>
									
			</h2>
		
			<div class="entry-meta">
				<span class="date"><?php the_time('F j'); ?> </span>
				<span class="category"><?php the_category(', ' ); ?></span> 
				<?php if ( comments_open() ) : ?>
					<span class="comments"><?php comments_popup_link( __('no comments', 'wellthemes'), __( '1 comment', 'wellthemes'), __('% comments', 'wellthemes')); ?></span>
				<?php endif; ?>	
			</div><!-- /entry-meta -->		
		
		</header><!-- /entry-header -->

		<div class="entry-content">
			<?php 
				//display only first 220 characters in the slide description.								
				$excerpt = get_the_excerpt();																
				echo mb_substr($excerpt,0, 220);									
				if (strlen($excerpt) > 219){ 
					echo '...'; 
				}
			?>
		</div><!-- /entry-content -->

		<footer class="entry-footer">

		</footer><!-- /entry-footer -->
		
	</div> <!-- /post-right -->
	
</article><!-- /post-<?php the_ID(); ?> -->
