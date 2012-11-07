<?php get_header(); ?>

<div id="content">

	<div id="contentleft">
    
    	<div class="postarea">
    
		<!-- This sets the $curauth variable -->
        
		<?php
		
			if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
			else :
			$curauth = get_userdata(intval($author));
			endif;
			
		?>
        
		<h3><?php _e("About:", 'organicthemes'); ?> <?php echo $curauth->display_name; ?></h3>
		<p><strong><?php _e("Website:", 'organicthemes'); ?></strong> <a href=”<?php echo $curauth->user_url; ?>”><?php echo $curauth->user_url; ?></a></p>
		<p><strong><?php _e("Profile:", 'organicthemes'); ?></strong> <?php echo $curauth->user_description; ?></p>
		<h3><?php _e("Posts by", 'organicthemes'); ?> <?php echo $curauth->display_name; ?>:</h3>
        
		<ul>
        
		<!– The Loop –>
        
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
				<?php the_title(); ?></a>
			</li>
			<?php endwhile; else: ?>
			<p><?php _e('No posts by this author.'); ?></p>
			<?php endif; ?>
            
		<!– End Loop –>
        
		</ul>
        
	</div>
    
    </div>
			
	<?php include(TEMPLATEPATH."/sidebar.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>