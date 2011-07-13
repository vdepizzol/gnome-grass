<?php
/**
 * @package GNOME Website
 * @subpackage Grass Theme
 */

add_action('wp_head', function() {
    echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_url').'/css/project.css" />'."\n";
});


require_once("header.php"); ?>

    <!-- container -->
    <div id="container" class="two_columns">
        <div class="container_12">
        
            <div class="page_title">
                <h1><a href="<?php bloginfo('url'); ?>/applications/"><?php echo __('Applications', 'grass');?></a></h1>
            </div>
        
            <div class="sidebar">
                <?php include('applications_sidebar.php'); ?>
            </div>
            
            <div class="content">
            
                <div class="applications_list">
                    <div class="row">
                        <?php $i = 0; while ( have_posts() ) : the_post(); ?>
                        
                            <div class="item">
                                <div class="icon">
                                    <a href="<?php the_permalink();?>">
                                    <?php
                                    if (has_post_thumbnail($post->ID)) {
                                        echo get_the_post_thumbnail($post->ID, 'icon-small');
                                    } else {
                                        echo '<img src="'.get_bloginfo('template_url').'/images/applications/application-default-icon-64x64.png" alt="" />';
                                    }
                                    ?>
                                    </a>
                                </div>
                                <div class="main">
                                    <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                    <p><?php the_excerpt();?></p>
                                </div>
                            
                            </div>
                            
                            <?php if ($i % 2) echo '</div><div class="row">'; $i++; ?>
                            
                        <?php endwhile; // End the loop. Whew. ?>
                    </div>
                </div>
                
                <?php if ($wp_query->max_num_pages > 1): ?>
                <div class="page_navigation">
                    <span class="prev"><?php previous_posts_link(__('Previous page', 'grass')); ?></span>
                    <span class="next"><?php next_posts_link(__('Next page', 'grass')); ?></span>
                    <div class="clear"></div>
                </div>
                <?php endif; ?>

                <div class="clear"></div>
            </div>
            <?php
            $footer_art = 'applications';
            require_once("footer_art.php");
            ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <?php require_once("footer.php"); ?>
</body>
</html>
