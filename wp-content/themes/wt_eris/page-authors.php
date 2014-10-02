<?php
/**
 * Template Name: Authors Page
 * Description: A Page Template to display archives without the sidebar.
 *
 * @package  WellThemes
 * @file     page-authors.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 */
?>
<?php get_header(); ?>
<section id="primary">
	<div id="content" role="main">
	
	<?php if (have_posts()) : ?>
		<?php while ( have_posts() ) : the_post(); ?>				
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>						
				</div><!-- /entry-content -->
			</article><!-- /post-<?php the_ID(); ?> -->
		<?php endwhile; // end of the loop. ?>
	<?php endif ?>

	<section class="authors-list">
		<?php wellthemes_authors_list(); ?>
	</section>

	</div><!-- /content -->
</section><!-- /primary -->

<?php get_sidebar('left'); ?>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>