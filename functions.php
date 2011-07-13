<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

add_editor_style("editor_style.css");

/*
 * Add support for custom menus and posts thumbnails
 */

add_theme_support('menus');
add_theme_support( 'post-thumbnails');


/*
 * Remove support for rich editor.
 * We don't want messy wysiwyg edits!
 */
if (is_admin ()) {
    add_filter ('user_can_richedit', create_function ('$a' ,'return false;') , 50);
}


set_post_thumbnail_size(940, 320);

/*
 * Media sizes for applications icons
 */

add_image_size( 'icon-big', 256, 256, true);
add_image_size( 'icon-medium', 186, 186, true);
add_image_size( 'icon-small', 64, 64, true);

add_image_size( 'image-crafted-content', 420, 263, true);
add_image_size( 'thumbnail-big', 210, 210, false);
add_image_size( 'thumbnail-small', 120, 80, false);


/*
 * Add support for banners and projects post types
 * (any taxonomies for projects)
 */

add_action( 'init', function() {
    
    register_post_type( 'banner',
        array(
            'labels' => array(
                'name' => 'Banners',
                'singular_name' => 'Banner',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Banner',
                'edit' => 'Edit',
                'edit_item' => 'Edit',
                'new_item' => 'New Banner',
                'view' => 'View',
                'view_item' => 'View Banner',
                'search_items' => 'Search Banners',
                'not_found' => 'No banners found',
                'not_found_in_trash' => 'No banners found in Trash',
                'parent' => 'Parent Banner',
            ),
            'public' => false,
            'exclude_from_search' => true,
            'supports' => array(
                'title', 'thumbnail', 'excerpt', 'revisions', 'author'
            ),
            'rewrite' => false
        )
    );
    
    register_taxonomy(  
        'project_category',
        'projects',  
        array(  
            'hierarchical' => true,  
            'label' => 'Categories',
            'query_var' => true,  
            'rewrite' => array(
                'slug' => 'projects/category'
            )
        )
    );

    register_post_type( 'projects',
        array(
            'labels' => array(
                'name' => 'Projects',
                'singular_name' => 'Project',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Project',
                'edit' => 'Edit',
                'edit_item' => 'Edit Project',
                'new_item' => 'New Project',
                'view' => 'View',
                'view_item' => 'View Project',
                'search_items' => 'Search Projects',
                'not_found' => 'No projects found',
                'not_found_in_trash' => 'No projects found in Trash',
                'parent' => 'Parent Project',
            ),
            'public' => true,
            'exclude_from_search' => false,
            'supports' => array(
                'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'author', 'custom-fields'
            )
        )
    );
    
    //flush_rewrite_rules();
    
});




/* 
 * Applications Quick Links
 */

$applications_quick_links = array(
    'website'       => __('Project Website'),
    'contribute'    => __('Contribute'),
    'documentation' => __('Documentation'),
    'extensions'    => __('Extensions'),
    'faq'           => __('Frequently Asked Questions'),
    'forum'         => __('Forum'),
    'mailing-list'  => __('Mailing List'),
    'report-bug'    => __('Report a bug'),
    'source-code'   => __('Source Code'),
    'support'       => __('Support'),
    'translate'     => __('Translate'),
);


/*
 * Custom edit area in Applications
 */
add_action( 'add_meta_boxes', function() {
    
    add_meta_box('quick-links', 'Quick Links', function() {
        
        global $applications_quick_links, $post;
        
        echo '<style type="text/css">
            .quicklinks {
                margin: -6px;
                padding: 6px 0 0;
            }
            .quicklinks .item {
                padding: 3px 10px;
                border-bottom: 1px solid #ececec;
            }
            .quicklinks .item:last-child {
                border-bottom: 0;
            }
            .quicklinks label {
                display: inline-block;
                width: 25%;
            }
            .quicklinks input[type="text"] {
                width: 73%;
            }
        </style>';
        echo '<div class="quicklinks">';
        foreach ($applications_quick_links as $key => $title) {
            
            $current_value = get_post_meta($post->ID, 'quicklinks_'.$key, true);
            
            if (empty($current_value)) {
                $current_value = '';
            }
            echo '<div class="item">';
            echo '<label for="quicklinks['.$key.']">'.$title.'</label> ';
            echo '<input type="text" id="quicklinks['.$key.']" name="quicklinks['.$key.']" value="'.$current_value.'" /><br>';
            echo '</div>';
        }
        echo '</div>';
        
    }, 'projects');
    
    
    add_meta_box('featured', 'Featured Project', function() {
        
        global $applications_quick_links, $post;
        
        if (get_post_meta($post->ID, 'is_featured', true) == 'yes') {
            $checked = 'checked';
        } else {
            $checked = '';
        }
        echo '<label style="display: block;"><input type="checkbox" '.$checked.' name="is_featured" style="margin-right: 3px;" />This is a featured project</label>';
        
    }, 'projects', 'side'); 
    
});

function save_project_post($post_id) {
    
    global $post, $applications_quick_links;
    
    if ($_REQUEST['post_type'] == 'projects') {
        
        if (!current_user_can( 'edit_page', $post_id)) {
            return $post_id;
        }
        
    } else {
        
        if (!current_user_can( 'edit_post', $post_id )) {
            return $post_id;
        }
        
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    
    /*
     * Save Quicklinks
     */
    
    if (isset($_POST['quicklinks'])) {
        $quicklinks_values = $_POST['quicklinks'];
        
        foreach($applications_quick_links as $key => $title) {
            
            $meta_name = 'quicklinks_'.$key;
            
            if (array_key_exists($key, $quicklinks_values)) {
                $meta_value = $quicklinks_values[$key];
            } else {
                $meta_value = '';
            }
        
            if (get_post_meta($post_id, $meta_name) == "") {
                
                add_post_meta($post_id, $meta_name, $meta_value, true);
                
            } elseif ($meta_value != get_post_meta($post_id, $meta_name, true)) {
                
                update_post_meta($post_id, $meta_name, $meta_value);
                
            } elseif($meta_value == '') {
                
                delete_post_meta($post_id, $meta_name, get_post_meta($post_id, $meta_name, true));
                
            }
            
        }
    }
    
    /*
     * Save Featured information
     */
    
    
    if (isset($_POST['is_featured'])) {
        
        if (get_post_meta($post_id, 'is_featured') == "") {
            
            add_post_meta($post_id, 'is_featured', 'yes', true);
            
        } else {
            
            update_post_meta($post_id, 'is_featured', 'yes');
            
        }
        
    } else {
        
        if (get_post_meta($post_id, 'is_featured', true) == 'yes') {
            
            delete_post_meta($post_id, 'is_featured', get_post_meta($post_id, 'is_featured', true));
            
        }
        
    }
    
}
add_action('save_post', 'save_project_post');




/*
 * Identify Ajax Language Selector
 */
if (array_key_exists('select-language', $_GET)) {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
        require_once('footer_language-selector.php');
        die;
    }
}
