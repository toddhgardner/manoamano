<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {

	// Test data
	$test_array = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");

	// Multicheck Array
	$multicheck_array = array("one" => "French Toast", "two" => "Pancake", "three" => "Omelette", "four" => "Crepe", "five" => "Waffle");

	// Multicheck Defaults
	$multicheck_defaults = array("one" => "true","five" => "true");

	// Background Defaults
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	// Slider Transition Array
	$transition_array = array("1000" => "1 Second", "2000" => "2 Seconds", "4000" => "4 Seconds", "6000" => "6 Seconds", "8000" => "8 Seconds", "10000" => "10 Seconds", "12000" => "12 Seconds", "14000" => "14 Seconds", "16000" => "16 Seconds", "18000" => "18 Seconds", "20000" => "20 Seconds", "30000" => "30 Seconds", "60000" => "1 Minute", "999999999" => "Hold Frame");
	
	// Yes or No Array
	$yesno_array = array("true" => "Yes", "false" => "No");


	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Add all categories option
    $options_categories[0] = "All Categories";

	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages['false'] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';

	$options = array();

	$options[] = array( "name" => "Homepage Settings",
						"type" => "heading");

	$options[] = array( "name" => "Featured Slider Category",
						"desc" => "Choose the category you wish to display in the homepage slider.",
						"id" => "select_categories_slider",
						"std" => "Select a category:",
						"type" => "select",
						"options" => $options_categories);
						
	$options[] = array( "name" => "Featured Slider Transition Interval",
						"desc" => "Choose the transition time for the homepage slider.",
						"id" => "slider_transition_interval",
						"std" => "Select a transition time:",
						"type" => "select",
						"options" => $transition_array);
						
	$options[] = array( "name" => "Display The Homepage Posts?",
						"desc" => "Select whether or not you would like to display the posts section on the homepage.",
						"id" => "display_homeblog",
						"std" => "Yes",
						"type" => "select",
						"options" => $yesno_array);
						
	$options[] = array( "name" => "Homepage Posts Category",
						"desc" => "Choose the category you wish to display in the homepage posts beneath the slider.",
						"id" => "select_categories_homeblog",
						"std" => "Select a category:",
						"type" => "select",
						"options" => $options_categories);
						
	$options[] = array( "name" => "Number Of Homepage Posts Displayed",
						"desc" => "Enter the number of posts you would like to display on the homepage.",
						"id" => "number_display_homeblog",
						"std" => "4",
						"type" => "text");
						
	$options[] = array( "name" => "Blog Page Template",
						"type" => "heading");
						
	$options[] = array( "name" => "Blog Template Category",
						"desc" => "Choose the category you wish to display on the blog page template.",
						"id" => "select_categories_blog",
						"std" => "Select a category:",
						"type" => "select",
						"options" => $options_categories);
								
	$options[] = array( "name" => "Blog Posts To Display",
						"desc" => "Enter the number of posts you would like to display on the blog page template.",
						"id" => "number_display_blog",
						"std" => "5",
						"type" => "text");
						
	$options[] = array( "name" => "Portfolio Templates",
						"type" => "heading");
						
	$options[] = array( "name" => "1 Column Portfolio Template Category",
						"desc" => "Choose the category you wish to display on the 1 column portfolio page template.",
						"id" => "select_categories_portfolio_1",
						"std" => "Select a category:",
						"type" => "select",
						"options" => $options_categories);
								
	$options[] = array( "name" => "1 Column Portfolio Posts To Display",
						"desc" => "Enter the number of posts you would like to display on the 1 column portfolio page template.",
						"id" => "number_display_portfolio_1",
						"std" => "12",
						"type" => "text");
						
	$options[] = array( "name" => "2 Column Portfolio Template Category",
						"desc" => "Choose the category you wish to display on the 2 column portfolio page template.",
						"id" => "select_categories_portfolio_2",
						"std" => "Select a category:",
						"type" => "select",
						"options" => $options_categories);
								
	$options[] = array( "name" => "2 Column Portfolio Posts To Display",
						"desc" => "Enter the number of posts you would like to display on the 2 column portfolio page template.",
						"id" => "number_display_portfolio_2",
						"std" => "12",
						"type" => "text");
						
	$options[] = array( "name" => "3 Column Portfolio Template Category",
						"desc" => "Choose the category you wish to display on the 3 column portfolio page template.",
						"id" => "select_categories_portfolio_3",
						"std" => "Select a category:",
						"type" => "select",
						"options" => $options_categories);
								
	$options[] = array( "name" => "3 Column Portfolio Posts To Display",
						"desc" => "Enter the number of posts you would like to display on the 3 column portfolio page template.",
						"id" => "number_display_portfolio_3",
						"std" => "12",
						"type" => "text");
						
	$options[] = array( "name" => "Portfolio Categories",
						"type" => "heading");
						
	$options[] = array( "name" => "Display 1 Column Portfolio?",
						"desc" => "Select whether or not you would like to display the 1 column portfolio layout on category pages.",
						"id" => "display_1_column",
						"std" => "No",
						"type" => "select",
						"options" => $yesno_array);
						
	$options[] = array( "name" => "Display 2 Column Portfolio?",
						"desc" => "Select whether or not you would like to display the 2 column portfolio layout on category pages.",
						"id" => "display_2_column",
						"std" => "No",
						"type" => "select",
						"options" => $yesno_array);

	return $options;
}