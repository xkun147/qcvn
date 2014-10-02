<?php
if ( is_singular()) {
      
      $layout = get_post_meta($post->ID, 'mom_page_layout', TRUE);
      if(function_exists('is_bbpress') && is_bbpress()) {
	if ($layout == '') { $layout = mom_option('bbpress_layout');}
      } else {
	if ($layout == '') { $layout = mom_option('main_layout');}
      }

} elseif (function_exists('is_bbpress') && is_bbpress()) {
	$layout = mom_option('bbpress_layout');
} else {
	$layout = mom_option('main_layout');  
}
    
   if (strpos($layout,'both') !== false) {
?>
          <div class="sidebar secondary-sidebar">
            <?php if (is_singular()) {
		if(function_exists('is_bbpress') && is_bbpress()) {
		    $custom_sidebar = mom_option('bbpress_left_sidebar');
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'left-sidebar' );
		    }
		} else {
		  $custom_sidebar = get_post_meta($post->ID, 'mom_left_sidebar', TRUE);
		  if (!empty($custom_sidebar)) {
		      dynamic_sidebar($custom_sidebar);		    
		  } else {
		      dynamic_sidebar( 'left-sidebar' );
		  }
		}
	    } elseif (is_category()){
		$cat_data = get_option("category_".get_query_var('cat'));
		$custom_sidebar = isset($cat_data['sidebarl']) ? $cat_data['sidebarl'] :'';
		if ($custom_sidebar == '') {
		    $custom_sidebar = mom_option('cat_sidebarl');
		}
		if (!empty($custom_sidebar)) {
		    dynamic_sidebar($custom_sidebar);		    
		} else {
		    dynamic_sidebar( 'left-sidebar' );
		}
	    } elseif(function_exists('is_bbpress') && is_bbpress()) {
		    $custom_sidebar = mom_option('bbpress_left_sidebar');
		    if (!empty($custom_sidebar)) {
			dynamic_sidebar($custom_sidebar);		    
		    } else {
			dynamic_sidebar( 'left-sidebar' );
		    }
	    } else {
		if ( is_active_sidebar( 'left-sidebar' ) ) {
		    dynamic_sidebar( 'left-sidebar' );
		}
	    } ?>

            </div> <!--main sidebar-->
            <div class="clear"></div>
<?php }