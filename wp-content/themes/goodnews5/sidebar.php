
            <div class="sidebar main-sidebar">
            <?php if (is_singular()) {
		if(function_exists('is_bbpress') && is_bbpress()) {
		    $custom_sidebar = mom_option('bbpress_right_sidebar');
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'right-sidebar' );
		    }
		} else {
		    global $post;
		    $custom_sidebar = get_post_meta($post->ID, 'mom_right_sidebar', TRUE);
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'right-sidebar' );
		    }
		}
	    } elseif (is_category()){
		$cat_data = get_option("category_".get_query_var('cat'));
		$custom_sidebar = isset($cat_data['sidebar']) ? $cat_data['sidebar'] :'';
		if ($custom_sidebar == '') {
		    $custom_sidebar = mom_option('cat_sidebar');
		}
		if (!empty($custom_sidebar)) {
		    dynamic_sidebar($custom_sidebar);		    
		} else {
		    dynamic_sidebar( 'right-sidebar' );
		}
	    } elseif(function_exists('is_bbpress') && is_bbpress()) {
		    $custom_sidebar = mom_option('bbpress_right_sidebar');
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'right-sidebar' );
		    }
		} else {
		if ( is_active_sidebar( 'right-sidebar' ) ) {
		    dynamic_sidebar( 'right-sidebar' );
		}
	    } ?>

            </div> <!--main sidebar-->
            <div class="clear"></div>