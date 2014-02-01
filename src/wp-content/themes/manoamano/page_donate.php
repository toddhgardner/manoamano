<?php
/*
Template Name: Donation Template
*/
?>
<?php get_header(); ?>

<div id="content">

	<div id="featureimg"><?php the_post_thumbnail( 'page-feature' ); ?></div>

	<div id="contentwide">

        <div class="postarea">

			<div class="donate-wrap">
				<div class="donate-box">
					<h2 class="dontate-title">Marketing Message</h2>
					<h3 class="donate-sub-title">Sub marketing message</h3>
                    <div class="stripe-wrap">
                        <?php echo do_shortcode("[wp-stripe]") ?>
                    </div>
				</div>
            </div>

            <div class="donate-tabs">
            	<div class="donate-tab donate-tab-1 active">Tab 1</div>
            	<div class="donate-tab donate-tab2">Tab 2</div>
            	<div class="donate-tab donate-tab3">Tab 3</div>
            	<div class="donate-tab donate-tab4">Tab 4</div>
            </div>
            <div class="donate-tabs-content">
            	<div class="donate-content donate-content-1">content 1</div>
            	<div class="donate-content donate-content-2">content 2</div>
            	<div class="donate-content donate-content-3">content 3</div>
            	<div class="donate-content donate-content-4">content 4</div>
            </div>

    		<!-- <div class="wysiwig">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>


            <?php the_content(__('Read More'));?><div style="clear:both;"></div><?php edit_post_link('(Edit)', '', ''); ?>

            <?php endwhile; else: ?>

            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
            <div> -->



        </div>

	</div>


</div>

<!-- The main column ends  -->

<?php get_footer(); ?>