<?php get_header(); ?>

<div id="content">

	<div id="contentleft">

		<div class="postarea">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php $meta_box = get_post_custom($post->ID); $video = $meta_box['custom_meta_video'][0]; ?>

            <h3><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>

            <div class="postauthor">
            	<p><?php _e("Posted by", 'organicthemes'); ?> <?php the_author_posts_link(); ?> on <?php the_time('F j, Y'); ?></p>      
            </div>
            
            <?php if ( $video ) : ?>
                <div class="feature_video"><?php echo $video; ?></div>
            <?php else: ?>
                <div class="feature_img"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'archive-thumb' ); ?></a></div>
            <?php endif; ?>

            <?php the_excerpt('Read More'); ?><div style="clear:both;"></div>   

			<div class="postmeta">
				<p><?php _e("Category:", 'organicthemes'); ?> <?php the_category(', ') ?> &middot; <?php _e("Tags:", 'organicthemes'); ?> <?php the_tags('') ?></p>
			</div>

			<?php endwhile; else: ?>         
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; ?>
            
            <div id="pagination">
                <div id="prevLink"><p><?php previous_posts_link(); ?></p></div>
                <div id="nextLink"><p><?php next_posts_link(); ?></p></div>
            </div>

        </div>

	</div>

	<?php include(TEMPLATEPATH."/sidebar.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>