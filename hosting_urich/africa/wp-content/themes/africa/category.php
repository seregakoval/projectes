<?php get_header(); ?>
<div class="category-block" id="<?php the_ID(); ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <?php
                /*$page = (get_query_var('page')) ? get_query_var('page') : 1;
                $temp = $wp_query;
                $wp_query = null;*/
                /*$wp_query = new WP_Query();*//*cat36*/
               /* $wp_query -> query('posts_per_page=2&r_sortby=highest_rated'.'&paged='.$paged);*/
                query_posts('cat='.$cat.'&r_sortby=highest_rated'.'&paged='.$paged);
                //query_posts( array( 'meta_key' => 'ratings_average', 'orderby' => 'meta_value_num', 'order' => 'DESC' ) );
                while (/*$wp_query->*/have_posts()) : /*$wp_query->*/the_post(); ?>

                    <div class="post clearfix">
                        <div class="img-post col-lg-5 col-lg-5 col-sm-5 col-xs-5">
                            <div class="img">
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail("post_thumb"); ?></a>
                            </div>
                        </div>
                        <div class="content-post-category col-lg-7 col-lg-7 col-sm-7 col-xs-7">
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
                <?php wp_reset_query(); ?>
                <?php /*$wp_query = null; $wp_query = $temp;*/ ?>

            </div>
                <div class="sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="row">
                    <?php  $wp_query -> query('cat='.$cat.'r_sortby=highest_rated'.'&paged='.$paged);
                    while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <div class="post-sidebar clearfix col-md-12 col-sm-6 col-xs-6">
                            <div class="all-post clearfix">
                                <div class="img">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                                </div>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                            </div>
                        </div>
                    <?php  endwhile; ?>
                    <?php //get_sidebar(); ?>
                </div>
                </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
