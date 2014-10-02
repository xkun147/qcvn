jQuery(document).ready(function() {
	
	jQuery('#main-menu .menu').mobileMenu({
			defaultText: 'Navigate to...',					//default text for select menu
			className: 'select-menu',						//class name
			subMenuDash: '&nbsp;&nbsp;&nbsp;&ndash;'		//submenu separator
	});
	
	jQuery('#main-menu ul.menu').superfish({				// main menu settings
		hoverClass:  'over', 								// the class applied to hovered list items 
		delay:       400,                            		// one second delay on mouseout 
		animation:   {opacity:'show',height:'show'},  		// fade-in and slide-down animation 
		speed:       150,                          			// faster animation speed 
		autoArrows:  true,                           		// disable generation of arrow mark-up 
		dropShadows: true                            		// disable drop shadows 
	});	
	
	jQuery("#feat-carousel .carousel-posts").jCarouselLite({				//carousel settings
		btnNext: ".carousel-nav .next",						// next button class
        btnPrev: ".carousel-nav .prev",						// previous button class
        speed: 500,											//carousel speed
        auto: 5000,											//auto scroll
        visible: 3											// visible items										
   	});
	
	jQuery(".sidebar-carousel-posts").jCarouselLite({		//carousel settings
			visible: 2,										// visible items
			auto: 5000,										// carousel speed
			btnNext: ".wid-next",							// next button class
			btnPrev: ".wid-prev"							// previous button class
   	});
	
	jQuery('#wt-slider').flexslider({						// slider settings
			animation: "fade",								// animation style
			controlNav: "thumbnails",						// slider thumnails class
			slideshow: true,								// enable automatic sliding
			directionNav: false,							// disable nav arrows
			slideshowSpeed: 3000   							// slider speed
	});	
	
    
	jQuery(".widget_video iframe").each(function(){
      var ifr_source = jQuery(this).attr('src');
      var wmode = "wmode=transparent";
      if(ifr_source.indexOf('?') != -1) jQuery(this).attr('src',ifr_source+'&'+wmode);
      else jQuery(this).attr('src',ifr_source+'?'+wmode);
	});	
	
});