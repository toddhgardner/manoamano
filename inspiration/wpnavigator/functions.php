<?php

//OPTIONS PLUGIN CHECK
wpaid_check();
function wpaid_check()
{
  if ( !function_exists('option_tree_css_save') )
  {
    add_thickbox(); // Required for the plugin install dialog.
    add_action('admin_notices', 'wpaid_check_notice');
  }
}
add_theme_support('automatic-feed-links' );
// The Admin Notice if OptionTree not installed.
function wpaid_check_notice()
{
?>
  <div class='updated fade'>
    <p>The OptionTree plugin is required for this theme to function properly. <a href="<?php echo admin_url('plugin-install.php?tab=plugin-information&plugin=option-tree&TB_iframe=true&width=640&height=517'); ?>" class="thickbox onclick">Install now</a>.</p>
  </div>
<?php
}


add_theme_support('automatic-feed-links' );

if ( !isset( $content_width ) ) $content_width = 300;

//EXCERPT STUFF
function new_excerpt_more($more) {
	return ' ...';
}
add_filter('excerpt_more', 'new_excerpt_more');

//IMAGE ATTACHMENTS TOOLBOX
function attachment_toolbox($size = thumbnail) {

	if($images = get_children(array(
		'post_parent'    => get_the_ID(),
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
		'orderby' => 'menu_order'
	))) {
		foreach($images as $image) {
			$attimg   = wp_get_attachment_image($image->ID,$size);
			$atturl   = wp_get_attachment_url($image->ID);
			$attlink  = get_attachment_link($image->ID);
			$postlink = get_permalink($image->post_parent);
			$atttitle = apply_filters('the_title',$image->post_title);
			/*
			echo '<p><strong>wp_get_attachment_image()</strong><br />'.$attimg.'</p>';
			echo '<p><strong>wp_get_attachment_url()</strong><br />'.$atturl.'</p>';
			echo '<p><strong>get_attachment_link()</strong><br />'.$attlink.'</p>';
			echo '<p><strong>get_permalink()</strong><br />'.$postlink.'</p>';
			echo '<p><strong>Title of attachment</strong><br />'.$atttitle.'</p>';
			echo '<p><strong>Image link to attachment page</strong><br /><a href="'.$attlink.'">'.$attimg.'</a></p>';
			echo '<p><strong>Image link to attachment post</strong><br /><a href="'.$postlink.'">'.$attimg.'</a></p>';
			echo '<p><strong>Image link to attachment file</strong><br /><a href="'.$atturl.'">'.$attimg.'</a></p>';
			*/ 
			echo'<li class="wrapperli"><a href="'.$atturl.'">'.$attimg.'</a></li>';
		}
	}
}

//EXCLUDE PAGES FROM SEARCH
function SearchFilter($query) {
	if ($query->is_search) {
    	$query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','SearchFilter');

//FEATURED IMAGE SUPPORT
add_theme_support( 'post-thumbnails', array( 'post' ) );
set_post_thumbnail_size( 95, 95, true );
add_image_size( 'slider',300 ,200, true );
add_image_size( 'blog',500 ,200, true );
add_image_size( 'small',53 ,53, true );

//CATEGORY ID FROM NAME FOR PAGE TEMPLATES
function get_category_id($cat_name){
	$term = get_term_by('name', $cat_name, 'category');
	return $term->term_id;
}

//ADD MENU SUPPORT
add_theme_support( 'menus' );
register_nav_menu('main', 'Main Navigation Menu');

//REPLACE FOOTER INFO
function remove_footer_admin () {
    echo "Theme designed and developed by <a href='http://themeforest.net/user/themolitor/portfolio?ref=themolitor'>THE MOLITOR</a>";
} 
add_filter('admin_footer_text', 'remove_footer_admin');

//BREADCRUMBS
function dimox_breadcrumbs() {
  $delimiter = '&nbsp;/&nbsp;';
  $name = 'Home';
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
  if ( !is_home() && !is_front_page() || is_paged() ) {
    echo '<div id="crumbs">';
    global $post;
    $home = home_url();
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . '';
      single_cat_title();
      echo '' . $currentAfter;
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
    } elseif ( is_single() && !is_attachment() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      //the_title();
      echo "Current Page";
      echo $currentAfter;
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    } elseif ( is_search() ) {
      echo $currentBefore . 'Search Results' . $currentAfter;
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo '</div>';
  }
}

//SIDEBAR GENERATOR (FOR SIDEBAR AND FOOTER)-----------------------------------------------
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Live Widgets',
	'description' => 'It is recommended that you not exceed 3 widgets here.',
	'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget' => '</li>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>',
));

//CUSOTM POST OPTIONS
$key = "key";

$meta_boxes = array(

"zoom" => array(
"name" => "zoom",
"title" => "Zoom Level",
"description" => "Enter a number between 0 and 20, where '0' is maximum zoomed out and '20' is maximum zoomed in."),

"latitude" => array(
"name" => "latitude",
"title" => "Latitude",
"description" => "You can generate this info here: <a target='_blank' href='http://itouchmap.com/latlong.html'>http://itouchmap.com/latlong.html</a>"),

"longitude" => array(
"name" => "longitude",
"title" => "Longitude",
"description" => "You can generate this info here: <a target='_blank' href='http://itouchmap.com/latlong.html'>http://itouchmap.com/latlong.html</a>"),

"address_one" => array(
"name" => "address_one",
"title" => "Address Line 1",
"description" => "Example: '100th ST NW'"),

"address_two" => array(
"name" => "address_two",
"title" => "Address Line 2",
"description" => "Example: 'Seattle, WA 98016'"),

"pin" => array(
"name" => "pin",
"title" => "Custom Marker Image URL",
"description" => "Enter full URL to customize the marker for this post."),

"bg_img" => array(
"name" => "bg_img",
"title" => "Background Image URL",
"description" => "This is used when no latitude and longitude is provided above."),

);
function create_meta_box() {
	global $key;
	if( function_exists( 'add_meta_box' ) ) {
		add_meta_box( 'new-meta-boxes', ' Custom Post Options', 'display_meta_box', 'post', 'normal', 'high' );
		add_meta_box( 'new-meta-boxes', ' Custom Post Options', 'display_meta_box', 'page', 'normal', 'high' );
	}
}
function display_meta_box() {
	global $post, $meta_boxes, $key;
?>
<div class="form-wrap">
<?php wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );
foreach($meta_boxes as $meta_box) {
	$data = get_post_meta($post->ID, $key, true);
?>
<div class="form-field form-required">
	<label for="<?php echo $meta_box[ 'name' ]; ?>"><?php echo $meta_box[ 'title' ]; ?></label>
	<input type="text" name="<?php echo $meta_box[ 'name' ]; ?>" value="<?php echo htmlspecialchars( $data[ $meta_box[ 'name' ] ] ); ?>" />
	<p><?php echo $meta_box[ 'description' ]; ?></p>
</div>
<?php } ?>
</div>
<?php
}
function save_meta_box( $post_id ) {
	global $post, $meta_boxes, $key;
	foreach( $meta_boxes as $meta_box ) {
		$data[ $meta_box[ 'name' ] ] = $_POST[ $meta_box[ 'name' ] ];
	}
	if ( !wp_verify_nonce( $_POST[ $key . '_wpnonce' ], plugin_basename(__FILE__) ) )
	return $post_id;
	if ( !current_user_can( 'edit_post', $post_id ))
	return $post_id;
	update_post_meta( $post_id, $key, $data );
}
add_action( 'admin_menu', 'create_meta_box' );
add_action( 'save_post', 'save_meta_box' );
?>