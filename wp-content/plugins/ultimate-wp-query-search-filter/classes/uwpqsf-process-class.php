<?php
if(!class_exists('uwpqsfprocess')){
  class uwpqsfprocess{
	function __construct(){
	 //script
	 add_action( 'wp_enqueue_scripts', array($this, 'ufront_js') );
	 //front ajax
	 add_action( 'wp_ajax_nopriv_uwpqsf_ajax', array($this, 'uwpqsf_ajax') );
	 add_action( 'wp_ajax_uwpqsf_ajax', array($this, 'uwpqsf_ajax') );
	 add_action( 'pre_get_posts', array($this ,'uwpqsf_search_query'),1000);
	}

	function get_uwqsf_cmf($id, $getcmf){
			$options = get_post_meta($id, 'uwpqsf-option', true);
			$cmfrel = isset($options[0]['cmf']) ? $options[0]['cmf'] : 'AND';
			
			if(isset($getcmf)){
				$cmf=array('relation' => $cmfrel,'');
				foreach($getcmf as  $v){
				   $classapi = new uwpqsfclass();	
					$campares = $classapi->cmf_compare();//avoid tags stripped 
					if(!empty($v['value'])){
					if($v['value'] == 'uwpqsfcmfall'){
							$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => 'get_all_cmf_except_me',
								'compare' => '!='
						);
						  
						}
					elseif( $v['compare'] == '11'){
						$range = explode("-", strip_tags( stripslashes($v['value'])));
						$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => $range,
								'type' => 'numeric',
								'compare' => 'BETWEEN'
						);
					  
					  }
					  elseif( $v['compare'] == '12'){
						$range = explode("-", strip_tags( stripslashes($v['value'])));
						$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => $range,
								'type' => 'numeric',
								'compare' => 'NOT BETWEEN'
						);
					  
					  }elseif( $v['compare'] == '9' || $v['compare'] == '10' ){
						foreach($campares as $ckey => $cval)
							{  if($ckey == $v['compare'] ){ $safec = $cval;}        }
							$trimmed_array=array_map('trim',$v['value']);
						//implode(',',$v['value'])
						$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' =>$trimmed_array,
								'compare' => $safec 
						);
					  
					  }elseif( $v['compare'] == '3' || $v['compare'] == '4' || $v['compare'] == '5' || $v['compare'] == '6'){
							
							foreach($campares as $ckey => $cval)
							{  if($ckey == $v['compare'] ){ $safec = $cval;}        }
							
							$cmf[] = array(
							'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => strip_tags( stripslashes($v['value'])),
								'type' => 'DECIMAL',
								'compare' => $safec
							);
						}elseif($v['compare'] == '1' || $v['compare'] == '2' || $v['compare'] == '7' || $v['compare'] == '8' || $v['compare'] == '13'){
								
								foreach($campares as $ckey => $cval)
								{  if($ckey == $v['compare'] ){ $safec = $cval;}        }
								
								$cmf[] = array(
								'key' => strip_tags( stripslashes($v['metakey'])),
								'value' => strip_tags( stripslashes($v['value'])),
								'compare' => $safec
							);
						}
						
					   }//end isset
					}//end foreach
						$output =  apply_filters( 'uwpqsf_get_cmf', $cmf,$id, $getcmf );
						unset($output[0]);
						return $output;				
						
				}
	
	   }
	   
	  function get_uwqsf_taxo($id, $gettaxo){
			global $wp_query;
		    $options = get_post_meta($id, 'uwpqsf-option', true);
		    $savetaxo = get_post_meta($id, 'uwpqsf-taxo', true);
			$taxrel = isset($options[0]['tax']) ? $options[0]['tax'] : 'AND';
			$taxo=array('relation' => $taxrel,'');
			if(!empty($gettaxo)){
				$taxoperator =array('1'=>'IN','2'=>'NOT IN','3'=>'AND');		
				
				foreach($gettaxo as  $v){
						
				  $safopt = !empty ( $taxoperator[$v['opt']])  ?  $taxoperator[$v['opt']] : 'IN';	
				   if(!empty($v['term']))	{	
					if( $v['term'] == 'uwpqsftaxoall'){
						
						foreach($savetaxo as $key => $value){
							if($v['name'] == $value['taxname'] && !empty($value['exsearch']) && $value['exsearch'] == '1' && !empty($value['exc']) ){
								$taxo[] = array(
									'taxonomy' => strip_tags( stripslashes($v['name'])),
									'field' => 'id',
									'terms' =>  explode(',',$value['exc']),
									'operator' => 'NOT IN'
								);
							}
						}	
					  
					  
					  }
					elseif(is_array($v['term'])){
					 
					 $taxo[] = array(
							'taxonomy' =>  strip_tags( stripslashes($v['name'])),
							'field' => 'slug',
							'terms' =>$v['term'],
							'operator' => $safopt
						);
					}
					else{
				  
					$taxo[] = array(
							'taxonomy' => strip_tags( stripslashes($v['name'])),
							'field' => 'slug',
							'terms' => strip_tags( stripslashes($v['term'])),
							'operator' => $safopt
						);
					}
				   }else{
					   
					 
					   foreach($savetaxo as $key => $value){
							if(!empty($value['exsearch']) && $value['exsearch'] == '1' && !empty($value['exc']) && $v['name'] == $value['taxname']){
								$taxo[] = array(
									'taxonomy' => $value['taxname'],
									'field' => 'id',
									'terms' =>  explode(',',$value['exc']),
									'operator' => 'NOT IN'
								);
							}
						}
				   }
				 } //end foreach
								
					
			}				   
			   $output = apply_filters( 'uwpqsf_get_taxo', $taxo,$id, $gettaxo );	
				unset($output[0]);
				return $output;	
			
		}		
			
	

       function uwpqsf_search_query($query){
	 if($query->is_search()){
	    if($query->query_vars['s'] == 'uwpsfsearchtrg'){	
		$getdata = $_GET;
		$taxo = (isset($_GET['taxo']) && !empty($_GET['taxo'])) ? $_GET['taxo'] : null;
		$cmf = (isset($_GET['cmf']) && !empty($_GET['cmf'])) ? $_GET['cmf'] : null;
		$id = absint($_GET['uformid']);
		$options = get_post_meta($id, 'uwpqsf-option', true);
		$cpts = get_post_meta($id, 'uwpqsf-cpt', true);
		$default_number = get_option('posts_per_page');
		$paged = ( get_query_var( 'paged') ) ? get_query_var( 'paged' ) : 1;
		$cpt        = !empty($cpts) ? $cpts : 'any';
		$ordermeta  = !empty($options[0]['smetekey']) ? $options[0]['smetekey'] : null;
		$ordertype = !empty($options[0]['otype']) ? $options[0]['otype'] : null;
		$order      = !empty($options[0]['sorder']) ? $options[0]['sorder'] : null;
		$number      = !empty($options[0]['resultc']) ? $options[0]['resultc'] : $default_number;
		$keyword = !empty($_GET['skeyword']) ?	 sanitize_text_field($_GET['skeyword']) : null;
		$get_tax = $this->get_uwqsf_taxo($id, $taxo);
		$get_meta = $this->get_uwqsf_cmf($id, $cmf);
		if($options[0]['snf'] != '1' && !empty($keyword)){
		 $get_tax = $get_meta = null;
		} 

		$ordermeta  = apply_filters('uwpqsf_dmeta_query',$ordermeta,$getdata,$id);
		$ordervalue = apply_filters('uwpqsf_dmeta_type',$ordertype,$getdata,$id);
		$order 	    = apply_filters('uwpqsf_dorder_query',$order,$getdata,$id);	
		$number     = apply_filters('uwpqsf_dnum_query',$number,$getdata,$id);	
				
		
		$args = array(
			'post_type' => $cpt,
			'post_status' => 'publish',
			'meta_key'=> $ordermeta,
			'orderby' => $ordertype,
			'order' => $order, 
			'paged'=> $paged,
			'posts_per_page' => $number,
			'meta_query' => $get_meta,						
			'tax_query' => $get_tax,
			's' => esc_html($keyword),
			);
							
		$arg = apply_filters( 'uwpqsf_deftemp_query', $args, $id,$getdata);	


		foreach($arg as $k => $v){
         		$query->set( $k, $v );
		}
		return $query; 
            }	
	    
	 }	
	   
   }//end for search

  function uwpqsf_ajax(){
    $postdata =parse_str($_POST['getdata'], $getdata);
    $taxo = (isset($getdata['taxo']) && !empty($getdata['taxo'])) ? $getdata['taxo'] : null;
    $cmf = (isset($getdata['cmf']) && !empty($getdata['cmf'])) ? $getdata['cmf'] : null;
    $formid = $getdata['uformid'];
    $nonce =  $getdata['unonce'];
    $pagenumber = isset($_POST['pagenum']) ? $_POST['pagenum'] : null;

	if(isset($formid) && wp_verify_nonce($nonce, 'uwpsfsearch')){
  		$id = absint($formid);
		$options = get_post_meta($id, 'uwpqsf-option', true);
		$cpts = get_post_meta($id, 'uwpqsf-cpt', true);
		$pagenumber = isset($_POST['pagenum']) ? $_POST['pagenum'] : null;
		$default_number = get_option('posts_per_page');
				
		$cpt        = !empty($cpts) ? $cpts : 'any';
		$ordermeta  = !empty($options[0]['smetekey']) ? $options[0]['smetekey'] : null;
		$ordertype = !empty($options[0]['otype'])  ? $options[0]['otype'] : null;
		$order      = !empty($options[0]['sorder']) ? $options[0]['sorder'] : null;
		$number      = !empty($options[0]['resultc']) ? $options[0]['resultc'] : $default_number;
				
		$keyword = !empty($getdata['skeyword']) ? sanitize_text_field($getdata['skeyword']) : null;
		$get_tax = $this->get_uwqsf_taxo($id, $taxo);
		$get_meta = $this->get_uwqsf_cmf($id, $cmf);
		
		if($options[0]['snf'] != '1' && !empty($keyword)){
		 $get_tax = $get_meta = null;
		}
		
		$ordermeta  = apply_filters('uwpqsf_ometa_query',$ordermeta,$getdata,$id);
		$ordervalue = apply_filters('uwpqsf_ometa_type',$ordertype,$getdata,$id);
		$order 	    = apply_filters('uwpqsf_order_query',$order,$getdata,$id);	
		$number     = apply_filters('uwpqsf_pnum_query',$number,$getdata,$id);	
					
		
				
		$args = array(
			'post_type' => $cpt,
			'post_status' => 'publish',
			'meta_key'=> $ordermeta,
			'orderby' => $ordertype,
			'order' => $order, 
			'paged'=> $pagenumber,
			'posts_per_page' => $number,
			'meta_query' => $get_meta,						
			'tax_query' => $get_tax,
			's' => esc_html($keyword),
			);
							
		$arg = apply_filters( 'uwpqsf_query_args', $args, $id,$getdata);		
				
						
					    
		$results =  $this->uajax_result($arg, $id,$pagenumber,$getdata);
		$result = apply_filters( 'uwpqsf_result_tempt',$results , $arg, $id, $getdata );	
					
		echo $result;
					
							
		}else{ echo 'There is error here';}
	    	die;	

  }//end ajax	

  function uajax_result($arg, $id,$pagenumber,$getdata){
    	$query = new WP_Query( $arg );
	$html = '';
	$count = 0;
		//print_r($query);	// The Loop
	if ( $query->have_posts() ) {
	  $html .= '<h1 class="result">'.__('Kết quả tìm kiếm :', 'UWPQSF' ).'</h1>';
      $html .= '<table id="rt1" class="rt cf">
                    <thead class="cf">';
	   while ( $query->have_posts() ) {
	        	$query->the_post();global $post;
	        	$count++;	
	        	$post_id=$post->ID;
                global $wpdb;
                $sql = "SELECT wp_postmeta.meta_value FROM wp_postmeta WHERE wp_postmeta.meta_key = '_wpcf_belongs_to-chuc_id' AND wp_postmeta.post_id = $post_id";
                $results = $wpdb->get_results( $sql, ARRAY_A );
                $parent_id = $results[0]['meta_value'];
                $address ='';
                $start_date ='';
                $end_date = '';	
            if($parent_id == NULL){
            	$address = get_post_meta( $post_id, 'wpcf-auditee-dia-chi', true );
            	$child_posts = types_child_posts('giay-chung-nhan');

            	$html .= '<tr><th>'.$count.'. '.get_the_title($post_id).'</th></tr>';
            	$html .= '</thead><tbody>';
            	$html .= '<tr><td>Địa chỉ: '.$address.'</td></tr>';
            	foreach ($child_posts as $child_post){

            		$start_date = $child_post->fields['certification-ngay-cap'];  
            		$start_date = strftime("%d/%m/%Y", $start_date);
            		$end_date = $child_post->fields['certification-ngay-het-han'];
            		$end_date = strftime("%d/%m/%Y", $end_date);

            		$html .= '<tr><td>Mã số giấy chứng nhận: '.$child_post->post_title.'</br>';
		            $html .= 'Ngày cấp: '.$start_date.'</br>';
		            $html .= 'Ngày hết hạn: '.$end_date.'</td></tr>';
		            $html .= '</tbody>';
            	}	

            }else{    

		  		$address = get_post_meta( $parent_id, 'wpcf-auditee-dia-chi', true );

	            $start_date = get_post_meta( $post->ID, 'wpcf-certification-ngay-cap', true );
	            $start_date = strftime("%d/%m/%Y", $start_date);
	            $end_date = get_post_meta( $post->ID, 'wpcf-certification-ngay-het-han', true );
	           
	            if($end_date!=NULL){
	            	 $end_date = strftime("%d/%m/%Y", $end_date);
	            }

	            $html .= '<tr><th>'.$count.'. '.get_the_title($parent_id).'</th></tr>';
	            $html .= '</thead><tbody>';
	            $html .= '<tr><td>Địa chỉ: '.$address.'</td></tr>';
				$html .= '<tr><td>Mã số giấy chứng nhận: '.get_the_title().'</br>';
	            $html .= 'Ngày cấp: '.$start_date.'</br>';
	            $html .= 'Ngày hết hạn: '.$end_date.'</td></tr>';
				$html .= '</tbody>';
			}
		}
            $html .= '</tbody></table>';
			$html .= $this->ajax_pagination($pagenumber,$query->max_num_pages, 4, $id,$getdata);
	} else {
			$html .= __( '<h3 class="not_found">Đang cập nhật nội dung !</h3>', 'UWPQSF' );
			}
			/* Restore original Post Data */
			wp_reset_postdata();
				
	return $html;
			
		
  }//end result	 

  function ajax_pagination($pagenumber, $pages = '', $range = 4, $id,$getdata){
	$showitems = ($range * 2)+1;  
	 
	$paged = $pagenumber;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	 {
		 
	   global $wp_query;
	   $pages = $query->max_num_pages;
			 
	    if(!$pages)
		 {
				 $pages = 1;
		 }
	}   
	 
	if(1 != $pages)
	 {
	  $html = "<div class=\"uwpqsfpagi\">  ";  
	  $html .= '<input type="hidden" id="curuform" value="#uwpqsffrom_'.$id.'">';
	
	 if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
	 $html .= '<a id="1" class="upagievent" href="#">&laquo; '.__("First","UWPQSF").'</a>';
	 $previous = $paged - 1;
	 if($paged > 1 && $showitems < $pages) $html .= '<a id="'.$previous.'" class="upagievent" href="#">&lsaquo; '.__("Previous","UWPQSF").'</a>';
	
	 for ($i=1; $i <= $pages; $i++)
	  {
		 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
		 {
		 $html .= ($paged == $i)? '<span class="upagicurrent">'.$i.'</span>': '<a id="'.$i.'" href="#" class="upagievent inactive">'.$i.'</a>';
		 }
	 }
				
	 if ($paged < $pages && $showitems < $pages){
		 $next = $paged + 1;
		 $html .= '<a id="'.$next.'" class="upagievent"  href="#">'.__("Next","UWPQSF").' &rsaquo;</a>';}
		 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
		 $html .= '<a id="'.$pages.'" class="upagievent"  href="#">'.__("Last","UWPQSF").' &raquo;</a>';}
		 $html .= "</div>\n";$max_num_pages = $pages;
		 return apply_filters('uwpqsf_pagination',$html,$max_num_pages,$pagenumber,$id);
	 }
		 
		 
   }// pagination
  	
  function ufront_js(){
      $variables = array('url' => admin_url( 'admin-ajax.php' ),);
	$themeopt = new uwpqsfclass();	
	$themeops = $themeopt->uwpqsf_theme();
	$themenames= $themeopt->uwpqsf_theme_val();
	if(isset($themenames)){
	  foreach($themeops as $k){
		if(in_array($k['themeid'],$themenames) ){
				wp_register_style( $k['themeid'], $k['link'], array(),  'all' );
				wp_enqueue_style( $k['themeid'] );
			}
		
	  wp_enqueue_script(  'uwpqsfscript', plugins_url( '/scripts/uwpqsfscript.js', __FILE__ ) , array('jquery'), '1.0', true);
          wp_localize_script('uwpqsfscript', 'ajax', $variables);
	}// end foreach
      }//end if
  }
 

  
 }//end class
}//end check 
global $uwpqsfprocess;
$uwpqsfprocess = new uwpqsfprocess();
?>
