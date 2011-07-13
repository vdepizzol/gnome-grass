<ul class="categories_list">
    <li class="cat-item cat-featured<?php if (is_page('applications')) echo ' current-cat';?>"><a href="<?php bloginfo('url'); ?>/applications/">Featured</a></li>
    <?php

    $current_category = wp_get_object_terms($post->ID, 'project_category');
    
    if (isset($current_category[0]->term_id)) {
        $current_category = $current_category[0]->term_id;
    } else {
        $current_category = false;
    }

    wp_list_categories(array(
        'taxonomy' => 'project_category',
        'current_category' => $current_category,
        'use_desc_for_title' => false,
        'title_li' => ''
    ));

    ?>
</ul>
