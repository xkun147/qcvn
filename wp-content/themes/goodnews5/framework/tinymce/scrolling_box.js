(function() {
    tinymce.create('tinymce.plugins.scrollbox', {
        init : function(ed, url) {
            ed.addButton('scrollbox', {
                title : 'Scrolling box',
                image : url+'/images/scollingbox.png',
                onclick : function() {
// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height()-50, W = ( 720 < width ) ? 720: width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Scrolling box', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=scrollbox-form' );
						                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('scrollbox', tinymce.plugins.scrollbox);
    
   // executes this when the DOM is ready
	jQuery(function($){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="scrollbox-form">\
		<div class="mom_tiny_form">\
		    <div class="mom_tiny_form_element">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-title">Title</label>\
			    <span>if you select display category or tag leave this blank and it will be the category/tag name</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
			    <input id="scrollbox-title" type="text">\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		    <div class="mom_tiny_form_element">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-display">Display</label>\
			    <span>get post from anywhere</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
			    <select id="scrollbox-display">\
					<option value="">Latest Posts</option>\
					<option value="category">Category</option>\
					<option value="tag">tag</option>\
				    </select>\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		    <div class="mom_tiny_form_element nb_cats hide">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-cat">Category</label>\
			    <span>select one or more</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
			    <select id="scrollbox-category" name="scrollbox-category">\
			    <option value="">Select Category ...</option>\
				    '+$cats+'\
			    </select>\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		    <div class="mom_tiny_form_element nb_tags hide">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-tag">Tag</label>\
			    <span>multiple tags separated by comma</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
			    <select id="scrollbox-tag" name="scrollbox-tag">\
			    <option value="">Select Tag ...</option>\
				    '+$tags+'\
			    </select>\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		    <div class="mom_tiny_form_element">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-format">Format</label>\
			    <span>display posts by format</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
			    <select id="scrollbox-format" multiple>\
			    <option value="">All</option>\
			    '+$formats+'\
			    </select>\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		    <div class="mom_tiny_form_element">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-count">Number Of posts</label>\
			    <span>-1 for all posts</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
			    <input type="text" name="scrollbox-count" id="scrollbox-count">\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		    <div class="mom_tiny_form_element">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-items">Items</label>\
			    <span>items displayed at a time depend on width default is 3</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
			    <input type="text" name="scrollbox-items" id="scrollbox-items">\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		    <div class="mom_tiny_form_element">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-excerpt_length">Excerpt Length</label>\
			    <span>characters length default is 0</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
			    <input type="text" name="scrollbox-excerpt_length" id="scrollbox-excerpt_length">\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		    <div class="mom_tiny_form_element">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-orderby">Order by</label>\
			    <span>recent, popular, random</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
				<select id="scrollbox-orderby">\
					<option value="">Recent</option>\
					<option value="popular">Popular</option>\
					<option value="random">Random</option>\
				</select>\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		    <div class="mom_tiny_form_element">\
			<div class="mom_tiny_desc">\
			<div class="mom_td_bubble">\
			    <label for="scrollbox-sort">Sort by</label>\
			    <span>DESC, ASC</span>\
			</div>\
			</div>\
			<div class="mom_tiny_input">\
				<select id="scrollbox-sort">\
					<option value="">DESC</option>\
					<option value="ASC">ASC</option>\
				</select>\
			</div>\
			<div class="clear"></div>\
		    </div>\
		    <!-- end element -->\
		</div><!-- end form -->\
		<div class="mom_submit_form">\
			<input type="button" id="scrollbox-submit" class="button-primary" value="Save" name="submit" />\
		</div>\
		</div>');
		var table = form.find('.mom_tiny_form');
		form.appendTo('body').hide();
		$('.mom-color-field').wpColorPicker();
		

		$('#scrollbox-show_more').click(function() {
		    if (!this.checked) {
			$('.show_more_type').slideUp('fast');
		    } else {
			$('.show_more_type').slideDown(250);
		    }
		});

		$('#scrollbox-display').change( function() {
		    if($(this).val() === 'category') {
			$('.nb_cats').slideDown(250);
			$('.nb_tags').slideUp('fast');
			$('.custom_scrollbox_title').slideUp('fast');
		    } else if ($(this).val() === 'tag') {
			$('.nb_tags').slideDown(250);
			$('.nb_cats').slideUp('fast');
			$('.custom_scrollbox_title').slideDown(250);
		    } else {
			$('.nb_tags').slideUp('fast');
			$('.nb_cats').slideUp('fast');
			$('.custom_scrollbox_title').slideDown(250);
		    }
		});
jQuery('input[name="scrollbox-style"]').click(function() {
    if ($('input[name="scrollbox-style"]:checked').val() === 'two_cols') {
	$('.tow_cols_last').slideDown(250);
    } else {
	$('.tow_cols_last').slideUp('fast');
    }
});

		    $("#scrollbox-form input[type=checkbox]").click(
			function() {
			    var attr = $(this).attr('checked');
		    if (typeof attr !== 'undefined' && attr !== false) {
			        $(this).attr({
					     checked: 'checked',
					     value: 'on'
					     });
		    } else {
				$(this).removeAttr('checked');
 				$(this).attr('value', 'off');
		    }
			} 
		    );
		
		// handles the click event of the submit button
		form.find('#scrollbox-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			
			var options = { 
				'title':'',
				'display':'',
				'format':null,
				'category':'',
				'tag':'',
				'orderby':'',
				'sort':'',
				'count':'',
				'excerpt_length':'',
				'items':''
		};
			var shortcode = '[scrolling_box';
			
			for( var index in options) {
				var value = table.find('#scrollbox-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();