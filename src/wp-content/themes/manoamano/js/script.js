var $j = jQuery.noConflict();

function copyMenuTitlesToDescription() {
	$j('.homemenu > li').each(function(index) {
		var title = $j(this).children('a').attr('title');
		$j(this).append('<p>'+title+'</p>');
	});
}