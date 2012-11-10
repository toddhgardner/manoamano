<?php 
get_header();

if (!function_exists( 'get_option_tree')) { //IF OPTION TREE ISN'T INSTALLED?>
	
	<div id="main">
		<div id="handle"></div>
		<div id="closeBox"></div>
		<h3>Welcome to Navigator</h3>
		<p class="alert">First you need to install and setup the OptionTree plugin. For details, please review the supplied help file.</p>
	</div>
	
<?php } elseif (!has_nav_menu( 'main' ) ) { //IF NAVIGATION MENU ISN'T SETUP?>
	
	<div id="main">
		<div id="handle"></div>
		<div id="closeBox"></div>
		<h3>Welcome to Dig The Falls</h3>
		<p>To create a navigation menu, navigate to the "<a href="<?php echo site_url();?>/wp-admin/nav-menus.php">Menus</a>" page. Watch this video for details:</p>
		<br />
		<p><iframe title="YouTube video player" width="300" height="220" src="http://www.youtube.com/embed/6lXbIR9jEnM" frameborder="0" allowfullscreen></iframe></p>
	</div>
	
<?php } elseif (!is_active_sidebar(1) ) { //IF SIDEBAR IS EMPTY?>
	
	<div id="main">
		<div id="handle"></div>
		<div id="closeBox"></div>
		<h3>Welcome to Navigator</h3>
		<br />
		<p>You're almost done! To add content to the footer pop-up menu, navigate to the <a href="<?php echo site_url();?>/wp-admin/widgets.php">"Widgets"</a> page.</p>
	</div>
	
<?php } else { //IF EVERYTHING IS READY TO GO, SHOW THE MAP...
	

	get_template_part('script');

}	
get_sidebar();
get_footer(); 
?>