<?php
//Tinymce
function mom_tinymce_script() {
	  global $pagenow, $typenow;
  if (empty($typenow) && !empty($_GET['post'])) {
    $post = get_post($_GET['post']);
    $typenow = $post->post_type;
  }
    if ($pagenow=='post-new.php' OR $pagenow=='post.php') { 
global $wpdb;
$cats = get_terms("category");
$tags = get_terms("post_tag");
$formats = get_theme_support( 'post-formats' );

$faces = mom_google_fonts();
// Get ads
$ads = get_posts('post_type=ads&posts_per_page=-1');

?>
<script type="text/javascript">
post_id = '<?php echo get_the_id(); ?>';
mom_url = '<?php echo get_template_directory_uri(); ?>';
$cats = '<?php 
        foreach ( $cats as $cat ) {
        echo '<option value="'.$cat->term_id.'">' . esc_attr($cat->name) . '</option>';
        }
?>';

$tags = '<?php 
        foreach ( $tags as $tag ) {
        echo '<option value="'.$tag->term_id.'">' . esc_attr($tag->name) . '</option>';
        }
?>';
$formats = '<?php 
        foreach ( $formats[0] as $format ) {
        echo '<option value="'.$format.'">' . esc_attr($format) . '</option>';
        }
?>';
$faces = '<?php 
        foreach ( $faces as $key => $face ) {
        echo '<option value="'.$key.'">' . esc_attr($face) . '</option>';
        }
?>';

$ads = '<?php 
foreach($ads as $item) {
        echo '<option value="'.$item->ID.'">' . esc_attr($item->post_title) . '</option>';
        }
	?>';
</script>
<?php
}
}
add_action( 'in_admin_footer', 'mom_tinymce_script' );