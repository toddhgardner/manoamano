<?php get_header();?>

<div id="main">
	<div id="handle"></div>
	<div id="closeBox"></div>
	
	<h2 class="entrytitle">Search Results</h2>
	
	<div class="listing">
	
	<?php if (have_posts()) { ?>
	
		<p id="results">Search returned <span></span> listing(s)...</p>
	
		<?php get_template_part("navigation"); ?>
	
		<?php } else {?>
		<p>Sorry, your search didn't return any listings. Please try again, checking spelling or using more specific terms.</p>
		
		<script>
		jQuery.noConflict(); jQuery(document).ready(function(){
			jQuery.backstretch("<?php echo get_template_directory_uri();?>/images/Lost.jpg", {speed: 150});
		});
		</script>
	<?php } ?>
	
	</div><!--end listing-->
	
</div><!--end main-->

<?php get_template_part('script_list');?>

<?php 
get_sidebar();
get_footer(); 
?>