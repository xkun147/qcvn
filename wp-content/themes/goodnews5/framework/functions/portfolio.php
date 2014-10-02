<?php
function mom_pt_single ($layout) {
?>
    <article id="portfolio-<?php the_ID(); ?>" <?php post_class('portfolio_single main_border_color'); ?>>
    <?php if ($layout == 'full') { ?>
    <?php if ($type == 'video') { ?>
	<div class="video_wrap">
	    <div class="video_frame">
	    <?php if (strpos($video_url, 'youtube')) { ?>
	    <iframe width="100%" height="525" src="http://www.youtube.com/embed/<?php echo $video; ?>" frameborder="0" allowfullscreen></iframe>
	    <?php } ?>
	    <?php  if (strpos($video_url, 'vimeo')) { ?>
	    <iframe src="http://player.vimeo.com/video/<?php echo $video; ?>" width="100%" height="525" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	    <?php } ?>
	    </div>
	</div>

    <?php } elseif ($type == 'slider') {
		wp_enqueue_script('flexslider');	
		wp_enqueue_script('prettyPhoto');
	?>
    <script type="text/javascript">
jQuery(document).ready(function($){
	$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, deeplinking: false});

	$('.pt_slider').flexslider({
	    animation: "slide",
	    controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
	    directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
	    prevText: "",           //String: Set the text for the "previous" directionNav item
	    nextText: "",
	    animationSpeed: 400,	    
	    }); poer
});
    </script>
	<div class="portfolio_slider">
		<div class="pt_slider">
			<ul class="slides">
			    <?php
			    if (isset($settings['use_fi'])) {
			    if ($settings['use_fi'] == 'yes') {
				global $post;
				if ( has_post_thumbnail() ) {
    $fi = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
    $fi_id = get_post_thumbnail_id( $post->ID );
    $fi_meta = wp_get_attachment_metadata($fi_id);
$full_url = $fi['0'];				
$url = aq_resize( $full_url, 940, 400, true );
				?>
		    		<?php echo "<li><a href='{$full_url}' rel='prettyPhoto[pt_slide]'><img src='{$url}' alt='' /><span class='plus_overlay pt_single_ov'><i></i></span></a></li>"; ?>
			    <?php }}} ?>
			    
			<?php
			foreach ($settings['slides'] as $slide) {
			$thumb = $slide['imgurl'];
			$fImage = aq_resize( $thumb, 940, 400, true );
			if (empty($fImage)) {
			    $fImage = $thumb;
			}
		    if (isset($slide['title'])) {$title = $slide['title'];} else { $title = '';}
		    if (isset($slide['caption'])) {$caption = $slide['caption'];} else { $caption = '';}

			 ?>
		<?php echo "<li><a href='{$slide['imgurl']}' rel='prettyPhoto[pt_slide]' title='{$title}'><img src='{$fImage}' alt='{$title}' /><span class='plus_overlay pt_single_ov'><i></i></span></a><p class='pt_slide_caption'>{$caption}</p></li>"; ?>
		<?php } ?>
			</ul>
		</div> <!--pt slider-->
	</div>

    <?php } else {
    	wp_enqueue_script('prettyPhoto');
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){
		    $("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, deeplinking: false});
    });
    </script>
    <div style="text-align: center;">
    <div class="pt_single_image">
		<?php 
		    $thumb = mom_post_image('full');
		    $fImage = aq_resize( $thumb, 940, 400, true );
		?>
	<a href="<?php echo $thumb; ?>" rel="prettyPhoto[pt_image]"><img src="<?php echo $fImage; ?>" alt="<?php the_title(); ?>"><span class='plus_overlay pt_single_ov'><i></i></span></a>
    </div> <!--post img-->
    </div>
    <?php } ?>
    <div style="height: 25px;"></div>
    <div class="two_third">
    <h1 class="pt_title"><?php the_title(); ?></h1>
  <div class="pt_content entry-content">
        <?php the_content(); ?>
    </div>
    </div> <!--two third-->
    <div class="one_third last">
  <div class="pt_details">
    <?php
    global $portfolio_mb;
    $meta = get_post_meta(get_the_ID(), $portfolio_mb->get_the_id(), TRUE);
    if (isset($meta['client'])) { $client = $meta['client']; } else { $client = ''; }
    if (isset($meta['hide_date'])) { $date = $meta['hide_date']; } else { $date = ''; }
    if (isset($meta['hide_cat'])) { $cat = $meta['hide_cat']; } else { $cat = ''; }
    if (isset($meta['url'])) { $url = $meta['url']; } else { $url = ''; }
    ?>
    <h3 class="pt_title"><?php _e('Project Details', 'theme'); ?></h3>
    <div class="pt_infos">
    <?php if($client != '') { ?>
        <div class="pt_info">
            <span class="info-term"><?php _e('Client:', 'theme'); ?> </span>
            <span class="info-data"><?php echo $client; ?></span>
        </div>
        <?php } ?>
        <?php if($date != 'yes') { ?>
        <div class="pt_info">
            <span class="info-term"><?php _e('Date:', 'theme'); ?></span>
            <span class="info-data" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_time(mom_option('date_format')); ?></span>
        </div>
        <?php } ?>

        <?php if($cat != 'yes') { ?>
        <div class="pt_info">
            <span class="info-term"><?php _e('Categories:', 'theme'); ?></span>
            <span class="info-data"> <?php echo get_the_term_list( $post->ID, 'portfolio_category', '', ', ', '' ); ?></span>
        </div>
	<?php } ?>
        <?php if($url != '') { ?>
        <div class="pt_info">
            <span class="info-term"><?php _e('Project URL:', 'theme'); ?></span>
            <span class="info-data"><a href="<?php echo $url; ?>" target="_blank"><?php _e('View Project', 'theme'); ?></a></span>
        </div>
	<?php } ?>
	<?php
	if (isset($meta['ptc'])) { $infos = $meta['ptc']; } else { $infos = array(); }
	    foreach ($infos as $info) { ?>
		    <div class="pt_info">
			<span class="info-term"><?php _e($info['title'].':', 'theme'); ?></span>
			<span class="info-data"><?php _e($info['content'],'theme'); ?></a></span>
		    </div>
	<?php }	?>

    </div>
  </div> <!--pt Details-->
    </div> 

    <?php } else {
	get_template_part('portfolio', 'post');
    }
    ?>
</article> <!-- End Post -->

<?php
}



function mom_related_projects () {
	$ov_style = mom_option('pt_related_ov');
	$ov_animation = 'ov_'.mom_option('pt_related_ov_ani');
	$posts_per_page = mom_option('pt_related_count');
	$ov_title = mom_option('pt_defaults_ov_title');
	$ov_cat = mom_option('pt_defaults_ov_cat');
	$ov_link = mom_option('pt_defaults_ov_hl');
	$ov_zoom = mom_option('pt_defaults_ov_hz');
	global $post;
	
	wp_enqueue_script('easing');
	wp_enqueue_script('carof');
	wp_enqueue_script('swipe');		
	
?>

	<script type="text/javascript">
		jQuery(document).ready( function($) {
		    var carou_items = 4;
   			if ($(window).width() < 767) {
					carou_items = 2;
			} 

			if ($(window).width() < 450) {
					carou_items = 1;
			} 

			$(".pt_carousel_related .mom_portfolio ul").carouFredSel({
				circular: false,
				infinite: true,
				auto 	: false,
				responsive : false,
				swipe: {
				onTouch:true	
				},
				scroll : {
					easing  : 'easeInOutCubic',
					duration : 600,
				},
				items       : carou_items,
				prev	: {	
					button	: ".pt_carousel_related .carou_prev",
				},
				next	: { 
					button	: ".pt_carousel_related .carou_next",
				},
			});
			
		});
	</script>
	<div class="clear"></div>
		<div class="mom_carousel pt_carousel_related">
		<h3 class="carousel_title double_dots"><?php _e('Related Projects', 'theme'); ?></h3>
		<div class="carouse_arrows">
			<a class="carou_prev" href="#"></a>
			<a class="carou_next" href="#"></a>
		</div>
		<div class="mom_portfolio"> <?php $cat = wp_get_post_terms($post->ID, 'portfolio_category', array("fields" => "ids")); ?>
		<ul class="portfolio_list four_col_portfolio">
			<?php
				$args = array(
				'posts_per_page' => $posts_per_page,
				'post_type' => 'portfolio',
				'post__not_in' => array($post->ID),
	    'tax_query' => array(
		array(
			'taxonomy' => 'portfolio_category',
			'field' => 'id',
			'terms' => $cat,
			'operator' => 'IN'
		)
	)
				);
		$query = new WP_Query( $args );
		?>
		<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
		<?php
			global $portfolio_mb;
			global $portfolio_st;
			$meta = get_post_meta(get_the_ID(), $portfolio_mb->get_the_id(), TRUE);
			$settings = get_post_meta(get_the_ID(), $portfolio_st->get_the_id(), TRUE);
				$taxonomy = 'portfolio_category';
				$terms = get_the_terms( $post->ID, $taxonomy);
		?>
				<li class="<?php
				foreach ($terms as $term ) {
				echo $term->slug.' ';
				}
				?>">
				<div class="portfolio_image">
				<?php
				$type = $settings['type'];
				if (isset($settings['video_url'])) {$videourl = $settings['video_url'];} else { $videourl = '';}
				$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' );
				if ($type == 'video') {
					$lightbox = $videourl;
					$ov_ico = 'pt_ov_vids';
				} else {
					$lightbox = $src[0];
					$ov_ico = '';
				}
				
				?>
					<?php if($ov_style == 'drop') { ?> 
						<div class="pt_overlay_drop">
					<div class="pt_ovs_zoom_wrap">
					<a href="<?php echo $lightbox; ?>" rel="prettyPhoto[pt_gallery]" title="<?php the_title(); ?>" class="pt_ovs_zoom <?php echo $ov_ico; ?>"></a>
					</div>
						</div>
					<?php } elseif($ov_style == 'simple') { ?>
				<a class="ov_simple_link" href="<?php the_permalink(); ?>"></a>
				<div class="pt_overlay_simple">
					<h3><?php the_title(); ?></h3>
					<p>
						<?php
							$excerpt = get_the_content();
							echo wp_html_excerpt(strip_shortcodes($excerpt), 70).'...';
						?>
					</p>
					<span class="ov_simple_ico"></span>
				</div>
					<?php } elseif($ov_style == 'plus') { ?>
					<a href="<?php the_permalink(); ?>" class="plus_overlay"><i class="tb_link"></i></a>
					<?php } elseif($ov_style == 'zoom') { ?>
						<span class="pt_ov_zar"></span>
					<?php } else { ?>
						<div class="pt_overlay <?php echo $ov_animation; ?>">
						<div class="pt_ov_content">
						<?php if($ov_title != true) { ?>
						<h3><?php the_title(); ?></h3>
						<?php } ?>
						<?php if($ov_cat != true) { ?>
						<div class="pt_ov_cats">
			<?php
				foreach ($terms as $term ) {
				echo '<a href="'.get_term_link($term->slug, $taxonomy).'">'.$term->name.'</a> ';
				}
			?>
						</div>
						<div class="pt_ov_icons">
					<?php if($ov_link != true) { ?>
						<a href="<?php the_permalink(); ?>" class="pt_ov_link"></a>
					<?php } ?>
					<?php if($ov_zoom != true) { ?>
				<a href="<?php echo $lightbox; ?>" rel="prettyPhoto[pt_gallery]" title="<?php the_title(); ?>" class="pt_ov_zoom <?php echo $ov_ico; ?>"></a>
						<?php } ?>
						</div>
						<?php } ?>
						</div>
					</div>
					<?php } ?>
					<?php
						$thumb = mom_post_image('large'); 
						$fImage = aq_resize( $thumb, 600, 376, true );

					?>
	<a href="<?php the_permalink(); ?>"><img src="<?php echo $fImage; ?>" alt="<?php the_title(); ?>"></a>
					</div>
			</li>
<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.', 'theme'); ?></p>
<?php endif; ?>
		</ul>
		<div class="clear"></div>
<?php wp_reset_query(); ?>
	</div>
	
		</div>
<?php
}