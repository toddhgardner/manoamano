(function($) {
	$.fn.imgFade = function() {
	
		// OPACITY OF BUTTON SET TO 50%
		$("#homepage img, #homepagetop img").css("opacity","1.0");
	
		// ON MOUSE OVER
		$("#homepage img, #homepagetop img").hover(function () {
	
			// SET OPACITY TO 100%
			$(this).stop().animate({
				opacity: 0.9
			}, "fast");
		},
	
		// ON MOUSE OUT
		function () {
	
			// SET OPACITY BACK TO 50%
			$(this).stop().animate({
				opacity: 1.0
			}, "slow");
		});
	
	};
})(jQuery);
