<?php get_header();?>


    <!--<div class="large_intro" style="background-image: url(<?php // if(of_get_option('homepageimg')) : echo of_get_option('homepageimg'); else: echo get_stylesheet_directory_uri().'/img/large.jpg'; endif;?>); background-size: cover; background-position: center center; background-attachment: fixed;">
		<div class="large_intro_text">
			<?php //if(of_get_option('homepagetext')) : echo '<h1>'.nl2br(of_get_option('homepagetext')).'</h1>'; endif;?>
			<?php //if(of_get_option('homepagedescription')) : echo '<span class="h1_description"><hr/>'.nl2br(of_get_option('homepagedescription')).'</span>'; endif;?>

			<span class="clearfix"></span>
			<strong><?php// _e('BROWSE MY COLLECTIONS:', 'site5framework'); ?></strong>

			<span class="clearfix"></span>

			<?php
    //$count_postss = wp_count_posts('post');
    //$count_recipe = wp_count_posts('recipes');
    ?>

			<a href="<?php //echo of_get_option("browserecipes_url") ?>" class="buttonsm"><?php // echo $count_recipe->publish ?> recipes</a> <a href="<?php // echo of_get_option("browsearticles_url") ?>" class="buttonsm"><?php // echo $count_postss->publish ?> articles</a>
        </div>
    </div>-->

    <div class="parallax-head" style="/*background: rgba(0,0,0,0.2);*/">
        <?php // Цикл 1
        $query1 = new WP_Query('page_id=101');
        while($query1->have_posts()) $query1->the_post(); ;?>
        <?php the_content(); ?>
        <?php wp_reset_query(); ?>
    </div>
    <div class="title-category">
       <div class="wrap-title">
           <?php query_posts( array('p'=>98)); ?>
           <?php
           while (have_posts()) : the_post();?>
               <h1><?php the_title(); ?></h1>
               <?php the_content(); ?>
               <?php
           endwhile;
           /* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
           wp_reset_query();
           ?>
       </div>
    </div>
    <div class="wrapper-category clearfix">
        <?php get_sidebar(); ?>
        <div class="right-tovar">
           <div class="article">
               <?php query_posts('p=306'); ?>
               <?php
               while (have_posts()) : the_post();?>
                   <?php the_content(); ?>
                   <?php
               endwhile;
               /* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
               wp_reset_query();
               ?>
           </div>
        </div>
    </div>

    <div class="page-about">
        <?php //dynamic_sidebar("true_foot"); ?>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <!-- begin .post -->
            <article <?php post_class(); ?>>
            <?php the_content(); ?>
        <?php endwhile; ?>
            </article>
            <!-- end .post -->

        <?php endif;?>
    </div>
    <!--


<?php if(of_get_option('latestarticles')) { ?>
    <div class="latestarticles latestblog">
        <h3><?php echo of_get_option('latestarticle_title'); ?></h3>
        <?php
        $latestposts_paged = 1;
        $lp = new WP_Query("order=DESC&orderby=date&post_type=post&paged={$latestposts_paged}&posts_per_page=6");
        if($lp->have_posts()) {
            echo '<ul>';
            while ( $lp->have_posts() ) {
                $lp->the_post();
                echo '<li>';
                echo '<div class="latestarticles_pic"><a href="'.get_the_permalink().'">';
                if(has_post_thumbnail()) echo get_the_post_thumbnail(get_the_ID(),'blog-thumb');
                echo '</a><span class="latestarticlesitem"><i class="fa fa-file-text-o"></i></span></div>';
                echo '<div class="entry_details">';
                echo '<h4><a href="'.get_the_permalink().'">'.get_the_title() . '</a></h4>';
                echo '<span class="date">'.get_the_date('M d, Y').'</span><a href="'.get_comments_link().'" class="comments"><i class="fa fa-comment"></i>
 '.get_comments_number(get_the_id()).' комментариев</a>';
                echo '<p class="post_content">'.wp_trim_words( get_the_content(), 15, '...' ).'</p>';
                echo '</div>';
                echo '</li>';
            }
            echo '</ul>';
        }
        wp_reset_postdata();
        ?>


        <div class="browsingall">
            <a href="<?php echo of_get_option("browserecipes_url") ?>" class="buttonbig"><?php echo of_get_option("browserecipes_text") ?></a> <a href="<?php echo of_get_option("browsearticles_url") ?>" class="buttonbig"><?php echo of_get_option("browsearticles_text") ?></a>
        </div>

    </div>


<?php } ?>
<?php get_footer(); ?>