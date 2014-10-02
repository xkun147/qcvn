<?php
/*
Template Name: Certification
*/
 
/*-----CHÚNG TA SẼ VIẾT CODE PHÍA DƯỚI NÀY-----*/
 if (function_exists('is_bbpress') && is_bbpress()) {
            get_template_part( 'bbpress', 'page' );
} else { ?>
<?php
    //Page settings
    $d_breacrumb = get_post_meta(get_the_ID(), 'mom_disbale_breadcrumb', true);
    $hpt = get_post_meta(get_the_ID(), 'mom_hide_pagetitle', true);
    $PS = get_post_meta(get_the_ID(), 'mom_page_share', true);
    $PC = get_post_meta(get_the_ID(), 'mom_page_comments', true);
    //Page Layout
    $custom_page = get_post_meta(get_the_ID(), 'mom_custom_page', true);
    $layout = get_post_meta(get_the_ID(), 'mom_page_layout', true);
    $right_sidebar = get_post_meta(get_the_ID(), 'mom_right_sidebar', true);
    $left_sidebars = get_post_meta(get_the_ID(), 'mom_left_sidebar', true);
?>
<?php get_header(); ?>
    <div class="inner">
        <?php if ($layout == 'fullwidth') { ?>
                <?php if ($d_breacrumb != true) { ?>
                <div class="category-title">
                        <?php mom_breadcrumb(); ?>
                </div>
                <?php } ?>
                <?php if ($custom_page) { ?>
                    
 <!--        Hiển thị danh sách giấy chứng nhận-->
                                <?php
                                $temp = $wp_query;
                                $wp_query = null;
                                $wp_query = new WP_Query();
                                $wp_query->query('showposts=6&post_type=to-chuc'.'&paged='.$paged);
                                $count = 0;
                                ?>
                                <?php while ($wp_query->have_posts()):$wp_query->the_post();$count++?>
                                    <table id="rt1" class="rt cf">
                                        <thead class="cf">
                                        <tr>
                                            <th><a href="<?php the_permalink(); ?>"><?php echo $count?>. <?php the_title(); ?></a></th>
                                            <th><?php echo get_post_meta( $post->ID, 'wpcf-auditee-name', true ); ?></th>
                                            <th><?php echo get_post_meta( $post->ID, 'wpcf-auditee-dia-chi', true ); ?></th>
                                            <th colspan="2"><?php echo get_post_meta( $post->ID, 'wpcf-auditee-address', true ); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $child_posts = types_child_posts('giay-chung-nhan');?>
                                            <?php foreach ($child_posts as $child_post) :?>
                                            <?php $parent_id = wpcf_pr_post_get_belongs($child_post->ID, ‘to-chuc’);
echo get_the_title($parent_id)."\n"; ?>
                                                <tr>
                                                    <td><?php echo $child_post->post_title;?></td>
                                                    <td><?php echo $child_post->fields['certification-pham-vi'];?></td>
                                                    <td><?php echo $child_post->fields['certification-scope'];?></td>
                                                    <td><?php $start_date = $child_post->fields['certification-ngay-cap']; echo $start_date = strftime("%d/%m/%Y", $start_date);?></td>
                                                    <td><?php $end_date = $child_post->fields['certification-ngay-het-han']; echo $end_date = strftime("%d/%m/%Y", $end_date);?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endwhile; ?>
                                <?php wp_pagenavi(); ?>
                                <?php
                                $wp_query = null;
                                $wp_query = $temp;  // Reset
                                ?>
                                <!--end danh sách giấy chứng nhận -->

                    <?php wp_reset_query(); ?>
                <?php } else { ?>
                        <div class="base-box page-wrap">
                        <?php if ($hpt != true) { ?><h1 class="page-title"><?php the_title(); ?></h1><?php } ?>
                        <div class="entry-content">
                    <!--        Hiển thị danh sách giấy chứng nhận-->
                                <?php
                                $temp = $wp_query;
                                $wp_query = null;
                                $wp_query = new WP_Query();
                                $wp_query->query('showposts=6&post_type=to-chuc'.'&paged='.$paged);
                                $count = 0;
                                ?>
                                <?php while ($wp_query->have_posts()):$wp_query->the_post();$count++?>
                                    <table id="rt1" class="rt cf">
                                        <thead class="cf">
                                        <tr>
                                            <th><a href="<?php the_permalink(); ?>"><?php echo $count?>. <?php the_title(); ?></a></th>
                                            <th><?php echo get_post_meta( $post->ID, 'wpcf-auditee-name', true ); ?></th>
                                            <th><?php echo get_post_meta( $post->ID, 'wpcf-auditee-dia-chi', true ); ?></th>
                                            <th colspan="2"><?php echo get_post_meta( $post->ID, 'wpcf-auditee-address', true ); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $child_posts = types_child_posts('giay-chung-nhan');?>
                                            <?php foreach ($child_posts as $child_post) :?>
                                            <?php $parent_id = wpcf_pr_post_get_belongs($child_post->ID, ‘to-chuc’);
echo get_the_title($parent_id)."\n"; ?>
                                                <tr>
                                                    <td><?php echo $child_post->post_title;?></td>
                                                    <td><?php echo $child_post->fields['certification-pham-vi'];?></td>
                                                    <td><?php echo $child_post->fields['certification-scope'];?></td>
                                                    <td><?php $start_date = $child_post->fields['certification-ngay-cap']; echo $start_date = strftime("%d/%m/%Y", $start_date);?></td>
                                                    <td><?php $end_date = $child_post->fields['certification-ngay-het-han']; echo $end_date = strftime("%d/%m/%Y", $end_date);?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endwhile; ?>
                                <?php wp_pagenavi(); ?>
                                <?php
                                $wp_query = null;
                                $wp_query = $temp;  // Reset
                                ?>
                                <!--end danh sách giấy chứng nhận -->
                    <?php wp_reset_query(); ?>
                        <?php if ($PS == true) mom_posts_share(get_the_ID(), get_permalink()); ?>
                        </div> <!-- entry content -->
                        </div> <!-- base box -->
                        <?php if ($PC == true) comments_template(); ?>        
                <?php } // end cutom page  ?>
        <?php } else { //if not full width ?>
            <div class="main_container">
           <div class="main-col">
                <?php if ($d_breacrumb != true) { ?>
                <div class="category-title">
                        <?php mom_breadcrumb(); ?>
                </div>
                <?php } ?>
<?php if ($custom_page) { ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php the_content(); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'theme' ), 'after' => '</div>' ) ); ?>
                    <?php endwhile; // end of the loop. ?>
                    <?php wp_reset_query(); ?>
<?php } else { ?>
        <div class="base-box page-wrap">
           <?php if ($hpt != true) { ?><h1 class="page-title"><?php the_title(); ?></h1><?php } ?>
        <div class="entry-content">
                    <!--        Hiển thị danh sách giấy chứng nhận-->
                                <?php
                                $temp = $wp_query;
                                $wp_query = null;
                                $wp_query = new WP_Query();
                                $wp_query->query('showposts=6&post_type=to-chuc'.'&paged='.$paged);
                                $count = 0;
                                ?>
                                <?php while ($wp_query->have_posts()):$wp_query->the_post();$count++?>
                                    <table id="rt1" class="rt cf">
                                        <thead class="cf">
                                        <tr>
                                            <th><?php echo $count?>. <?php the_title(); ?></th>
                                            <th><?php echo get_post_meta( $post->ID, 'wpcf-auditee-name', true ); ?></th>
                                            <th><?php echo get_post_meta( $post->ID, 'wpcf-auditee-dia-chi', true ); ?></th>
                                            <th colspan="2"><?php echo get_post_meta( $post->ID, 'wpcf-auditee-address', true ); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $child_posts = types_child_posts('giay-chung-nhan');?>
                                            <?php foreach ($child_posts as $child_post) :?>
                                            <?php $parent_id = wpcf_pr_post_get_belongs($child_post->ID, ‘to-chuc’);
echo get_the_title($parent_id)."\n"; ?>
                                                <tr>
                                                    <td><?php echo $child_post->post_title;?></td>
                                                    <td><?php echo $child_post->fields['certification-pham-vi'];?></td>
                                                    <td><?php echo $child_post->fields['certification-scope'];?></td>
                                                    <td><?php $start_date = $child_post->fields['certification-ngay-cap']; echo $start_date = strftime("%d/%m/%Y", $start_date);?></td>
                                                    <td><?php $end_date = $child_post->fields['certification-ngay-het-han']; echo $end_date = strftime("%d/%m/%Y", $end_date);?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php endwhile; ?>
                                
                                <?php
                                $wp_query = null;
                                $wp_query = $temp;  // Reset
                                ?>
                                <!--end danh sách giấy chứng nhận -->


                                <?php 
                                $args = array( 
                                'post_type' => 'giay-chung-nhan', 
                                'tax_query' => array( 
                                    array( 'taxonomy' => 'linh-vuc', 
                                            'field' => 'term_id', 
                                            'terms' => '54' ) 
                                            ) ); 
                                $words = new WP_Query( $args ); 
                                if( $words->have_posts() ) { 
                                    while( $words->have_posts() ) { 
                                        $words->the_post(); ?>
                                        <h1><?php the_title() ?></h1> 
                                        <div class='content'> <?php the_content() ?> </div> 
                                        <?php 
                                    } 
                                } 
                                else { echo 'Chưa có giấy chứng nhận trong lĩnh vực này!'; } ?> 
                    <?php wp_reset_query(); ?>
        <?php if ($PS == true) mom_posts_share(get_permalink()); ?>
        </div> <!-- entry content -->
        </div> <!-- base box -->
        <?php if ($PC == true) comments_template(); ?>        
<?php } ?>
            </div> <!--main column-->
            <?php get_sidebar('secondary'); ?>
            <div class="clear"></div>
</div> <!--main container-->            
<?php get_sidebar(); ?>
<?php }// end full width ?>             
</div> <!--main inner-->
            
<?php get_footer(); ?>
<?php } ?>