<?php
/**
 * The Template for displaying all single posts.
 *
 */
?>
<?php get_header(); ?>
<div class="clear"></div>
<div class="page-content">
    <div class="grid_16 alpha">
        <div class="content-bar">
            <!-- Start the Loop. -->
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="post">
                        <h1 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                        <ul class="post_meta">
                            <li class="posted_by"><span><?php _e('Posted by', 'squirrel'); ?></span>&nbsp;<?php the_author_posts_link(); ?></li>
                            <li class="post_date"><span><?php _e('on', 'squirrel'); ?></span>&nbsp;<?php echo get_the_time('M, d, Y') ?></li>
                            <li class="post_category"><span><?php _e('in', 'squirrel'); ?></span>&nbsp;<?php the_category(', '); ?></li>
                            <li class="postc_comment"><span><?php _e('Blog', 'squirrel'); ?></span>&nbsp;<?php comments_popup_link('No Comments.', '1 Comment.', '% Comments.'); ?></li>
                        </ul>
                        <div class="post_content"> 
                            <?php the_content(); ?>
                            <div class="clear"></div>
                            <?php if (has_tag()) { ?>
                                <div class="tag">
                                    <?php the_tags('Post Tagged with ', ', ', ''); ?>
                                </div>
                            <?php } ?>
                            <?php wp_link_pages(array('before' => '<div class="clear"></div><div class="page-link"><span>' . __('Pages:', 'squirrel') . '</span>', 'after' => '</div>')); ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <nav id="nav-single"> <span class="nav-previous">
                            <?php previous_post_link('%link', __('<span class="meta-nav">&larr;</span> Previous Post ', 'squirrel')); ?>
                        </span> <span class="nav-next">
                            <?php next_post_link('%link', __('Next Post <span class="meta-nav">&rarr;</span>', 'squirrel')); ?>
                        </span> </nav>
                    <!--End post-->
                <?php endwhile;
            endif; ?>
            <!--End Loop-->

            <!--Start Comment box-->
<?php comments_template(); ?>
            <!--End Comment box-->
        </div>
    </div>
    <div class="grid_8 omega">
        <!--Start Sidebar-->
<?php get_sidebar(); ?>
        <!--End Sidebar-->
    </div>
</div>
</div>
<?php get_footer(); ?>