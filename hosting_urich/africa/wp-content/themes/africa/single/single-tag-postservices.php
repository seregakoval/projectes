
<?php get_header(); ?>
<section id="<?php echo single_tag_title(); ?>" class="content-post">
    <div class="container">
        <div class="row">

            <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                <div class="col-lg-12">
                    <h1 class="title-content-page"><?php the_title(); ?></h1>
                    <div style="clear: both;"></div>
                    <div class="date clearfix">
                        <p class="date-p"><i class="fa fa-calendar" aria-hidden="true"></i><span><?php the_time('M d, Y') ?></span></p>
                        <p class="time"><i class="fa fa-clock-o" aria-hidden="true"></i><span><?php the_time('G:i'); ?></span></p>
                    </div>
                    <div class="category clearfix">
                        <i class="fa fa-folder-open-o" aria-hidden="true"></i><?php echo get_the_category_list(); ?>
                    </div>
                </div>
                <div class="post-single-service col-lg-7">
                   <div class="top-section clearfix">
                       <div class="img">
                           <?php the_post_thumbnail("size"); ?>
                       </div>
                       <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                       <?php the_content(); ?>
                   </div>
                    <div class="content-single">

                        <script type="text/javascript">
                            function preloadFunc()
                            {
                              //  $(".content-single .envira-gallery-wrap:first").css({"display":"none"});
                                $(".content-single br:first").css({"display":"none"});
                            }
                            window.onpaint = preloadFunc();
                        </script>
                    </div>
                </div>
                    <?php //dynamic_sidebar( 'true_foot' ); ?>
                    <?php/*
                    $id_post = get_the_ID();
                    if($id_post == '2294'){
                         echo "koval";
                    }else{
                        echo "none";
                    }*/
                    ?>
            <?php endwhile ?>
            <?php endif ?>
            <div class="col-lg-4" style=" box-shadow: 0 0 2px;float:right;">
                <?php comments_template(); ?>
            </div>
        </div>

    </div>
</section>

<?php get_footer(); ?>

