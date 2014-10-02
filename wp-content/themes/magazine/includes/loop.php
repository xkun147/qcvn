<?php
/**
 * Template for generic post display.
 * @package themify
 * @since 1.0.0
 */
?>
<?php if(!is_single()){ global $more; $more = 0; } //enable more link ?>

<?php 
/** Themify Default Variables
 *  @var object */
global $themify; ?>

<?php themify_post_before(); // hook ?>

<article itemscope itemtype="http://schema.org/Article" id="post-<?php the_ID(); ?>" <?php post_class("post clearfix " . $themify->get_categories_as_classes(get_the_ID())); ?>>
	
	<?php themify_post_start(); // hook ?>
	
	<?php if ( $themify->hide_image != 'yes' ) : ?>

			<?php themify_before_post_image(); // Hook ?>

			<figure class="post-image <?php echo $themify->image_align; ?>">

				<?php if( themify_check( 'video_url' ) ): ?>

					<?php
					global $wp_embed;
					echo $wp_embed->run_shortcode('[embed]' . themify_get('video_url') . '[/embed]');
					?>

				<?php else: ?>

					<?php if( $post_image = themify_get_image($themify->auto_featured_image . $themify->image_setting . "w=".$themify->width."&h=".$themify->height) ) : ?>
						<?php if( 'yes' == $themify->unlink_image): ?>
							<?php echo $post_image; ?>
						<?php else: ?>
							<a href="<?php echo themify_get_featured_image_link(); ?>"><?php echo $post_image; ?><?php themify_zoom_icon(); ?></a>
						<?php endif; ?>
					<?php endif; // post image ?>

				<?php endif; // video url ?>

			</figure>

			<?php themify_after_post_image(); // Hook ?>

	<?php endif; // hide image ?>

	<div class="post-content">

		<?php if( $themify->hide_meta != 'yes' ): ?>
			<p class="post-meta entry-meta">
				<?php if($themify->hide_meta_category != 'yes'): ?>
					<span class="post-category"><?php the_category('/ ') ?></span>
				<?php endif; ?>
			</p>
		<?php endif; //post meta ?>

		<?php if($themify->hide_title != 'yes'): ?>
			<?php themify_before_post_title(); // Hook ?>
			<?php if($themify->unlink_title == 'yes'): ?>
				<h1 class="post-title entry-title" itemprop="name"><?php the_title(); ?></h1>
			<?php else: ?>
				<h1 class="post-title entry-title" itemprop="name"><a href="<?php echo themify_get_featured_image_link(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			<?php endif; //unlink post title ?>
			<?php themify_after_post_title(); // Hook ?> 
		<?php endif; //post title ?>

		<?php if( $themify->hide_date != 'yes' || $themify->hide_meta != 'yes' ): ?>
			<p class="post-meta entry-meta">

				<?php if( $themify->hide_meta != 'yes' ): ?>
					<?php if($themify->hide_meta_author != 'yes'): ?>
						<span class="author-avatar"><?php echo get_avatar( get_the_author_meta('user_email'), 30, '' ); ?></span>
						<span class="author-name"><?php echo themify_get_author_link() ?></span>
					<?php endif; ?>

					<?php if($themify->hide_meta_tag != 'yes'): ?>
						<?php the_tags(' <span class="post-tag">', ', ', '</span>'); ?>
					<?php endif; ?>

					<?php  if( !themify_get('setting-comments_posts') && comments_open() && $themify->hide_meta_comment != 'yes' ) : ?>
						<span class="post-comment"><?php comments_popup_link( __( '0 Comment', 'themify' ), __( '1 Comment', 'themify' ), __( '% Comments', 'themify' ) ); ?></span>
					<?php endif; //post comment ?>
				<?php endif; // post meta ?>

				<?php if( $themify->hide_date != 'yes' ): ?>
					 <time datetime="<?php the_time('o-m-d') ?>" class="post-date entry-date updated" itemprop="datePublished"><?php the_time(apply_filters('themify_loop_date', 'M j, Y')) ?></time>
				<?php endif; //post date ?>

			</p>
		<?php endif; //post date or post meta ?>

		<?php if( is_single() ) : ?>
			<?php get_template_part( 'includes/social-share'); ?>
		<?php endif; ?>

		<?php if( is_single() ) get_template_part( 'includes/before-content-widget' ); ?>
		
		<div class="entry-content" itemprop="articleBody">

		<?php if ( 'excerpt' == $themify->display_content && ! is_attachment() ) : ?>
	
			<?php the_excerpt(); ?>

			<?php if( themify_check('setting-excerpt_more') ) : ?>
				<p><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute('echo=0'); ?>" class="more-link"><?php echo themify_check('setting-default_more_text')? themify_get('setting-default_more_text') : __('More &rarr;', 'themify') ?></a></p>
			<?php endif; ?>
	
		<?php elseif ( 'none' == $themify->display_content && ! is_attachment() ) : ?>
	
		<?php else: ?>

			<?php the_content(themify_check('setting-default_more_text')? themify_get('setting-default_more_text') : __('More &rarr;', 'themify')); ?>
		
		<?php endif; //display content ?>

		</div><!-- /.entry-content -->
		
		<?php edit_post_link(__('Edit', 'themify'), '<span class="edit-button">[', ']</span>'); ?>
		
	</div>
	<!-- /.post-content -->
	<?php themify_post_end(); // hook ?>
	
</article>
<!-- /.post -->

<?php themify_post_after(); // hook ?>
