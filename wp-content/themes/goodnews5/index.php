<?php get_header(); ?>
        <div class="inner">
            <div class="main_container">
                <div class="main-col">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <?php mom_blog_post('', false, 245);
                    ?>
                <?php endwhile; ?>
                <?php  else:  ?>
                <!-- Else in here -->
                <?php  endif; ?>
                <?php mom_pagination(); ?>
                </div> <!--main column-->
                <?php get_sidebar('secondary'); ?>
            <div class="clear"></div>
            </div> <!--main container-->            
                <?php get_sidebar(); ?>
        </div> <!--main inner-->
<?php get_footer(); ?>