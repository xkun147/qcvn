<?php
function mom_ads_system($atts, $content = null) {
	extract(shortcode_atts(array(
	'id' => '',
	), $atts));
ob_start();

 ?>
	<?php
		global $ads_mb;
		global $ads_content_mb;

		$ad_setting = get_post_meta($id, $ads_mb->get_the_id(), TRUE);
		$size = isset($ad_setting['ad_size']) ? explode('x',$ad_setting['ad_size']) : '';
		if(isset($ad_setting['ad_size'])) {
			if ($ad_setting['ad_size'] == 'custom-size') {
				$size = array($ad_setting['ad_custom_size_width'],$ad_setting['ad_custom_size_height']);
			}
		}
		$layout = isset($ad_setting['ad_layout']) ? $ad_setting['ad_layout'] : '';
		$rndn = rand(1,1000);

		$space = isset($ad_setting['ad_space']) ? $ad_setting['ad_space'] : '';
		$w_space = '';
		if ($space != '') {
			if ($layout == 'grid') {
			$w_space = 'margin-right:-'.$space.'px; margin-bottom:-'.$space.'px;';
			}
			$w_space = 'margin-bottom:-'.$space.'px;';
			$space = 'margin-bottom:'.$space.'px;';
		}

		$rotator_dem = '';
		$rotator_rndn = '';
		$arrows_output ='';
		$rotator = false;
		if ($layout == 'rotator') {
			//wp_enqueue_script('boxslider'); //minify in plugins.php
			
			$rotator_dem = 'width:'.$size[0].'px; height:'.$size[1].'px;';
			$rotator_rndn = ' ads-rotator-id-'.$rndn;
			$arrows_output = '<div class="adr-arrows"><span class="adr-prev"><i class="enotype-icon-arrow-left4"></i></span><span class="adr-next"><i class="enotype-icon-arrow-right4"></i></span></div>';
			$rotator = true;
		}
		if ($layout != '') {
			$layout = 'ads-layout-'.$layout;
		}
		$empty_link = mom_option('ads_request_page');
		if ($empty_link == '') {
			$empty_link = '#';
		}
		
		// rotator options
		$autoscroll = isset($ad_setting['ad_rotate_autoscroll']) ? $ad_setting['ad_rotate_autoscroll'] : 'true';
		$timeout = isset($ad_setting['ad_rotate_timeout']) ? $ad_setting['ad_rotate_timeout'] : '5000';
		$speed = isset($ad_setting['ad_rotate_speed']) ? $ad_setting['ad_rotate_speed'] : '800';
		$effect = isset($ad_setting['ad_rotate_effect']) ? $ad_setting['ad_rotate_effect'] : '800';
		$arrows = isset($ad_setting['ad_rotate_arrows']) ? $ad_setting['ad_rotate_arrows'] : 'no';
		
		// ads 
		$ads = get_post_meta($id, $ads_content_mb->get_the_id(), TRUE);
		if ($rotator == true) {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			jQuery('.ads-rotator-id-<?php echo $rndn; ?> .mom-ads-inner').boxSlider({
				autoScroll: <?php echo $autoscroll; ?>,
				timeout: <?php echo $timeout; ?>,
				speed: <?php echo $speed; ?>,
				effect: '<?php echo $effect; ?>',
				pauseOnHover: true,
				next:'.ads-rotator-id-<?php echo $rndn; ?> .adr-next',
				prev: '.ads-rotator-id-<?php echo $rndn; ?> .adr-prev'
				
			});

		});
	</script>
	<?php } // end if $rotator true ?>
	<div class="mom-ads-wrap">
	<div class="mom-ads <?php echo $layout.$rotator_rndn; ?>" style="<?php echo $w_space.$rotator_dem; ?>">
	<?php if ($arrows == 'yes') {
		echo $arrows_output;
	} ?>
	<div class="mom-ads-inner">
		
	<?php
	if (!isset($ads['ads'])) {
		echo '<p>'.__('There are no ads, please add some', 'theme').'</p>';
	} else {

	foreach ($ads['ads'] as $ad) {
		$type = isset($ad['ad_type']) ? $ad['ad_type'] : '';
		$img = isset($ad['ad_image']) ? $ad['ad_image'] : '';
		$img = wp_get_attachment_image_src($img,'full');
		$img = $img[0];
		$url = isset($ad['ad_url']) ? $ad['ad_url'] : '#';
		$url_target = isset($ad['ad_url_target']) ? $ad['ad_url_target'] : '';
		$code = isset($ad['ad_code']) ? $ad['ad_code'] : '';
		$expire_date = isset($ad['ad_expire_date']) ? $ad['ad_expire_date'] : '';
		$today_date = date('m/d/Y');
		$dateArr = '';
		$exp_day = '';
		$today = strtotime($today_date);
		$expiration_date = strtotime($expire_date);
		$output = true;
	?>
	<?php
	if ($expire_date != '') {
		 if( $today >= $expiration_date ) {
			$output = false;
		}
	} ?>
	<?php if ($output) { ?>
	<div class="mom-ad" style="width:<?php echo $size[0]; ?>px; height:<?php echo $size[1]; ?>px; <?php echo $space; ?>">
		<?php if ($type == 'code') { 
			echo '<div class="ad-code">'.$code.'</div>';
		} else { ?>
			<a href="<?php echo $url; ?>" target="<?php echo $url_target; ?>"><img src="<?php echo $img ?>" alt="<?php echo get_the_title($id); ?>"></a>
		 <?php } ?>
	</div><!--mom ad-->
	<?php } else { ?>
		<div class="mom-ad mom-ad-empty border-box" style="width:<?php echo $size[0]; ?>px; height:<?php echo $size[1]; ?>px; line-height:<?php echo $size[1]; ?>px; <?php echo $space; ?>">
			<a href="<?php echo $empty_link; ?>"><?php _e('Ad Here: ', 'theme'); echo $size[0].'x'.$size[1]; ?></a>
			<a href="<?php echo $empty_link; ?>" class="overlay"></a>
		</div>
	<?php } ?>
	<?php }
	} //end ads here 
	?>
	</div>
	</div>	<!--Mom ads-->
	</div>
<?php
$content = ob_get_contents();
ob_end_clean();
return $content;


}
add_shortcode("ad", "mom_ads_system");

?>