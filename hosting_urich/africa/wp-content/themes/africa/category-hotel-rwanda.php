<?php get_header(); ?>

<div class="category-block" id="<?php the_ID(); ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <?php
                $page = (get_query_var('page')) ? get_query_var('page') : 1;
                $temp = $wp_query;
                $wp_query = null;
                $wp_query = new WP_Query();
                $wp_query -> query('posts_per_page=2&r_sortby=highest_rated&cat=35'.'&paged='.$paged);
                while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

                    <div class="post clearfix">
                        <div class="col-lg-5">
                            <div class="img">
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail("post_thumb"); ?></a>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="title-post clearfix">
                                <h1 class="title-post-category"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h1>
                                <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                            </div>
                            <div class="koval">
                                <?php the_content("Read more"); ?>
                            </div>
                        </div>
                        <?php //echo get_the_category_list(); ?>
                    </div>
                <?php endwhile; ?>
                <?php $wp_query = null; $wp_query = $temp; ?>

            </div>
            <div class="sidebar col-lg-3">
                <?php  $wp_query -> query('r_sortby=highest_rated&cat=35'.'&paged='.$paged);
                while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                    <div class="post-sidebar clearfix">
                        <div class="img">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                        </div>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                        <div style="clear: both;"></div>
                        <a href="<?php permalink_link(); ?>" class="link-more">Read more</a>
                    </div>
                <?php  endwhile; ?>
                <?php //get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
