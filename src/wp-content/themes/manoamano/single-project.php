<?php
/*
This is the custom post type post template.
If you edit the post type name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom post type is called
register_post_type( 'bookmarks',
then your single template should be
single-bookmarks.php

*/
?>

<?php get_header(); ?>
			
			<div id="content">
			
				<div id="inner-content" class="wrap clearfix">
			
				    <div id="main" class="eightcol first clearfix" role="main">

					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					    <article id="post-<?php the_ID(); ?>" class="article" <?php post_class('clearfix'); ?> role="article">

							<div id="map_canvas"></div>
						
						    <header class="article-header">
							    <h1 class="single-title custom-post-type-title transparent">
									<div class="headerLeft" style="margin-right:10px;">
										<a href="<?php echo get_option('siteurl'); ?>/project/"><</a> 
									</div>
									<div class="headerLeft">
										<?php the_title(); ?>
									</div>
									<div class="headerZoomButtons">
										<a href="javascript:archiveProject.zoomBy(map, +1);">+</a>
										<a href="javascript:archiveProject.zoomBy(map, -1);">-</a>
									</div>
									<div style="clear:both;"></div>
								</h1>
						    </header> <!-- end article header -->
					
						    <section class="entry-content clearfix transparent">
								<div class="contentScroller">
									<?php the_content(); ?>
								</div>
						    </section> <!-- end article section -->
							
					    </article> <!-- end article -->


						
						<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHsmNZZdw5ChH3LHg2uEHxkKDLQE0vohs&sensor=false"></script>
						<script type="text/javascript">

							var archiveProject = {
								initialize: function() {
									var mapOptions = {
										center: new google.maps.LatLng(<?php echo get_post_meta($post->ID,'_project_latitude',true) ?>, <?php echo get_post_meta($post->ID,'_project_longitude',true) ?>),
										zoom: <?php echo get_post_meta($post->ID,'_project_map_zoom',true) ?>,
										mapTypeId: google.maps.MapTypeId.SATELLITE,
										zoomControl: false,
										panControl: false,
										mapTypeControl: false,
										streetViewControl: false
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
									options.map.panBy(-230,0);
								},
								
								zoomBy: function(map, amount) {
									var value = map.getZoom();
									map.setZoom(value + amount);
									map.setCenter(new google.maps.LatLng(<?php echo get_post_meta($post->ID,'_project_latitude',true) ?>, <?php echo get_post_meta($post->ID,'_project_longitude',true) ?>));
									map.panBy(-230,0);
								}
							};

							var map = archiveProject.initialize();
							archiveProject.addMarker({"map":map, "latitude":<?php echo get_post_meta($post->ID,'_project_latitude',true) ?>, "longitude":<?php echo get_post_meta($post->ID,'_project_longitude',true) ?>, "title":"Test Title"});
							
							
						</script>
						
					    <?php endwhile; ?>			
					
					    <?php else : ?>
					
        					<article id="post-not-found" class="hentry clearfix">
        						<header class="article-header">
        							<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
        						</header>
        						<section class="entry-content">
        							<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
        						</section>
        						<footer class="article-footer">
        						    <p><?php _e("This is the error message in the single-custom_type.php template.", "bonestheme"); ?></p>
        						</footer>
        					</article>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    
				    <!--?php get_sidebar(); ?-->
				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>

<style>
	.headerLeft {
		float:left;
	}
	
	.headerZoomButtons {
		float:right;
	}
	
	.headerLeft a, .headerZoomButtons a {
		padding:0px 5px;
		border:1px solid #FFFFFF;
		-moz-border-radius: 15px;
		border-radius: 15px;
	}
	
	.headerLeft a:hover, .headerZoomButtons a:hover {
		border:1px solid #FFFFFF;
	}

	.article {
		min-height:650px;
	}
	
	.entry-content, #content h1 {
		background: #222222;
	}

	.article-header {
		z-index:1;
		position:relative;
		top:20px;
	}

	.entry-content {
		width:400px;
		height:460px;
		position:relative;
		z-index:1;
		top:60px;
		left:30px;
		padding:15px;
	}
	
	.contentScroller {
		height:450px;
		overflow-x:hidden;
		overflow-y:auto;
		color:#FFFFFF;
	}
	
	#map_canvas {
		position:relative;
		width: 1000px;
		height: 650px;
		margin-bottom:-650px;
		z-index:0;
	}
	
	#contentwrap {
		padding:0px;
	}
	
	#content {
		width: 100%;
	}
</style>

<!--[if IE]>
   
   <style type="text/css">

   .color-block { 
       background:transparent;
       filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#CC000000,endColorstr=#CC000000); 
       zoom: 1;
    } 

    </style>

<![endif]-->
