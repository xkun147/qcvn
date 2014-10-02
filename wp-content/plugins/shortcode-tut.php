<?php
/*
	Plugin Name: Shortcode 
	Plugin Author: XuanNQ
*/
	
	add_shortcode('product_by_id', 'create_shortcode_productbycategory');

    function create_shortcode_productbycategory($args) {
            extract($args);
            $product_query = new WP_Query( array(
                    'post_type' => 'giay-chung-nhan',
                    'posts_per_page' => $number,
                    'tax_query' => array(
                            array(
                                    'taxonomy' => 'linh-vuc',
                                    'field' => 'term_id',
                                    'terms' => $term_id
                            )
                    )
            ));
     	
            ob_start();
            if ( $product_query->have_posts() ) :
                    "<ol>";
                    while ( $product_query->have_posts() ) :
                            $product_query->the_post();?>
     
                                    <li><a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a></li>
     
                    <?php endwhile;
                    "</ol>";
            endif;
            $list_post = ob_get_contents(); //Lấy toàn bộ nội dung phía trên bỏ vào biến $list_post để return
     
            ob_end_clean();
     		 echo $term_id ."ok";

            return $list_post;

    }
    

