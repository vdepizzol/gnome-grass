<?php
/**
 * @package GNOME Website
 * @subpackage Grass Theme
 */

add_action('wp_head', 'add_news_stylesheet');

function add_news_stylesheet() {
    echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_url').'/css/news.css" />';
}

$is_news_home = true;


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
                <h1><?php echo __('News', 'grass');?></h1>
            </div>
            
            <div class="content">
            
                <?php the_content(); ?>
                <?php
                
                $original_query = clone $wp_query;
                
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                get_query_var('page');
                query_posts(array('post_type' => 'post', 'posts_per_page' => 10, 'paged' => $paged));
                
                ?>
                
                <ul class="news_list">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <li>
                            <span class="date"><?php the_date(); ?></span>
                            <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                            <p><?php the_excerpt(); ?></p>
                        </li>
                    <?php endwhile; // End the loop. Whew. ?>
                </ul>
                
                <?php if (  $wp_query->max_num_pages > 1 ) : ?>
                <div class="page_navigation">
                    <span class="next"><?php previous_posts_link(__('Newer posts', 'grass')); ?></span>
                    <span class="prev"><?php next_posts_link(__('Older posts', 'grass')); ?></span>
                    <div class="clear"></div>
                </div>
                <?php endif; ?>
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
