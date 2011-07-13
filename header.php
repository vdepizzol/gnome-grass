<?php

if (function_exists('wppo_get_lang')) {
    $current_lang = str_replace('_', '-', strtolower(wppo_get_lang()));
    if (strpos($current_lang, '-') !== false) {
       $current_lang = explode('-', $current_lang);
       $current_lang[1] = strtoupper($current_lang[1]);
       $current_lang = implode('-', $current_lang);
    }
} else {
    $current_lang = 'en';
}

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $current_lang;?>" lang="<?php echo $current_lang;?>">

<!-- Good morning, GNOME -->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('-', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.png" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-1.4.2.min.js"></script>

<!-- Fancybox -->
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/pack/fancybox-1.3.4/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/pack/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/pack/fancybox-1.3.4/jquery.fancybox-1.3.4.css" />

<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/template.js"></script>
<?php wp_head(); ?>
</head>


<body>

    <!-- accessibility access -->
    <div id="accessibility_access">
        <ul>
            <li><a href="#container"><?php _e( 'Go to page content', 'grass' ); ?></a></li>
            <li><a href="#top_bar"><?php _e( 'Go to main menu', 'grass' ); ?></a></li>
            <li><a href="#s" onclick="$('#s').focus(); return false;"><?php _e( 'Go to the search field', 'grass' ); ?></a></li>
        </ul>
    </div>
    
    <!-- global gnome.org domain bar -->
    <div id="global_domain_bar">
        <div>
            <a href="/"><strong>GNOME</strong>.ORG</a>
        </div>
    </div>
    
    
    <!-- header -->
    <div id="header" class="container_12">
        <div id="logo" class="grid_3">
            <h1><a title="<?php _e( 'Go to home page', 'grass' ); ?>" href="<?php echo home_url('/'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/gnome-logo.png" alt="<?php echo _e('GNOME: The Free Software Desktop Project', 'grass');?>" /></a></h1>
        </div>
        <div id="top_bar" class="grid_9">
            <div class="left">
                <?php wp_nav_menu('menu=globalnav'); ?>
                <?php /*<ul>
                    <li class="selected"><a href="index.html">About</a></li>
                    <li><a href="../products/index.html">Products</a></li>
                    <li><a href="../download/index.html">Download</a></li>
                    <li><a href="../support/index.html">Support</a></li>
                    <li><a href="../community/index.html">Community</a></li>
                    <li><a href="../contact/index.html">Contact</a></li>
                </ul> */ ?>
            </div>
            <div class="right">
                <form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>" >
                    <div>
                        <label class="hidden" for="s"><?php _e( 'Search', 'grass' ); ?>: </label><input type="text" value="<?php if(isset($_GET['s'])) { echo htmlspecialchars(stripslashes(strip_tags($_GET['s']))); } ?>" name="s" id="s" placeholder="<?php _e( 'Search', 'grass' ); ?>" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
