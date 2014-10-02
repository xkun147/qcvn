<?php 
if(class_exists('WPBakeryShortCodesContainer'))
{
	class WPBakeryShortCode_animate extends WPBakeryShortCodesContainer {
	}
	class WPBakeryShortCode_visibility extends WPBakeryShortCodesContainer {
	}
}
if ( function_exists('vc_map')) { 
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_name] = $of_cat->cat_ID;} 

$of_tags = array();  
$of_tags_obj = get_tags('hide_empty=0');
foreach ($of_tags_obj as $of_tag) {
    $of_tags[$of_tag->name] = $of_tag->term_id;}

$ads = array();
$get_ads = get_posts('post_type=ads&posts_per_page=-1');
foreach ($get_ads as $ad ) {
    $ads[$ad->post_title] = $ad->ID;
}

$ps = array();
$get_ps = get_posts('posts_per_page=-1');
foreach ($get_ps as $p ) {
    $ps[$p->post_title] = $p->ID;
}

$ani = array(
    'bounce'  => 'bounce',
'flash' => 'flash',
'pulse' => 'pulse',
'rubberBand'  => 'rubberBand',
'shake' => 'shake',
'swing' => 'swing',
'tada'  => 'tada',
'wobble'  => 'wobble',
'bounceIn'  => 'bounceIn',
'bounceInDown'  => 'bounceInDown',
'bounceInLeft'  => 'bounceInLeft',
'bounceInRight' => 'bounceInRight',
'bounceInUp'  => 'bounceInUp',
'fadeIn'  => 'fadeIn',
'fadeInDown'  => 'fadeInDown',
'fadeInDownBig' => 'fadeInDownBig',
'fadeInLeft'  => 'fadeInLeft',
'fadeInLeftBig' => 'fadeInLeftBig',
'fadeInRight' => 'fadeInRight',
'fadeInRightBig'  => 'fadeInRightBig',
'fadeInUp'  => 'fadeInUp',
'fadeInUpBig' => 'fadeInUpBig',
'flip'  => 'flip',
'flipInX' => 'flipInX',
'flipInY' => 'flipInY',
'lightSpeedIn'  => 'lightSpeedIn',
'rotateIn'  => 'rotateIn',
'rotateInDownLeft'  => 'rotateInDownLeft',
'rotateInDownRight' => 'rotateInDownRight',
'rotateInUpLeft'  => 'rotateInUpLeft',
'rotateInUpRight' => 'rotateInUpRight',
'slideInDown' => 'slideInDown',
'slideInLeft' => 'slideInLeft',
'slideInRight'  => 'slideInRight',
'hinge' => 'hinge',
'rollIn'  => 'rollIn',  
);

$vc_formats = array(
		   __('Gallery') => 'gallery',
		   __('Audio') => 'audio',
		   __('Video') => 'video',
		   __('Chat') => 'chat',
		    );
    
vc_map( array(
    "name" => __("News Box", "framework"),
    "base" => "news_box",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_newsbox',
    "description" => __("insert news boxes.", 'framework'),
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style", 'framework'),
         "param_name" => "style",
	 "admin_label" => true,
         "description" => __("select from newsbox styles.", 'framework'),
         "value" => array(
			'Default' => '1',
			'Style 2' => '2',
			'Style 3' => '3',
			'Style 4' => '4',
			'Two Columns' => 'two_cols',
			),
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Last", 'framework'),
         "param_name" => "last",
        "dependency" => Array('element' => "style", 'value' => array('two_cols')),
         "value" => array(
			  __("No", 'framework') => '',
			  __("Yes", 'framework') => 'yes',
			  ),
      ),  
	  array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title", 'framework'),
         "param_name" => "title",
         "value" => '',
         "description" => __("if you select display category or tag leave this blank and it will be the category/tag name.", 'framework')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
	 "admin_label" => true,
         "value" => array(
			__('Latest Posts', 'framework') => '' ,
			__('Category', 'framework') => 'category',
			__('Tag', 'framework') => 'tag'
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "category",
        "dependency" => Array('element' => "display", 'value' => array('category')),
	 "admin_label" => true,
         "value" => array( "Select a Category" => '' ) + $of_categories,
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
        "dependency" => Array('element' => "display", 'value' => array('tag')),
	 "admin_label" => true,
         "value" => array( "Select a Tag" => '' ) + $of_tags,
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts", 'framework'),
         "param_name" => "count",
         "description" => __('this count start after the recent post it mean if you set this as 10 the newsbox will show 11 posts the top post then the 10', 'framework')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("order by", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			  __("Recent", 'framework') => '',
			  __("Popular", 'framework') => 'popular',
			  __("Random", 'framework') => 'random',
			  ),
      ),      
        array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Sort by", 'framework'),
         "param_name" => "sort",
         "value" => array(
			  __("DESC", 'framework') => '',
			  __("ASC", 'framework') => 'ASC',
			  ),
      ),      
      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Show more Button"),
         "param_name" => "show_more",
         "description" => __('Disable show more button as tabs on bottom of each news box', 'framework'),
        "value" => Array(__("Show/hide", "js_composer") => 'on')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("On click"),
         "param_name" => "show_more_type",
         "value" => array(
			__('More posts with Ajax', 'framework') => '',
			__('Category/tag page', 'framework') => 'link' ,
		),
      ),
   )
));

vc_map( array(
    "name" => __("News List", "framework"),
    "base" => "news_list",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_newslist',
    "description" => __("insert news lists.", 'framework'),
    "params" => array(
	  array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title", 'framework'),
         "param_name" => "title",
         "value" => '',
         "description" => __("if you select display category or tag leave this blank and it will be the category/tag name.", 'framework')
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Image Size", 'framework'),
         "param_name" => "image_size",
         "value" => array(
			__('Medium', 'framework') => '' ,
			__('Big', 'framework') => 'big',
			),
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
	 "admin_label" => true,
         "value" => array(
			__('Latest Posts', 'framework') => '' ,
			__('Category', 'framework') => 'category',
			__('Tag', 'framework') => 'tag'
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "category",
        "dependency" => Array('element' => "display", 'value' => array('category')),
	 "admin_label" => true,
         "value" => array( "Select a Category" => '' ) + $of_categories,
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
        "dependency" => Array('element' => "display", 'value' => array('tag')),
	 "admin_label" => true,
         "value" => array( "Select a Tag" => '' ) + $of_tags,
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Format", 'framework'),
         "param_name" => "format",
	 "admin_label" => true,
	"description" => __('display posts by format, leave blank for all post formats spaerated by comma for multiple formats', 'framework'),
         "value" => '',
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts", 'framework'),
	 "admin_label" => true,
         "param_name" => "count",
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Excerpt Length", 'framework'),
         "param_name" => "excerpt_length",
         "description" => __('characters length default is 150', 'framework')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("order by", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			  __("Recent", 'framework') => '',
			  __("Popular", 'framework') => 'popular',
			  __("Random", 'framework') => 'random',
			  ),
      ),      
        array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Sort by", 'framework'),
         "param_name" => "sort",
         "value" => array(
			  __("DESC", 'framework') => '',
			  __("ASC", 'framework') => 'ASC',
			  ),
      ),      
      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Show more Button"),
         "param_name" => "show_more",
         "description" => __('Disable show more button as tabs on bottom of each news box', 'framework'),
        "value" => Array(__("Show/hide", "js_composer") => 'on')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("On click"),
         "param_name" => "show_more_type",
         "value" => array(
			__('More posts with Ajax', 'framework') => '',
			__('Category/tag page', 'framework') => 'link' ,
		),
      ),
   )
));

vc_map( array(
    "name" => __("Scrolling box", "framework"),
    "base" => "scrolling_box",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_scrolling_box',
    "description" => __("insert posts carousel.", 'framework'),
    "params" => array(
	  array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title", 'framework'),
         "param_name" => "title",
         "value" => '',
         "description" => __("if you select display category or tag leave this blank and it will be the category/tag name.", 'framework')
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
	 "admin_label" => true,
         "value" => array(
			__('Latest Posts', 'framework') => '' ,
			__('Category', 'framework') => 'category',
			__('Tag', 'framework') => 'tag'
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "category",
        "dependency" => Array('element' => "display", 'value' => array('category')),
	 "admin_label" => true,
         "value" => array( "Select a Category" => '' ) + $of_categories,
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
        "dependency" => Array('element' => "display", 'value' => array('tag')),
	 "admin_label" => true,
         "value" => array( "Select a Tag" => '' ) + $of_tags,
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Format", 'framework'),
         "param_name" => "format",
	"description" => __('display posts by format, leave blank for all post formats spaerated by comma for multiple formats', 'framework'),
	 "admin_label" => true,
         "value" => '',
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts", 'framework'),
         "param_name" => "count",
	 "admin_label" => true,
	"description" => __('-1 for all posts', 'framework'),
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Items", 'framework'),
         "param_name" => "items",
	"description" => __('items displayed at a time depend on width default is 3', 'framework'),
         "value" => '',
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Excerpt Length", 'framework'),
         "param_name" => "excerpt_length",
         "description" => __('characters length default is 0', 'framework')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("order by", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			  __("Recent", 'framework') => '',
			  __("Popular", 'framework') => 'popular',
			  __("Random", 'framework') => 'random',
			  ),
      ),      
        array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Sort by", 'framework'),
         "param_name" => "sort",
         "value" => array(
			  __("DESC", 'framework') => '',
			  __("ASC", 'framework') => 'ASC',
			  ),
      ),      

   )
));


vc_map( array(
    "name" => __("Feature Slider", "framework"),
    "base" => "feature_slider",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_feature_slider',
    "description" => __("insert Feature Slider.", 'framework'),
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
         "value" => array(
			__('Latest Posts', 'framework') => '' ,
			__('Category', 'framework') => 'category',
			__('Tag', 'framework') => 'tag'
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "category",
        "dependency" => Array('element' => "display", 'value' => array('category')),
         "value" => array( "Select a Category" => '' ) + $of_categories,
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
        "dependency" => Array('element' => "display", 'value' => array('tag')),
         "value" => array( "Select a Tag" => '' ) + $of_tags,
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts", 'framework'),
         "param_name" => "count",
	"description" => __('-1 for all posts', 'framework'),
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("order by", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			  __("Recent", 'framework') => '',
			  __("Popular", 'framework') => 'popular',
			  __("Random", 'framework') => 'random',
			  ),
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Caption", 'framework'),
         "param_name" => "caption",
         "value" => array(
			  __("ON", 'framework') => 'on',
			  __("OFF", 'framework') => 'off',
			  ),
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Caption Style", 'framework'),
         "param_name" => "caption_style",
         "value" => array(
			  __("Default", 'framework') => '',
			  __("Alt", 'framework') => 2,
			  ),
      ),
            
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Caption Length", 'framework'),
         "param_name" => "caption_length",
         "description" => __('characters length default is 110', 'framework')
      ),
     
        array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Navigation", 'framework'),
         "param_name" => "nav",
         "value" => array(
			  __("Bullets", 'framework') => 'bullets',
			  __("Thumbs", 'framework') => 'thumbs',
	    ),
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Arrows", 'framework'),
         "param_name" => "arrows",
         "value" => array(
			  __("OFF", 'framework') => 'off',
			  __("ON", 'framework') => 'on',
			  ),
      ),	
        array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Animation", 'framework'),
         "param_name" => "animation",
         "value" => array(
			  __("crossfade", 'framework') => 'crossfade',
			  __("scroll", 'framework') => 'scroll',
			  __("directscroll", 'framework') => 'directscroll',
			  __("fade", 'framework') => 'fade',
			  __("cover", 'framework') => 'cover',
			  __("cover-fade", 'framework') => 'cover-fade',
			  __("uncover", 'framework') => 'uncover',
			  __("uncover-fade", 'framework') => 'uncover-fade',
	    ),
      ),      
        array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Easing", 'framework'),
         "param_name" => "easing",
         "value" => array(
	__('easeInOutCubic', 'framework') => 'easeInOutCubic',
	__('jswing', 'framework') => 'jswing',
	__('def', 'framework') => 'def',
	__('easeInQuad', 'framework') => 'easeInQuad',
	__('easeOutQuad', 'framework') => 'easeOutQuad',
	__('easeInOutQuad', 'framework') => 'easeInOutQuad',
	__('easeInCubic', 'framework') => 'easeInCubic',
	__('easeOutCubic', 'framework') => 'easeOutCubic',
	__('easeInQuart', 'framework') => 'easeInQuart',
	__('easeOutQuart', 'framework') => 'easeOutQuart',
	__('easeInOutQuart', 'framework') => 'easeInOutQuart',
	__('easeInQuint', 'framework') => 'easeInQuint',
	__('easeOutQuint', 'framework') => 'easeOutQuint',
	__('easeInOutQuint', 'framework') => 'easeInOutQuint',
	__('easeInSine', 'framework') => 'easeInSine',
	__('easeOutSine', 'framework') => 'easeOutSine',
	__('easeInOutSine', 'framework') => 'easeInOutSine',
	__('easeInExpo', 'framework') => 'easeInExpo',
	__('easeOutExpo', 'framework') => 'easeOutExpo',
	__('easeInOutExpo', 'framework') => 'easeInOutExpo',
	__('easeInCirc', 'framework') => 'easeInCirc',
	__('easeOutCirc', 'framework') => 'easeOutCirc',
	__('easeInOutCirc', 'framework') => 'easeInOutCirc',
	__('easeInElastic', 'framework') => 'easeInElastic',
	__('easeOutElastic', 'framework') => 'easeOutElastic',
	__('easeInOutElastic', 'framework') => 'easeInOutElastic',
	__('easeInBack', 'framework') => 'easeInBack',
	__('easeOutBack', 'framework') => 'easeOutBack',
	__('easeInOutBack', 'framework') => 'easeInOutBack',
	__('easeInBounce', 'framework') => 'easeInBounce',
	__('easeOutBounce', 'framework') => 'easeOutBounce',
	__('easeInOutBounce', 'framework') => 'easeInOutBounce',
    ),
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Animation Speed", 'framework'),
         "param_name" => "speed",
         "description" => __('in ms, default is 600', 'framework')
      ),	

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Timeout", 'framework'),
         "param_name" => "timeout",
         "description" => __('the time between each slide in ms, default 4000 = 4 seconds', 'framework')
      ),
   )
));

vc_map( array(
    "name" => __("Blog Posts", "framework"),
    "base" => "blog_posts",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_blog_posts',
    "description" => __("insert blog posts.", 'framework'),
    "params" => array(

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style", 'framework'),
         "param_name" => "style",
         "value" => array(
			__('Medium Thumbnails', 'framework') => 'm1' ,
			__('Medium Thumbnails2', 'framework') => 'm2',
			__('Large Thumbnails', 'framework') => 'l',
			__('Grid', 'framework') => 'g',
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Share Icons", 'framework'),
         "param_name" => "share",
         "value" => array(
			  __("ON", 'framework') => 'on',
			  __("OFF", 'framework') => 'off',
			  ),
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
         "value" => array(
			__('Latest Posts', 'framework') => '' ,
			__('Category', 'framework') => 'category',
			__('Tag', 'framework') => 'tag'
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "category",
        "dependency" => Array('element' => "display", 'value' => array('category')),
         "value" => array( "Select a Category" => '' ) + $of_categories,
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
        "dependency" => Array('element' => "display", 'value' => array('tag')),
         "value" => array( "Select a Tag" => '' ) + $of_tags,
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Format", 'framework'),
         "param_name" => "format",
	"description" => __('display posts by format, leave blank for all post formats spaerated by comma for multiple formats', 'framework'),
         "value" => '',
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts", 'framework'),
         "param_name" => "count",
	"description" => __('-1 for all posts', 'framework'),
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Excerpt Length", 'framework'),
         "param_name" => "excerpt_length",
         "description" => __('characters length', 'framework')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("order by", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			  __("Recent", 'framework') => '',
			  __("Popular", 'framework') => 'popular',
			  __("Random", 'framework') => 'random',
			  ),
      ),      
        array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Sort by", 'framework'),
         "param_name" => "sort",
         "value" => array(
			  __("DESC", 'framework') => '',
			  __("ASC", 'framework') => 'ASC',
			  ),
      ),      

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Pagination", 'framework'),
         "param_name" => "pagination",
         "value" => array(
			  __("ON", 'framework') => 'on',
			  __("OFF", 'framework') => 'off',
			  ),
      ),
      
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Pagination type", 'framework'),
         "param_name" => "pagination_type",
        "dependency" => Array('element' => "pagination", 'value' => array('on')),
         "description" => __('caution: dont use ajax pagination if you order post by', 'framework'),
         "value" => array(
			__('Default') => '',  
			__('Ajax') => 'ajax',  
		),
      ),
      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Post count on load", 'framework'),
         "param_name" => "load_more_count",
        "dependency" => Array('element' => "pagination", 'value' => array('on')),
         "value" => '',
         "description" => __('the count of posts on load if you set the pagination type to ajax default is 3', 'framework')
      ), 
   )
));

vc_map( array(
    "name" => __("News in pictures", "framework"),
    "base" => "news_in_pics",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_news_pics',
    "description" => __("insert news in pictures.", 'framework'),
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Style", 'framework'),
         "param_name" => "style",
         "description" => __("select from newsbox styles.", 'framework'),
         "value" => array(
			'Grid' => '1',
			'Grid with feature post' => '2',
			),
      ),
      
	array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Title", 'framework'),
         "param_name" => "title",
         "value" => '',
         "description" => __("if you select display category or tag leave this blank and it will be the category/tag name.", 'framework')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Display", 'framework'),
         "param_name" => "display",
	 "admin_label" => true,
         "value" => array(
			__('Latest Posts', 'framework') => '' ,
			__('Category', 'framework') => 'category',
			__('Tag', 'framework') => 'tag'
			),
      ),

      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Category", 'framework'),
         "param_name" => "category",
        "dependency" => Array('element' => "display", 'value' => array('category')),
	 "admin_label" => true,
         "value" => array( "Select a Category" => '' ) + $of_categories,
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Tag", 'framework'),
         "param_name" => "tag",
        "dependency" => Array('element' => "display", 'value' => array('tag')),
	 "admin_label" => true,
         "value" => array( "Select a Tag" => '' ) + $of_tags,
      ),

      array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Number of posts", 'framework'),
         "param_name" => "count",
	 "admin_label" => true,
         "description" => __('this count start after the recent post it mean if you set this as 10 the newsbox will show 11 posts the top post then the 10', 'framework')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("order by", 'framework'),
         "param_name" => "orderby",
         "value" => array(
			  __("Recent", 'framework') => '',
			  __("Popular", 'framework') => 'popular',
			  __("Random", 'framework') => 'random',
			  ),
      ),      
        array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Sort by", 'framework'),
         "param_name" => "sort",
         "value" => array(
			  __("DESC", 'framework') => '',
			  __("ASC", 'framework') => 'ASC',
			  ),
      ),      
      array(
         "type" => "checkbox",
         "class" => "",
         "heading" => __("Show more Button"),
         "param_name" => "show_more",
         "description" => __('Disable show more button as tabs on bottom of each news box', 'framework'),
        "value" => Array(__("Show/hide", "js_composer") => 'on')
      ),
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("On click"),
         "param_name" => "show_more_type",
         "value" => array(
			__('More posts with Ajax', 'framework') => '',
			__('Category/tag page', 'framework') => 'link' ,
		),
      ),
   )
));

vc_map( array(
    "name" => __("Portfolio", "framework"),
    "base" => "portfolio",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_portfolio',
    "description" => __("insert portfolio items.", 'framework'),
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Columns", 'framework'),
         "param_name" => "columns",
         "description" => __("set the number of columns.", 'framework'),
         "value" => array(
			__('One columns', 'theme') => 'one',
			__('Two columns', 'theme') => 'two',
			__('Three columns', 'theme') => 'three',
			__('Four columns', 'theme') => 'four',
			),
      ),
      
	array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Items per page", 'framework'),
         "param_name" => "count",
         "value" => '',
         "description" => __("By default its: 12.", 'framework')
      ),
 
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Navigation", 'framework'),
         "param_name" => "nav",
         "description" => __("filter, pagination, both or none.", 'framework'),
         "value" => array(
			__('Filter', 'theme') => 'filter',
			__('Pagination', 'theme') => 'pagination',
			__('Both', 'theme') => 'both',
			__('None', 'theme') => 'none',
			),
      ), 
   )
));

vc_map( array(
    "name" => __("Ad", "framework"),
    "base" => "ad",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_blog_posts',
    "description" => __("insert ad.", 'framework'),
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Select Ad:", 'framework'),
         "param_name" => "id",
         "value" => $ads,
      ),
      
   )
));

vc_map( array(
    "name" => __("Review", "framework"),
    "base" => "review",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_review',
    "description" => __("insert review.", 'framework'),
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Select Post to get the review from it:", 'framework'),
         "param_name" => "id",
         "value" => array(__('Current Post') => '') + $ps,
      ),
      
   )
));

vc_map( array(
    "name" => __("Animator", "framework"),
    "base" => "animate",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_animate',
    "description" => __("elements Animation.", 'framework'),
    "content_element" => true,
    "js_view" => 'VcColumnView',
    "as_parent" => array('except' => ''),
    
    
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Animation", 'framework'),
	"description" => __("tons of animations.", 'framework'),
         "param_name" => "animation",
         "value" => array(__('None') => '') + $ani,
      ),
      
            array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Duration", 'framework'),
	"description" => __("animation duration in seconds.", 'framework'),
         "param_name" => "duration",
      ),
            array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Delay", 'framework'),
	"description" => __("animated element delay in seconds.", 'framework'),
         "param_name" => "delay",
      ),
            array(
         "type" => "textfield",
         "class" => "",
         "heading" => __("Iteration Count", 'framework'),
	"description" => __("number of animation times -1 for non stop animation.", 'framework'),
         "param_name" => "iteration",
      ),  	    
   )
));


vc_map( array(
    "name" => __("Visibility", "framework"),
    "base" => "visibility",
	"category" => __('Goodnews'),
    "icon" => 'icon-mom_vis',
    "description" => __("visibility options.", 'framework'),
    "content_element" => true,
    "js_view" => 'VcColumnView',
    "as_parent" => array('except' => ''),
    
    
    "params" => array(
      array(
         "type" => "dropdown",
         "class" => "",
         "heading" => __("Animation", 'framework'),
	"description" => __("tons of animations.", 'framework'),
         "param_name" => "visible_on",
         "value" => array(
			  __('Desktop', 'framework') => 'desktop',
			  __('Device (mobiles and tablets)', 'framework') => 'device',
			  __('Tablet', 'framework') => 'tablet',
			  __('Mobile', 'framework') => 'mobile',
			  
			)
      ),
      
 	    
   )
));

} // if VC installed
?>