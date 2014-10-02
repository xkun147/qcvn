<?php
/**
 * Template Name: Archives Full
 * Description: A Page Template to display archives without the sidebar.
 *
 * @package  WellThemes
 * @file     page-archivesfull.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 */
?>

<?php get_header(); ?>
<div id="full-content">
<section id="primary">
	<div id="content" role="main">
		<?php if (have_posts()) :?>
			<?php while ( have_posts() ) : the_post(); ?>				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>
					<div class="entry-content">
						<?php the_content(); ?>						
					</div><!-- /entry-content -->
				</article><!-- /post-<?php the_ID(); ?> -->
			<?php endwhile; ?>
		<?php endif; ?>
		
		<div class="archive-columns">
		
			<div class="block">
			
				<div class="full-onethird">
					<h2><?php _e('Last 10 Posts', 'wellthemes') ?></h2>
					<ol class="archive-list">
						<?php $archive_10 = get_posts('numberposts=10');
						foreach($archive_10 as $post) : ?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
						<?php endforeach; ?>
					</ol>					
				</div>
			
				<div class="full-onethird">
					<h2><?php _e('Most Popular Tags:', 'wellthemes')?></h2>
						<?php wp_tag_cloud('number=10&format=list&topic_count_text_callback=default_topic_count_text&orderby=count&order=DESC'); ?>
				</div>
			
				<div class="full-onethird last-col">
					<h2><?php _e('Archives By Month:', 'wellthemes')?></h2>
					<ul class="sp-list unordered-list">
						<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
					</ul>
				</div>
			
			</div> <!-- block -->
			
			<div class="block">
				<div class="full-onethird">
					<h2><?php _e('Archives by Category:', 'wellthemes')?></h2>
					<ul class="archive-list">
						<?php wp_list_categories('title_li=') ?>
					</ul>
				</div>				
			
				<div class="full-onethird">
					<h2><?php _e('Pages:', 'wellthemes')?></h2>
					<ul class="pages">
						<?php wp_list_pages("title_li=" ); ?>
					</ul>
				</div>
				
				<div class="full-onethird last-col">
					<h2><?php _e('Search Archives:', 'wellthemes')?></h2>
					<div class="archive-search">
						<?php get_search_form(); ?>
					</div>
				</div>
			
			</div> <!-- block -->
		</div><!-- /archive-columns -->
		
	
	</div><!-- /content -->
</section><!-- /primary -->
<div id="full-content">
<?php get_footer(); ?>