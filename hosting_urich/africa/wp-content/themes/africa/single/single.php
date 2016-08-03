<?php get_header(); ?>
<section id="<?php the_ID(); ?>" class="content-post">
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
                <div class="col-lg-7">
                    <?php the_post_thumbnail("size"); ?>
                </div>
                <div class="text-post col-lg-5">
                    <?php the_content(); ?>
                    <?php //dynamic_sidebar( 'true_foot' ); ?>
                    <?php/*
                    $id_post = get_the_ID();
                    if($id_post == '2294'){
                         echo "koval";
                    }else{
                        echo "none";
                    }*/
                    ?>
                </div>
            <?php endwhile ?>
            <?php endif ?>
        </div>
        <?php
        /*$id_section = get_the_ID();
        if($id_section == "2290"){ */?>
        <div class="row services">
            <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile ?>
        <?php endif ?>
    </div>
       <?php /*}*/
        ?>

    </div>
</section>
<?php get_footer(); ?>
