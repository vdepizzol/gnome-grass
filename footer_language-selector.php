<?php


if (function_exists('wppo_get_all_available_langs') && function_exists('wppo_get_lang')) {

?>
<div class="container_12">
    <div class="grid_9">
        <h3><?php _e( 'GNOME speaks your language.', 'grass' ); ?></h3>
        
        <ul>
            <?php
            
            $list_of_languages = wppo_get_all_available_langs();
            $current_language = wppo_get_lang();
            
            $current_url = $_GET['url'];
            
            foreach($list_of_languages as $lang_code => $lang_name) {
                if($lang_code == $current_language) {
                    $active = ' class="active"';
                } else {
                    $active = '';
                }
                echo '<li'.$active.'><a href="'.wppo_recreate_url($current_url, $lang_code).'">'.$lang_name.'</a></li>'."\n";
            }
            
            ?>
        </ul>
    </div>
    
    <div class="grid_3">
        
        <div class="help_us_translating">
            <?php
            $join_translation_url = 'http://live.gnome.org/TranslationProject/JoiningTranslation';
            printf(__( 'Found a translation bug or want to help translating GNOME? Join the <a href="%1$s">GNOME Translation Project</a>!', 'grass' ), $join_translation_url);
            ?>
        </div>
        
    </div>
</div>

<?php

}
