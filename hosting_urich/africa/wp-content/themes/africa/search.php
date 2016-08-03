<?php get_header() ?>
<section class="search" style="margin-top:100px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <h2>Результаты поиска по запросу: <?php $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; _e(''); _e('<span style="color: #900;">'); echo $key; _e('</span>'); wp_reset_query(); ?></h2>

                <?php
                /* Restore original Post Data */
                //wp_reset_postdata();
                /*$page = (get_query_var('page')) ? get_query_var('page') : 1;
                $temp = $wp_query;
                $wp_query = null;*/
               // $input1 = $_GET['s'];
                /*$args = array(
                    'meta_query' => array(
                        'post_type' => 'post'
                    ),
                    'meta_query' => array(
                        array(
                            'key' => 'Restaurants'
                        ),
                    ),
                );

                $wp_query = new WP_Query($args );*/
                /* $wp_query -> query('posts_per_page=2&r_sortby=highest_rated'.'&paged='.$paged);*/
                //query_posts('cat='.$cat.'&r_sortby=highest_rated'.'&paged='.$paged);
                //query_posts( array( 'meta_key' => 'ratings_average', 'orderby' => 'meta_value_num', 'order' => 'DESC' ) );
                while (/*$wp_query->*/have_posts()) : /*$wp_query->*/the_post(); ?>

                    <div class="post clearfix">
                        <div class="img-post col-lg-5 col-lg-5 col-sm-5 col-xs-5">
                            <div class="img">
                                <a href="<?php //the_permalink(); ?>"><?php the_post_thumbnail("post_thumb"); ?></a>
                            </div>
                        </div>
                        <div class="content-post-category col-lg-7 col-lg-7 col-sm-7 col-xs-7">
                            <div class="title-post clearfix">
                                <h1 class="title-post-category"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h1>
                                <?php //if(function_exists('the_ratings')) { the_ratings(); } ?>
                            </div>
                            <div class="koval">
                                <?php //the_content("Read more"); ?>
                            </div>
                        </div>
                        <?php //echo get_the_category_list(); ?>
                    </div>
                <?php endwhile; ?>
                <?php //wp_reset_query(); ?>
                <?php //$wp_query = null; $wp_query = $temp; ?>

            </div>
        </div>
    </div>
</section>
    <?php get_footer() ?>
