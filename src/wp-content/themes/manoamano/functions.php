<?php

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {
    if ( ! class_exists( 'cmb_Meta_Box' ) )
        require_once 'metabox/init.php';
}


// Turn a category ID to a Name
function cat_id_to_name($id) {
	foreach((array)(get_categories()) as $category) {
    	if ($id == $category->cat_ID) { return $category->cat_name; break; }
	}
}

/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */

if ( !function_exists( 'of_get_option' ) ) {
	function of_get_option($name, $default = 'false') {
		
		$optionsframework_settings = get_option('optionsframework');
		
		// Gets the unique option id
		$option_name = $option_name = $optionsframework_settings['id'];
		
		if ( get_option($option_name) ) {
			$options = get_option($option_name);
		}
			
		if ( !empty($options[$name]) ) {
			return $options[$name];
		} else {
			return $default;
		}
	}	
}

if ( !function_exists( 'optionsframework_add_page' ) && current_user_can('edit_theme_options') ) {
	function options_default() {
		add_theme_page(__('Theme Options','organicthemes'), __('Theme Options','organicthemes'), 'edit_theme_options', 'options-framework','optionsframework_page_notice');
	}
	add_action('admin_menu', 'options_default');
}

// Displays a notice on the theme options page if the Options Framework plugin is not installed
if ( !function_exists( 'optionsframework_page_notice' ) ) {
	add_thickbox(); // Required for the plugin install dialog.

	function optionsframework_page_notice() { ?>
	
		<div class="wrap">
		<?php screen_icon( 'themes' ); ?>
		<h2><?php _e('Theme Options','organicthemes'); ?></h2>
        <p><b>This theme requires the Options Framework plugin installed and activated to manage your theme options. <a href="<?php echo admin_url('plugin-install.php?tab=plugin-information&plugin=options-framework&TB_iframe=true&width=640&height=517'); ?>" class="thickbox onclick">Install Now</a></b></p>
		</div>
		<?php
	}
}

//	Include the Custom Header code
// include_once(TEMPLATEPATH.'/includes/custom-header.php'); // Turned off, doesnt need to change

//	Load local Gravity Forms styles if the plugin is installed
if(class_exists("RGForms") && !is_admin()){
    wp_enqueue_style("local_gf_styles", get_bloginfo('template_url') . "/includes/organic_gforms.css");
    if(!get_option('rg_gforms_disable_css'))
        update_option('rg_gforms_disable_css', true);
}

//	Register sidebars
if ( function_exists('register_sidebars') )
	register_sidebar(array('name'=>'Sidebar','before_widget'=>'<div id="%1$s" class="widget %2$s">','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>'));

//	Include Content Limit function
function the_content_limit($max_char, $more_link_text = 'Read More', $stripteaser = 0, $more_file = '') {

    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      echo "<p>";
      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>"."Read More</a>";
      echo "</p>";
   }

   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {

        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "<p>";
        echo $content;
        echo "...";
        echo "&nbsp;<a href='";
        the_permalink();
        echo "'>".$more_link_text."</a>";
        echo "</p>";
   }
   
   else {
      echo "<p>";
      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>"."Read More</a>";
      echo "</p>";

   }
}

// Add Custom Meta Box To Posts

$prefix = 'custom_meta_';

$meta_box = array(
    'id' => 'my-meta-box',
    'title' => 'Featured Video',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Paste Video Embed Code',
            'desc' => 'Enter Vimeo, YouTube or other embed code to display a featured video. (640px by 360px Featured Slider)',
            'id' => $prefix . 'video',
            'type' => 'textarea',
            'std' => ''
        ),
    )
);

add_action('admin_menu', 'mytheme_add_box');

// Add meta box
function mytheme_add_box() {
    global $meta_box;
    
    add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function mytheme_show_box() {
    global $meta_box, $post;
    
    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        
        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="8" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
        }
        echo     '<td>',
            '</tr>';
    }
    
    echo '</table>';
}

add_action('save_post', 'mytheme_save_data');

// Save data from meta box
function mytheme_save_data($post_id) {
    global $meta_box;
    
    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

// Add ID and CLASS attributes to the first <ul> occurence in wp_page_menu
function add_menuclass($ulclass) {
return preg_replace('/<ul>/', '<ul class="menu">', $ulclass, 1);
}
add_filter('wp_page_menu','add_menuclass');
add_filter('wp_nav_menu','add_menuclass');

// Add custom background
if ( function_exists('add_custom_background') )
add_custom_background();

// Add navigation support
if ( function_exists('add_theme_support') )
add_theme_support( 'menus' );


function register_menus(){
	register_nav_menus(
	array(
		'main-menu' => __('Main Menu'),
		'home-menu' => __('Home Menu')
	)
);}
add_action('init','register_menus');


// let's create the function for the custom type
function register_project_post_type() { 
    /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
    register_post_type( 'project', 
        // let's now add all the options for this post type
        array('labels' => array(
            'name' => __('Projects', 'post type general name'), /* This is the Title of the Group */
            'singular_name' => __('Project', 'post type singular name'), /* This is the individual type */
            'all_items' => __('All Projects'), /* the all items menu item */
            'add_new' => __('Add New', 'custom post type item'), /* The add new menu item */
            'add_new_item' => __('Add New Project'), /* Add New Display Title */
            'edit' => __( 'Edit' ), /* Edit Dialog */
            'edit_item' => __('Edit Project'), /* Edit Display Title */
            'new_item' => __('New Project'), /* New Display Title */
            'view_item' => __('View Project'), /* View Display Title */
            'search_items' => __('Search Projects'), /* Search Custom Type Title */ 
            'not_found' =>  __('Nothing found in the Database.'), /* This displays if there are no entries yet */ 
            'not_found_in_trash' => __('Nothing found in Trash'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
            ), /* end of arrays */
            'description' => __( 'Geospacial project in Bolivia' ), /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
            'menu_icon' => get_stylesheet_directory_uri() . '/images/project-icon.png', /* the icon for the custom post type menu */
            'rewrite'   => array( 'slug' => 'project' ), /*, 'with_front' => true ), /* you can specify it's url slug */
            'has_archive' => true, /*'project',  you can rename the slug here */
            'capability_type' => 'post',
            'hierarchical' => true,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array( 'title', 'editor', 'excerpt', 'revisions', 'sticky')
        ) /* end of options */
    ); /* end of register post type */
    
    /* this ads your post categories to your custom post type */
    register_taxonomy_for_object_type('project_category', 'project');
    
    /* this ads your post tags to your custom post type */
    //register_taxonomy_for_object_type('post_tag', 'custom_type');
} 
add_action( 'init', 'register_project_post_type');

// now let's add custom categories (these act like categories)
register_taxonomy( 'project_category', 
    array('project'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    array('hierarchical' => true,     /* if this is true, it acts like categories */             
        'labels' => array(
            'name' => __( 'Category', 'manoamano' ), /* name of the custom taxonomy */
        ),
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'category' ),
    )
);   

add_filter( 'cmb_meta_boxes', 'cmb_project_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_project_metaboxes( array $meta_boxes ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_project_';

    $meta_boxes[] = array(
        'id'         => 'project_metabox',
        'title'      => 'Project Metabox',
        'pages'      => array( 'project', ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => 'Geospacial Coordinates',
                'desc' => 'The location of this project',
                'id'   => $prefix . 'geospacial_title',
                'type' => 'title',
            ),
            array(
                'name' => 'Latitude',
                /*'desc' => 'field description (optional)',*/
                'id'   => $prefix . 'latitude',
                'type' => 'text',
            ),
            array(
                'name' => 'Longitude',
                /*'desc' => 'field description (optional)',*/
                'id'   => $prefix . 'longitude',
                'type' => 'text',
            ),
            array(
                'name' => 'Map Zoom Level',
                /*'desc' => 'field description (optional)',*/
                'id'   => $prefix . 'map_zoom',
                'type' => 'text',
            )
        ), 
    );

    return $meta_boxes;
}



// Display home page link in custom menu
function home_page_menu_args( $args ) {
$args['show_home'] = true;
return $args;
}
add_filter('wp_page_menu_args', 'home_page_menu_args');

// Add default posts and comments RSS feed links to head
if ( function_exists('add_theme_support') )
add_theme_support( 'automatic-feed-links' );

//	Add thumbnail support
if ( function_exists('add_theme_support') )
add_theme_support('post-thumbnails');
add_image_size( 'home-feature', 580, 252, true ); // Homepage Feature Image
add_image_size( 'home-thumbnail', 230, 155, true ); // Homepage Feature Bottom Image
add_image_size( 'page-feature', 960, 420, true ); // Page Banner Image
add_image_size( 'archive-thumb', 640, 640, true ); // Archive Page Thumbnail
add_image_size( 'portfolio-1', 950, 720 ); // Portfolio Page 1 Column Images
add_image_size( 'portfolio-2', 462, 400 ); // Portfolio Page 2 Column Images
add_image_size( 'portfolio-3', 300, 500 ); // Portfolio Page 3 Column Images
add_image_size( 'thumb-xs', 40, 40, true ); // Homepage Feature Image

?>