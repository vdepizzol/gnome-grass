            <!-- footer artwork -->
            <?php
            
            if(!isset($footer_art)) {
                $footer = get_post_meta($post->ID, 'footer_art');
                if(count($footer) > 0) {
                    $footer_art = $footer[0];
                } else {
                    $footer_art = 'default';
                }
            }
            
            ?>
            <?php if($footer_art == 'default' || $footer_art == 'none'): ?>
            <div id="footer_art" class="grid_12 <?php echo $footer_art;?>">
            <?php else: ?>
            <div id="footer_art" class="grid_12" style="background-image: url(<?php bloginfo('stylesheet_directory') ?>/images/footer_arts/<?php echo $footer_art;?>.png);">
            <?php endif; ?>
                &nbsp;
            </div>
