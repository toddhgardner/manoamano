<?php 
	get_header();
	
	//OptionTree Stuff
	if ( function_exists( 'get_option_tree') ) {
		$theme_options = get_option('option_tree');
		$crumbs = get_option_tree('crumbs',$theme_options);
		$blogCat = get_option_tree('blog_cat',$theme_options);
		$bg = get_option_tree('bg',$theme_options);
	}
?>

<div id="main" <?php if(is_category($blogCat)){ echo 'class="blog"'; } ?>>
	<div id="handle"></div>
	<div id="closeBox"></div>
	
	<?php if(!is_category($blogCat)) { //IF NOT BLOG CATEGORY...?>
		<h2 class="entrytitle"><?php single_cat_title(); ?></h2>	
		<?php if ($crumbs && function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
		<div class="entry"><?php echo category_description(); ?></div>
	<?php } ?>
	
	<div class="listing">
	
	<?php 
	if(is_category($blogCat)){  //IF BLOG CATEGORY...
	
		if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div <?php post_class();?>>
				<h2 class="blogTitle"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
    			<a class="blogThumb" href="<?php the_permalink();?>"><?php the_post_thumbnail('blog');	?></a>
    			<p class="blogMeta">Posted <?php the_date();?>&nbsp; / &nbsp; By <?php the_author();?>&nbsp; / &nbsp;<?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></p>
    			<?php the_excerpt();?>
    			<p class="readMore"><a href="<?php the_permalink();?>">Read More &rarr;</a></p>
    			<div class="clear"></div>
    		</div>
        <?php endwhile; endif;
        
   		get_template_part("navigation");
	
	} else { //IF NOT BLOG CATEGORY...
		if (have_posts()) {
			get_template_part("navigation");
		} else { ?>
		<h2>Not Found</h2>
		<p>Sorry, but you may be looking for something that isn't here. Please check again just to be sure.</p>
		<?php }} ?>
	
	</div><!--end listing-->
</div><!--end main-->

<?php if(is_category($blogCat)){ //IF BLOG CATEGORY...?>  
<script type="text/javascript">
jQuery.noConflict(); jQuery(document).ready(function(){
	//FULL SCREEN IMAGE
	jQuery.backstretch("<?php echo $bg; ?>", {speed: 150});
});
</script>
<?php } else { //IF NOT BLOG CATEGORY...
	get_template_part('script_list'); 
}

get_sidebar();
get_footer(); 
?>