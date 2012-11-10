<?php get_header(); ?>

<div id="main">
	<div id="handle"></div>
	<div id="closeBox"></div>
	<h2>Not Found</h2>
	<p>The page you were looking for doesn't seem to exist. Please navigate to the home screen and try again.<br />
</div><!--end main-->

<script>
jQuery.noConflict(); jQuery(document).ready(function(){
	//LOADS FULLSCREEN IMAGE
	jQuery.backstretch("<?php echo get_template_directory_uri();?>/images/Lost.jpg", {speed: 150});
});
</script>

<?php 
get_sidebar();
get_footer(); 
?>