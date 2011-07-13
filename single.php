<?php
/**
 * @package GNOME Website
 * @subpackage Grass Theme
 */


$post_type = get_post_type();

if($post_type == 'post') {

    require_once('news.php');

} elseif($post_type == 'projects') {
    
    require_once('project.php');
    
} else {

    require_once('one-column.php');
    
}


?>
