<?php get_header(); ?>

<?php
//OptionTree Stuff
if ( function_exists( 'get_option_tree') ) {
	$theme_options = get_option('option_tree');
	$crumbs = get_option_tree('crumbs',$theme_options);
	$bg = get_option_tree('bg',$theme_options);
	$toggle = get_option_tree('toggle',$theme_options);
	$zoomOn = get_option_tree('zoom_on',$theme_options);
	$postZoom = get_option_tree('post_zoom',$theme_options);
	$blogCat = get_option_tree('blog_cat',$theme_options);
	$twitter = get_option_tree('twitter',$theme_options);
	$pin = get_option_tree('pin',$theme_options);
	if(!$pin){$pin = "". get_template_directory_uri() ."/images/pin.png";}
	if(!$postZoom){$postZoom = "17";}
}
?>	

<div id="main" <?php if(in_category($blogCat)){ ?>class="blog"<?php } ?>>

	<div id="handle"></div>
	<div id="closeBox"></div>
		
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div  <?php post_class(); ?>>
	
		<h2 class="posttitle"><?php the_title(); ?><?php edit_post_link(' <small>&#9997;</small>','',' '); ?></h2>
		
		<?php if ($crumbs && function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>				
				
		<div id="entryToggle" class="toggleButton opened"><span>&times;</span>Details</div>
		<div class="entry">
			<?php 
			$data = get_post_meta( $post->ID, 'key', true );
			if($data[ 'pin' ]){$pin2 = $data[ 'pin' ]; } else {$pin2 = $pin;}
			if ($data[ 'address_one' ] && $data[ 'address_two' ]) { 
				echo "<p id='postAddr'>".$data[ 'address_one' ]."<br />";
				echo "".$data[ 'address_two' ]."<br /><em><a target='_blank' title='Get Directions' href='http://maps.google.com/maps?daddr=".$data[ 'address_one' ]." ".$data[ 'address_two' ]."'>Get Directions &rarr;</a></em></p>";
			}
		
			the_content();
			?>    					
       	</div><!--end entry-->
		
		<?php 
		$args = array('post_type' => 'attachment','post_mime_type' => 'image' ,'post_status' => null, 'post_parent' => $post->ID);
		$attachments = get_posts($args);
		if ($attachments) { 
		?>
		<div id="galleryToggle" class="toggleButton closed"><span>+</span>Gallery</div>
		<ul class="galleryBox">
       		<?php attachment_toolbox('small'); ?>
        </ul>
		<?php } ?>
       
       	<div id="socialToggle" class="toggleButton closed"><span>+</span>Share</div>
       	<div id="socialButtons">
       		<div class="socialButton">	
				<a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
			</div>
			<div class="socialButton">	
				<g:plusone size="medium" count="false"></g:plusone>
			</div>	
			<div class="socialButton">
				<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="<?php the_permalink() ?>" send="false" layout="button_count" width="100" height="21" show_faces="true" action="recommend" colorscheme="light" font=""></fb:like>
			</div>	
			<div class="clear"></div>
		</div>
       
		<?php        	
			$original_post = $post;
			$tags = wp_get_post_tags($post->ID);
			$showtags = 10;
			if ($tags) {
  				$first_tag = $tags[0]->term_id;
  				$tagname = $tags[0]->name;
  				$args=array(
    				'tag__in' => array($first_tag),
    				'post__not_in' => array($post->ID),
    				//'showposts'=>$showtags,
    				'caller_get_posts'=>1
   				);
  				$my_query = new WP_Query($args);
  				if( $my_query->have_posts() ) { 
		?>
		<div id="relatedToggle" class="toggleButton"><span>+</span>Related</div>
       	<div id="related">
			<ul>
				<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<li><a class="tooltip" href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'small' ); ?></a></li>
				<?php endwhile; ?>

			</ul>
			<?php
			//DISPLAYS VIEW ALL LINK IF RELATED POSTS EXCEEDS $shotags+1
			$count = get_tags('include='.$first_tag.'');
			if ($count && $tags) {
				foreach ($count as $tag) {
				?>
				<p id="relatedItemsLink"><a class="tooltip" title="Items Tagged '<?php echo $tagname; ?>' (<?php echo $tag->count; ?>)" href="<?php echo get_tag_link($first_tag); ?>"><em>View Map of Related Items &rarr;</em></a></p>
			<?php }}?>
			
		</div><!--end related-->
			<?php  }}
			$post = $original_post;
			wp_reset_query();
			?>
		
		<div id="tagsToggle" class="toggleButton"><span>+</span>Meta</div>
       	<div id="tags">
       		<p>Posted: <?php the_date();?></p>
       		<p>Author: <?php the_author();?></p>
       		<p>Category: <?php the_category(', '); ?></p>
       		<?php the_tags('<p>Tags: ',', ','</p>'); ?> 
       	</div>
		
		<?php if ('open' == $post->comment_status) : ?>     
		<div id="commentToggle" class="toggleButton closed"><span>+</span><?php comments_number( 'Comments', '1 Comment', '% Comments' ); ?></div>
        <div class="clear" id="commentsection">
			<?php comments_template(); ?>
        </div>
        <?php endif;?>
	</div><!--end post-->


<?php //START MAP STUFF
$data = get_post_meta( $post->ID, 'key', true );
if ($data[ 'latitude' ] && $data[ 'longitude' ] ) { 
	$zoom = $data[ 'zoom' ];
	if($zoom == ""){$zoom = $postZoom;}
?>
<script>
jQuery.noConflict(); jQuery(document).ready(function(){
	
	//MAP ZOOM
	var zoomLevel = <?php echo $zoom;?>,
		gMap = jQuery("#gMap"),
		//iPad,iPhone,iPod...
		deviceAgent = navigator.userAgent.toLowerCase(),
		iPadiPhone = deviceAgent.match(/(iphone|ipod|ipad)/);
		
	//iPad Stuff
	if (iPadiPhone) {
		<?php if($toggle){ ?>jQuery("#footer").append('<div id="mapTypeContainer"><div id="mapStyleContainer" class="gradientBorder"><div id="mapStyle"></div></div><div id="mapType" class="roadmap"></div></div>');<?php } ?>
	} else {
		jQuery('#zoomIn').live('click',function(){
			zoomLevel += 1;
			gMap.gmap3({action: 'setOptions', args:[{zoom:zoomLevel}]});
		});
		jQuery('#zoomOut').live('click',function(){
			zoomLevel -= 1;
			gMap.gmap3({action: 'setOptions', args:[{zoom:zoomLevel}]});
		});
      	jQuery("#footer").append('<?php if($toggle){ ?><div id="mapTypeContainer"><div id="mapStyleContainer" class="gradientBorder"><div id="mapStyle"></div></div><div id="mapType" class="roadmap"></div></div><?php } ?><?php if($zoomOn){ ?><div class="zoomControl" id="zoomOut"><img src="<?php echo get_template_directory_uri();?>/images/zoomOut.png" alt="-" /></div><div class="zoomControl" id="zoomIn"><img src="<?php echo get_template_directory_uri();?>/images/zoomIn.png" alt="+" /></div><?php } ?>');
    } 
    	
	jQuery('#gMap').gmap3({
    	action: 'addMarker',
    	lat:<?php echo $data[ 'latitude' ]; ?>,
    	lng:<?php echo $data[ 'longitude' ]; ?>,
    	marker:{
      		options:{
        		icon: new google.maps.MarkerImage('<?php echo $pin2;?>')
      		}
    	},
    	map:{
     	 center: true,
     	 zoom: zoomLevel
   		}
	},{
		action: 'setOptions', args:[{
			scrollwheel:false,
			disableDefaultUI:false,
			disableDoubleClickZoom:false,
			draggable:true,
			mapTypeControl: true,
			panControl:false,
			scaleControl:false,
			streetViewControl:false,
			zoomControl:false,
			mapTypeId:'terrain'
		}]
	});
});
</script>
<?php } elseif ($data[ 'bg_img' ]) { ?>
<script>
jQuery.noConflict(); jQuery(document).ready(function(){
	jQuery.backstretch("<?php echo $data[ 'bg_img' ]; ?>", {speed: 150});
});
</script>
<?php } else {?>
<script>
jQuery.noConflict(); jQuery(document).ready(function(){
	jQuery.backstretch("<?php echo $bg; ?>", {speed: 150});
});
</script>
<?php }?>

<?php endwhile; endif; ?>
        		
</div><!--end main-->

<?php 
get_sidebar();
get_footer(); 
?>