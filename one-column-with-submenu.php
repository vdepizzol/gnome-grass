<?php
/*
Template Name: One Column with submenu in the title
*/


require_once("header.php"); ?>

    <!-- container -->
    <div id="container" class="two_columns">
        <div class="container_12">
        
            <div class="page_title with_subpages_list">
                <h1><?php the_title(); ?></h1>
                
                <ul class="subpages_list">
                    <?php
                    $parent_id  = $post->post_parent;
                    $breadcrumbs = array();
                    while ($parent_id) {
                        $page = get_page($parent_id);
                        $breadcrumbs[] = get_page($parent_id);
                        $parent_id  = $page->post_parent;
                    }
                    $breadcrumbs = array_reverse($breadcrumbs);
                    $first_page = $breadcrumbs[0];
                    
                    
                    if($first_page->ID != '') {
                        wp_list_pages(array('title_li' => '', 'depth' => 1, 'include' => $first_page->ID));
                        wp_list_pages(array('title_li' => '', 'depth' => 1, 'child_of' => $first_page->ID));
                    } else {
                        wp_list_pages(array('title_li' => '', 'depth' => 1, 'include' => $post->ID));
                        wp_list_pages(array('title_li' => '', 'depth' => 1, 'child_of' => $post->ID));
                    }
                    ?>
                </ul>
            </div>
            
            <div class="content without_sidebar">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; // End the loop. Whew. ?>
                <br />
                <div class="clear"></div>
            </div>
            
            <?php require_once("footer_art.php"); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <?php require_once("footer.php"); ?>
</body>
</html>
