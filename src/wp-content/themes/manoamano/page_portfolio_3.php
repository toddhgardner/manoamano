<?php
/*
Template Name: Portfolio Page 3 Column
*/
?>

<?php get_header(); ?>

<div id="content">

	<div id="featureimg"><?php the_post_thumbnail( 'page-feature' ); ?></div>

	<div id="contentwide">
	
		<div class="postarea">
        
        	<h1><?php the_title(); ?></h1>
            
            <?php $wp_query = new WP_Query(array('cat'=>of_get_option('select_categories_portfolio_3'),'showposts'=>of_get_option('number_display_portfolio_3'),'paged'=>$paged)); ?>
			<?php $post_class = 'first'; ?>
            <?php if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>
            <?php $meta_box = get_post_custom($post->ID); $video = $meta_box['custom_meta_video'][0]; ?>
            <?php global $more; $more = 0; ?>
            
            <div class="portfolio_3 <?php echo $post_class; ?>">
            
				<?php
                    if ('first' == $post_class){
                      $post_class = 'second';
                    }elseif ('second' == $post_class){
                      $post_class = 'third';
                    }else{
                      $post_class = 'first';
                    }
                ?>	

                <?php if ( $video ) : ?>
              		<div class="portfoliovideo_3"><?php echo $video; ?></div>
				<?php else: ?>
                    <div class="portfolioimg_3"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'portfolio-3' ); ?></a></div>
                <?php endif; ?>
                
                <div class="portfoliotitle_3">              
                    <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                    <?php the_excerpt(); ?>
                </div>
            
            </div>
							
			<?php endwhile; ?>
            
            <div id="pagination">
                <div id="prevLink"><p><?php previous_posts_link(); ?></p></div>
                <div id="nextLink"><p><?php next_posts_link(); ?></p></div>
            </div>
            
            <?php else : // do not delete ?>

            <h3><?php _e("Page not Found"); ?></h3>
            <p><?php _e("We're sorry, but the page you're looking for isn't here."); ?></p>
            <p><?php _e("Try searching for the page you are looking for or using the navigation in the header or sidebar"); ?></p>

			<?php endif; // do not delete ?>
		
		</div>
		
	</div>
		
</div>

<?php get_footer(); ?>