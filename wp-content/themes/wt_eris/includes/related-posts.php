<?php
$tags = wp_get_post_tags($post->ID);
if ($tags) {
	$tag_ids = array();
	foreach($tags as $single_tag) $tag_ids[] = $single_tag->term_id;

	$args=array(
		'tag__in' => $tag_ids,
		'post__not_in' => array($post->ID),
		'showposts'=> 3, //number of related posts
		'ignore_sticky_posts'=> 1
	);	
	
} else {

	$categories = get_the_category($post->ID);
	
	if ($categories) {
		$category_ids = array();
		foreach($categories as $single_category) $category_ids[] = $single_category->term_id;

		$args=array(
			'category__in' => $category_ids,
			'post__not_in' => array($post->ID),
			'showposts'=> 3,  //number of related posts
			'ignore_sticky_posts'=>1
		);
		
	}
}

if($args){

	$my_query = new wp_query($args);

	$post_count = 0;
	if( $my_query->have_posts() ) {
		echo '<div class="related-posts"><h3>Related Posts</h3><ul>';
		
		
		while ($my_query->have_posts()) {
			$my_query->the_post();
			
			$last = '';
			if (++$post_count  == 3) {
				$last = 'class="last-post"';
			}
     		?>		

			<li <?php echo $last; ?>>
				<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('wt-archive-thumb', array('title' => ''.get_the_title().'' )); ?></a>
				<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'wellthemes'), the_title_attribute('echo=0')); ?>">
						<?php 
							//display only first 50 characters in the title.	
							$short_title = mb_substr(the_title('','',FALSE),0, 30);
							echo $short_title; 
							if (strlen($short_title) > 29){ 
								echo '...'; 
							} 
						?>	
				</a></h4>
					
				
			</li>
		<?php
		}
		echo '</ul></div>';
	}
	 wp_reset_query();
	
}

?>