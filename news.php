<?php
/**
 * @package GNOME Website
 * @subpackage Grass Theme
 */
 

add_action('wp_head', function() {
    echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_url').'/css/news.css" />';
});

/*
 * Add link to global feeds instead of current page comments
 */
automatic_feed_links(false);
add_action('wp_head', function() {
   echo '<link rel="alternate" type="application/rss+xml" title="'.get_bloginfo('name').' &raquo; Feed" href="'.home_url('/').'feed/" />'; 
});

require_once("header.php"); ?>

    <!-- container -->
    <div id="container" class="two_columns">
        <div class="container_12">
        
            <div class="page_title">
                <h1><a href="<?php bloginfo('url'); ?>/news/"><?php echo __('News', 'grass');?></a></h1>
            </div>
            
            <div class="content">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="news_title">
                    <p class="date"><?php the_date(); ?></p>
                    <h1><?php the_title(); ?></h1>
                </div>
                <?php the_content(); ?>
            <?php endwhile; // End the loop. Whew. ?>
                <br />
                <div class="clear"></div>
            </div>
            
            <div class="sidebar">
            
                <?php require_once("news_sidebar.php");?>
                      
            </div>
            <?php require_once("footer_art.php"); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <?php require_once("footer.php"); ?>
</body>
</html>
