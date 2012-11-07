<?php
/*
Template Name: Archive
*/
?>


<?php get_header(); ?>

<div id="content">

	<div id="contentleft">

        <div class="postarea">

				<h1><?php the_title(); ?></h1>		

				<div class="archive_column">

					<h4><?php _e("By Page:", 'organicthemes'); ?></h4>

						<ul>
							<?php wp_list_pages('title_li='); ?>
						</ul>

					<h4><?php _e("By Month:", 'organicthemes'); ?></h4>

						<ul>
							<?php wp_get_archives('type=monthly'); ?>
						</ul>	

					<h4><?php _e("By Category:", 'organicthemes'); ?></h4>

						<ul>
							<?php wp_list_categories('sort_column=name&title_li='); ?>
						</ul>	

				</div>		

				<div class="archive_column">				

					<h4><?php _e("By Post:", 'organicthemes'); ?></h4>

						<ul>
							<?php wp_get_archives('type=postbypost&limit=100'); ?> 
						</ul>

				</div>		            

          </div>

	</div>

<?php include(TEMPLATEPATH."/sidebar.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>