<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>
<?php $pageId = $post->ID; ?>
<div id="contenthome">

	<div id="homepagetop">

		<div id="homeslider">
			<ul id="slider1">
				<?php
					$recent = new WP_Query("cat=" . of_get_option('select_categories_slider'));
					while ($recent->have_posts()) : $recent->the_post();
						$meta_box = get_post_custom($post->ID);
						$video = $meta_box['custom_meta_video'][0];
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'home-feature' );
						$thumburl = $thumb['0'];
				?>
				<li>
					<?php if ($video) : ?>
					<div class="feature_video"><?=$video?></div>
					<?php else: ?>
					<div class="feature_img" style="background: url(<?=$thumburl?>) 0 0 no-repeat">
						<?php endif; ?>
						<div class="slideinfo">
							<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
							<?php the_content_limit(160); ?>
						</div>
						
					</div>
				</li>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); // reset the_post from the above loops ?>
			</ul>
		</div>

		<div id="navmenu">
			<?php wp_nav_menu( array( 'theme_location' => 'home-menu',
											  'title_li' => '',
											  'depth' => 1,
											  'container_class' => 'homemenu',
											  'menu_class' => 'homemenu') ); ?>
		</div>

	</div>

	<?php if (of_get_option('display_homeblog') == 'true') { ?>
	<div id="homepage">

		<?php $wp_query = new WP_Query(array('cat' => of_get_option('select_categories_homeblog'), 'showposts' => of_get_option('number_display_homeblog'))); ?>
		<?php $post_class = 'first'; ?>
		<?php if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
		<?php $meta_box = get_post_custom($post->ID); $video = $meta_box['custom_meta_video'][0]; ?>
		<?php global $more;
		$more = 0; ?>

		<div class="homebox <?php echo $post_class; ?>">

			<?php
				if ('first' == $post_class) {
					$post_class = 'second';
				} elseif ('second' == $post_class) {
					$post_class = 'third';
				} elseif ('third' == $post_class) {
					$post_class = 'fourth';
				} else {
					$post_class = 'first';
				}
			?>

			<?php if ($video) : ?>
			<div class="home_video"><?php echo $video; ?></div>
			<?php else: ?>
			<div class="home_img"><a href="<?php the_permalink() ?>"
											 rel="bookmark"><?php the_post_thumbnail('home-thumbnail'); ?></a></div>
			<?php endif; ?>

			<div class="homeboxinfo">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			</div>

		</div>

		<?php endwhile; ?>
		<?php else : // do not delete ?>
		<?php endif; // do not delete ?>

	</div>
	<?php } else { ?>
	<?php } ?>
	
	<div style="clear:both;"></div>
	
	<?php $pageQuery = new WP_Query("page_id=$pageId&showposts=1"); // reset the_post from the above loops ?>
	<?php if ($pageQuery->have_posts()) : while ($pageQuery->have_posts()) : $pageQuery->the_post(); ?>

	<div id="homecontent">
    
            <?php the_content(__('Read More'));?><div style="clear:both;"></div><?php edit_post_link('(Edit)', '', ''); ?>
            
	</div>
			
    <?php endwhile; endif; ?>
       	
</div>

<?php get_footer(); ?>