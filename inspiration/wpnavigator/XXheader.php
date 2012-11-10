<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta name="description" content="Dig The Falls - New York State waterfalls, nature and now so much more!" />
<meta name="keywords" content="New York, Waterfalls, Nature, Dig The Falls, Hiking, Biking, Canoeing, Snow Shoeing, State Park, Town Park, Trails" />
<meta name="classification" content="Education" />
<meta name="copyright" content="Copyright 2011 Dig The Falls" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php
    //OptionTree Stuff
    if ( function_exists( 'get_option_tree') ) {
        $theme_options = get_option('option_tree');
        $logo = get_option_tree('logo',$theme_options);
        $favicon = get_option_tree('favicon',$theme_options);
        $tagline = get_option_tree('tagline',$theme_options);
        $color = get_option_tree('color',$theme_options);
        $css = get_option_tree('css',$theme_options);
        $googleApi = get_option_tree('google_api',$theme_options);
        $googleKeyword = get_option_tree('google_keyword',$theme_options);
        if(!$color){$color = "#99b3cc";}
    } ?>

<?php if($favicon) { ?><link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" /><?php } ?> 

<?php if($googleApi) { echo $googleApi; } ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/scripts/prettyPhoto.css" type="text/css" media="screen" />

<style type="text/css">
<?php if($logo){?>
#loading {background-image: url(<?php echo $logo;?>);}
<?php } ?>

<?php if($googleKeyword){?>
h1,h2,h3, h4, h5, h6 {font-family: '<?php echo $googleKeyword;?>', sans-serif;}
<?php } ?>

a {color: <?php echo $color;?>;}

#commentform input[type="submit"], 
input[type="submit"],
.toggleButton:hover,
.widget_tag_cloud a {background: <?php echo $color;?>;}

<?php echo $css;?>
</style>

<?php 
    wp_deregister_script('jquery');
    wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"), false, '');
    wp_enqueue_script('jquery');
    wp_head(); 
    if ( is_singular() ) wp_enqueue_script( "comment-reply" );
    ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/prettyphoto.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/activity.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/gmap3.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/jquery.backstretch.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/jquery.animate-colors-min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/custom.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<script type="text/javascript">
jQuery.noConflict(); jQuery(document).ready(function(){
                                            //ACCORDION TOGGLES	
                                            jQuery('.toggleButton').hover(function(){
                                                                          jQuery(this).stop(true,true).animate({paddingLeft:"10px",backgroundColor:'<?php echo $color;?>', color:'#000'},300);
                                                                          },function(){
                                                                          jQuery(this).stop(true,true).animate({paddingLeft:"8px",backgroundColor:'#333',color:'#fff'},300);
                                                                          });
                                            });
</script>
</head>

<body <?php body_class();?>>

<div id="gMap"></div>

<div id="header">
<?php if($logo){?><a id="logo" href="<?php echo home_url()?>"><img src="<?php echo $logo;?>" alt="<?php bloginfo('name'); ?>" /></a><?php } ?> 
<?php if($tagline){?><h2 id="description"><?php bloginfo('description')?></h2><?php } ?>
<?php if (has_nav_menu( 'main' ) ) { wp_nav_menu(array('theme_location' => 'main', 'container_id' => 'navigation', 'menu_id' => 'dropmenu')); }?>
</div><!--end header-->	

<div id="loading"></div>

<div id="contentContainer">
<div id="content">