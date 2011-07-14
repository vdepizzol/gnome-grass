<?php
/**
 * @package GNOME Website
 * @subpackage Grass Theme
 */

add_action('wp_head', function() {
    echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_url').'/css/project.css" />';
});



/*
 * Remove feed from this page
 */
//automatic_feed_links(false);
//remove_theme_support('automatic-feed-links');

require_once("header.php"); ?>

    <!-- container -->
    <div id="container">
        <div class="container_12">
        
            <div class="page_title">
                <h1><?php the_title(); ?></h1>
            </div>
            
            <div class="content">
            
                <?php the_content(); ?>
                
                <hr class="top_shadow" />
                
                <div class="grid_3 alpha">
                    <?php include('applications_sidebar.php'); ?>
                </div>
                
                <div class="grid_9 omega">
                    
                    <?php
                
                    $original_query = clone $wp_query;
                    
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    get_query_var('page');
                    query_posts(array('post_type' => 'projects', 'meta_key' => 'is_featured', 'posts_per_page' => 10, 'paged' => $paged));
                    
                    ?>
                    
                    <div class="applications_featured">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <div class="item">
                                <?php
                                
                                /*
                                 * Tries to get the application screenshot
                                 */
                                
                                $args = array(
                                    'post_type' => 'attachment',
                                    'numberposts' => null,
                                    'post_status' => null,
                                    'post_parent' => $post->ID
                                );
                                $attachments = get_posts($args);
                                
                                foreach ($attachments as $k => $attachment) {
                                    if (get_post_thumbnail_id($post->ID) == $attachment->ID) {
                                        unset($attachments[$k]);
                                    }
                                }
                                
                                if (count($attachments) > 0) {
                                    
                                    $has_screenshot = true;
                                    
                                    echo '<div class="screenshot">';
                                    foreach ($attachments as $attachment) {
                                        $title = apply_filters('the_title', get_the_title(), $post->ID);
                                        ?><a href="<?php the_permalink();?>"><?php
                                        echo wp_get_attachment_image($attachment->ID, 'medium', false, array('alt' => $title, 'title' => $title));
                                        ?></a><?php
                                        break;
                                    }
                                    echo '</div>';
                                } else {
                                    
                                    $has_screenshot = false;
                                    
                                }
                                
                                ?>
                                <div class="main<?php if (!$has_screenshot) echo ' no-screenshot';?>">
                                    <h3>
                                        <a href="<?php the_permalink();?>">
                                            <?php
                                            if (has_post_thumbnail($post->ID)) {
                                                echo get_the_post_thumbnail($post->ID, 'icon-small');
                                            } else {
                                                echo '<img src="'.get_bloginfo('template_url').'/images/applications/application-default-icon-64x64.png" alt="" />';
                                            }
                                            ?>
                                            <span><?php the_title(); ?></span>
                                        </a>
                                    </h3>
                                    <p><?php the_excerpt(); ?></p>
                                </div>
                            </div>
                        <?php endwhile; // End the loop. Whew. ?>
                    </div>
                    
                    <?php if (  $wp_query->max_num_pages > 1 ) : ?>
                    <div class="page_navigation">
                        <span class="prev"><?php previous_posts_link(__('Previous page', 'grass')); ?></span>
                        <span class="next"><?php next_posts_link(__('Next page', 'grass')); ?></span>
                        <div class="clear"></div>
                    </div>
                    <?php endif; ?>
                    
                </div>
                
            </div>
            <?php $footer_art = 'applications'; ?>
            <?php require_once("footer_art.php"); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <?php require_once("footer.php"); ?>
</body>
</html>
