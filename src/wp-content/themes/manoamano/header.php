<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en" />

<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
<link rel="Shortcut Icon" href="<?php echo bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon" />

<!-- CSS : implied media="all" -->
<!-- BUILD: The following line is updated by the buildscript. -->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style.css">

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_enqueue_script("jquery"); ?>
<?php wp_head(); ?>

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/lib/superfish.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/lib/hoverIntent.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/lib/jquery.anythingslider.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/lib/swfobject.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/lib/jquery.imgFade.js"></script>

<script type="text/javascript"> 
	var $j = jQuery.noConflict();
    $j(document).ready(function() {
			copyMenuTitlesToDescription();
        $j('.menu').superfish(); 
    }); 
</script>

<script type="text/javascript">
	var $j = jQuery.noConflict();
	$j(function(){
		$j('#slider1').anythingSlider({
			width           : 580,
			height          : 252,
			delay           : <?php echo of_get_option('slider_transition_interval'); ?>,
			resumeDelay     : 10000,
			startStopped    : false,
			autoPlay        : true,
			autoPlayLocked  : false,
			easing          : "swing",
			onSlideComplete : function(slider){
				// alert('Welcome to Slide #' + slider.currentPage);
			}
		});
		$j(".feature_video").hover(function(){
		    $j('#slider1').data('AnythingSlider').startStop(false); // this stops the slideshow
		});
		$j(".arrow").click(function(){
		    $j('#slider1').data('AnythingSlider').startStop(true); // this starts the slideshow
		});
	});
</script>

<script type="text/javascript"> 
	var $j = jQuery.noConflict();
	$j(document).ready(function () {
		$j('#homeslider iframe').each(function() {
			var url = $j(this).attr("src")
			$j(this).attr("src",url+"&amp;wmode=Opaque")
		});
	});
</script>

<script type="text/javascript">
	var $j = jQuery.noConflict();
	$j(function() {
		$j().imgFade();
	});
</script>

</head>

<body <?php if(function_exists('body_class')) body_class(); ?>>

<div id="wrap">

<div id="header">

	<h1 id="title"><a href="<?php echo get_option('home'); ?>/" title="Home"><?php bloginfo('name'); ?></a></h1>
	
	<ul id="sociallinks">
		<li>
			<a href="http://www.goodnesstv.org/en/profil/manoamanointl"><img alt="goodnessTV" src="<?php bloginfo('template_url'); ?>/images/newfaviconsm.png" /></a>
		</li>
		<li>
			<a href="http://twitter.com/manoamanointl"><img alt="twitter" src="<?php bloginfo('template_url'); ?>/images/twitter.png" /></a>
		</li>
		<li>
			<a href="http://www.facebook.com/manoamanointl"><img alt="facebook" src="<?php bloginfo('template_url'); ?>/images/facebook.png" /></a>
		</li>
		<li>
			<a href="http://www.youtube.com/manoamanousa"><img alt="youtube" src="<?php bloginfo('template_url'); ?>/images/youtube.png" /></a>
		</li>		
		<li>
			<a href="<?php bloginfo('url')?>/donate"><img alt="donate" src="<?php bloginfo('template_url'); ?>/images/donate.png" /></a>
		</li>		
	</ul>
	
	<?php get_search_form(); ?> 
    
</div>

<div id="navbar">

	<?php if ( function_exists('wp_nav_menu') ) { // Check for 3.0+ menus
    wp_nav_menu( array( 'theme_location' => 'main-menu', 'title_li' => '', 'depth' => 4, 'container_class' => 'menu' ) ); }
    else {?>
    <ul class="menu"><?php wp_list_categories('title_li=&depth=4'); wp_list_pages('title_li=&depth=4'); ?></ul>
    <?php } ?>

</div>

<div style="clear:both;"></div>

<div id="contentwrap">