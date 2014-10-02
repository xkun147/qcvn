/*
 * Themify Mega Menu Plugin
 */
;(function ($) {
	$.fn.ThemifyMegaMenu = function( custom ) {

		var options = $.extend({
				events: 'mouseenter'
			}, custom),
			cacheMenu = {};

		return this.each(function() {
			var $thisMega = $(this),
				$megaMenuPosts = $('.mega-menu-posts', $thisMega),
				firstTerm = $('.mega-link:first', $thisMega).data('termslug');

			cacheMenu[firstTerm] = $megaMenuPosts.html();

			$thisMega.on(options.events, '.mega-link', function(event) {
				event.preventDefault();
				var $self = $(this),
					termslug = $self.data('termslug'),
					tax = $self.data('tax');

				if( 'string' == typeof cacheMenu[termslug] ) {
					$megaMenuPosts.html( cacheMenu[termslug] );
				} else {
					$.post(
						themifyScript.ajax_url,
						{
							action: 'themify_theme_mega_posts',
							nonce: themifyScript.ajax_nonce,
							termslug: termslug,
							tax: tax
						},
						function( response ) {
							$megaMenuPosts.html( response );
							cacheMenu[termslug] = response;
						}
					);
				}
			});

		});
	};

	$(document).ready(function() {
		if( 'undefined' !== typeof $.fn.ThemifyMegaMenu ) {
			$('.has-mega-sub-menu').ThemifyMegaMenu({
				events: themifyScript.events
			});
		}
	});

})(jQuery);