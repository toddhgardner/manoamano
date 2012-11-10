<?php
/*
Template Name: Project Map
*/
?>

<?php get_header(); ?>

<style>
	#map_canvas {
		height: 650px;
		width: 960px;
	}
</style>


<div id="content">

	<div id="featureimg"><?php the_post_thumbnail( 'page-feature' ); ?></div>

	<div id="contentwide">
    
        <div class="postarea">
    
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            	<!--  Content lives here  -->
            
            	<h1><?php the_title(); ?></h1>
            	<?php the_content(__('Read More'));?><div style="clear:both;"></div><?php edit_post_link('(Edit)', '', ''); ?>
            
            <?php endwhile; else: ?>
            
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
            
        </div>
		
	</div>
	
	<div id="map_canvas"></div>
			
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHsmNZZdw5ChH3LHg2uEHxkKDLQE0vohs&sensor=false"></script>
<script type="text/javascript">

	var archiveProject = {
		initialize: function() {
			var mapOptions = {
				center: new google.maps.LatLng(-16.425548, -63.984375),
				zoom: 6,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
			return map;
		},
		addMarker: function(options) {
			latitudeLongitude = new google.maps.LatLng(options.latitude, options.longitude)
			new google.maps.Marker({
				position: latitudeLongitude,
				map: options.map,
				title: options.title
			}); 
		}
	};

	var map = archiveProject.initialize();
	archiveProject.addMarker({"map":map, "latitude":-16.425548, "longitude":-63.984375, "title":"Test Title"});
	
	
</script>