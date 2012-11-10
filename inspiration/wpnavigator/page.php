<?php get_header(); ?>

<?php
	//OptionTree Stuff
	if ( function_exists( 'get_option_tree') ) {
		$theme_options = get_option('option_tree');
		$bg = get_option_tree('bg',$theme_options);
		$toggle = get_option_tree('toggle',$theme_options);
		$zoomOn = get_option_tree('zoom_on',$theme_options);
		$crumbs = get_option_tree('crumbs',$theme_options);
		$postZoom = get_option_tree('post_zoom',$theme_options);
		if(!$postZoom){$postZoom = "12";}
	}
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="main">
	<div id="handle"></div>
	<div id="closeBox"></div>
	
	<h2 class="entrytitle"><?php the_title(); ?><?php edit_post_link(' <small>&#9997;</small>','',' '); ?></h2>
	
	<?php
	if ($crumbs && function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();
	?>
	
	<div class="entry">
		<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>												
		<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	</div>
		
    <?php if ('open' == $post->comment_status) : ?>     
	<div id="commentToggle" class="toggleButton"><?php comments_number( 'Comments', '1 Comment', '% Comments' ); ?> <span>+</span></div>	       
    <div class="clear" id="commentsection">
		<?php comments_template(); ?>
    </div>
    <?php endif; ?>
</div><!--end main-->

<?php //IF INDIVIDUAL ADDRESS
$data = get_post_meta( $post->ID, 'key', true );
if ($data[ 'address_one' ] && $data[ 'address_two' ] ) { 
?>
<script type="text/javascript">
jQuery.noConflict(); jQuery(document).ready(function(){

	//MAP ZOOM
	var zoomLevel = <?php echo $zoom;?>,
		gMap = jQuery("#gMap");
	jQuery('#zoomIn').live('click',function(){
		zoomLevel += 1;
		gMap.gmap3({action: 'setOptions', args:[{zoom:zoomLevel}]});
	});
	jQuery('#zoomOut').live('click',function(){
		zoomLevel -= 1;
		gMap.gmap3({action: 'setOptions', args:[{zoom:zoomLevel}]});
	});

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
        		icon: new google.maps.MarkerImage('<?php echo get_template_directory_uri();?>/images/pin.png')
      		}
    	},
    	map:{
     	 center: true,
     	 zoom: zoomLevel
   		}
	},{
		action: 'setOptions', args:[{
				zoom:zoomLevel,
				scrollwheel:true,
				disableDefaultUI:true,
				disableDoubleClickZoom:false,
				draggable:true,
				mapTypeControl:true,
				mapTypeId:'terrain',
				panControl:false,
				scaleControl:false,
				streetViewControl:false,
				zoomControl:false
		}]
	});
});
</script>
<?php } elseif ($data[ 'bg_img' ]) { //IF BACKGROUND IMAGE ?>
<script type="text/javascript">
jQuery.noConflict(); jQuery(document).ready(function(){
	jQuery.backstretch("<?php echo $data[ 'bg_img' ]; ?>", {speed: 150});
});
</script>
<?php } elseif($bg){?>
<script type="text/javascript">
jQuery.noConflict(); jQuery(document).ready(function(){
	jQuery.backstretch("<?php echo $bg; ?>", {speed: 150});
});
</script>
<?php } elseif(is_front_page()){ get_template_part('script'); } //END MAP STUFF ?>

<?php endwhile; endif; ?>

<?php 
get_sidebar();
get_footer(); 
?>