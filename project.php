<?php
/**
 * @package GNOME Website
 * @subpackage Grass Theme
 */


add_action('wp_head', function() {
    echo '<link rel="stylesheet" type="text/css" media="all" href="'.get_bloginfo('template_url').'/css/project.css" />'."\n";
    echo '<script type="text/javascript" src="'.get_bloginfo('template_url').'/pack/jcarousel/jquery.jcarousel.min.js"></script>'."\n";
    echo '<script type="text/javascript" src="'.get_bloginfo('template_url').'/js/project.js"></script>'."\n";
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
            <?php while ( have_posts() ) : the_post(); ?>
            
                <div class="project">
                
                    <div class="project_title">
                        <div class="icon">
                        <?php
                        if (has_post_thumbnail($post->ID)) {
                            echo get_the_post_thumbnail($post->ID, 'icon-medium');
                        } else {
                            echo '<img src="'.get_bloginfo('template_url').'/images/applications/application-default-icon-186x186.png" alt="" />';
                        }
                        ?>
                        </div>
                        <div class="main">
                            <h1><?php the_title(); ?></h1>
                            <div class="main_feature"><?php the_excerpt(); ?></div>
                        </div>
                    </div>
                    
                    <?php
                    
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
                        echo '<div class="screenshots">'."\n";
                        
                        if (count($attachments) > 3) {
                            echo '<a href="#" class="prev">'.__('Previous', 'grass').'</a>';
                            echo '<a href="#" class="next">'.__('Next', 'grass').'</a>';
                        }
                    
                        echo '<div><ul>'."\n";
                        foreach ($attachments as $attachment) {
                            $title = apply_filters('the_title', $attachment->post_title, $attachment->ID);
                            echo '<li class="item">';
                            echo '<a href="'.wp_get_attachment_url($attachment->ID).'" rel="screenshot">';
                            echo wp_get_attachment_image($attachment->ID, 'thumbnail', false, array('alt' => $title, 'title' => $title));
                            echo '</a>';
                            echo '<span class="description">';
                            echo $title;
                            echo '</span>';
                            echo '</li>'."\n";
                        }
                        echo '</div></ul>'."\n";
                        echo '</div>'."\n";
                    }
                    
                    
                    
                    /*
                     * Get the original content in default language
                     */
                    $original_content = wpautop(get_the_content());
                    
                    /*
                     * Get the content we'll use.
                     * Here we really hope there will be no filter
                     * that messes the <h2> and <h3> tags
                     */
                    $translated_content = apply_filters('the_content', $original_content);
                    
                    
                    
                    /*
                     * Creates a vector of the page contents, separating the
                     * <h2> and <h3> elements in a multidimensional array
                     */
                    function separate_content_in_sections($content) {
                        
                        $content_lines = explode("\n", $content);
                        
                        $group = 0;
                        $subgroup = 0;
                        
                        $separated_content = array();
                        
                        foreach ($content_lines as $k => $line) {
                            
                            if(substr($line, 0, 4) == '<h2>' && substr($line, -5) == '</h2>') {
                                
                                $group++;
                                $subgroup = 0;
                                $separated_content[$group]['title'] = substr($line, 4, -5);
                                continue;
                            }
                            
                            if(substr($line, 0, 4) == '<h3>' && substr($line, -5) == '</h3>') {
                                $subgroup++;
                                $separated_content[$group][$subgroup]['title'] = substr($line, 4, -5);
                                continue;
                            }
                            
                            if ($subgroup == 0) {
                                
                                if (!isset($separated_content[$group]['content'])) {
                                    $separated_content[$group]['content'] = '';
                                }
                                $separated_content[$group]['content'] .= $line."\n";
                                
                            } else {
                                
                                if (!isset($separated_content[$group][$subgroup]['content'])) {
                                    $separated_content[$group][$subgroup]['content'] = '';
                                }
                                $separated_content[$group][$subgroup]['content'] .= $line."\n";
                                
                            }
                        }
                        
                        return $separated_content;
                        
                    }
                    
                    $parsed_original_content = separate_content_in_sections($original_content);
                    $parsed_translated_content = separate_content_in_sections($translated_content);
                    
                    $final_content = array();
                    
                    foreach($parsed_original_content as $k => $group) {
                        if (array_key_exists('title', $group)) {
                            $key = strtolower(strip_tags($group['title']));
                            $final_content[$key] = $parsed_translated_content[$k];
                        } else {
                            $final_content[] = $parsed_translated_content[$k];
                        }
                    }
                    
                    
                    foreach ($final_content as $type => $item) {
                        
                        if(array_key_exists('title', $item)) {
                            echo '<h2>'.$item['title'].'</h2>';
                        }
                        
                        $subitems = $item;
                        unset($subitems['title'], $subitems['content']);
                        
                        
                        switch ($type) {
                            
                            case '0':
                                
                                /*
                                 * PHP will break zeros due to "loose comparation".
                                 * So here I am repeating the 'default' option.
                                 */
                                if(array_key_exists('content', $item)) {
                                    echo $item['content']."\n";
                                }
                            
                            break;
                        
                            case 'highlights':
                                
                                echo '<div class="highlights">'."\n";
                                if(array_key_exists('content', $item)) {
                                    echo $item['content']."\n";
                                }
                                foreach ($subitems as $subitem) {
                                    if(array_key_exists('title', $subitem)) {
                                        echo '<h3>'.$subitem['title'].'</h3>'."\n";
                                    }
                                    if(array_key_exists('content', $subitem)) {
                                        echo $subitem['content']."\n";
                                    }
                                }
                                echo '</div>'."\n";
                            
                            break;
                            
                            case 'install':
                            
                                if(array_key_exists('content', $item)) {
                                    echo $item['content']."\n";
                                }
                            
                                echo '<div class="install">'."\n";
                                echo '<ul class="options">'."\n";
                                $i = 0;
                                foreach ($subitems as $subitem) {
                                    if(array_key_exists('title', $subitem) && array_key_exists('content', $subitem)) {
                                    
                                        $class = str_replace(' ', '', strtolower(strip_tags($subitem['title'])));
                                        
                                        if ($i == 0) {
                                            $active = ' active';
                                        } else {
                                            $active = '';
                                        }
                                        
                                        echo '<li class="'.$class.$active.'"><a href="#install-'.$class.'">'.$subitem['title'].'</a></li>'."\n";
                                        
                                        $i++;
                                    }
                                }
                                echo '</ul>'."\n";
                                
                                echo '<div class="explanation">'."\n";
                                $i = 0;
                                foreach ($subitems as $subitem) {
                                    if(array_key_exists('title', $subitem) && array_key_exists('content', $subitem)) {
                                        $class = str_replace(' ', '', strtolower(strip_tags($subitem['title'])));
                                        
                                        if ($i == 0) {
                                            $active = ' class="active"';
                                        } else {
                                            $active = '';
                                        }
                                        
                                        echo '<div id="install-'.$class.'"'.$active.'>'."\n";
                                        echo $subitem['content']."\n";
                                        echo '</div>'."\n";
                                        
                                        $i++;
                                    }
                                }
                                echo '</div>'."\n";
                                
                                echo '</div>'."\n";
                            
                            break;
                            
                            default:
                            
                                if(array_key_exists('content', $item)) {
                                    echo $item['content']."\n";
                                }
                            
                            break;
                        
                        }
                        
                    }
                    
                    ?>
                    
                    <h2><?php echo __('Quick Links', 'grass');?></h2>
                    
                    <?php
                    
                    $custom_fields = get_post_custom($post->ID);
                                        
                    echo '<ul class="quick_links">';
                    foreach ($custom_fields as $key => $url_array) {
                        
                        if (strpos($key, 'quicklinks_') !== false) {
                            
                            $parsed_key = substr($key, strlen('quicklinks_'));
                            
                            if (array_key_exists($parsed_key, $applications_quick_links)) {
                                foreach ($url_array as $url) {
                                    echo '<li><a href="'.$url.'">'.$applications_quick_links[$parsed_key].'</a></li>';
                                }
                            }
                        }
                        
                    }
                    echo '</ul>';
                    
                    ?>
                
                </div>
                
            <?php endwhile; // End the loop. Whew. ?>
            
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
