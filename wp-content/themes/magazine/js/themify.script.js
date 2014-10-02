;// Themify Theme Scripts - http://themify.me/

// Initialize object literals
var FixedHeader = {};

/////////////////////////////////////////////
// jQuery functions					
/////////////////////////////////////////////
(function($){

	// Test if touch event exists //////////////////////////////
	function is_touch_device() {
		return 'true' == themifyScript.isTouch;
	}

	// Fixed Header /////////////////////////
	FixedHeader = {
		init: function() {
			this.headerHeight = $('#headerwrap').outerHeight();
			$(window).on('scroll', this.activate);
			$(window).on('touchstart.touchScroll', this.activate);
			$(window).on('touchmove.touchScroll', this.activate);
		},

		activate: function() {
			var $window = $(window),
				scrollTop = $window.scrollTop();
			if ( scrollTop > $('#header').offset().top ) {
				FixedHeader.scrollEnabled();
			} else if ( scrollTop + $window.height() == $window.height() ) {
				FixedHeader.scrollDisabled();
			}
		},

		scrollDisabled: function() {
			$('#headerwrap').removeClass('fixed-header');
			$('#header').removeClass('header-on-scroll');
			$('#pagewrap').css('padding-top', '');
			$('body').removeClass('fixed-header-on');
		},

		scrollEnabled: function() {
			$('#headerwrap').addClass('fixed-header');
			$('#header').addClass('header-on-scroll');
			$('#pagewrap').css('padding-top', $('#headerwrap').outerHeight());
			$('body').addClass('fixed-header-on');
		}
	};

	// Initialize carousels //////////////////////////////
	function createCarousel(obj) {
		obj.each(function() {
			var $this = $(this);
			$this.carouFredSel({
				responsive : true,
				prev : '#' + $this.data('previd'),
				next : '#' + $this.data('nextid'),
				circular : true,
				infinite : true,
				scroll : {
					items : 1,
					wipe : true,
					fx : $this.data('effect'),
					duration : parseInt($this.data('speed'))
				},
				auto : {
					play : !!('off' != $this.data('autoplay')),
					pauseDuration : 'off' != $this.data('autoplay') ? parseInt($this.data('autoplay')) : 0,
					button: '#breaking-news-play_pause'
				},
				items : {
					visible : {
						min : 1,
						max : 1
					},
					width : 222
				},
				onCreate : function() {
					$this.closest('.slideshow-wrap').css({
						'visibility' : 'visible',
						'height' : 'auto'
					});
					$('.breaking-news .carousel-nav-wrap').remove();
					$('.breaking-news-loader').remove();
					$(window).resize();
				}
			});
		});
	}

	// DOCUMENT READY
	$(document).ready(function() {

		// Fixed header
		if(themifyScript.fixedHeader){
			FixedHeader.init();
		}

		/////////////////////////////////////////////
		// Scroll to top
		/////////////////////////////////////////////
		$('.back-top a').click(function() {
			$('body,html').animate({ scrollTop: 0 }, 800);
			return false;
		});

		/////////////////////////////////////////////
		// Add class if menu has children
		/////////////////////////////////////////////
		$("#main-nav li:has(ul)").addClass("has-sub-menu");
		$("#main-nav li:has(div)").addClass("has-mega-sub-menu");

		/////////////////////////////////////////////
		// Add class for longer meta info
		/////////////////////////////////////////////
		$('.post-content .post-title + .post-meta span').parent(".post-meta").addClass("post-meta-details");

		/////////////////////////////////////////////
		// search icon add class if it's focused
		/////////////////////////////////////////////
		$(function () {
			$("#headerwrap #searchform :input").focus(function() {
				$(".icon-search").addClass("icon-focus");
			}).blur(function() {
				$(".icon-search").removeClass("icon-focus");
			});
		});

		// Reset slide nav width
		$(window).resize(function(){
			var viewport = $(window).width();
			if (viewport > 780) {
				$('body').removeAttr('style');
			}
		});

		/////////////////////////////////////////////
		// Toggle nav on mobile
		/////////////////////////////////////////////
		var $menuIcon = $('#menu-icon'),
			$menuIconTop = $('#menu-icon-top'),
			$topNav = $('#top-nav'),
			$mainNav = $('#main-nav'),
			menuIconOnOpen = function( $icon, $nav ){
				$icon.html('<i class="icon-remove"></i>'); // close icon
				$icon.addClass('menu-close');
				if ( typeof $.fn.niceScroll !== 'undefined' ) {
					$nav.getNiceScroll().show().resize();
				}
			},
			menuIconOnClose = function( $icon, $nav ){
				$icon.html('<i class="icon-list-ul"></i>'); // nav list icon
				$icon.removeClass('menu-close');
				if ( typeof $.fn.niceScroll !== 'undefined' ) {
					$nav.getNiceScroll().hide().resize();
				}
			};

		// Top nav
		$menuIconTop.sidr({
			name: 'top-nav-sidr',
			side: themifyScript.top_nav_side,
			onOpen: function() {
				menuIconOnOpen( $menuIconTop, $topNav );
			},
			onClose: function() {
				menuIconOnClose( $menuIconTop, $topNav );
			}
		});

		// Main nav
		$menuIcon.sidr({
			name: 'sidr',
			side: themifyScript.main_nav_side,
			onOpen: function() {
				menuIconOnOpen( $menuIcon, $mainNav );
			},
			onClose: function() {
				menuIconOnClose( $menuIcon, $mainNav );
			}
		});

		/////////////////////////////////////////////
		// NiceScroll plugin
		/////////////////////////////////////////////
		if ( typeof $.fn.niceScroll !== 'undefined' ) {
			var event = 'click';
			$menuIcon.on(event, function(){
				var nice = $mainNav.getNiceScroll();
				if ( nice.length == 0 ) {
					$mainNav.niceScroll({
						autohidemode: false
					});
				}
			});
			$('.mega').each(function(){
				var alink = $(this).find('a').first(),
					vw = $(window).width();
				$(window).resize(function(){
					vw = $(window).width();
				});
				alink.hover(function(){
					var niceMega = $(".mega .mega-sub-menu ul").getNiceScroll();
					if(niceMega.length == 0 && vw > 780) {
						$(".mega .mega-sub-menu ul").show().niceScroll({
							autohidemode: false
						});
					}
				});
			});
			// Menu Top
			$menuIconTop.on(event, function(){
				var nice = $topNav.getNiceScroll();
				if ( nice.length == 0 ) {
					$topNav.niceScroll({
						autohidemode: false
					});
				}
			});
		}

		/////////////////////////////////////////////
		// Header height for slide effect
		/////////////////////////////////////////////
		function headerHeightSlide(){
			var headerH = $('#headerwrap').height();
			if (headerH > 120) {
				$("#headerwrap").addClass("long-menu");
			} else {
				$("#headerwrap").removeClass("long-menu");
			}
		}
		headerHeightSlide();
		$(window).resize(headerHeightSlide);

		// Lightbox / Fullscreen initialization ///////////
		if(typeof ThemifyGallery !== 'undefined') {
			ThemifyGallery.init({'context': $(themifyScript.lightboxContext)});
		}
	});

	// WINDOW LOAD
	$(window).load(function() {

		/////////////////////////////////////////////
		// Carousel initialization
		/////////////////////////////////////////////
		if( typeof $.fn.carouFredSel !== 'undefined' ) {
			createCarousel( $('.slideshow') );
		}

		/////////////////////////////////////////////
		// Pause breaking news
		/////////////////////////////////////////////
		$('#breaking-news-play_pause').click(function(){
			$(this).toggleClass('playing');
		});

	});

})(jQuery);