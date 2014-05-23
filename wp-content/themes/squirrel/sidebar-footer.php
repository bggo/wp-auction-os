<?php
/**
 * The Footer widget areas.
 *
 */
?>
<div class="grid_8 alpha">
    <div class="widget_inner">
        <?php if (is_active_sidebar('first-footer-widget-area')) : ?>
            <?php dynamic_sidebar('first-footer-widget-area'); ?>
        <?php else : ?>  
            <h4><?php _e('Contact Details', 'squirrel'); ?></h4>
            <?php _e('Address: Qarius dui, quis posuere nibh ollis quis. Mauris omma rhoncus rttitor.<br/>
            Contact No : +91-9985654789<br/>
            Website:&nbsp;<a href="#">http://example.com</a><br/>
            Email-id:&nbsp;<a href="#">example@domain.com</a><br/>', 'squirrel'); ?>
        <?php endif; ?>
    </div>
</div>
<div class="grid_8">
    <div class="widget_inner">
        <?php if (is_active_sidebar('second-footer-widget-area')) : ?>
            <?php dynamic_sidebar('second-footer-widget-area'); ?>
        <?php else : ?> 
            <h4><?php _e('Other Useful Links', 'squirrel'); ?></h4>
            <ul>
                <li> <a href="#"><?php _e('WordPress Development Blog', 'squirrel'); ?></a></li>
                <li> <a href="#"><?php _e('Developer Documentation', 'squirrel'); ?></a></li>
                <li> <a href="#"><?php _e('Reporting Bugs', 'squirrel'); ?></a></li>
                <li> <a href="#"><?php _e('WordPress Development Blog', 'squirrel'); ?></a></li>
                <li> <a href="#"><?php _e('Developer Documentation', 'squirrel'); ?></a></li>
                <li> <a href="#"><?php _e('Reporting Bugs', 'squirrel'); ?></a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>
<div class="grid_8 omega">
    <div class="widget_inner last">
        <?php if (is_active_sidebar('third-footer-widget-area')) : ?>
            <?php dynamic_sidebar('third-footer-widget-area'); ?>
        <?php else : ?>
            <h4><?php _e('Recent From Blog', 'squirrel'); ?></h4>
            <p><?php _e('Qarius dui, quis posuere nibh ollis quis. Mauris omma rhoncus rttitor. <a href="#">http://wordpress.org</a>', 'squirrel'); ?></p>
            <p><?php _e('Qarius dui, quis posuere nibh ollis quis. Mauris omma rhoncus rttitor. <a href="#">http://wordpress.com</a>', 'squirrel'); ?></p>
        <?php endif; ?>
    </div>
</div>
<!--End Footer-->
<div class="clear"></div>
<!--Start Footer bottom-->