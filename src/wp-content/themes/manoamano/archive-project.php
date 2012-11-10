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
	
	.archiveProject-marker {
		display: none;
	}
</style>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHsmNZZdw5ChH3LHg2uEHxkKDLQE0vohs&sensor=false"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/archiveProject.js"></script>

<div id="content">

	<div id="featureimg"><?php the_post_thumbnail( 'page-feature' ); ?></div>

	<div id="contentwide">
    
        <div class="postarea transparent">
    		<h1>Our Projects</h1>
    		<select id="archiveProject-filter">
				<option value="all">All</option>
				<?php 
					$terms = get_terms( 'project_category', array('hide_empty' => true) ); 
					foreach ( $terms as $term ) {
						echo "<option value=".$term->name.">".$term->name."</option>";
					}
				?>
			</select>
            <?php if (have_posts()) : while (have_posts()) : the_post();
            
	            $terms =  get_the_terms($post->ID, 'project_category'); 
	            $category="all";
	            foreach ($terms as $term) {
					$category = $category."~".$term->name;
				}
            ?>
            	<!--  Content lives here  -->
            	<div class="archiveProject-marker" 
            			data-category="<?php echo $category; ?>"
            			data-latitude="<?php echo get_post_meta($post->ID,'_project_latitude',true) ?>" 
            			data-longitude="<?php echo get_post_meta($post->ID,'_project_longitude',true) ?>">
            		<div class="archiveProject-title"><?php the_title(); ?></div>
            		<div class="archiveProject-excerpt"><?php the_excerpt(); ?><a href="<?php echo the_permalink(); ?>" class="archiveProject-readMore">Read More &#8250;</a></div>
            	</div>

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
