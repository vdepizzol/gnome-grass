<?php


add_action('wp_head', function() {
    echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_url').'/css/home.css" />';
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

    <?php
    
    $temp_query = clone $wp_query;
    
    query_posts(array('post_type' => 'banner', 'posts_per_page' => 1));
    
    ?>

    <!-- home banner -->
    <div id="home_banner">
        <?php
        while ( have_posts() ) : the_post();
        $home_link = get_post_meta($post->ID, 'link', true);
        if($home_link != '') { echo '<a href="'.$home_link.'">'; }
        the_post_thumbnail(array(940, 320), array('alt' => get_the_excerpt($post->ID), 'title' => get_the_title($post->ID)));
        if($home_link != '') { echo '</a>'; }
        endwhile;
        ?>
    </div>
    
    <?php
    $wp_query = clone $temp_query;
    ?>

    <!-- container -->
    <div id="container" class="two_columns">

        <div class="container_12">
        
            <div class="grid_12">
            
                <?php
                
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
                
                ?>
                
                <hr class="bottom_shadow" />
                
                <div class="grid_8 alpha">
                    <h2 style="margin-top: 0;">Latest news</h2>
                    
                    
                    <div class="news_list">
                    
                        <?php
                        
                        query_posts(array('post_type' => 'post', 'posts_per_page' => 3));
                        
                        while ( have_posts() ) : the_post();
                        ?>
                            <div class="news">
                                <span class="date">
                                    <?php the_date(); ?>
                                </span>
                                
                                <a href="<?php the_permalink(); ?>">
                                    <strong><?php the_title(); ?></strong><br />
                                    <?php echo strip_tags(get_the_excerpt()); ?>
                                </a>
                            </div>
                        <?php
                        $i++;
                        endwhile;
                        ?>
                        
                        <p><a href="/news/" class="action_button">Older news...</a></p>
                    </div>
                    
                </div>
                
                <div class="grid_4 omega">
                    
                    <div class="about_box">
                        <h4>We make great software available to all.</h4>
                        <p>GNOME is an international community dedicated to making great software that anyone can use, no matter what language they speak or their technical or physical abilities.</p>
                        <p><a class="more" href="/about/">About the GNOME Project</a></p>
                    </div>
                    
                    <div class="subtle_box" style="padding: 20px;">
                        <h4>Connect with us</h4>
                        
                        <div class="social_network_icons">
                            <ul>
                                <li>
                                    <a href="http://identi.ca/gnome">
                                        <img src="<?php bloginfo('template_url')?>/images/social_networks/identica.png" alt=" " />
                                        Identi.ca
                                    </a>
                                </li>
                                <li>
                                    <a href="http://twitter.com/gnome">
                                        <img src="<?php bloginfo('template_url')?>/images/social_networks/twitter.png" alt=" " />
                                        Twitter
                                    </a>
                                </li>
                                <li>
                                    <a href="http://www.facebook.com/GNOMEDesktop">
                                        <img src="<?php bloginfo('template_url')?>/images/social_networks/facebook.png" alt=" " />
                                        Facebook
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            
            </div>            
        <?php require_once("footer_art.php"); ?>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <?php require_once("footer.php"); ?>
</body>
</html>
