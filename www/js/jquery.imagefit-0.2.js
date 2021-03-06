/* jquery.imagefit 
 *
 * Version 0.2 by Oliver Boermans <http://www.ollicle.com/eg/jquery/imagefit/>
 *
 * Extends jQuery <http://jquery.com>
 *
 */
(function($) {
	$.fn.imagefit = function(options) {
		var fit = {
			all : function(imgs){
				imgs.each(function(){
					fit.one(this);
					})
				},
			one : function(img){
			        var ratio = $(img).attr('startheight')/$(img).attr('startwidth');

			        //Gather browser dimensions
			        var browserwidth = $(window).width();
			        var browserheight = $(window).height();
				
			        
				var ratioWindow = browserheight/browserwidth;
				
				if(ratioWindow < ratio) {
					$(img)
						.height(browserheight).each(function()
						{
							$(this).width(Math.round(
								$(this).attr('startwidth')*($(this).height()/$(this).attr('startheight')))
							);
						})
				} else {
					$(img)
						.width(browserwidth).each(function()
						{
							$(this).height(Math.round(
								$(this).attr('startheight')*($(this).width()/$(this).attr('startwidth')))
							);
						})
				}
				
			}

		};
		
		this.each(function(){
				var container = this;
				
				// store list of contained images (excluding those in tables)
				var imgs = $('img', container).not($("table img"));
				
				// store initial dimensions on each image 
				imgs.each(function(){
					$(this).attr('startwidth', $(this).width())
						.attr('startheight', $(this).height())
						; //.css('max-width', $(this).attr('startwidth')+"px");
				
					fit.one(this);
				});
				// Re-adjust when window width is changed
				$(window).bind('resize', function(){
					fit.all(imgs);
				});
			});
		return this;
	};
})(jQuery);
