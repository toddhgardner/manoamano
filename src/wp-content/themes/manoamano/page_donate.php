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

    		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="donate-wrap">
				<div class="donate-box">
					<h2 class="dontate-title"><?php echo get_field('donation_box_header'); ?></h2>
					<h3 class="donate-sub-title"><?php echo get_field('donation_box_subheader'); ?></h3>
					<div class="stripe-wrap">
                        <?php echo do_shortcode("[wp-stripe]") ?>
                    </div>
				</div>
            </div>

            <div class="donate-tabs">
            	<div class="donate-tab donate-tab-1 active" data-content="1">
            		<div class="donate-tab-thumb">
            			<?php if($img =get_field('thumb_image1')){ ?>
            				<?php $image = wp_get_attachment_image_src( $img['id'],'thumb-xs' ); ?>
                                    <img src="<?php echo $image[0]; ?>" width=40 height=40/>
            			<?php }else{ ?>
            				<img src="<?php echo get_template_directory_uri(); ?>/images/donate-family.jpg" width="40" height="40"/>
            			<?php } ?>
            		</div>
            		<div class="donate-tab-title">
            			<?php echo get_field('title1'); ?>
            		</div>
            		<div class="dontate-tab-content"><?php echo get_field('subtitle1'); ?></div>
            	</div>
            	<div class="donate-tab donate-tab2"  data-content="2">
            		<div class="donate-tab-thumb">
            			<?php if($img =get_field('thumb_image2')){ ?>
                                    <?php $image = wp_get_attachment_image_src( $img['id'],'thumb-xs' ); ?>
                                    <img src="<?php echo $image[0]; ?>" width=40 height=40/>
                              <?php }else{ ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/donate-family.jpg" width="40" height="40"/>
                              <?php } ?>
                        </div>
            		<div class="donate-tab-title">
            			<?php echo get_field('title2'); ?>
            		</div>
            		<div class="dontate-tab-content"><?php echo get_field('subtitle2'); ?></div>
            	</div>
            	<div class="donate-tab donate-tab3"  data-content="3">
            		<div class="donate-tab-thumb">
            			<?php if($img =get_field('thumb_image3')){ ?>
                                    <?php $image = wp_get_attachment_image_src( $img['id'],'thumb-xs' ); ?>
                                    <img src="<?php echo $image[0]; ?>" width=40 height=40/>
                              <?php }else{ ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/donate-family.jpg" width="40" height="40"/>
                              <?php } ?>
                        </div>
            		<div class="donate-tab-title">
            			<?php echo get_field('title3'); ?>
            		</div>
            		<div class="dontate-tab-content"><?php echo get_field('subtitle3'); ?></div>
            	</div>
            	<div class="donate-tab donate-tab4"  data-content="4">
            		<div class="donate-tab-thumb">
            			<?php if($img =get_field('thumb_image4')){ ?>
                                    <?php $image = wp_get_attachment_image_src( $img['id'],'thumb-xs' ); ?>
                                    <img src="<?php echo $image[0]; ?>" width=40 height=40/>
                              <?php }else{ ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/donate-family.jpg" width="40" height="40"/>
                              <?php } ?></div>
            		<div class="donate-tab-title">
            			<?php echo get_field('title4'); ?>
            		</div>
            		<div class="dontate-tab-content"><?php echo get_field('subtitle4'); ?></div>
            	</div>
            </div>

            <div class="donate-tabs-content">
            	<div class="donate-content donate-content-1 active"><?php echo get_field('content1'); ?></div>
            	<div class="donate-content donate-content-2"><?php echo get_field('content2'); ?></div>
            	<div class="donate-content donate-content-3"><?php echo get_field('content3'); ?></div>
            	<div class="donate-content donate-content-4"><?php echo get_field('content4'); ?></div>
            </div>

			
			<?php endwhile; endif;  ?>
  

        </div>

	</div>


</div>

<!-- The main column ends  -->

<?php get_footer(); ?>