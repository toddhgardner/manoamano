<?php
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$rss = get_option_tree('rss',$theme_options);
	$skype = get_option_tree('skype',$theme_options);
	$myspace = get_option_tree('myspace',$theme_options);
	$flickr = get_option_tree('flickr',$theme_options);
	$linkedin = get_option_tree('linkedin',$theme_options);
	$youtube = get_option_tree('youtube',$theme_options);
	$vimeo = get_option_tree('vimeo',$theme_options);
	$facebook = get_option_tree('facebook',$theme_options);
	$twitter = get_option_tree('twitter',$theme_options);
	$widgets = get_option_tree('footer_widgets',$theme_options);
	$search = get_option_tree('search',$theme_options);
}?>

<div class="clear"></div>
</div><!--end content-->
</div><!--end contentContainer-->

<div id="footer">
	
	<?php if($widgets){ ?>
	<a href="#" id="widgetsOpen" title="More" class="widgetsToggle">+</a>
	<a href="#" id="widgetsClose" title="Close" class="widgetsToggle">&times;</a>	
	<?php } ?>
	
	<?php if($search){ ?>
	<div id="footerSearch">
		<form method="get" action="<?php echo home_url(); ?>/">
			<input type="image" src="<?php echo get_template_directory_uri(); ?>/images/mag_glass.png" id="searchsubmit" alt="GO!" />
			<input type="text" value="" onfocus="this.value=''; this.onfocus=null;"  name="s" id="s" />
		</form>
	</div>
	<?php } ?>
		
	<?php if(is_single()){
		next_post_link('%link', '&lsaquo;', TRUE); 
		previous_post_link('%link', '&rsaquo;', TRUE);
	}?>

	<div class="pageContent">
		<?php if(is_single() || is_page()) { ?>
		<h2><?php the_title(); ?></h2>
		<?php } elseif(is_404()) { ?>
		<h2>404 Error</h2>
		<?php } elseif(is_search()) { ?>
		<h2>Search Results</h2>
		<?php } elseif(is_category()) { ?>
		<h2><?php single_cat_title(); ?></h2>
		<?php } elseif( is_tag() ) { ?>
		<h2><?php single_tag_title(); ?></h2>
		<?php } elseif (is_day()) { ?>
		<h2>Archive for <?php the_time('F jS, Y'); ?></h2>
		<?php } elseif (is_month()) { ?>
		<h2>Archive for <?php the_time('F, Y'); ?></h2>
		<?php } elseif (is_year()) { ?>
		<h2>Archive for <?php the_time('Y'); ?></h2>
		<?php } elseif (is_author()) { ?>
		<h2>Author Archive</h2>
		<?php } ?>
	</div>
	
	<?php if ($rss || $skype || $myspace || $flickr || $linkedin || $youtube || $vimeo || $facebook || $twitter) { ?>
	<div id="socialStuff">
		<?php if ($rss) { ?>
			<a class="socialicon" id="rssIcon" href="<?php bloginfo('rss2_url'); ?>"  title="Subscribe via RSS" rel="nofollow"></a>
		<?php } if ($skype) { ?>
			<a class="socialicon" id="skypeIcon" href="<?php echo $skype; ?>"  title="Skype" rel="nofollow"></a>
		<?php } if ($myspace) { ?>
			<a class="socialicon" id="myspaceIcon" href="<?php echo $myspace; ?>"  title="MySpace" rel="nofollow"></a>
		<?php } if ($flickr) { ?>
			<a class="socialicon" id="flickrIcon" href="<?php echo $flickr; ?>"  title="Flickr" rel="nofollow"></a>
		<?php } if ($linkedin) { ?>
			<a class="socialicon" id="linkedinIcon" href="<?php echo $linkedin; ?>"  title="LinkedIn" rel="nofollow"></a>
		<?php } if ($youtube) { ?> 
			<a class="socialicon" id="youtubeIcon" href="<?php echo $youtube; ?>" title="YouTube Channel"  rel="nofollow"></a>
		<?php } if ($vimeo) { ?> 
			<a class="socialicon" id="vimeoIcon" href="<?php echo $vimeo; ?>"  title="Vimeo Profile" rel="nofollow"></a>
		<?php } if ($facebook) { ?> 
			<a class="socialicon" id="facebookIcon" href="<?php echo $facebook; ?>"  title="Facebook Profile" rel="nofollow"></a>
		<?php } if ($twitter) { ?> 
			<a class="socialicon" id="twitterIcon" href="<?php echo $twitter; ?>" title="Follow on Twitter"  rel="nofollow"></a>
		<?php } ?>
	</div>
	<?php } ?>
	
	<div id="copyright">
	<!--IMPORTANT! DO NOT REMOVE GOOGLE NOTICE-->
	&copy; <?php echo date("Y "); bloginfo('name'); ?>. Map by Google.</a>
	<!--IMPORTANT! DO NOT REMOVE GOOGLE NOTICE-->
	</div>	

</div><!--end footer-->

<?php wp_footer(); ?>

</body>
</html>