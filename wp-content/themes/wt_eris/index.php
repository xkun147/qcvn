<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package  WellThemes
 * @file     index.php
 * @author   Well Themes Team
 * @link 	 http://wellthemes.com
 */
?>
<?php get_header(); ?>

	<section id="primary">
		<div id="content" role="main">
			<?php
				if (is_home() && $paged < 2 ){
					//include slider
					if ( wt_get_option( 'wt_show_slider' ) == 1 ) {
						get_template_part( 'includes/feat-slider' );
					}
			
					//include carousel
					if ( wt_get_option( 'wt_show_carousel' ) == 1 ) {
						get_template_part( 'includes/feat-carousel' );
					}
			
					//include single column featured categories
					if ( wt_get_option( 'wt_show_sf_cats' ) == 1 ) {
				?>
					<div id="feat-singlecol">
					<?php
						get_template_part( 'includes/feat-singlecol1' );
						get_template_part( 'includes/feat-singlecol2' );
					?>
					</div>
				<?php }	?>		
		
				<div id="featured-cats">
				<?php
					//include featured categories
					if ( wt_get_option( 'wt_feat_cat1' ) != 0 ) {
						get_template_part( 'includes/feat-cat1' );
					}
			
					if ( wt_get_option( 'wt_feat_cat2' ) != 0 ) {
						get_template_part( 'includes/feat-cat2' );
					}
			
					if ( wt_get_option( 'wt_feat_cat3' ) != 0 ) {
						get_template_part( 'includes/feat-cat3' );
					}
			
					if ( wt_get_option( 'wt_feat_cat4' ) != 0 ) {
						get_template_part( 'includes/feat-cat4' );
					}
			
					if ( wt_get_option( 'wt_feat_cat5' ) != 0 ) {
						get_template_part( 'includes/feat-cat5' );
					}			
				?>
				</div>
										
			<?php			
				//include featured gallery
				if ( wt_get_option( 'wt_show_feat_gallery' ) == 1 ) {
					get_template_part( 'includes/feat-gallery' ); 
				}
			
			} //is_home			
			
			//include latest posts list
			if ( wt_get_option( 'wt_show_other_posts' ) == 1 ) {?>
				<div id="feat-postlist">
					<h3><?php _e( 'Latest Posts', 'wellthemes' ); ?></h3>
					<?php
						while ( have_posts() ) : the_post();
							/* Include the Post-Format-specific template for the content.
							* If you want to overload this in a child theme then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/
							get_template_part( 'content', 'excerpt' );
						endwhile;
				
						wt_pagination();			
					?>
				</div>
			<?php } ?>		
					
		</div><!-- /content -->
	</section><!-- /primary -->
	
<?php get_sidebar('left'); ?>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>