var $j = jQuery.noConflict();

function copyMenuTitlesToDescription() {
	$j('.homemenu > li').each(function(index) {
		var title = $j(this).children('a').attr('title');
		$j(this).append('<p>'+title+'</p>');
	});
}

$j('.donate-tabs .donate-tab').on('click',function(e){

	e.preventDefault();

	$j(this).siblings('.donate-tab').removeClass('active');
	$j(this).addClass('active');

	active = $j(this).data('content');

	$j('.donate-tabs-content .donate-content').removeClass('active');
	$j('.donate-tabs-content .donate-content-'+active).addClass('active');


});