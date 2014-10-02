<?php
function mom_posts_share($id, $url, $style=null, $min=false) {
    $url = urlencode($url);
    $desc = wp_html_excerpt(strip_shortcodes(get_the_content()), 160);
    $img = urlencode(mom_post_image('large'));
    $title = get_the_title();
    $window_title = __('Share This', 'theme');
    $window_width = 700;
    $window_height = 455;
?>
<script>
    jQuery(document).ready(function($) {
        var url = '<?php echo $url; ?>';
        // twitter
        jQuery.getJSON(
            'ht'+'tp://urls.api.twitter.com/1/urls/count.json?url='+url+'&callback=?',
            function (data) {
		    //console.log(data.count);
		    $('.ss-icon.twitter .count').text(data.count);
                }
        );
	

        // facebook
        jQuery.getJSON(
            'ht'+'tp://api.facebook.com/method/links.getStats?urls='+url+'&format=json',
            function (data) {
                //console.log(data[0].like_count);
                $('.ss-icon.facebook .count').text(data[0].like_count);
            }
        );

        // linkedin
        jQuery.getJSON(
	    'http://www.linkedin.com/countserv/count/share?format=jsonp&url='+url+'&callback=?',
            function (data) {

                //console.log(data.count);
                $('.ss-icon.linkedin .count').text(data.count);
            }
        );

        // Pintrest
        jQuery.getJSON(
	    'http://api.pinterest.com/v1/urls/count.json?url='+url+'&callback=?',
            function (data) {
                //console.log(data.count);
                $('.ss-icon.pinterest .count').text(data.count);
            }
        );
    });
    

</script>
<?php
	$plusone = 0;
	$plusone = mom_getGoogleCount($url);
?>
<?php if ($style == 'vertical') { ?>
	  <div class="mom-social-share ss-vertical border-box">
            <div class="ss-icon facebook">
                <a href="#" onclick="window.open('http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo $url; ?>&p[images][0]=<?php echo $img; ?>&p[title]=<?php $title; ?>&p[summary]=<?php echo $desc; ?>', '<?php echo $window_title; ?>', 'menubar=no,toolbar=no,resizable=no,scrollbars=no, width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');"><span class="icon"><i class="fa-icon-facebook"></i><?php _e('Like', 'theme'); ?></span></a>
                <span class="count">0</span>
            </div> <!--icon-->

            <div class="ss-icon twitter">
                <a href="#" onclick="window.open('http://twitter.com/home?status=<?php echo $title; ?>+<?php echo $url; ?>', '<?php _e('Post this On twitter', 'theme'); ?>', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');"><span class="icon"><i class="fa-icon-twitter"></i><?php _e('Tweet', 'theme'); ?></span></a>
                <span class="count">0</span>
            </div> <!--icon-->

            <div class="ss-icon googleplus">
                <a href="https://plus.google.com/share?url=<?php echo $url;?>"
onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=<?php echo $window_height; ?>,width=<?php echo $window_width; ?>');return false"><span class="icon"><i class="fa-icon-google-plus"></i><?php _e('Share', 'theme'); ?></span></a>
                <span class="count"><?php echo $plusone; ?></span>
            </div> <!--icon-->
	<?php if ($min == false) { ?>
            <div class="ss-icon linkedin">
                <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url;?>&title=<?php echo strip_tags($title); ?>&source=<?php echo urlencode(home_url());?>"
onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=<?php echo $window_height; ?>,width=<?php echo $window_width; ?>');return false;"><span class="icon"><i class="fa-icon-linkedin"></i><?php _e('Share', 'theme'); ?></span></a>
                <span class="count">0</span>
            </div> <!--icon-->
            <div class="ss-icon pinterest">
                <a href="http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $img;?>&amp;
url=<?php echo $url;?>&amp;
is_video=false&amp;description=<?php echo $title;?>"
onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=<?php echo $window_height; ?>,width=<?php echo $window_width; ?>');return false;"><span class="icon"><i class="fa-icon-pinterest"></i><?php _e('Share', 'theme'); ?></span></a>
                <span class="count">0</span>
            </div> <!--icon-->
	    <?php } ?>	    
	    <div class="clear"></div>
        </div> <!--social share-->
<?php } else { ?>
       <div class="mom-social-share ss-horizontal border-box">
            <div class="ss-icon facebook">
                <a href="#" onclick="window.open('http://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo $url; ?>&p[images][0]=<?php echo $img; ?>&p[title]=<?php $title; ?>&p[summary]=<?php echo $desc; ?>', '<?php echo $window_title; ?>', 'menubar=no,toolbar=no,resizable=no,scrollbars=no, width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');"><span class="icon"><i class="fa-icon-facebook"></i><?php _e('Like', 'theme'); ?></span></a>
                <span class="count">0</span>
            </div> <!--icon-->

            <div class="ss-icon twitter">
                <a href="#" onclick="window.open('http://twitter.com/home?status=<?php echo $title; ?>+<?php echo $url; ?>', '<?php _e('Post this On twitter', 'theme'); ?>', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,width=<?php echo $window_width; ?>,height=<?php echo $window_height; ?>');"><span class="icon"><i class="fa-icon-twitter"></i><?php _e('Tweet', 'theme'); ?></span></a>
                <span class="count">0</span>
            </div> <!--icon-->

            <div class="ss-icon googleplus">
                <a href="https://plus.google.com/share?url=<?php echo $url;?>"
onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=<?php echo $window_height; ?>,width=<?php echo $window_width; ?>');return false"><span class="icon"><i class="fa-icon-google-plus"></i><?php _e('Share', 'theme'); ?></span></a>
                <span class="count"><?php echo $plusone; ?></span>
            </div> <!--icon-->
	<?php if ($min == false) { ?>
            <div class="ss-icon linkedin">
                <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url;?>&title=<?php echo strip_tags($title); ?>&source=<?php echo urlencode(home_url());?>"
onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=<?php echo $window_height; ?>,width=<?php echo $window_width; ?>');return false;"><span class="icon"><i class="fa-icon-linkedin"></i><?php _e('Share', 'theme'); ?></span></a>
                <span class="count">0</span>
            </div> <!--icon-->
            <div class="ss-icon pinterest">
                <a href="http://pinterest.com/pin/create/bookmarklet/?media=<?php echo $img;?>&amp;
url=<?php echo $url;?>&amp;
is_video=false&amp;description=<?php echo $title;?>"
onclick="javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=<?php echo $window_height; ?>,width=<?php echo $window_width; ?>');return false;"><span class="icon"><i class="fa-icon-pinterest"></i><?php _e('Share', 'theme'); ?></span></a>
                <span class="count">0</span>
            </div> <!--icon-->
	    <?php } ?>
	    <div class="clear"></div>
        </div> <!--social share-->

<?php
}
}
function mom_getGoogleCount($url) {
    $googleURL = file_get_contents('https://plusone.google.com/_/+1/fastbutton?url=' .  $url );
    preg_match('/window\.__SSR = {c: ([\d]+)/', $googleURL, $results);
    if( isset($results[0]))
        return (int) str_replace('window.__SSR = {c: ', '', $results[0]);
    return "0";
}