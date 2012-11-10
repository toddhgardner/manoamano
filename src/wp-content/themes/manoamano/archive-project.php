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

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHsmNZZdw5ChH3LHg2uEHxkKDLQE0vohs&sensor=false"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/archiveProject.js"></script>

<div id="content">

	<div id="featureimg"><?php the_post_thumbnail( 'page-feature' ); ?></div>

	<div id="contentwide">
    
        <div class="postarea">
    		
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            	<!--  Content lives here  -->
            	<div class="archiveProject-marker" 
            		data-latitude="<?php echo get_post_meta($post->ID,'_project_latitude',true) ?>" 
            		data-longitude="<?php echo get_post_meta($post->ID,'_project_longitude',true) ?>" 
            		data-title="<?php the_title(); ?>"></div>

            <?php endwhile; else: ?>
            
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
            
        </div>
		
	</div>
	
	<div id="map_canvas"></div>
			
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>

<script type="text/javascript">
	var map = archiveProject.displayMap();
</script>
