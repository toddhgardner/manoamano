<script type="text/javascript">
//<![CDATA[
jQuery.noConflict(); jQuery(document).ready(function(){  
    //MAP ZOOM
    <?php
    if ( function_exists( 'get_option_tree') ) {
		$theme_options = get_option('option_tree');
		$mainZoom = get_option_tree('main_zoom',$theme_options);
		$toggle = get_option_tree('toggle',$theme_options);
		$zoomOn = get_option_tree('zoom_on',$theme_options);
		$blogCat = get_option_tree('blog_cat',$theme_options);
		$pin = get_option_tree('pin',$theme_options);
		if(!$pin){$pin = "". get_template_directory_uri() ."/images/pin.png";}
		if(!$mainZoom){$mainZoom = "12";}
	}
	?>
	var zoomLevel = <?php echo $mainZoom;?>,
		gMap = jQuery("#gMap"),
		//iPad,iPhone,iPod...
		deviceAgent = navigator.userAgent.toLowerCase(),
		iPadiPhone = deviceAgent.match(/(iphone|ipod|ipad)/);
		
	//iPad Stuff
	if (iPadiPhone) {
		
		jQuery("#footer").prepend('<div class="markerNav" title="Prev" id="prevMarker">&lsaquo;</div><div id="markers"></div><div class="markerNav" title="Next" id="nextMarker">&rsaquo;</div><?php if($toggle){ ?><div id="mapTypeContainer"><div id="mapStyleContainer"><div id="mapStyle" class="terrain"></div></div><div id="mapType" title="Map Type" class="terrain"></div></div><?php } ?>');
	} else {
		jQuery('#zoomIn').live('click',function(){
			zoomLevel += 1;
			gMap.gmap3({action: 'setOptions', args:[{zoom:zoomLevel}]});
		});
		jQuery('#zoomOut').live('click',function(){
			zoomLevel -= 1;
			gMap.gmap3({action: 'setOptions', args:[{zoom:zoomLevel}]});
		});
      	jQuery("#footer").prepend('<div class="markerNav" title="Prev" id="prevMarker">&lsaquo;</div><div id="markers"></div><div class="markerNav" title="Next" id="nextMarker">&rsaquo;</div><?php if($toggle){ ?><div id="mapTypeContainer"><div id="mapStyleContainer"><div id="mapStyle" class="terrain"></div></div><div id="mapType" title="Map Type" class="terrain"></div></div><?php } ?><?php if($zoomOn){ ?><div class="zoomControl" title="Zoom Out" id="zoomOut"><img src="<?php echo get_template_directory_uri();?>/images/zoomOut.png" alt="-" /></div><div class="zoomControl" title="Zoom In" id="zoomIn"><img src="<?php echo get_template_directory_uri();?>/images/zoomIn.png" alt="+" /></div><?php } ?>');
    }
        jQuery('body').prepend("<div id='target'></div>");
        
        gMap.gmap3({ 
        	action: 'init',
            onces: {
              bounds_changed: function(){
              	var number = 0;
                jQuery(this).gmap3({
                  action:'getBounds', 
                  callback: function (){
                  	<?php 
                  	$customList = new WP_Query();
                  	if($blogCat){
                  		$customList->query('showposts=100&cat=-'.$blogCat.'');
                  	}else{
                  		$customList->query('showposts=100'); 
                  	}/*above # calls out how many posts show on first page*/
                  	if ($customList->have_posts()) : while ($customList->have_posts()) : $customList->the_post(); 
                  	$data = get_post_meta( $post->ID, 'key', true );
                  	if($data[ 'pin' ]){$pin2 = $data[ 'pin' ]; } else {$pin2 = $pin;}
                  	?>
                  	add(jQuery(this), number += 1, "<?php the_title(); ?>", "<?php the_permalink() ?>","<?php if($data[ 'address_one' ]){ echo $data[ 'address_one' ]."<br />"; } ?><?php echo $data[ 'address_two' ]; ?>","<?php echo $data[ 'latitude' ]; ?>","<?php echo $data[ 'longitude' ]; ?>", '<?php the_post_thumbnail(); ?>','<?php echo $pin2;?>');<?php endwhile; else:?>
                  		alert('You need to add posts to display on the map.');
                  	<?php endif; 
                  	?>
                  }
                });
              }
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
        function add(jQuerythis, i, title, link, excerpt, lati, longi, img, pin){
          jQuerythis.gmap3({
            action : 'addMarker',
            lat:lati,
            lng:longi,
            options: {icon: new google.maps.MarkerImage(pin)},
            events:{
       			mouseover: function(marker){
          			jQuerythis.css({cursor:'pointer'});
          			jQuery('#markerTitle'+i+'').fadeIn({ duration: 200, queue: false }).animate({bottom:"32px"},{duration:200,queue:false});
          			jQuery('.markerInfo').removeClass('activeInfo').hide();
          			jQuery('#markerInfo'+i+'').addClass('activeInfo').show();
          			jQuery('.marker').removeClass('activeMarker');
          			jQuery('#marker'+i+'').addClass('activeMarker');
      			},
       			mouseout: function(){
          			jQuerythis.css({cursor:'default'});
          			jQuery('#markerTitle'+i+'').stop(true,true).fadeOut(200,function(){jQuery(this).css({bottom:"0"})});
      			},
      			click: function(marker){window.location = link}
   			},
            callback: function(marker){
              var jQuerybutton = jQuery('<div id="marker'+i+'" class="marker"><div id="markerInfo'+i+'" class="markerInfo"><a href="'+link+'">'+img+'</a><h2><a href="'+link+'">'+title+'</a></h2><p>'+excerpt+'</p><a class="markerLink" href="'+link+'">View Details &rarr;</a><div class="markerTotal">'+i+' / <span></span></div></div></div>');
              jQuerybutton.mouseover(function(){
                  jQuerythis.gmap3({
                    action:'panTo', 
                    args:[marker.position]
                  });
                  jQuery("#target").stop(true,true).fadeIn(1200).delay(500).fadeOut(1200);
               });
              jQuery('#markers').append(jQuerybutton);
              var numbers = jQuery(".markerInfo").length;
              jQuery(".markerTotal span").html(numbers);
              if(i == 1){
              	jQuery('.marker:first-child').addClass('activeMarker').mouseover();
              }
              jQuerythis.gmap3({
              	action:'addOverlay',
              	content: '<div id="markerTitle'+i+'" class="markerTitle">'+title+'</div>',
              	latLng: marker.getPosition()
               });
            }    		
          });
        }
});
//]]>
</script>