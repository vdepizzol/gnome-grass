<?php
/**
 * @package GNOME Website
 * @subpackage Grass Theme
 */

require_once("header.php"); ?>

    <!-- container -->
    <div id="container" class="two_columns">
        <div class="container_12">

            <?php if ( have_posts() ) : ?>
                <div class="page_title">
                    <h1><?php _e( 'Looking for', 'grass' ); ?> <em><?php echo htmlentities(strip_tags($_GET['s']));?></em>...</h1>
                </div>
                
                <div class="content">
                    <dl>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <dt><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></dt>
                        <dd><?php the_excerpt(); ?></dd>
                    <?php endwhile; // End the loop. Whew. ?>
                    </dl>
                    
                    <?php if (  $wp_query->max_num_pages > 1 ) : ?>
                    <div class="page_navigation">
                        <span class="prev"><?php previous_posts_link(__('Previous page', 'grass')); ?></span>
                        <span class="next"><?php next_posts_link(__('Next page', 'grass')); ?></span>
                        <div class="clear"></div>
                    </div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </div>
                
                <div class="sidebar">
                    &nbsp;
                </div>
                
            <?php else : ?>
            
                <div class="content without_sidebar">
                    
                    <div class="grid_10 alpha prefix_1 omega suffix_1">
                    
                        <p><?php get_search_form(); ?></p>
                        
                        <hr />
                    
                        <h2><?php _e( 'Sorry, but nothing was found.', 'grass' ); ?></h2>
                        
                        <p><?php _e( 'Suggestions:', 'grass' ); ?></p>
                        
                        <ul>
                            <li><?php _e( 'Make sure all words are spelled correctly.', 'grass' ); ?></li>
                            <li><?php _e( 'Try different keywords.', 'grass' ); ?></li>
                            <li><?php _e( 'Try fewer keywords.', 'grass' ); ?></li>
                        </ul>
                        
                        <p>
                        <?php
                        printf(
                                __( 'If you feel lost, you may want to search for %1$s in all GNOME websites on %2$s.', 'grass'),
                                '“'.htmlspecialchars(stripslashes(strip_tags($_GET['s']))).'”',
                                '<a href="http://google.com/search?q='.htmlspecialchars(stripslashes(strip_tags($_GET['s']))).'%20site:gnome.org">Google</a>'
                            );
                        ?>
                        </p>
                        
                        <!-- Never to get lost is not to live. -->
                        
                    </div>
                    <div class="clear"></div>
                    
            </div>
            <?php endif; ?>
            
            <?php
            if ( have_posts() ) :
                $footer_art = 'search';
            else:
                $footer_art = 'search_no-results';
            endif;
            ?>
            <?php require_once("footer_art.php"); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <?php require_once("footer.php"); ?>
</body>
</html>
