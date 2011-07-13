<?php
/**
 * @package GNOME Website
 * @subpackage Grass Theme
 */

require_once("header.php"); ?>

    <!-- container -->
    <div id="container" class="two_columns">
        <div class="container_12">
        
            <div class="page_title">
                <h1><?php the_title(); ?></h1>
            </div>
            
            <div class="content">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; // End the loop. Whew. ?>
                <br />
                <div class="clear"></div>
            </div>
            
            <div class="sidebar">
                
                <?php
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = get_page($parent_id);
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                if (isset($breadcrumbs[0])) {
                    $first_page = $breadcrumbs[0];
                } else {
                    $first_page = NULL;
                }
                ?>

                <?php if(is_page()) {?>
                <ul class="navigation_list">
                    <?php
                    if(isset($first_page) && $first_page->ID != '') {
                        wp_list_pages(array('title_li' => '', 'include' => $first_page->ID));
                        wp_list_pages(array('title_li' => '', 'child_of' => $first_page->ID));
                    } else {
                        wp_list_pages(array('title_li' => '', 'include' => $post->ID));
                        wp_list_pages(array('title_li' => '', 'child_of' => $post->ID));
                    }
                    ?>
                </ul>
                <?php } ?>            
            </div>
            <?php require_once("footer_art.php"); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <?php require_once("footer.php"); ?>
</body>
</html>
