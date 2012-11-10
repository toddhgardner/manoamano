<?php 
get_header();

	
{ //IF EVERYTHING IS READY TO GO, SHOW THE MAP...
	

	get_template_part('script');

}?>

<div id="main">

	<div id="handle"></div>
	<div id="closeBox"></div>

		<h2>Welcome to Dig The Falls!</h2>
		<br />
		<p>The goal of Dig The Falls is to create a robust website that will highlight all that New York has to offer. From waterfalls, State Parks and natural areas to hiking, biking and canoeing.<br />
		<br />*You can search site content by using the text box located at the bottom right. There is also a "+" to the right of the search box which has a couple of useful widgets to help navigate through our latest site updates.<br />
		<br />*Check out the box to the bottom left. It shows some of our site content. Pass your mouse over any of the red pins on the map and you will gain a small preview of the information about that pin in this box.<br /></p>
		<br /><h4><p>Please feel free to <a href="mailto:info@digthefalls.com">"Contact Us"</a> should you have any questions concerning the Dig The Falls site, copyright info and any other general inquires.</p></h4>
		<br /><p style="text-align: right;"><a title="Donate to Dig The Falls" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=PZHKXBPPTM2AS" target="_blank"><img src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" alt="" /></a></p>
	</div>

<?php	
get_sidebar();
get_footer(); 
?>