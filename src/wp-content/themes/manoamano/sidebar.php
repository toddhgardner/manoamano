<!-- begin right sidebar -->

<div id="sidebar">
 

	<?php 
		$children = wp_list_pages("sort_column=menu_order&depth=1&title_li=&child_of=".$post->ID."&echo=0");
		if ($children != '') : ?>
		
		<div id="subNavWrapper">
			<ul id="subNav">
				<?php echo $children; ?>
			</ul>
		</div>
		
	<?php else : ?>
	
		<div id="emptySubNavWrapper"></div>
		
	<?php endif; ?>
 
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?>
    	
		<div class="widget">
            <h4>Widget Area</h4>
            <p>This section is widgetized. To add widgets here, go to the <a href="<?php echo admin_url(); ?>widgets.php">Widgets</a> panel in your WordPress admin, and add the widgets you would like to <strong>Sidebar</strong>.</p>
            <p><small>*This message will be overwritten after widgets have been added</small></p>
        </div>
		
	<?php endif; ?>
    
</div>

<!-- end right sidebar -->