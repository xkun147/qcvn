<?php
require_once get_template_directory() . '/framework/main.php';
if (file_exists(get_template_directory() . '/demo/demo.php')) {
    	$detect = new Mobile_Detect;
	if(! $detect->isMobile()) {
            require_once get_template_directory() . '/demo/demo.php';
	}
}

function list_posts_by_taxonomy( $post_type, $taxonomy, $get_terms_args = array(), $wp_query_args = array() ){
    $tax_terms = get_terms( $taxonomy, $get_terms_args );
    if( $tax_terms ){
        foreach( $tax_terms  as $tax_term ){
            $query_args = array(
                'post_type' => $post_type,
                "$taxonomy" => $tax_term->slug,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'ignore_sticky_posts' => true
            );
            $query_args = wp_parse_args( $wp_query_args, $query_args );
 
            $my_query = new WP_Query( $query_args );
            if( $my_query->have_posts() ) { ?>
                <h2 id="<?php echo $tax_term->slug; ?>" class="tax_term-heading"><?php echo $tax_term->name; ?></h2>
                <ul>
                <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
                    <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
                </ul>
                <?php
            }
            wp_reset_query();
        }
    }
}	
?>