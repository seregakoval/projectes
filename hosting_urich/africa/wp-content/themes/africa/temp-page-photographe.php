<?php
/* Template Name: Temp-page-photographe */
?>
<?php get_header(); ?>
<section class="page-photographe">
    <div class="container">
            <?php while(have_posts()) : the_post() ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        
    </div>
</section>
<?php get_footer(); ?>
