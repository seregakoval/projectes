
<?php // PAGE-CATALOG ?>
<?php get_header(); ?>
<div class="parallax-head" style="background: rgba(0,0,0,0.2);">
    <?php // Цикл 1
    $query1 = new WP_Query('page_id=101');
    while($query1->have_posts()) $query1->the_post(); ;?>
    <?php the_content(); ?>
    <?php wp_reset_query(); ?>
</div>
<div class="wrapper-category clearfix">
    <?php get_sidebar(); ?>
   <div class="right-tovar rem">
       <?php query_posts( array('p'=>71) ); ?>
       <?php while (have_posts()) : the_post();?>
           <?php the_content(); ?>
           <?php endwhile;
       /* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
       wp_reset_query();
       ?>
   </div>
</div>
<?php get_footer(); ?>
